<?php

namespace App\Nexus\Modules\PayrollAudit\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Payroll\RefusesManualChanges;
use App\Nexus\Modules\Employee\Models\Employee;
use App\Payroll\Audit\AuditBuilder;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Nodex\Nexus\Models\Module;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * The module index is the audit report: pick an employee, optionally a period and a date window
 * (empty dates = entire history). `export` returns the same selection as CSV.
 */
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

    public function index(FormRequest $request, Module $module)
    {
        $employees = Employee::query()->orderBy('name')->get(['id', 'name']);
        $employee = $this->employee($request, $employees);
        $report = $employee ? app(AuditBuilder::class)->report($employee, ...$this->window($request), period: $request->query('period') ?: null) : null;

        return view('payrollAudit::report', [
            'module' => $module,
            'employees' => $employees,
            'employee' => $employee,
            'periods' => $employee ? $employee->payrollLines()->pluck('period') : collect(),
            'report' => $report,
            'filters' => $request->only(['employee', 'period', 'from', 'to']),
        ]);
    }

    public function export(FormRequest $request, Module $module): StreamedResponse
    {
        $employee = $this->employee($request, Employee::query()->get(['id', 'name']));
        abort_unless($employee, 404);

        $rows = app(AuditBuilder::class)->report($employee, ...$this->window($request), period: $request->query('period') ?: null)->rows();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, array_keys($rows[0] ?? ['employee' => '']), escape: '');
            foreach ($rows as $row) {
                fputcsv($out, $row, escape: '');
            }
            fclose($out);
        }, "audit-{$employee->id}.csv", ['Content-Type' => 'text/csv']);
    }

    private function employee(FormRequest $request, $employees): ?Employee
    {
        $id = $request->query('employee') ?: $employees->first()?->id;

        return $id ? Employee::query()->find($id) : null;
    }

    /** @return array{0: ?CarbonImmutable, 1: ?CarbonImmutable} */
    private function window(FormRequest $request): array
    {
        return [
            $request->query('from') ? CarbonImmutable::parse($request->query('from'))->startOfDay() : null,
            $request->query('to') ? CarbonImmutable::parse($request->query('to'))->endOfDay() : null,
        ];
    }
}
