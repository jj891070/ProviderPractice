<?php 
namespace App\MaboMethod\Facades;

use Illuminate\Support\Facades\Facade;

class Mabo extends Facade
{
    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor()
    {
        return 'mabo';
    }
}
