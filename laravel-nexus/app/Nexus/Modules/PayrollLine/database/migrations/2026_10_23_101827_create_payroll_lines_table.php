<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nx_payroll_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('nx_employees')->restrictOnDelete();
            $table->char('period', 7); // YYYY-MM
            $table->char('currency', 3);
            $table->string('label'); // "Employee name — period", shown in selects
            // Last applied automatic calculation; frozen once an adjustment exists.
            $table->decimal('system_value', 14, 2);
            $table->timestamps();

            $table->unique(['employee_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nx_payroll_lines');
    }
};
