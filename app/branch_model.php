<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class branch_model extends Model
{

	// Defining an accessor
    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }
    public function open_new_ac_model()
    {
        return $this->hasOne('App\open_new_ac_model');
    }
    public function tbl_ledger_model()
    {
        return $this->hasOne('App\tbl_ledger_model');
    }
    public function voucher_model()
    {
        return $this->hasOne('App\voucher_model');
    }  

    public function bank_fd_ac_model()
    {
        return $this->hasOne('App\bank_fd_ac_model');
    }        
}
