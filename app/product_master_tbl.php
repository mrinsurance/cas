<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_master_tbl extends Model
{
    public function tax_master_tbl()
    {
    	return $this->belongsTo('App\tax_master_tbl');
    }public function unit_master_tbl()
    {
    	return $this->belongsTo('App\unit_master_tbl');
    }public function product_type_master_tbl()
    {
    	return $this->belongsTo('App\product_type_master_tbl');
    }
    public function purchase_detail_tbl()
    {
        return $this->hasOne('purchase_detail_tbl');
    }
    public function sale_detail_tbl()
    {
        return $this->hasOne('sale_detail_tbl');
    }
}
