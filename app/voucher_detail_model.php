<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucher_detail_model extends Model
{
    public function group_master_model()
    {
    	return $this->belongsTo('App\group_master_model');
    }

    public function subgroup_master_model()
    {
    	return $this->belongsTo('App\subgroup_master_model');
    }
}
