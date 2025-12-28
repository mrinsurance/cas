<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subgroup_master_model extends Model
{
	// Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }
    public function group_master_model()
    {
    	return $this->belongsTo('App\group_master_model');
    }

    public function bal_sheet_head_model()
    {
    	return $this->belongsTo('App\bal_sheet_head_model');
    }

    public function voucher_detail_model()
    {
        return $this->belongsTo('App\voucher_detail_model');
    }
}
