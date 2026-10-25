<?php

namespace Database\Seeders;

use App\Nexus\Modules\Employee\Models\Employee;
use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use App\Payroll\AdjustPayrollLine;
use App\Payroll\CalculatePayroll;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /** Demo employees; Anna gets the assignment table replayed, one step per day, ending today. */
    public function run(CalculatePayroll $calculate, AdjustPayrollLine $adjust): void
    {
        $anna = Employee::query()->firstOrCreate(['name' => 'Anna Koval'], ['currency' => 'USD', 'base_salary' => '1000.00']);
        $bohdan = Employee::query()->firstOrCreate(['name' => 'Bohdan Melnyk'], ['currency' => 'USD', 'base_salary' => '2400.00']);
        $olena = Employee::query()->firstOrCreate(['name' => 'Olena Shevchenko'], ['currency' => 'USD', 'base_salary' => '1850.50', 'bonus' => '100.00']);

        $period = now()->format('Y-m');
        if (PayrollLine::query()->where('employee_id', $anna->id)->where('period', $period)->exists()) {
            return; // already seeded
        }

        $day = now()->subDays(7)->setTime(9, 0);
        $step = function (callable $fn) use (&$day) {
            Carbon::setTestNow($day);
            $fn();
            $day = $day->copy()->addDay();
        };
        $by = 'Olena (payroll specialist)';
        $line = fn () => PayrollLine::query()->where('employee_id', $anna->id)->where('period', $period)->firstOrFail();

        $step(fn () => $calculate($anna, $period));                                                                      // 1. $1,000.00
        $step(function () use ($anna, $calculate, $period) {                                                             // 2. $1,050.00
            $anna->update(['base_salary' => '1050.00']);
            $calculate($anna, $period);
        });
        $step(fn () => $adjust($line(), '-45.55', 'Employee declined dental benefit; reversing deduction', $by));        // 3. $1,004.45
        $step(function () use ($anna, $calculate, $period) {                                                             // 4. ignored
            $anna->update(['base_salary' => '1300.00']);
            $calculate($anna, $period);
        });
        $step(fn () => $adjust($line(), '100.10', 'Late correction: missed approved overtime bonus', $by));              // 5. $1,104.55
        $step(fn () => $adjust($line(), '-0.10', 'Minor rounding adjustment', $by));                                     // 6. $1,104.45
        $step(fn () => $adjust($line(), '-0.20', 'Second minor rounding adjustment', $by));                              // 7. $1,104.25
        $step(fn () => $adjust($line(), '0.20', 'Correcting mistake in adjustment #4', $by));                            // 8. $1,104.45

        Carbon::setTestNow();
        $calculate($bohdan, $period);
        $calculate($olena, $period);
    }
}
