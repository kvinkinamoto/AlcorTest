<?php

namespace Tests\Feature;

use App\Nexus\Modules\Employee\Models\Employee;
use Nodex\Nexus\Models\Module;
use Tests\TestCase;

/** Every form field of the payroll modules must use a type the Livewire form can render. */
class NoUnsupportedFieldsTest extends TestCase
{
    public function test_payroll_modules_only_declare_field_types_with_a_livewire_renderer(): void
    {
        $views = base_path('vendor/nodex/nexus/src/resources/views/tailadmin/livewire/field_types');
        $aliases = ['editor' => 'text', 'date' => 'birthday'];

        foreach (['Employee', 'PayrollAdjustment'] as $module) {
            $source = file_get_contents(app_path("Nexus/Modules/{$module}/Models/{$module}.php"));
            preg_match_all("/#\[Field\(type: '([a-z]+)'/", $source, $m);
            foreach ($m[1] as $type) {
                $this->assertFileExists("{$views}/".($aliases[$type] ?? $type).'.blade.php', "{$module}: field type '{$type}' has no Livewire renderer");
            }
        }
    }
}
