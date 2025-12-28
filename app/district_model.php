<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class district_model extends Model
{
	// Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }
    public function state_model()
    {
    	return $this->belongsTo('App\state_model');
    }

    public function open_new_ac_model()
    {
    	return $this->hasOne('App\open_new_ac_model');
    }

    public function User()
    {
        return $this->hasOne('App\User');
    }
}
