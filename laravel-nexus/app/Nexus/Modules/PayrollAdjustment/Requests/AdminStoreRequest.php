<?php

namespace App\Nexus\Modules\PayrollAdjustment\Requests;

use Nodex\Nexus\Http\Requests\NexusFormRequest;

class AdminStoreRequest extends NexusFormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'regex:/^[+-]?\d+(\.\d{1,2})?$/', 'not_in:0,0.0,0.00,+0,-0,+0.00,-0.00'],
            'comment' => ['required', 'string', 'max:2000'],
            'relation' => ['required', 'array'],
            'relation.line' => ['required', 'integer', 'exists:nx_payroll_lines,id'],
        ];
    }
}
