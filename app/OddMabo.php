<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OddMabo extends Model
{
    //
    protected $table = 'oddmabo';
    public function oddevent()
    {
    	return $this->hasOne('App\OddEvent','event_id','event_id');
    }

}
