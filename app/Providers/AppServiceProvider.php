<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    protected $defer = true;
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        // $this->app->singleton('soba', function ($app) {
        //     $soba = new Soba();
        //     return $soba;
        //   });
        // $this->app->singleton('mabo', function ($app) {
        //     $mabo = new Mabo();
        //     return $mabo;
        //   });
    }
}
