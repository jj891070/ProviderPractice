<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OddEvent extends Model
{
    //
    protected $table = 'oddevent';

    public function oddmarket()
    {
    	return $this->hasOne('App\OddMarket','event_id','event_id');
    }
    public function oddmabo()
    {
    	return $this->hasOne('App\OddMabo','event_id','event_id');
    }
}
