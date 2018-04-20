<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\handel_hooks;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        new handel_hooks();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
