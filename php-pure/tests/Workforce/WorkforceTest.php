<?php

declare(strict_types=1);

namespace Alcor\Payroll\Tests\Workforce;

use Alcor\Payroll\Earning\Application\Command\CalculateEarningLine;
use Alcor\Payroll\PayrollApp;
use Alcor\Payroll\SharedKernel\Domain\DomainEvent;
use Alcor\Payroll\SharedKernel\Period;
use Alcor\Payroll\Tests\SteppingClock;
use Alcor\Payroll\Workforce\Application\Command\ChangeSourceData;
use Alcor\Payroll\Workforce\Application\Command\HireEmployee;
use Alcor\Payroll\Workforce\Application\Query\GetEmployee;
use Alcor\Payroll\Workforce\Application\Query\ListEmployees;
use Alcor\Payroll\Workforce\Domain\Event\EmployeeHired;
use Alcor\Payroll\Workforce\Domain\Event\EmployeeSourceDataChanged;
use Alcor\Payroll\Workforce\Domain\Exception\EmployeeNotFound;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class WorkforceTest extends TestCase
{
    private PayrollApp $app;

    /** @var list<DomainEvent> */
    private array $published = [];

    protected function setUp(): void
    {
        $this->app = PayrollApp::inMemory(new SteppingClock());
        $this->app->events->subscribe('*', function (DomainEvent $e): void {
            $this->published[] = $e;
        });
    }

    public function test_hiring_stores_the_employee_and_raises_an_event(): void
    {
        $this->app->commands->dispatch(new HireEmployee('anna', 'Anna Koval', '1000'));

        $employee = $this->app->queries->ask(new GetEmployee('anna'));
        $this->assertSame('Anna Koval', $employee->name);
        $this->assertSame('$1,000.00', $employee->baseSalary->format());
        $this->assertSame('$0.00', $employee->bonus->format());
        $this->assertInstanceOf(EmployeeHired::class, $this->published[0]);
    }

    public function test_source_data_changes_raise_an_event_and_feed_the_salary_stub(): void
    {
        $this->app->commands->dispatch(new HireEmployee('olena', 'Olena', '1850.50'));
        $this->app->commands->dispatch(new ChangeSourceData('olena', benefitsDeduction: '50', bonus: '100'));

        $this->assertInstanceOf(EmployeeSourceDataChanged::class, $this->published[1]);

        $this->app->commands->dispatch(new CalculateEarningLine('olena', Period::parse('2026-01')));
        $line = $this->app->queries->ask(new \Alcor\Payroll\Audit\Application\Query\GetLine('olena', Period::parse('2026-01')));
        $this->assertSame('$1,900.50', $line->currentValue->format(), 'base - benefits + bonus');
    }

    public function test_list_is_ordered_by_name(): void
    {
        $this->app->commands->dispatch(new HireEmployee('b', 'Bohdan', '1'));
        $this->app->commands->dispatch(new HireEmployee('a', 'Zoya', '1'));

        $this->assertSame(['Bohdan', 'Zoya'], array_map(fn ($e) => $e->name, $this->app->queries->ask(new ListEmployees())));
    }

    public function test_unknown_employee_and_invalid_data_are_refused(): void
    {
        $this->assertThrowsType(EmployeeNotFound::class, fn () => $this->app->queries->ask(new GetEmployee('nobody')));
        $this->assertThrowsType(EmployeeNotFound::class, fn () => $this->app->commands->dispatch(new ChangeSourceData('nobody', baseSalary: '1')));
        $this->assertThrowsType(InvalidArgumentException::class, fn () => $this->app->commands->dispatch(new HireEmployee('', 'No id', '1')));
    }

    /** @param class-string<\Throwable> $class */
    private function assertThrowsType(string $class, callable $fn): void
    {
        try {
            $fn();
            $this->fail("Expected {$class}");
        } catch (\Throwable $e) {
            $this->assertInstanceOf($class, $e);
        }
    }
}
