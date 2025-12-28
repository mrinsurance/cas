<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mis_model extends Model
{
    public function member_type_model()
    {
    	return $this->belongsTo('App\member_type_model');
    }

    public function open_new_ac_model()
    {
    	return $this->belongsTo('App\open_new_ac_model');
    }
}
