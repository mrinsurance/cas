<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dividend_tbl extends Model
{
    public function open_new_ac_model()
    {
    	return $this->belongsTo('App\open_new_ac_model');
    }
    public function session_master_model()
    {
    	return $this->belongsTo('App\session_master_model');
    }
}
