<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ration_depot_model extends Model
{
    // Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }
}
