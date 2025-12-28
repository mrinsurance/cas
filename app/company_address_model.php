<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company_address_model extends Model
{
    // Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }
}
