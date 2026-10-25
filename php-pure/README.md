# Payroll adjustments — pure PHP 8.5 (DDD + CQRS + Event Sourcing)

Employees, an automatic salary calculation (a stub), manual corrections with a permanent audit trail, and an audit report per employee (full history or a date window). No framework: plain PHP, PDO/MySQL, PHPUnit.

```
composer install
php bin/payroll migrate          # MySQL tables (DB_HOST=MySQL-8.4, DB_DATABASE=alcortest, root, no password; override via env)
php bin/payroll seed             # employees anna, bohdan, olena; Anna's line replays the assignment table
php bin/payroll scenario         # the assignment table on in-memory adapters (no database), step by step
composer test                    # PHPUnit: 123 tests (the MySQL ones use their own pure_test_* tables)
```

Web UI: `public/` (OSPanel: https://alcor-pure.local) — pick an employee, change salary source data, run the calculation, add an adjustment, read the audit with a date filter, export CSV.

```
php bin/payroll set-source anna --base=1050
php bin/payroll calculate anna 2026-01          # created | recalculated | ignored
php bin/payroll adjust anna 2026-01 -45.55 "Employee declined dental benefit" --actor=olena [--key=<idempotency key>]
php bin/payroll audit anna                      # full history, all periods
php bin/payroll audit anna --from=2026-01-05 --to=2026-01-31 [--period=2026-01] [--csv]
php bin/payroll stream anna 2026-01             # the raw event stream of one line (the source of truth)
php bin/payroll rebuild                         # drop the audit read model and rebuild it from the events
```

## Quick start from the database dump

`database/alcortest.sql` is a dump of the shared `alcortest` database (the tables, triggers and demo data of all three variants, including the admin login of the Laravel ones). The connection defaults in `MySqlSchema::connectFromEnv()` already point to that database (`MySQL-8.4`, `alcortest`, `root`, empty password; override with `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), so installing the dependencies is enough.

```
mysql -h MySQL-8.4 -u root < database/alcortest.sql        # creates and fills the `alcortest` database
composer install
php bin/payroll employees                                   # works straight away
```

The dump is only a shortcut: `bin/payroll migrate && bin/payroll seed` build the same thing from scratch.

## Design: DDD + CQRS + Event Sourcing

The code is split into **bounded contexts**, each with its own `Domain`, `Application` and `Infrastructure` layers (`src/<Context>/...`).

| Context | Responsibility | Core |
|---|---|---|
| **Earning** (core domain) | The earning line of one employee for one month: system value, manual corrections, freezing | `EarningLine` — an **event-sourced aggregate** |
| **Workforce** | Employees and the source data their salary is calculated from | `Employee` aggregate (state-stored), `EmployeeView` read model |
| **PayrollCalculation** | The automatic calculation. A stub of the real engine, and the **anti-corruption layer** between it and Earning | `StubSalaryCalculator` implements Earning's `SalaryCalculator` port |
| **Audit** (read side) | Current value and audit history, date windows, CSV | Projections (`line_view`, `audit_entry`) and queries |
| **SharedKernel** | Only what everybody must agree on | `Money`, `Period`, `DomainEvent`, `EventSourcedAggregate`, the bus and event-store ports |

`src/PayrollApp.php` is the composition root (the only place that knows every context); the CLI, the web page and the tests talk to the application through `$app->commands` and `$app->queries` only.

**Context map.** Contexts never share classes or tables. Earning knows nothing about the others. PayrollCalculation is a *downstream* adapter: it implements an Earning port and asks Workforce through a **query** (never its repository). Audit is *downstream* of Earning (it subscribes to its events) and asks Workforce for an employee's name through a query. `tests/ArchitectureTest.php` enforces this: the domain imports no Application/Infrastructure and no PDO, the application layer imports no Infrastructure, and a context may import another only through the seams above.

**Ubiquitous language.** *Earning line* — one employee × one month. *System value* — what the automatic calculation produced. *Manual correction / adjustment* — a signed amount with a mandatory comment added by a payroll specialist. *Freeze* — after the first correction the system can no longer change the line. *Audit entry* — one row of the history. *Current value* — system value plus all corrections.

### Event Sourcing (Earning)

`EarningLine` stores nothing but its events: `LineCalculated`, `SystemValueRecalculated`, `RecalculationIgnored`, `AdjustmentAdded`. A command asks the aggregate to decide, the aggregate records an event and applies it to itself (`recordThat` → `apply`); its state (system value, current value, frozen, idempotency keys) exists only as those events applied in order. The repository loads the stream, `EarningLine::fromHistory()` replays it, and `save()` appends the new events to the **event store** with an expected version (optimistic concurrency, `UNIQUE (stream_id, version)`; the loser gets `ConcurrencyConflict`). The stream id is `employee:YYYY-MM`. MySQL triggers on `events` refuse UPDATE and DELETE.

### CQRS

*Write side*: command objects (`CalculateEarningLine`, `AddAdjustment`, `HireEmployee`, `ChangeSourceData`) go through a `CommandBus` to one handler each; a handler runs in a transaction: load the aggregate → call it → append events → publish them. *Read side*: query objects (`GetLine`, `GetLines`, `GetAudit`, `GetEmployee`, `ListEmployees`) go through a `QueryBus` and read only the **projections**. The `AuditProjector` subscribes to the event bus and keeps `line_view` (current state) and `audit_entry` (rows with running totals) up to date in the same transaction as the events, so the read side is never behind. The projections are disposable: `bin/payroll rebuild` drops them and replays every stored event (a test proves the rebuilt model equals the live one).

### Domain model

Value objects with their own validation: `Money` (integer cents + currency), `Period`, `EarningLineId`, `Comment` (non-empty), `Actor` (non-empty), `IdempotencyKey`. Domain exceptions: `CommentRequired`, `ActorRequired`, `ZeroAdjustment`, `LineNotCalculated`, `CurrencyMismatch`, `EmployeeNotFound`. Repositories are interfaces in the domain; PDO and in-memory adapters live in infrastructure.

### Rules and where they live

- **Corrections are never edited or deleted** — `EarningLine` has no method that does it, events are `readonly`, and MySQL refuses UPDATE/DELETE on the store. A mistake is fixed by a compensating correction (steps 7→8 of the assignment).
- **Freeze** — `EarningLine::calculate()` replaces the system value only while there is no correction. Afterwards it records `RecalculationIgnored` (shown in the audit as "System recalculation ignored") and the line is unchanged. The outcome is `created | recalculated | ignored`.
- **Current value is derived** (system value + Σ corrections) from the events, never stored on the aggregate.
- **Validation** — comment, actor and a non-zero amount are mandatory; the currency must match the line; a line must be calculated before it can be corrected.
- **Idempotency** — an optional key per correction; sending it again (double click, retry) returns the original number and records nothing.
- **Concurrency** — stream versions as above; the web form also sends a fresh key.
- **Audit window** — `AuditSectionAssembler` applies `[from, to]` (inclusive, `to` = end of day); entries before `from` collapse into an *opening balance*, so running totals stay correct.

### Why event sourcing here

The business case is "current value **and** the full history that produced it, nothing ever edited": that is what an event stream is. The history is the model, the current value is a fold over it, and the audit read model can be rebuilt or reshaped without touching the data.

## Assumptions

- One earning line per employee per calendar month, created by the first calculation.
- The actor of a correction is whatever `--actor` / the form says; there are no roles (a natural next step: a "payroll specialist" policy).
- Employees are state-stored; only their changes are announced as events (`EmployeeHired`, `EmployeeSourceDataChanged`). Nothing reacts to them yet — a calculation is always an explicit command.
- Projections are updated synchronously; moving them to a queue would only change the event bus adapter.
- A line may go negative; there is no payroll-close or approval step.
- Name and currency are fixed at hiring; only the salary source data can change.
- `bin/payroll migrate` drops the tables of earlier versions of this project (`pure_payroll_lines`, `pure_line_events`, …).
