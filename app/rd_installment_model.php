<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rd_installment_model extends Model
{
    public function rd_model()
    {
    	return $this->belongsTo('App\rd_model');
    }
}
