<?php

namespace App\Nexus\Modules\PayrollLine\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Payroll\RefusesManualChanges;
use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use App\Payroll\CalculatePayroll;
use Illuminate\Foundation\Http\FormRequest;
use Nodex\Nexus\Models\Module;

/** Row buttons of the payroll line list: re-run the salary stub, or open the audit of the line. */
class AdminController extends Controller
{
    use RefusesManualChanges;

    public function create(FormRequest $request, Module $module)
    {
        return $this->refuse($module);
    }

    public function store(FormRequest $request, Module $module)
    {
        return $this->refuse($module);
    }

    public function recalculate(FormRequest $request, Module $module, string $id)
    {
        $line = PayrollLine::query()->with('employee')->findOrFail($id);
        $outcome = app(CalculatePayroll::class)($line->employee, $line->getAttribute('period'));

        return redirect()
            ->route('nexus.module.action', ['module' => $module->name, 'action' => 'index'])
            ->with('alert_message', $outcome->value === 'ignored'
                ? 'Ignored: the line has manual adjustments (the attempt is logged in the audit).'
                : 'Payroll line recalculated.')
            ->with('alert_type', $outcome->value === 'ignored' ? 'warning' : 'success');
    }

    /** The line has no detail form of its own: its detail is the audit of the line. */
    public function view(FormRequest $request, Module $module, string $id)
    {
        return $this->audit($request, $module, $id);
    }

    public function audit(FormRequest $request, Module $module, string $id)
    {
        $line = PayrollLine::query()->findOrFail($id);

        return redirect()->route('nexus.module.action', [
            'module' => 'PayrollAudit',
            'action' => 'index',
            'employee' => $line->employee_id,
            'period' => $line->getAttribute('period'),
        ]);
    }
}
