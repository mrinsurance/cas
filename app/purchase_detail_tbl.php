<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_detail_tbl extends Model
{
    public function purchase_tbl()
    {
    	return $this->belongsTo('App\purchase_tbl');
    }
    public function product_master_tbl()
    {
    	return $this->belongsTo('App\product_master_tbl');
    }
}
