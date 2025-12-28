<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class unit_master_tbl extends Model
{
    public function product_master_tbl()
    {
    	return $this->hasOne('App\product_master_tbl');
    }
}
