<?php

namespace Database\Seeders;

use App\Models\User;
use App\Payroll\Audit\Application\Query\GetLine;
use App\Payroll\Earning\Application\Command\AddAdjustment;
use App\Payroll\Earning\Application\Command\CalculateEarningLine;
use App\Payroll\SharedKernel\Application\CommandBus;
use App\Payroll\SharedKernel\Application\QueryBus;
use App\Payroll\SharedKernel\Money;
use App\Payroll\SharedKernel\Period;
use App\Payroll\Workforce\Application\Command\ChangeSourceData;
use App\Payroll\Workforce\Application\Command\HireEmployee;
use App\Payroll\Workforce\Application\Query\ListEmployees;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /** Local dev login: admin@example.com / password. Also replays the assignment table for Anna. */
    public function run(CommandBus $commands, QueryBus $queries): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Olena (payroll specialist)', 'password' => 'password'],
        );

        $known = array_map(fn ($e) => $e->id, $queries->ask(new ListEmployees()));
        foreach ([['anna', 'Anna Koval', '1000.00', '0'], ['bohdan', 'Bohdan Melnyk', '2400.00', '0'], ['olena', 'Olena Shevchenko', '1850.50', '100.00']] as [$id, $name, $base, $bonus]) {
            if (! in_array($id, $known, true)) {
                $commands->dispatch(new HireEmployee($id, $name, $base));
                $commands->dispatch(new ChangeSourceData($id, bonus: $bonus));
            }
        }

        $period = Period::parse(now()->format('Y-m'));
        if ($queries->ask(new GetLine('anna', $period)) !== null) {
            return; // already seeded
        }

        // One command per day, ending around today, so the audit date filter has something to filter.
        $day = now()->subDays(11)->setTime(9, 0);
        $step = function (object $command) use (&$day, $commands) {
            Carbon::setTestNow($day);
            $commands->dispatch($command);
            $day = $day->copy()->addDay();
        };
        $by = 'Olena (payroll specialist)';

        $step(new CalculateEarningLine('anna', $period));                                                                                            // 1. $1,000.00
        $step(new ChangeSourceData('anna', baseSalary: '1050.00'));
        $step(new CalculateEarningLine('anna', $period));                                                                                            // 2. $1,050.00
        $step(new AddAdjustment('anna', $period, Money::parse('-45.55'), 'Employee declined dental benefit; reversing deduction', $by));             // 3. $1,004.45
        $step(new ChangeSourceData('anna', baseSalary: '1300.00'));
        $step(new CalculateEarningLine('anna', $period));                                                                                            // 4. ignored
        $step(new AddAdjustment('anna', $period, Money::parse('100.10'), 'Late correction: missed approved overtime bonus', $by));                   // 5. $1,104.55
        $step(new AddAdjustment('anna', $period, Money::parse('-0.10'), 'Minor rounding adjustment', $by));                                          // 6. $1,104.45
        $step(new AddAdjustment('anna', $period, Money::parse('-0.20'), 'Second minor rounding adjustment', $by));                                   // 7. $1,104.25
        $step(new AddAdjustment('anna', $period, Money::parse('0.20'), 'Correcting mistake in adjustment #4', $by));                                 // 8. $1,104.45

        Carbon::setTestNow();
        $commands->dispatch(new CalculateEarningLine('bohdan', $period));
        $commands->dispatch(new CalculateEarningLine('olena', $period));
    }
}
