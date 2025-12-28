<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class open_new_ac_model extends Model
{
    protected $table = 'open_new_ac_models';

    // Defining an accessor
    public function getFullNameAttribute($value)
    {
        return ucfirst($value);
    }
    public function getFatherNameAttribute($value)
    {
        return ucfirst($value);
    }
    public function member_type_model()
    {
    	return $this->belongsTo('App\member_type_model');
    }

    public function state_model()
    {
    	return $this->belongsTo('App\state_model');
    }

    public function district_model()
    {
    	return $this->belongsTo('App\district_model');
    }

    public function branch_model()
    {
        return $this->belongsTo('App\branch_model');
    }
    public function ac_type_model()
    {
        return $this->belongsTo('App\ac_type_model');
    }

    public function share_ac_model()
    {
        return $this->hasOne('App\share_ac_model');
    }

    public function saving_ac_model()
    {
        return $this->hasMany('App\saving_ac_model');
    }

    public function dds_ac_model()
    {
        return $this->hasOne('App\dds_ac_model');
    }

    public function loan_ac_model()
    {
        return $this->hasMany('App\loan_ac_model');
    }

    public function mis_model()
    {
        return $this->hasOne('App\mis_model');
    }

    public function fd_ac_model()
    {
        return $this->hasOne('App\fd_ac_model');
    }

    public function rd_model()
    {
        return $this->hasOne('App\rd_model');
    }

    public function drd_model()
    {
        return $this->hasOne('App\drd_model');
    }
    public function dividend_tbl()
    {
        return $this->hasOne('App\dividend_tbl');
    }

    public function interest_on_saving_tbl()
    {
        return $this->hasOne('App\interest_on_saving_tbl');
    }

    public function bank_fd_ac_model()
    {
        return $this->hasOne('App\bank_fd_ac_model');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_open_new_ac_model');
    }

}
