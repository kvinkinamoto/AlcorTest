<?php

use Illuminate\Database\Migrations\Migration;

// Adjustments are rows of nx_payroll_line_events (PayrollAudit module) with kind = 'adjustment',
// so this module needs no table of its own. The file is the empty scaffold migration and can be deleted.
return new class extends Migration
{
    public function up(): void
    {
    }

    public function down(): void
    {
    }
};
