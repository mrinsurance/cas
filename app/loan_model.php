<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class loan_model extends Model
{
    // Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }

    public function loan_ac_model()
    {
    	return $this->hasOne('App\loan_ac_model');
    }
}
