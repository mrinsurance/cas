<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class interest_on_fd_tbl extends Model
{
    public function fd_ac_model()
    {
       return $this->belongsTo('App\fd_ac_model');
    }
}
