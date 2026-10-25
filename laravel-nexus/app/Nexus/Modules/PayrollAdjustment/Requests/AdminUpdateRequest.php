<?php

namespace App\Nexus\Modules\PayrollAdjustment\Requests;

/** Adjustments are append-only; the model refuses updates. Kept because #[Requests] expects the pair. */
class AdminUpdateRequest extends AdminStoreRequest
{
}
