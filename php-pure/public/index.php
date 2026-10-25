<?php

declare(strict_types=1);

// Small web UI over the same commands and queries the CLI uses: pick an employee, run the salary
// stub, change its source data, add adjustments and read the audit (full history or a date window).

use Alcor\Payroll\Audit\Application\Query\GetAudit;
use Alcor\Payroll\Earning\Application\Command\AddAdjustment;
use Alcor\Payroll\Earning\Application\Command\CalculateEarningLine;
use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\SharedKernel\Period;
use Alcor\Payroll\Workforce\Application\Command\ChangeSourceData;
use Alcor\Payroll\Workforce\Application\Query\GetEmployee;
use Alcor\Payroll\Workforce\Application\Query\ListEmployees;

$boot = require __DIR__ . '/../bootstrap.php';
$commands = $boot['app']->commands;
$queries = $boot['app']->queries;

$h = static fn (?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES);
$flash = null;

$employees = $queries->ask(new ListEmployees());
$employeeId = $_REQUEST['employee'] ?? ($employees[0]->id ?? '');
$period = $_REQUEST['period'] ?? date('Y-m');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $employeeId !== '') {
    try {
        $currency = $queries->ask(new GetEmployee($employeeId))->currency;
        $p = Period::parse($period);
        switch ($_POST['action'] ?? '') {
            case 'source':
                $amount = static fn (string $k) => ($_POST[$k] ?? '') !== '' ? $_POST[$k] : null;
                $commands->dispatch(new ChangeSourceData($employeeId, $amount('base'), $amount('benefits'), $amount('bonus')));
                $flash = 'Source data saved. Run the calculation to apply it.';
                break;
            case 'calculate':
                $outcome = $commands->dispatch(new CalculateEarningLine($employeeId, $p));
                $flash = match ($outcome->value) {
                    'created' => 'Line created.',
                    'recalculated' => 'Line recalculated.',
                    'ignored' => 'Recalculation ignored: the line has manual adjustments (logged in the audit).',
                };
                break;
            case 'adjust':
                $commands->dispatch(new AddAdjustment($employeeId, $p, Money::parse($_POST['amount'] ?? '', $currency), $_POST['comment'] ?? '', $_POST['actor'] ?? '', $_POST['key'] ?? null));
                $flash = 'Adjustment saved.';
                break;
        }
    } catch (Throwable $e) {
        $flash = 'Error: ' . $e->getMessage();
    }
}

$from = ($_GET['from'] ?? '') !== '' ? new DateTimeImmutable($_GET['from']) : null;
$to = ($_GET['to'] ?? '') !== '' ? (new DateTimeImmutable($_GET['to']))->setTime(23, 59, 59) : null;
$onlyPeriod = isset($_GET['only_period']) ? Period::parse($period) : null;

if ($employeeId !== '' && ($_GET['csv'] ?? null) !== null) {
    $rows = $queries->ask(new GetAudit($employeeId, $from, $to, $onlyPeriod))->rows();
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=audit-{$employeeId}.csv");
    $out = fopen('php://output', 'w');
    fputcsv($out, array_keys($rows[0] ?? ['employee' => '']), escape: '');
    foreach ($rows as $row) {
        fputcsv($out, $row, escape: '');
    }
    exit;
}

