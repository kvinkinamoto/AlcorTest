<?php

namespace App\Nexus\Modules\PayrollLine\Requests;

use Nodex\Nexus\Http\Requests\NexusFormRequest;

class AdminStoreRequest extends NexusFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }
}
