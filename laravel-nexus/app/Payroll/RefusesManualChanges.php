<?php

namespace App\Payroll;

use Illuminate\Foundation\Http\FormRequest;
use Nodex\Nexus\Models\Module;

/**
 * Closes the generic create/edit/delete routes of append-only modules. The buttons are already hidden,
 * but the URLs (e.g. /admin/payrollAdjustment/action/edit/5) would otherwise still open the generic form.
 */
trait RefusesManualChanges
{
    public function edit(FormRequest $request, Module $module, ?string $id = null)
    {
        return $this->refuse($module);
    }

    public function update(FormRequest $request, Module $module, ?string $id = null)
    {
        return $this->refuse($module);
    }

    public function delete(FormRequest $request, Module $module, ?string $id = null)
    {
        return $this->refuse($module);
    }

    public function deletePermanent(FormRequest $request, Module $module, ?string $id = null)
    {
        return $this->refuse($module);
    }

    public function restore(FormRequest $request, Module $module, ?string $id = null)
    {
        return $this->refuse($module);
    }

    public function deleteGroup(FormRequest $request, Module $module)
    {
        return $this->refuse($module);
    }

    private function refuse(Module $module)
    {
        return redirect()
            ->route('nexus.module.action', ['module' => $module->name, 'action' => 'index'])
            ->with('alert_message', 'Saved payroll records cannot be edited or deleted; add a compensating adjustment instead.')
            ->with('alert_type', 'warning');
    }
}
