<?php

namespace Tests\Feature;

use App\Models\User;
use App\Nexus\Modules\Employee\Models\Employee;
use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use App\Payroll\AdjustPayrollLine;
use App\Payroll\CalculatePayroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Nodex\Nexus\Livewire\ModuleForm;
use Nodex\Nexus\Livewire\ModuleTable;
use Tests\TestCase;

/** Drives the generated Nexus admin (forms, tables, custom controllers), not just the models. */
class AdminFormTest extends TestCase
{
    use RefreshDatabase;

    private Employee $anna;

    protected function setUp(): void
    {
        parent::setUp();

        // Permission's display_name column must exist before any module registers its permissions.
        foreach (['Permission', 'Role', 'User', 'Employee', 'PayrollLine', 'PayrollAudit', 'PayrollAdjustment'] as $module) {
            $this->artisan('migrate', ['--path' => "app/Nexus/Modules/{$module}/database/migrations", '--force' => true]);
        }
        $this->artisan('nexus:module:install');
        $this->artisan('nexus:permission:init');
        foreach (['Employee', 'PayrollLine', 'PayrollAudit', 'PayrollAdjustment'] as $module) {
            $this->artisan('nexus:module:install', ['name' => $module]);
        }
        // Routes and views of modules are registered at boot, before this test installed them: add what the layout needs.
        Route::post('/logout', fn () => '')->name('logout');
        Route::getRoutes()->refreshNameLookups();
        foreach (['Employee', 'PayrollAudit'] as $module) {
            view()->addNamespace(lcfirst($module), app_path("Nexus/Modules/{$module}/resources/views"));
        }
        $this->artisan('nexus:create:superadmin', ['name' => 'Olena', 'email' => 'admin@example.com', 'password' => 'password']);
        $this->actingAs(User::where('email', 'admin@example.com')->firstOrFail());

        Model::preventLazyLoading();
        $this->anna = Employee::create(['name' => 'Anna Koval', 'currency' => 'USD', 'base_salary' => '1050.00']);
        app(CalculatePayroll::class)($this->anna, '2026-01');
    }

    private function line(): PayrollLine
    {
        return PayrollLine::where('employee_id', $this->anna->id)->firstOrFail();
    }

    public function test_adjustment_is_added_through_the_admin_form_and_author_is_the_logged_in_user(): void
    {
        Livewire::test(ModuleForm::class, ['moduleName' => 'PayrollAdjustment'])
            ->set('data.line', $this->line()->id)
            ->set('data.amount', '-45.55')
            ->set('data.comment', 'Employee declined dental benefit')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('$1,004.45', $this->line()->currentValue()->format());
        $this->assertSame('Olena', $this->line()->adjustments()->first()->getAttribute('actor'));
    }

    public function test_admin_form_requires_a_comment(): void
    {
        Livewire::test(ModuleForm::class, ['moduleName' => 'PayrollAdjustment'])
            ->set('data.line', $this->line()->id)
            ->set('data.amount', '5')
            ->set('data.comment', '')
            ->call('save')
            ->assertHasErrors(['data.comment']);

        $this->assertSame(0, $this->line()->adjustments()->count());
    }

    public function test_employee_form_creates_an_employee(): void
    {
        Livewire::test(ModuleForm::class, ['moduleName' => 'Employee'])
            ->set('data.name', 'Bohdan Melnyk')
            ->set('data.currency', 'EUR')
            ->set('data.base_salary', '2400.00')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('EUR', Employee::where('name', 'Bohdan Melnyk')->firstOrFail()->getAttribute('currency'));
    }

    public function test_tables_show_values_and_no_edit_or_delete_for_adjustments(): void
    {
        app(AdjustPayrollLine::class)($this->line(), '-45.55', 'declined dental', 'olena');

        Livewire::test(ModuleTable::class, ['moduleName' => 'PayrollLine'])
            ->assertSee('Anna Koval — 2026-01')
            ->assertSee('$1,004.45')
            ->assertDontSee('/action/edit/', false);

        Livewire::test(ModuleTable::class, ['moduleName' => 'PayrollAdjustment'])
            ->assertSee('declined dental')
            ->assertDontSee("runAction('delete'", false)
            ->assertDontSee('/action/edit/', false);
    }

