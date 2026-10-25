<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Append-only audit log: system calculations (applied or ignored) and manual adjustments.
        Schema::create('nx_payroll_line_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_line_id')->constrained('nx_payroll_lines')->restrictOnDelete();
            $table->unsignedInteger('event_no');
            $table->string('kind', 20); // calculation | adjustment
            $table->decimal('amount', 14, 2); // calculated value, or signed delta for adjustments
            $table->decimal('balance_after', 14, 2); // line value right after this event (ledger style)
            $table->boolean('applied')->nullable(); // calculations only
            $table->unsignedInteger('sequence')->nullable(); // adjustments only: 1, 2, 3 ...
            $table->text('comment')->nullable();
            $table->string('actor')->nullable();
            $table->string('idempotency_key', 100)->nullable();
            $table->dateTime('occurred_at', 6);

            $table->unique(['payroll_line_id', 'event_no']);
            $table->unique(['payroll_line_id', 'idempotency_key']);
            $table->index(['payroll_line_id', 'occurred_at']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::unprepared("CREATE TRIGGER nx_payroll_line_events_no_update BEFORE UPDATE ON nx_payroll_line_events FOR EACH ROW
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'nx_payroll_line_events is append-only: updates are not allowed'");
            DB::unprepared("CREATE TRIGGER nx_payroll_line_events_no_delete BEFORE DELETE ON nx_payroll_line_events FOR EACH ROW
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'nx_payroll_line_events is append-only: deletes are not allowed'");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('nx_payroll_line_events');
    }
};
