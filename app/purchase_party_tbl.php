<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_party_tbl extends Model
{
    public function purchase_tbl()
    {
    	return $this->hasOne('App\purchase_tbl');
    }
}
