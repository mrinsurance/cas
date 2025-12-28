<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class interest_model extends Model
{
    public function session_master_model()
    {
    	return $this->belongsTo('App\session_master_model');
    }
}
