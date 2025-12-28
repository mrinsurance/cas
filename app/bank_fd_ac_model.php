<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bank_fd_ac_model extends Model
{
    public function bank_model()
    {
    	return $this->belongsTo('App\bank_model');
    }

    public function branch_model()
    {
    	return $this->belongsTo('App\branch_model');
    }

    public function open_new_ac_model()
    {
        return $this->belongsTo('App\open_new_ac_model');
    }
}
