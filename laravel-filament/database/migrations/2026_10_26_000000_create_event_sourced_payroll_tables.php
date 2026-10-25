<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tables of the earlier versions of this project (single-line version, then state-based payroll lines).
        Schema::dropIfExists('payroll_line_events');
        Schema::dropIfExists('payroll_lines');
        Schema::dropIfExists('earning_line_adjustments');
        Schema::dropIfExists('earning_lines');
        Schema::dropIfExists('employees');

        // Workforce: state-stored employees and the data their salary is calculated from. The id is a ULID chosen by the domain.
        Schema::create('employees', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('name');
            $table->char('currency', 3)->default('USD');
            $table->decimal('base_salary', 14, 2);
            $table->decimal('benefits_deduction', 14, 2)->default(0);
            $table->decimal('bonus', 14, 2)->default(0);
            $table->timestamps();
        });

        // Earning: the event store, source of truth of every earning line. One stream per line ("employee:YYYY-MM").
        Schema::create('payroll_events', function (Blueprint $table) {
            $table->id();
            $table->string('stream_id', 120);
            $table->unsignedInteger('version');
            $table->string('event_type', 100);
            $table->json('payload');
            $table->dateTime('occurred_at', 6);

            $table->unique(['stream_id', 'version']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::unprepared("CREATE TRIGGER payroll_events_no_update BEFORE UPDATE ON payroll_events FOR EACH ROW
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'payroll_events is append-only: updates are not allowed'");
            DB::unprepared("CREATE TRIGGER payroll_events_no_delete BEFORE DELETE ON payroll_events FOR EACH ROW
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'payroll_events is append-only: deletes are not allowed'");
        }

        // Audit: the read model, built from the events and disposable (php artisan payroll:rebuild).
        Schema::create('payroll_line_views', function (Blueprint $table) {
            $table->string('line_id', 120)->primary();
            $table->string('employee_id', 64);
            $table->char('period', 7);
            $table->char('currency', 3);
            $table->bigInteger('system_value_cents');
            $table->bigInteger('current_value_cents');
            $table->boolean('frozen')->default(false);
            $table->unsignedInteger('adjustment_count')->default(0);

            $table->index(['employee_id', 'period']);
        });

        Schema::create('payroll_audit_entries', function (Blueprint $table) {
            $table->string('line_id', 120);
            $table->unsignedInteger('event_no');
            $table->string('type', 30); // system_calculated | system_ignored | adjustment
            $table->bigInteger('amount_cents');
            $table->bigInteger('balance_cents');
            $table->text('comment')->nullable();
            $table->string('actor')->nullable();
            $table->unsignedInteger('adjustment_no')->nullable();
            $table->dateTime('occurred_at', 6);

            $table->primary(['line_id', 'event_no']);
        });
    }

    public function down(): void
    {
        // Dropping the table removes its triggers; the event store is intentionally not rolled back row by row.
        Schema::dropIfExists('payroll_audit_entries');
        Schema::dropIfExists('payroll_line_views');
        Schema::dropIfExists('payroll_events');
        Schema::dropIfExists('employees');
    }
};
