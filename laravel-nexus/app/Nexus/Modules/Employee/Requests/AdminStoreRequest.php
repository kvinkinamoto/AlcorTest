<?php

namespace App\Nexus\Modules\Employee\Requests;

use App\Nexus\Modules\Employee\Enums\PayrollCurrency;
use Illuminate\Validation\Rule;
use Nodex\Nexus\Http\Requests\NexusFormRequest;

class AdminStoreRequest extends NexusFormRequest
{
    public function rules(): array
    {
        $money = ['required', 'regex:/^\d+(\.\d{1,2})?$/'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'currency' => ['required', Rule::enum(PayrollCurrency::class)],
            'base_salary' => $money,
            'benefits_deduction' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
            'bonus' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
}
