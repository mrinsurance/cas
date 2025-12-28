<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucher_model extends Model
{
    public function branch_model()
    {
    	return $this->belongsTo('App\branch_model');
    }
}
