<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Infrastructure;

use Alcor\Payroll\SharedKernel\Application\Transaction;
use PDO;
use Throwable;

final readonly class PdoTransaction implements Transaction
{
    public function __construct(private PDO $pdo) {}

    public function run(callable $work): mixed
    {
        if ($this->pdo->inTransaction()) {
            return $work(); // joins the caller's transaction
        }

        $this->pdo->beginTransaction();
        try {
            $result = $work();
            $this->pdo->commit();

            return $result;
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
