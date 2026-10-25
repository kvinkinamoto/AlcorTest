<?php

namespace App\Nexus\Modules\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Nexus\Modules\Employee\Models\Employee;
use App\Payroll\CalculatePayroll;
use App\Payroll\Period;
use Illuminate\Foundation\Http\FormRequest;
use Nodex\Nexus\Models\Module;

/**
 * NexusController::action() dispatches the #[TableAction(name: 'calculate')] row button here by method name.
 * GET shows a small "choose the period" form, POST runs the salary stub.
 */
class AdminController extends Controller
{
    /** Employees own payroll history, so they are not deleted from the admin (the delete button is hidden). */
    public function delete(FormRequest $request, Module $module, ?string $id = null)
    {
        return $this->refuseDelete($module);
    }

    public function deleteGroup(FormRequest $request, Module $module)
    {
        return $this->refuseDelete($module);
    }

    private function refuseDelete(Module $module)
    {
        return redirect()
            ->route("nexus.module.action", ["module" => $module->name, "action" => "index"])
            ->with("alert_message", "Employees with payroll history cannot be deleted.")
            ->with("alert_type", "warning");
    }

    public function calculate(FormRequest $request, Module $module, string $id)
    {
        $employee = Employee::query()->findOrFail($id);

        if (! $request->isMethod('post')) {
            return view('employee::calculate', ['module' => $module, 'employee' => $employee, 'period' => now()->format('Y-m')]);
        }

        $period = (string) Period::parse((string) $request->input('period'));
        $outcome = app(CalculatePayroll::class)($employee, $period);

        return redirect()
            ->route('nexus.module.action', ['module' => 'PayrollLine', 'action' => 'index'])
            ->with('alert_message', match ($outcome->value) {
                'created' => "Payroll line for {$period} created.",
                'recalculated' => "Payroll line for {$period} recalculated.",
                'ignored' => 'Ignored: the line already has manual adjustments (the attempt is logged in the audit).',
            })
            ->with('alert_type', $outcome->value === 'ignored' ? 'warning' : 'success');
    }
}
