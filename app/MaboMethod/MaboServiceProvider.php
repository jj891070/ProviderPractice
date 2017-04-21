<?php

namespace App\MaboMethod;

use Illuminate\Support\ServiceProvider;
use App\MaboMethod\Mabo;
class MaboServiceProvider extends ServiceProvider
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
        
          $this->app->singleton('mabo', function ($app) {
            return new Mabo();
            // return $mabo;
          });
        

    }
    /**
     * 取得提供者所提供的服務。
     *
     * @return array
     */
    public function provides()
    {
        return ['mabo'];
    }
}
