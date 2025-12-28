<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sale_detail_tbl extends Model
{
    public function sale_tbl()
    {
    	return $this->belongsTo('App\sale_tbl');
    }
    public function product_master_tbl()
    {
    	return $this->belongsTo('App\product_master_tbl');
    }
}
