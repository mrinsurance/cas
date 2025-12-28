<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class year_end_tbl extends Model
{
    public function session_master_model()
    {
    	return $this->belongsTo('App\session_master_model');
    }
}
