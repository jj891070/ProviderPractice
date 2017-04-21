<?php 
namespace App\SobaMethod\Facades;

use Illuminate\Support\Facades\Facade;

class Soba extends Facade
{
    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor()
    {
        return 'soba';
    }
}