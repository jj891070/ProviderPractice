<?php

namespace App\SobaMethod;

use Illuminate\Support\ServiceProvider;
use App\SobaMethod\Soba;
class SobaServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
          $this->app->singleton('soba', function ($app) {
            $soba = new Soba();
            return $soba;
          });
        

    }
    /**
     * 取得提供者所提供的服務。
     *
     * @return array
     */
    public function provides()
    {
        return ['soba'];
    }
}
