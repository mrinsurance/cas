<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class fd_ac_model extends Model
{
    protected $table = 'fd_ac_models';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('agentFilter', function (Builder $builder) {
            if (Auth::check() && Auth::user()->staff_type == 'Agent') {
                // Apply filter to ensure the agent only accesses their records
                $builder->join('user_open_new_ac_model', 'fd_ac_models.open_new_ac_model_id', '=', 'user_open_new_ac_model.open_new_ac_model_id')
                    ->where('user_open_new_ac_model.user_id', Auth::id())
                    ->select('fd_ac_models.*'); // Ensure proper selection
            }
        });
    }
    // Defining an accessor
    public function getNomineeNameAttribute($value)
    {
    	return ucfirst($value);
    }

    public function member_type_model()
    {
    	return $this->belongsTo('App\member_type_model');
    }

    public function open_new_ac_model()
    {
    	return $this->belongsTo('App\open_new_ac_model');
    }

    public function interest_on_fd_tbl()
    {
        return $this->hasOne('App\interest_on_fd_tbl');
    }
}
