<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sale_tbl extends Model
{
    protected $table = 'sale_tbls';
    protected $fillable = ['id'];
    public function sale_detail_tbl()
    {
    	return $this->hasOne('App\sale_detail_tbl');
    }
    public function product_type_master_tbl()
    {
        return $this->belongsTo('App\product_type_master_tbl');
    }

    
}
