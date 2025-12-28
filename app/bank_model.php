<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bank_model extends Model
{
    public function bank_fd_ac_model()
    {
    	return $this->hasOne('App\bank_fd_ac_model');
    }
}
