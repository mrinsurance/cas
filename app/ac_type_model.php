<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ac_type_model extends Model
{
    // Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }
    public function open_new_ac_model()
    {
    	return $this->hasMany('App\open_new_ac_model');
    }
}
