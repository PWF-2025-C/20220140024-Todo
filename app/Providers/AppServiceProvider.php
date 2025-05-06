<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\pagination\paginator;
use Illuminate\Support\facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        paginator:: usetailwind();
        Gate::define('admin', function ($user){
            return $user->is_admin == true;
        });
    }
}
