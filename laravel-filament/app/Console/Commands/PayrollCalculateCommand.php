<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\ResolvesEmployee;
use App\Payroll\Audit\Application\Query\GetLine;
use App\Payroll\Earning\Application\Command\CalculateEarningLine;
use App\Payroll\SharedKernel\Application\CommandBus;
use App\Payroll\SharedKernel\Application\QueryBus;
use App\Payroll\SharedKernel\Period;
use Illuminate\Console\Command;

/** payroll:calculate — runs the salary stub; the line is created, recalculated, or (when frozen) only logged. */
class PayrollCalculateCommand extends Command
{
    use ResolvesEmployee;

    protected $signature = 'payroll:calculate {employee : employee id or exact name} {period? : YYYY-MM, default current month}';

    protected $description = 'Calculate (or recalculate) the payroll line of an employee with the salary stub';

    public function handle(CommandBus $commands, QueryBus $queries): int
    {
        $employee = $this->employee($queries, (string) $this->argument('employee'));
        $period = Period::parse($this->argument('period') ?? now()->format('Y-m'));

        $outcome = $commands->dispatch(new CalculateEarningLine($employee->id, $period));
        $line = $queries->ask(new GetLine($employee->id, $period));

        $this->info(ucfirst($outcome->value).". Current value: {$line->currentValue->format()}");

        return self::SUCCESS;
    }
}
