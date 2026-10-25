<?php

declare(strict_types=1);

namespace Alcor\Payroll;

use PDO;

/**
 * MySQL schema of the whole application (composition level: it knows every context's tables).
 *
 *  - `events`       the event store; append-only, triggers refuse UPDATE and DELETE (source of truth of earning lines)
 *  - `employees`    state-stored employees and their salary source data
 *  - `line_view`, `audit_entry`  the Audit read model; disposable, rebuilt from `events` by PayrollApp::rebuildProjections()
 *
 * All tables share a prefix so tests can use their own copy.
 */
final class MySqlSchema
{
    public const PREFIX = 'pure_';

    /** @return list<string> */
    public static function statements(string $p = self::PREFIX): array
    {
        return [
            "CREATE TABLE IF NOT EXISTS {$p}employees (
                id VARCHAR(64) NOT NULL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                currency CHAR(3) NOT NULL,
                base_salary_cents BIGINT NOT NULL,
                benefits_deduction_cents BIGINT NOT NULL DEFAULT 0,
                bonus_cents BIGINT NOT NULL DEFAULT 0
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            "CREATE TABLE IF NOT EXISTS {$p}events (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                stream_id VARCHAR(120) NOT NULL,
                version INT UNSIGNED NOT NULL,
                event_type VARCHAR(100) NOT NULL,
                payload JSON NOT NULL,
                occurred_at DATETIME(6) NOT NULL,
                UNIQUE KEY stream_version (stream_id, version)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            "DROP TRIGGER IF EXISTS {$p}events_no_update",
            "CREATE TRIGGER {$p}events_no_update BEFORE UPDATE ON {$p}events FOR EACH ROW
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'events is append-only: updates are not allowed'",
            "DROP TRIGGER IF EXISTS {$p}events_no_delete",
            "CREATE TRIGGER {$p}events_no_delete BEFORE DELETE ON {$p}events FOR EACH ROW
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'events is append-only: deletes are not allowed'",

            "CREATE TABLE IF NOT EXISTS {$p}line_view (
                line_id VARCHAR(120) NOT NULL PRIMARY KEY,
                employee_id VARCHAR(64) NOT NULL,
                period CHAR(7) NOT NULL,
                currency CHAR(3) NOT NULL,
                system_value_cents BIGINT NOT NULL,
                current_value_cents BIGINT NOT NULL,
                frozen TINYINT(1) NOT NULL DEFAULT 0,
                adjustment_count INT UNSIGNED NOT NULL DEFAULT 0,
                KEY employee_period (employee_id, period)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            "CREATE TABLE IF NOT EXISTS {$p}audit_entry (
                line_id VARCHAR(120) NOT NULL,
                event_no INT UNSIGNED NOT NULL,
                type ENUM('system_calculated', 'system_ignored', 'adjustment') NOT NULL,
                amount_cents BIGINT NOT NULL,
                balance_cents BIGINT NOT NULL,
                comment TEXT NULL,
                actor VARCHAR(255) NULL,
                adjustment_no INT UNSIGNED NULL,
                occurred_at DATETIME(6) NOT NULL,
                PRIMARY KEY (line_id, event_no),
                KEY occurred (line_id, occurred_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        ];
    }

    public static function install(PDO $pdo, string $p = self::PREFIX): void
    {
        foreach (self::statements($p) as $sql) {
            $pdo->exec($sql);
        }
    }

    /** Dropping tables is allowed (it needs DDL rights); row deletes are what the triggers refuse. */
    public static function drop(PDO $pdo, string $p = self::PREFIX): void
    {
        $pdo->exec("DROP TABLE IF EXISTS {$p}audit_entry, {$p}line_view, {$p}events, {$p}employees");
    }

    /** Tables of the earlier versions of this project (single-line version, then the state-based payroll lines). */
    public static function dropLegacy(PDO $pdo): void
    {
        $pdo->exec('DROP TABLE IF EXISTS pure_earning_line_adjustments, pure_earning_lines, pure_line_events, pure_payroll_lines');
    }

    public static function connectFromEnv(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            getenv('DB_HOST') ?: 'MySQL-8.4',
            getenv('DB_PORT') ?: '3306',
            getenv('DB_DATABASE') ?: 'alcortest',
        );

        return new PDO($dsn, getenv('DB_USERNAME') ?: 'root', getenv('DB_PASSWORD') ?: '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}
