<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class group_master_model extends Model
{
	// Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }
    public function subgroup_master_model()
    {
    	return $this->hasMany('App\subgroup_master_model');
    }

    public function voucher_detail_model()
    {
    	return $this->hasMany('App\voucher_detail_model');
    }
}
