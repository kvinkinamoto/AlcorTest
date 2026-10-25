<?php

namespace App\Nexus\Modules\PayrollAdjustment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Nexus\Modules\PayrollAdjustment\Models\PayrollAdjustment;
use App\Payroll\RefusesManualChanges;
use Illuminate\Foundation\Http\FormRequest;
use Nodex\Nexus\Models\Module;

/** Adjustments can be added (create/store) but never edited or deleted. */
class AdminController extends Controller
{
    use RefusesManualChanges;

    /** An adjustment is read in the audit of its line. */
    public function view(FormRequest $request, Module $module, string $id)
    {
        $line = PayrollAdjustment::query()->findOrFail($id)->line;

        return redirect()->route("nexus.module.action", [
            "module" => "PayrollAudit",
            "action" => "index",
            "employee" => $line->employee_id,
            "period" => $line->getAttribute("period"),
        ]);
    }
}
