<?php

declare(strict_types=1);

namespace Alcor\Payroll;

use Alcor\Payroll\Audit\Application\AuditProjection;
use Alcor\Payroll\Audit\Application\AuditProjector;
use Alcor\Payroll\Audit\Application\AuditReadModel;
use Alcor\Payroll\Audit\Application\Query\AuditQueryHandler;
use Alcor\Payroll\Audit\Application\Query\GetAudit;
use Alcor\Payroll\Audit\Application\Query\GetLine;
use Alcor\Payroll\Audit\Application\Query\GetLines;
use Alcor\Payroll\Audit\Infrastructure\InMemoryAuditStore;
use Alcor\Payroll\Audit\Infrastructure\PdoAuditStore;
use Alcor\Payroll\Earning\Application\Command\AddAdjustment;
use Alcor\Payroll\Earning\Application\Command\AddAdjustmentHandler;
use Alcor\Payroll\Earning\Application\Command\CalculateEarningLine;
use Alcor\Payroll\Earning\Application\Command\CalculateEarningLineHandler;
use Alcor\Payroll\Earning\Domain\Event\AdjustmentAdded;
use Alcor\Payroll\Earning\Domain\Event\LineCalculated;
use Alcor\Payroll\Earning\Domain\Event\RecalculationIgnored;
use Alcor\Payroll\Earning\Domain\Event\SystemValueRecalculated;
use Alcor\Payroll\Earning\Infrastructure\EventSourcedEarningLineRepository;
use Alcor\Payroll\PayrollCalculation\Infrastructure\StubSalaryCalculator;
use Alcor\Payroll\SharedKernel\Application\CommandBus;
use Alcor\Payroll\SharedKernel\Application\EventStore;
use Alcor\Payroll\SharedKernel\Application\QueryBus;
use Alcor\Payroll\SharedKernel\Application\Transaction;
use Alcor\Payroll\SharedKernel\Infrastructure\EventRegistry;
use Alcor\Payroll\SharedKernel\Infrastructure\InMemoryEventStore;
use Alcor\Payroll\SharedKernel\Infrastructure\NullTransaction;
use Alcor\Payroll\SharedKernel\Infrastructure\PdoEventStore;
use Alcor\Payroll\SharedKernel\Infrastructure\PdoTransaction;
use Alcor\Payroll\SharedKernel\Infrastructure\SimpleCommandBus;
use Alcor\Payroll\SharedKernel\Infrastructure\SimpleQueryBus;
use Alcor\Payroll\SharedKernel\Infrastructure\SynchronousEventBus;
use Alcor\Payroll\Workforce\Application\Command\ChangeSourceData;
use Alcor\Payroll\Workforce\Application\Command\ChangeSourceDataHandler;
use Alcor\Payroll\Workforce\Application\Command\HireEmployee;
use Alcor\Payroll\Workforce\Application\Command\HireEmployeeHandler;
use Alcor\Payroll\Workforce\Application\Query\EmployeeQueryHandler;
use Alcor\Payroll\Workforce\Application\Query\GetEmployee;
use Alcor\Payroll\Workforce\Application\Query\ListEmployees;
use Alcor\Payroll\Workforce\Domain\EmployeeRepository;
use Alcor\Payroll\Workforce\Infrastructure\InMemoryEmployeeRepository;
use Alcor\Payroll\Workforce\Infrastructure\PdoEmployeeRepository;
use PDO;
use Psr\Clock\ClockInterface;

/**
 * Composition root: the only place that knows every context and picks the adapters.
 * Callers (CLI, web page, tests) talk to the application through `$commands` and `$queries` only.
 */
final readonly class PayrollApp
{
    private function __construct(
        public CommandBus $commands,
        public QueryBus $queries,
        public SynchronousEventBus $events,
        public EventStore $eventStore,
        private AuditProjection $projection,
        private AuditProjector $projector,
        private Transaction $transaction,
    ) {}

    public static function inMemory(ClockInterface $clock): self
    {
        $audit = new InMemoryAuditStore();

        return self::wire($clock, new InMemoryEventStore(), new InMemoryEmployeeRepository(), $audit, $audit, new NullTransaction());
    }

    public static function mysql(PDO $pdo, ClockInterface $clock, string $prefix = MySqlSchema::PREFIX): self
    {
        $audit = new PdoAuditStore($pdo, $prefix);
        $store = new PdoEventStore($pdo, new EventRegistry(self::EARNING_EVENTS), $prefix);

        return self::wire($clock, $store, new PdoEmployeeRepository($pdo, $prefix), $audit, $audit, new PdoTransaction($pdo));
    }

    /** Throws the Audit read model away and rebuilds it by replaying every stored event. @return int events replayed */
    public function rebuildProjections(): int
    {
        return $this->transaction->run(function (): int {
            $this->projection->reset();

            $count = 0;
            foreach ($this->eventStore->all() as $event) {
                ($this->projector)($event);
                $count++;
            }

            return $count;
        });
    }

    /** Event types that are stored (the Earning stream). */
    private const EARNING_EVENTS = [LineCalculated::class, SystemValueRecalculated::class, RecalculationIgnored::class, AdjustmentAdded::class];

    private static function wire(
        ClockInterface $clock,
        EventStore $store,
        EmployeeRepository $employees,
        AuditProjection $projection,
        AuditReadModel $readModel,
        Transaction $transaction,
    ): self {
        $commands = new SimpleCommandBus();
        $queries = new SimpleQueryBus();
        $events = new SynchronousEventBus();

        // Read side: the projector keeps the Audit read model current from Earning events.
        $projector = new AuditProjector($projection);
        $events->subscribe('*', $projector);

        // Workforce
        $commands->register(HireEmployee::class, new HireEmployeeHandler($employees, $clock, $events, $transaction));
        $commands->register(ChangeSourceData::class, new ChangeSourceDataHandler($employees, $clock, $events, $transaction));
        $employeeQueries = new EmployeeQueryHandler($employees);
        $queries->register(GetEmployee::class, $employeeQueries->get(...));
        $queries->register(ListEmployees::class, $employeeQueries->list(...));

        // Earning (event sourced), calculating through the PayrollCalculation adapter
        $lines = new EventSourcedEarningLineRepository($store);
        $calculator = new StubSalaryCalculator($queries);
        $commands->register(CalculateEarningLine::class, new CalculateEarningLineHandler($lines, $calculator, $clock, $events, $transaction));
        $commands->register(AddAdjustment::class, new AddAdjustmentHandler($lines, $clock, $events, $transaction));

        // Audit queries
        $auditQueries = new AuditQueryHandler($readModel, $queries);
        $queries->register(GetLine::class, $auditQueries->line(...));
        $queries->register(GetLines::class, $auditQueries->lines(...));
        $queries->register(GetAudit::class, $auditQueries->report(...));

        return new self($commands, $queries, $events, $store, $projection, $projector, $transaction);
    }
}
