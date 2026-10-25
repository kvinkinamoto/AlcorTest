# Payroll adjustments — Laravel 13 + `nodex/nexus` modules

Same business rules as `../php-pure`, built as Nexus admin modules: employees, a salary calculation stub whose result is fixed per period, manual corrections with a permanent audit trail, and an audit report per employee with a date filter.

## Setup

One command installs everything (it is re-runnable):

```
composer setup            # composer install, .env, app key, payroll:install, npm install + build
```

or, if the dependencies and `.env` are already in place (DB: MySQL-8.4 / alcortest / root / no password):

```
php artisan payroll:install            # migrations (app + module, in dependency order), nexus modules + permissions,
                                       # admin@example.com / password (local demo), demo employees (Anna gets the assignment table)
php artisan payroll:install --fresh    # same, but drops every table first
php artisan serve                      # http://localhost:8000/admin   (OSPanel: https://alcor-nexus.local/admin)
php artisan test                       # 25 tests (in-memory sqlite, MySQL data is untouched)
```

## Quick start from the database dump

`database/alcortest.sql` is a dump of the shared `alcortest` database (all three variants' tables, triggers and the demo data, including the admin login below). `.env` already holds the connection to that database (`DB_HOST=MySQL-8.4`, `DB_DATABASE=alcortest`, `root`, empty password) and an app key, so installing the dependencies is enough; no `payroll:install` is needed. Login: `admin@example.com` / `password`.

```
mysql -h MySQL-8.4 -u root < database/alcortest.sql        # creates and fills the `alcortest` database
composer install
npm install && npm run build                                 # only if public/build is missing
php artisan serve
```

The dump is only a shortcut: the migrations / `bin/payroll migrate` build the same schema from scratch.

Admin menu **Payroll**:
- **Employees** — CRUD + salary source data (base, benefits deduction, bonus). Row button **Calculate payroll** opens a small period form and runs the salary stub.
- **Payroll lines** — one row per employee × period (system value, current value, frozen flag). Row buttons **Recalculate** (re-run the stub) and **Audit**. Lines cannot be created, edited or deleted by hand.
- **Adjustments** — the only place to add a correction (line, signed amount, mandatory comment; the author is the logged-in admin). No edit, no delete.
- **Payroll audit** — pick an employee, optionally a period and `From`/`To` dates (empty = entire history). Running totals, opening balance for a date window, authors, comments, **Export CSV**.

CLI:

```
php artisan payroll:calculate "Anna Koval" 2026-01
php artisan payroll:adjust "Anna Koval" 2026-01 -45.55 "Employee declined dental benefit" --actor=Olena [--key=<idempotency key>]
php artisan payroll:audit "Anna Koval" [--period=2026-01] [--from=2026-01-05] [--to=2026-01-31] [--csv]
```

## Modules used / written

| Module | Source |
|---|---|
| Auth, User, Permission, Role | published from the package (`nexus:default_module:publish`) — admin login and permissions |
| `Employee`, `PayrollLine`, `PayrollAudit`, `PayrollAdjustment` | **written** for this task |

Nothing from `nexus-modules-archive` was taken: its 65 modules are shop/book content (Cart, Order, Book, …) and none relates to payroll.

## Design

| Piece | Role |
|---|---|
| `nx_employees` | Employee + salary source data. |
| `nx_payroll_lines` | One row per employee × period (unique). Holds the last *applied* system value. Written only by `CalculatePayroll` (`PayrollLine::$systemWrite` guard). |
| `nx_payroll_line_events` | **Append-only ledger**: system calculations (applied or ignored) and adjustments, numbered per line, each row carrying the `balance_after`. Model `PayrollLineEvent`; `PayrollAdjustment` is its `kind = adjustment` slice with the entry form. |
| `App\Payroll\SalarySource` / `StubSalarySource` | Port + stub of the payroll engine (`base − benefits + bonus`), bound in `AppServiceProvider`. |
| `App\Payroll\CalculatePayroll` | Creates the line, recalculates it, or — once adjusted — only logs the attempt (`Created / Recalculated / Ignored`). |
| `App\Payroll\AdjustPayrollLine` | CLI/programmatic path; idempotent by key. The admin form uses the same model hooks. |
| `App\Payroll\Events\*` | Domain events (`SystemValueCalculated`, `SystemRecalculationIgnored`, `ManualAdjustmentAdded`) dispatched after commit; adjustments are announced from the model so the admin form and the CLI behave the same. |
| `App\Payroll\Audit\AuditBuilder` | Sections per period, date window, opening balance. |
| `App\Payroll\Money` | Immutable value object (integer cents + currency), shared with the other versions. |

### Rules and how they are enforced

- **No edit / delete** — `PayrollLineEvent` throws `AuditTrailIsImmutable` on update/delete; lines and employees with history cannot be deleted; FKs are `restrictOnDelete`; MySQL `BEFORE UPDATE/DELETE` triggers reject raw SQL; the UI has no edit/delete for adjustments (`#[TableAction(isActive: false)]`). A mistake is fixed by a compensating adjustment.
- **Freeze** — `CalculatePayroll` checks `isAdjusted()` under a row lock; after the first adjustment the result is logged with `applied = false` and shown as "System recalculation ignored".
- **Current value** is the latest ledger balance (= system value + adjustments); a test recomputes every stored balance from the events.
- **Concurrency** — the model's `save()` runs in a transaction and `creating` locks the line row (`lockForUpdate`) before numbering the event and computing the balance; `(line, event_no)` is also unique.
- **Idempotency** — optional key per adjustment (CLI/API); re-sending it returns the saved row.
- **Date window** — rows are filtered by `occurred_at` (inclusive, `to` = end of day); the opening balance is the balance of the last event before `from`, so running totals stay correct.

## Notes and assumptions

- Tables use the `nx_` prefix because the three implementations share one MySQL database.
- Model classes declare `#[Column]`/`#[Field]` marker properties, which shadow plain property access *inside* the class; model code therefore uses `getAttribute()`/`setAttribute()`.
- Nexus table filters have no date type (only search/select), which is why the audit is a custom `index` in `PayrollAudit\Http\Controllers\AdminController` rather than a table.
- `PayrollAdjustment/database/migrations/*_create_payroll_adjustments_table.php` is an empty scaffold migration (adjustments live in the events table) and can be deleted.
- The package ships duplicate module migrations (`user_user_…`, `permission_permission_…`) that break a fresh `migrate`; the duplicates were deleted from `app/Nexus/Modules/*/database/migrations`. `nexus:install` also fails on a clean database because permissions are created before Permission's `display_name` migration — hence `payroll:install` runs the module migrations explicitly, in order.
- The table **Export** button needs the package's `Export` module, which is missing from nodex/nexus v1.0.x; `app/Nexus/Modules/Export/Jobs/MasterExportJob.php` is taken from the package's development tree and runs inline (no queue worker needed). The CSV follows the table's current filters.
- The generic bulk action "Delete selected" cannot be disabled by attribute in this package version; it reaches the model, which refuses the delete.
- One base-salary line per employee per calendar month; a line may go negative; no payroll-close step; all admins with module permission may adjust.
