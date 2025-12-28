<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class state_model extends Model
{
	// Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }
    
    public function district_model()
    {
    	return $this->hasMany('App\district_model');
    }

    public function open_new_ac_model()
    {
    	return $this->hasMany('App\open_new_ac_model');
    }

    public function User()
    {
        return $this->hasMany('App\User');
    }
}
