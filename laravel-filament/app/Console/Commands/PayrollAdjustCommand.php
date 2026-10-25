<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\ResolvesEmployee;
use App\Payroll\Audit\Application\Query\GetLine;
use App\Payroll\Earning\Application\Command\AddAdjustment;
use App\Payroll\SharedKernel\Application\CommandBus;
use App\Payroll\SharedKernel\Application\QueryBus;
use App\Payroll\SharedKernel\Money;
use App\Payroll\SharedKernel\Period;
use Illuminate\Console\Command;

/** payroll:adjust — adds a manual correction (never edits or deletes one). */
class PayrollAdjustCommand extends Command
{
    use ResolvesEmployee;

    protected $signature = 'payroll:adjust {employee : employee id or exact name} {period : YYYY-MM} {amount : signed, e.g. -45.55} {comment}
        {--actor= : who made the correction (required)}
        {--key= : idempotency key; re-sending it does not create a duplicate}';

    protected $description = 'Add a manual adjustment to an employee payroll line';

    public function handle(CommandBus $commands, QueryBus $queries): int
    {
        $employee = $this->employee($queries, (string) $this->argument('employee'));
        $period = Period::parse($this->argument('period'));

        $number = $commands->dispatch(new AddAdjustment(
            $employee->id,
            $period,
            Money::parse($this->argument('amount'), $employee->currency),
            (string) $this->argument('comment'),
            (string) $this->option('actor'),
            $this->option('key'),
        ));

        $this->info("Adjustment {$number} saved. Current value: {$queries->ask(new GetLine($employee->id, $period))->currentValue->format()}");

        return self::SUCCESS;
    }
}
