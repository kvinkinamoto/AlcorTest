# Payroll adjustments — Laravel 13 + Filament 5 (DDD + CQRS + Event Sourcing)

The same business rules and the same domain as `../php-pure`, wired into Laravel: employees, a salary calculation stub, manual corrections with a permanent audit trail, and an audit page per employee with a date filter. Filament is only the user interface: it sends commands and reads projections.

```
composer install && cp .env.example .env && php artisan key:generate   # DB: MySQL-8.4 / alcortest / root / no password
php artisan migrate --seed       # tables + admin@example.com / password + employees; Anna gets the assignment table
php artisan serve                # http://localhost:8000/admin   (OSPanel: https://alcor-filament.local/admin)
php artisan test                 # 108 tests (in-memory sqlite, MySQL data is untouched)
```

## Quick start from the database dump

`database/alcortest.sql` is a dump of the shared `alcortest` database (the tables, triggers and demo data of all three variants, including the admin login below). `.env` already holds the connection to that database (`DB_HOST=MySQL-8.4`, `DB_DATABASE=alcortest`, `root`, empty password) and an app key, so installing the dependencies is enough; no `migrate` is needed. Login: `admin@example.com` / `password`.

```
mysql -h MySQL-8.4 -u root < database/alcortest.sql        # creates and fills the `alcortest` database
composer install
php artisan serve
```

The dump is only a shortcut: `php artisan migrate --seed` builds the same thing from scratch.

Panel:
- **Employees** — hire an employee (`HireEmployee`) and change their salary source data (`ChangeSourceData`: base, benefits deduction, bonus; name and currency are fixed at hiring). Row/header action **Calculate payroll** (`CalculateEarningLine`); the relation tab **Payroll periods** shows system value, current value, the frozen flag, and **Add adjustment** (`AddAdjustment`: signed amount + mandatory comment; the author is the logged-in user).
- **Payroll audit** — pick an employee, optionally a period and/or `From`/`To` dates (empty dates = entire history). Running totals, an opening balance for a date window, authors, comments; **Export CSV**.

CLI:

```
php artisan payroll:calculate "Anna Koval" 2026-01
php artisan payroll:adjust "Anna Koval" 2026-01 -45.55 "Employee declined dental benefit" --actor=Olena [--key=<idempotency key>]
php artisan payroll:audit "Anna Koval" [--period=2026-01] [--from=2026-01-05] [--to=2026-01-31] [--csv]
php artisan payroll:rebuild            # drop the audit read model and rebuild it from the stored events
```

## Design: DDD + CQRS + Event Sourcing

The domain is the same framework-free code as in `../php-pure`, under `app/Payroll/`, split into **bounded contexts** with their own `Domain`, `Application` and `Infrastructure` layers:

| Context | Responsibility | Core |
|---|---|---|
| **Earning** (core domain) | The earning line of one employee for one month: system value, manual corrections, freezing | `EarningLine` — an **event-sourced aggregate** |
| **Workforce** | Employees and their salary source data | `Employee` aggregate (state-stored), `EmployeeView` read model |
| **PayrollCalculation** | The automatic calculation; a stub of the real engine and the **anti-corruption layer** towards Earning | `StubSalaryCalculator` implements Earning's `SalaryCalculator` port |
| **Audit** (read side) | Current value and history, date windows, CSV | Projections `payroll_line_views`, `payroll_audit_entries` and queries |
| **SharedKernel** | What everybody must agree on | `Money`, `Period`, `DomainEvent`, `EventSourcedAggregate`, bus and event-store ports |

Laravel is confined to infrastructure and presentation:

| Piece | Role |
|---|---|
| `App\Providers\PayrollServiceProvider` | Composition root: binds the ports to adapters and registers every command and query handler on the buses |
| `SharedKernel\Infrastructure\DbEventStore` | The event store (`payroll_events`, unique `(stream_id, version)`; MySQL triggers refuse UPDATE/DELETE) |
| `Audit\Infrastructure\DbAuditStore` | Projection and read model (`payroll_line_views`, `payroll_audit_entries`) |
| `Workforce\Infrastructure\DbEmployeeRepository` | State-stored employees (`employees`) |
| `App\Models\Employee`, `App\Models\PayrollLine` | **Read-only** Eloquent models over `employees` and `payroll_line_views`, for Filament tables; nothing writes through them |
| `App\Filament\...`, `app/Console/Commands` | Presentation: build a command or a query, send it through `CommandBus` / `QueryBus` |

**Event Sourcing.** `EarningLine` keeps nothing but events (`LineCalculated`, `SystemValueRecalculated`, `RecalculationIgnored`, `AdjustmentAdded`); its state is those events applied in order. The repository replays the stream, `save()` appends new events with the expected version (optimistic concurrency: a second writer gets `ConcurrencyConflict`).

**CQRS.** Commands (`CalculateEarningLine`, `AddAdjustment`, `HireEmployee`, `ChangeSourceData`) go through the `CommandBus`; a handler runs in a database transaction: load → decide → append events → publish. Queries (`GetLine`, `GetLines`, `GetAudit`, `GetEmployee`, `ListEmployees`) go through the `QueryBus` and read only projections. The `AuditProjector` updates them synchronously, in the same transaction as the events; `payroll:rebuild` throws them away and replays the store (a test proves the rebuilt model equals the live one).

**Boundaries are tested** — `tests/Unit/Payroll/ArchitectureTest.php` fails if a domain or application class imports the framework or infrastructure, or if a context imports another one other than through the published seams (an Earning port, Workforce queries, Earning events).

### Rules and where they live

- **Corrections are never edited or deleted** — the aggregate has no method for it, events are `readonly`, MySQL refuses UPDATE/DELETE on `payroll_events`. A mistake is fixed by a compensating correction (steps 7→8 of the assignment).
- **Freeze** — after the first correction a recalculation records `RecalculationIgnored` (shown in the audit as "System recalculation ignored") and changes nothing.
- **Current value is derived** from the events (system value + Σ corrections).
- **Validation** — comment, actor and a non-zero amount are mandatory (value objects and domain exceptions); the currency must match the line.
- **Idempotency** — the Filament form sends a UUID key; re-sending it records nothing new.
- **Audit window** — `[from, to]` inclusive (`to` = end of day); earlier entries collapse into an opening balance.

## Assumptions

- One earning line per employee per calendar month, created by the first calculation.
- Any logged-in panel user may correct a line; there are no roles yet (a natural next step: a "payroll specialist" policy).
- Employees are state-stored and only announce their changes as events; a calculation is always an explicit command.
- Projections are updated synchronously (a queue would only change the event-bus adapter).
- A line may go negative; there is no payroll-close step.
- The migration drops the tables of earlier versions of this project (`payroll_lines`, `payroll_line_events`, `earning_*`).
