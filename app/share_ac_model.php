<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class share_ac_model extends Model
{
    protected $table = 'share_ac_models';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('agentFilter', function (Builder $builder) {
            if (Auth::check() && Auth::user()->staff_type == 'Agent') {
                // Apply filter to ensure the agent only accesses their records
                $builder->join('user_open_new_ac_model', 'share_ac_models.open_new_ac_model_id', '=', 'user_open_new_ac_model.open_new_ac_model_id')
                    ->where('user_open_new_ac_model.user_id', Auth::id())
                    ->select('share_ac_models.*'); // Ensure proper selection
            }
        });
    }

    public function member_type_model()
    {
    	return $this->belongsTo('App\member_type_model');
    }

    public function open_new_ac_model()
    {
    	return $this->belongsTo('App\open_new_ac_model');
    }
}
