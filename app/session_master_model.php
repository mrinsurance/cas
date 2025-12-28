<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class session_master_model extends Model
{
    public function interest_model()
    {
    	return $this->hasOne('App\interest_model');
    }

    public function dividend_tbl()
    {
    	return $this->hasOne('App\dividend_tbl');
    }
    public function interest_on_saving_tbl()
    {
    	return $this->hasOne('App\interest_on_saving_tbl');
    }
    public function year_end_tbl()
    {
        return $this->hasOne('App\year_end_tbl');
    }
}
