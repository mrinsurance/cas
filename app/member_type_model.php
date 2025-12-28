<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class member_type_model extends Model
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

    public function share_ac_model()
    {
        return $this->hasMany('App\share_ac_model');
    }

    public function saving_ac_model()
    {
    	return $this->hasMany('App\saving_ac_model');
    }

    public function dds_ac_model()
    {
        return $this->hasMany('App\dds_ac_model');
    }

    public function rd_model()
    {
        return $this->hasMany('App\rd_model');
    }

    public function drd_model()
    {
        return $this->hasMany('App\drd_model');
    }

    public function fd_ac_model()
    {
        return $this->hasOne('App\fd_ac_model');
    }

    public function loan_ac_model()
    {
        return $this->hasOne('App\loan_ac_model');
    }

    public function mis_model()
    {
        return $this->hasOne('App\mis_model');
    }
}
