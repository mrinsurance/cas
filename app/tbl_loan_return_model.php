<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_loan_return_model extends Model
{
    public function loan_ac_model()
    {
    	return $this->belongsTo('App\loan_ac_model');
    }
}
