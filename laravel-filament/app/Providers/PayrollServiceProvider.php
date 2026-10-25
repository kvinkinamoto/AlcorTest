<?php

namespace App\Providers;

use App\Payroll\Audit\Application\AuditProjection;
use App\Payroll\Audit\Application\AuditProjector;
use App\Payroll\Audit\Application\AuditReadModel;
use App\Payroll\Audit\Application\Query\AuditQueryHandler;
use App\Payroll\Audit\Application\Query\GetAudit;
use App\Payroll\Audit\Application\Query\GetLine;
use App\Payroll\Audit\Application\Query\GetLines;
use App\Payroll\Audit\Infrastructure\DbAuditStore;
use App\Payroll\Earning\Application\Command\AddAdjustment;
use App\Payroll\Earning\Application\Command\AddAdjustmentHandler;
use App\Payroll\Earning\Application\Command\CalculateEarningLine;
use App\Payroll\Earning\Application\Command\CalculateEarningLineHandler;
use App\Payroll\Earning\Application\Port\SalaryCalculator;
use App\Payroll\Earning\Domain\EarningLineRepository;
use App\Payroll\Earning\Domain\Event\AdjustmentAdded;
use App\Payroll\Earning\Domain\Event\LineCalculated;
use App\Payroll\Earning\Domain\Event\RecalculationIgnored;
use App\Payroll\Earning\Domain\Event\SystemValueRecalculated;
use App\Payroll\Earning\Infrastructure\EventSourcedEarningLineRepository;
use App\Payroll\PayrollCalculation\Infrastructure\StubSalaryCalculator;
use App\Payroll\SharedKernel\Application\CommandBus;
use App\Payroll\SharedKernel\Application\EventBus;
use App\Payroll\SharedKernel\Application\EventStore;
use App\Payroll\SharedKernel\Application\QueryBus;
use App\Payroll\SharedKernel\Application\Transaction;
use App\Payroll\SharedKernel\Infrastructure\DbEventStore;
use App\Payroll\SharedKernel\Infrastructure\DbTransaction;
use App\Payroll\SharedKernel\Infrastructure\EventRegistry;
use App\Payroll\SharedKernel\Infrastructure\LaravelClock;
use App\Payroll\SharedKernel\Infrastructure\SimpleCommandBus;
use App\Payroll\SharedKernel\Infrastructure\SimpleQueryBus;
use App\Payroll\SharedKernel\Infrastructure\SynchronousEventBus;
use App\Payroll\Workforce\Application\Command\ChangeSourceData;
use App\Payroll\Workforce\Application\Command\ChangeSourceDataHandler;
use App\Payroll\Workforce\Application\Command\HireEmployee;
use App\Payroll\Workforce\Application\Command\HireEmployeeHandler;
use App\Payroll\Workforce\Application\Query\EmployeeQueryHandler;
use App\Payroll\Workforce\Application\Query\GetEmployee;
use App\Payroll\Workforce\Application\Query\ListEmployees;
use App\Payroll\Workforce\Domain\EmployeeRepository;
use App\Payroll\Workforce\Infrastructure\DbEmployeeRepository;
use Illuminate\Support\ServiceProvider;
use Psr\Clock\ClockInterface;

/** Composition root of the payroll contexts: picks the adapters and registers every command and query handler. */
class PayrollServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommandBus::class, SimpleCommandBus::class);
        $this->app->singleton(QueryBus::class, SimpleQueryBus::class);
        $this->app->singleton(SynchronousEventBus::class);
        $this->app->bind(EventBus::class, SynchronousEventBus::class);

        $this->app->singleton(EventStore::class, fn () => new DbEventStore(new EventRegistry([
            LineCalculated::class,
            SystemValueRecalculated::class,
            RecalculationIgnored::class,
            AdjustmentAdded::class,
        ])));
        $this->app->bind(Transaction::class, DbTransaction::class);
        $this->app->bind(ClockInterface::class, LaravelClock::class);

        $this->app->bind(EmployeeRepository::class, DbEmployeeRepository::class);
        $this->app->bind(EarningLineRepository::class, EventSourcedEarningLineRepository::class);
        $this->app->bind(SalaryCalculator::class, StubSalaryCalculator::class); // swap for the real payroll engine here

        $this->app->singleton(DbAuditStore::class);
        $this->app->bind(AuditProjection::class, DbAuditStore::class);
        $this->app->bind(AuditReadModel::class, DbAuditStore::class);
    }

    public function boot(): void
    {
        $commands = $this->app->make(CommandBus::class);
        $queries = $this->app->make(QueryBus::class);

        // Handlers are resolved lazily, so the buses cost nothing on requests that do not use payroll.
        $command = fn (string $handler) => fn (object $c) => $this->app->make($handler)($c);

        $commands->register(HireEmployee::class, $command(HireEmployeeHandler::class));
        $commands->register(ChangeSourceData::class, $command(ChangeSourceDataHandler::class));
        $commands->register(CalculateEarningLine::class, $command(CalculateEarningLineHandler::class));
        $commands->register(AddAdjustment::class, $command(AddAdjustmentHandler::class));

        $queries->register(GetEmployee::class, fn (GetEmployee $q) => $this->app->make(EmployeeQueryHandler::class)->get($q));
        $queries->register(ListEmployees::class, fn (ListEmployees $q) => $this->app->make(EmployeeQueryHandler::class)->list($q));
        $queries->register(GetLine::class, fn (GetLine $q) => $this->app->make(AuditQueryHandler::class)->line($q));
        $queries->register(GetLines::class, fn (GetLines $q) => $this->app->make(AuditQueryHandler::class)->lines($q));
        $queries->register(GetAudit::class, fn (GetAudit $q) => $this->app->make(AuditQueryHandler::class)->report($q));

        // Read side: the projector keeps the Audit read model current from published events.
        $this->app->make(SynchronousEventBus::class)->subscribe('*', fn ($event) => $this->app->make(AuditProjector::class)($event));
    }
}
