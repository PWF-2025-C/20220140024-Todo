<?php
namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Illuminate\Support\ServiceProvider;
use Illuminate\pagination\paginator;
use Illuminate\Support\facades\Gate;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Route;


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
        Sanctum ::usePersonalAccessTokenModel(\App\Models\PersonalAccessToken::class);
        Scramble::configure()->routes(function (Route $route) {
           return Str ::startsWith($route->uri, 'api/');
        });
    }
}
