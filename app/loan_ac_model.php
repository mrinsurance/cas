<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class loan_ac_model extends Model
{
	protected $table = 'loan_ac_models';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('agentFilter', function (Builder $builder) {
            if (Auth::check() && Auth::user()->staff_type == 'Agent') {
                // Apply filter to ensure the agent only accesses their records
                $builder->join('user_open_new_ac_model', 'loan_ac_models.open_new_ac_model_id', '=', 'user_open_new_ac_model.open_new_ac_model_id')
                    ->where('user_open_new_ac_model.user_id', Auth::id())
                    ->select('loan_ac_models.*'); // Ensure proper selection
            }
        });
    }

    public function open_new_ac_model()
    {
    	return $this->belongsTo('App\open_new_ac_model');
    }

    public function member_type_model()
    {
    	return $this->belongsTo('App\member_type_model');
    }

    public function loan_model()
    {
    	return $this->belongsTo('App\loan_model');
    }

    public function tbl_loan_return_model()
    {
        return $this->hasMany('App\tbl_loan_return_model');
    }

    public function loanpurpose_model()
    {
        return $this->belongsTo('App\loanpurpose_model');
    }
}
