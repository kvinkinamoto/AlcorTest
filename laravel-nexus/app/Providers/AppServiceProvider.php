<?php

namespace App\Providers;

use App\Payroll\SalarySource;
use App\Payroll\StubSalarySource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Swap for the real payroll engine here.
        $this->app->bind(SalarySource::class, StubSalarySource::class);
    }

    public function boot(): void
    {
        //
    }
}
