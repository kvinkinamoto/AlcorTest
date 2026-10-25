<?php

namespace App\Console\Commands;

use App\Nexus\Modules\Employee\Models\Employee;
use App\Payroll\Audit\AuditBuilder;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

/** payroll:audit — full history or a date window for one employee. */
class PayrollAuditCommand extends Command
{
    protected $signature = 'payroll:audit {employee : employee id or exact name}
        {--period= : only this period (YYYY-MM)}
        {--from= : window start (YYYY-MM-DD)}
        {--to= : window end, inclusive (YYYY-MM-DD)}
        {--csv : print CSV instead of a table}';

    protected $description = 'Audit of an employee: full history or a date window';

    public function handle(AuditBuilder $builder): int
    {
        $key = (string) $this->argument('employee');
        $employee = Employee::query()->where('id', $key)->orWhere('name', $key)->firstOrFail();
        $from = $this->option('from') ? CarbonImmutable::parse($this->option('from'))->startOfDay() : null;
        $to = $this->option('to') ? CarbonImmutable::parse($this->option('to'))->endOfDay() : null;
        $report = $builder->report($employee, $from, $to, $this->option('period'));

        if ($this->option('csv')) {
            $rows = $report->rows();
            $out = fopen('php://output', 'w');
            fputcsv($out, array_keys($rows[0] ?? ['employee' => '']), escape: '');
            foreach ($rows as $row) {
                fputcsv($out, $row, escape: '');
            }

            return self::SUCCESS;
        }

        $window = $from || $to ? ($from?->toDateString() ?? 'beginning').' .. '.($to?->toDateString() ?? 'now') : 'full history';
        $this->info("Audit: {$employee->getAttribute('name')} — {$window}");

        foreach ($report->sections as $s) {
            $this->line('');
            $this->line("Period {$s->period}".($s->frozen ? '  [frozen by manual adjustments]' : '').($s->opening ? "  opening balance {$s->opening->format()}" : ''));
            $this->table(
                ['Date', 'Entry', 'Amount', 'Running total', 'By', 'Comment'],
                array_map(fn ($e) => [$e->at->format('Y-m-d H:i'), $e->label(), $e->amount->format($e->adjustmentNo !== null), $e->runningTotal->format(), $e->actor ?? 'system', $e->comment], $s->entries),
            );
            $this->line("Current value: {$s->currentValue->format()} (system value {$s->systemValue->format()})");
        }
        if ($report->sections === []) {
            $this->warn('No entries.');
        }

        return self::SUCCESS;
    }
}
