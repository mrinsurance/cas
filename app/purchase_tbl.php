<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_tbl extends Model
{
    protected $fillable = [
    	'user_id',
    	'invoice_no',
    	'date_of_transaction',
    	'billing_date',
    	'purchase_party_tbl_id',
    	'product_type_master_tbl_id',
    	'branch_model_id',
    	'session_year',
    ];

    public function purchase_detail_tbl()
    {
    	return $this->hasOne('App\purchase_detail_tbl');
    }

    public function purchase_party_tbl()
    {
        return $this->belongsTo('App\purchase_party_tbl');
    }

    public function product_type_master_tbl()
    {
        return $this->belongsTo('App\product_type_master_tbl');
    }
}