    public function test_audit_page_filters_by_employee_period_and_dates_and_exports_csv(): void
    {
        $adjust = app(AdjustPayrollLine::class);
        $this->travelTo('2026-01-03 09:00:00');
        $adjust($this->line(), '-45.55', 'Employee declined dental benefit', 'olena');
        $this->travelTo('2026-01-05 09:00:00');
        $adjust($this->line(), '100.10', 'Late correction: missed approved overtime bonus', 'olena');
        $this->travelBack();

        $base = ['module' => 'PayrollAudit', 'action' => 'index'];

        $this->get(route('nexus.module.action', $base + ['employee' => $this->anna->id]))
            ->assertOk()
            ->assertSee('Employee declined dental benefit')
            ->assertSee('Late correction')
            ->assertDontSee('Opening balance');

        $this->get(route('nexus.module.action', $base + ['employee' => $this->anna->id, 'from' => '2026-01-04']))
            ->assertOk()
            ->assertDontSee('Employee declined dental benefit')
            ->assertSee('Late correction')
            ->assertSee('Opening balance')
            ->assertSee('$1,004.45');

        $this->get(route('nexus.module.action', $base + ['employee' => $this->anna->id, 'from' => '2027-01-01']))
            ->assertOk()
            ->assertSee('No entries for this selection');

        $csv = $this->get(route('nexus.module.action', ['module' => 'PayrollAudit', 'action' => 'export', 'employee' => $this->anna->id, 'from' => '2026-01-04']))
            ->assertOk()
            ->streamedContent();
        $this->assertStringContainsString('Late correction', $csv);
        $this->assertStringNotContainsString('declined dental', $csv);
    }

    public function test_calculate_button_page_and_post(): void
    {
        $route = route('nexus.module.action', ['module' => 'Employee', 'action' => 'calculate', 'id' => $this->anna->id]);

        $this->get($route)->assertOk()->assertSee('Calculated salary');

        $this->anna->update(['base_salary' => '1100.00']);
        $this->post($route, ['period' => '2026-01'])->assertRedirect();

        $this->assertSame('$1,100.00', $this->line()->currentValue()->format());
    }

    public function test_generic_edit_and_delete_urls_of_append_only_modules_are_closed(): void
    {
        app(AdjustPayrollLine::class)($this->line(), "-45.55", "declined dental", "olena");
        $event = $this->line()->adjustments()->firstOrFail();

        foreach ([["PayrollAdjustment", "edit", $event->id], ["PayrollAdjustment", "delete", $event->id], ["PayrollLine", "edit", $this->line()->id], ["PayrollLine", "create", null], ["Employee", "delete", $this->anna->id], ["PayrollLine", "view", $this->line()->id], ["PayrollAdjustment", "view", $event->id]] as [$module, $action, $id]) {
            $this->get(route("nexus.module.action", array_filter(["module" => $module, "action" => $action, "id" => $id])))
                ->assertRedirect();
            if ($action !== "view") {
                $this->assertSame("warning", session("alert_type"));
            }
        }
    }

    public function test_table_export_button_builds_a_csv_without_a_queue_worker(): void
    {
        \Illuminate\Support\Facades\Storage::fake("local");

        $component = Livewire::test(ModuleTable::class, ["moduleName" => "Employee"])->call("exportTable");
        $component->assertDispatched("nexus-export-started");

        $cacheKey = $component->effects["dispatches"][0]["params"]["cacheKey"];
        $state = \Illuminate\Support\Facades\Cache::get($cacheKey);
        $this->assertSame("completed", $state["status"]);

        $csv = \Illuminate\Support\Facades\Storage::disk("local")->get($state["filePath"]);
        $this->assertStringContainsString("Anna Koval", $csv);
    }
}
