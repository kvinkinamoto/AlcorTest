<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tables of the first, single-line version of this project.
        Schema::dropIfExists('nx_earning_line_adjustments');
        Schema::dropIfExists('nx_earning_lines');

        Schema::create('nx_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('currency', 3)->default('USD');
            // Salary source data used by the stub calculation: base - benefits deduction + bonus.
            $table->decimal('base_salary', 14, 2);
            $table->decimal('benefits_deduction', 14, 2)->default(0);
            $table->decimal('bonus', 14, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nx_employees');
    }
};
