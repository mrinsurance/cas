<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_type_master_tbl extends Model
{
    public function product_master_tbl()
    {
    	return $this->hasOne('App\product_master_tbl');
    }public function purchase_tbl()
    {
    	return $this->hasOne('App\purchase_tbl');
    }
    public function sale_tbl()
    {
    	return $this->hasOne('App\sale_tbl');
    }
}
