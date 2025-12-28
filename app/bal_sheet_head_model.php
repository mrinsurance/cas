<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bal_sheet_head_model extends Model
{
	// Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }
    
    public function subgroup_master_model()
    {
    	return $this->hasOne('App\subgroup_master_model');
    }
    public function tbl_ledger_model()
    {
    	return $this->hasOne('App\tbl_ledger_model');
    }
}