$employee = $employeeId !== '' ? $queries->ask(new GetEmployee($employeeId)) : null;
$report = $employee ? $queries->ask(new GetAudit($employeeId, $from, $to, $onlyPeriod)) : null;
$token = bin2hex(random_bytes(8)); // idempotency key for the adjustment form (double-click safe)
$query = http_build_query(array_filter(['employee' => $employeeId, 'period' => $period, 'from' => $_GET['from'] ?? '', 'to' => $_GET['to'] ?? '', 'only_period' => $_GET['only_period'] ?? '']));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Payroll adjustments (pure PHP)</title>
    <style>
        body { font: 15px/1.5 system-ui, sans-serif; max-width: 980px; margin: 2rem auto; padding: 0 1rem; }
        table { border-collapse: collapse; width: 100%; margin: .5rem 0 1.5rem; }
        td, th { border-bottom: 1px solid #ddd; padding: .35rem .6rem; text-align: left; vertical-align: top; }
        td.n, th.n { text-align: right; font-variant-numeric: tabular-nums; white-space: nowrap; }
        .neg { color: #b00020; } .pos { color: #0a7d2c; } .muted { color: #777; }
        form { display: flex; gap: .5rem; flex-wrap: wrap; align-items: center; margin: .5rem 0; }
        input[name=comment] { flex: 1; min-width: 220px; }
        .flash { background: #fff4d6; padding: .5rem .8rem; border-radius: 4px; }
        fieldset { border: 1px solid #ddd; margin: 1rem 0; border-radius: 4px; }
        legend { font-weight: 600; }
    </style>
</head>
<body>
<h1>Payroll adjustments <small class="muted">pure PHP 8.5 + MySQL</small></h1>

<form method="get">
    <label>Employee
        <select name="employee" onchange="this.form.submit()">
            <?php foreach ($employees as $e): ?>
                <option value="<?= $h($e->id) ?>" <?= $e->id === $employeeId ? 'selected' : '' ?>><?= $h($e->name) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Period <input name="period" value="<?= $h($period) ?>" size="7" pattern="\d{4}-\d{2}"></label>
    <button>Open</button>
</form>
<?php if ($employees === []): ?><p>No employees yet. Run <code>php bin/payroll migrate && php bin/payroll seed</code>.</p><?php endif; ?>
<?php if ($flash): ?><p class="flash"><?= $h($flash) ?></p><?php endif; ?>

<?php if ($employee): ?>
<fieldset>
    <legend>Salary source data (stub)</legend>
    <p class="muted">Salary = base − benefits deduction + bonus. Changing it simulates "source data changed"; the calculation picks it up.</p>
    <form method="post">
        <input type="hidden" name="action" value="source">
        <input type="hidden" name="employee" value="<?= $h($employeeId) ?>"><input type="hidden" name="period" value="<?= $h($period) ?>">
        <label>Base <input name="base" size="9" placeholder="<?= $h($employee->baseSalary->toDecimal()) ?>"></label>
        <label>Benefits <input name="benefits" size="9" placeholder="<?= $h($employee->benefitsDeduction->toDecimal()) ?>"></label>
        <label>Bonus <input name="bonus" size="9" placeholder="<?= $h($employee->bonus->toDecimal()) ?>"></label>
        <button>Save</button>
    </form>
    <form method="post">
        <input type="hidden" name="action" value="calculate">
        <input type="hidden" name="employee" value="<?= $h($employeeId) ?>"><input type="hidden" name="period" value="<?= $h($period) ?>">
        <button>Run calculation for <?= $h($period) ?></button>
    </form>
</fieldset>

<fieldset>
    <legend>Add adjustment to <?= $h($period) ?></legend>
    <form method="post">
        <input type="hidden" name="action" value="adjust">
        <input type="hidden" name="employee" value="<?= $h($employeeId) ?>"><input type="hidden" name="period" value="<?= $h($period) ?>">
        <input type="hidden" name="key" value="<?= $token ?>">
        <input name="amount" placeholder="-45.55" required size="8">
        <input name="comment" placeholder="Comment (required)" required>
        <input name="actor" placeholder="Your name" required size="12">
        <button>Add</button>
    </form>
</fieldset>

<h2>Audit — <?= $h($employee->name) ?></h2>
<form method="get">
    <input type="hidden" name="employee" value="<?= $h($employeeId) ?>"><input type="hidden" name="period" value="<?= $h($period) ?>">
    <label>From <input type="date" name="from" value="<?= $h($_GET['from'] ?? '') ?>"></label>
    <label>To <input type="date" name="to" value="<?= $h($_GET['to'] ?? '') ?>"></label>
    <label><input type="checkbox" name="only_period" value="1" <?= isset($_GET['only_period']) ? 'checked' : '' ?>> only <?= $h($period) ?></label>
    <button>Filter</button>
    <a href="?<?= $h(http_build_query(['employee' => $employeeId, 'period' => $period])) ?>">Full history</a>
    <a href="?<?= $h($query) ?>&csv=1">Export CSV</a>
</form>

<?php if ($report->sections === []): ?>
    <p class="muted">No entries for this selection.</p>
<?php endif; ?>
<?php foreach ($report->sections as $s): ?>
    <h3>Period <?= $h((string) $s->period) ?> <?= $s->frozen ? '<small class="muted">frozen by manual adjustments</small>' : '' ?></h3>
    <table>
        <tr><th>Date</th><th>Entry</th><th class="n">Amount</th><th class="n">Running total</th><th>By</th><th>Comment</th></tr>
        <?php if ($s->opening !== null): ?>
            <tr class="muted"><td></td><td>Opening balance</td><td></td><td class="n"><?= $h($s->opening->format()) ?></td><td></td><td></td></tr>
        <?php endif; ?>
        <?php foreach ($s->entries as $e): ?>
            <tr class="<?= $e->type->value === 'system_ignored' ? 'muted' : '' ?>">
                <td><?= $e->at->format('Y-m-d H:i') ?></td>
                <td><?= $h($e->label()) ?></td>
                <td class="n <?= $e->adjustmentNo === null ? '' : ($e->amount->cents < 0 ? 'neg' : 'pos') ?>"><?= $h($e->amount->format($e->adjustmentNo !== null)) ?></td>
                <td class="n"><?= $h($e->runningTotal->format()) ?></td>
                <td><?= $h($e->actor ?? 'system') ?></td>
                <td><?= $h($e->comment) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr><th colspan="3">Current value (system value <?= $h($s->systemValue->format()) ?>)</th><th class="n"><?= $h($s->currentValue->format()) ?></th><th colspan="2"></th></tr>
    </table>
<?php endforeach; ?>
<?php endif; ?>
</body>
</html>
