<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class designation_model extends Model
{
    public function User()
    {
        return $this->hasOne('App\User');
    }
}
