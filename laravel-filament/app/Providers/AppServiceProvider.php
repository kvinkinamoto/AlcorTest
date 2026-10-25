<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/** Nothing to register here: the payroll contexts are wired in PayrollServiceProvider. */
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
