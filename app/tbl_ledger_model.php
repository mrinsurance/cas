<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_ledger_model extends Model
{
    protected $guarded = [];
	protected  $fillable = ['purchase_tbl_id','type_of_transaction'];
	protected $table = "tbl_ledger_models";
    public function branch_model()
    {
    	return $this->belongsTo('App\branch_model');
    }
    public function bal_sheet_head_model()
    {
    	return $this->belongsTo('App\bal_sheet_head_model');
    }
}
