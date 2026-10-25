<?php

declare(strict_types=1);

// Wires the application against MySQL (DB_* env vars, default MySQL-8.4 / alcortest / root).

require __DIR__ . '/vendor/autoload.php';

use Alcor\Payroll\MySqlSchema;
use Alcor\Payroll\PayrollApp;
use Alcor\Payroll\SystemClock;

$pdo = MySqlSchema::connectFromEnv();

return [
    'pdo' => $pdo,
    'app' => PayrollApp::mysql($pdo, new SystemClock()),
];
