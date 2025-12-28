<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','session_master_model_id', 'login_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function designation_model()
    {
        return $this->belongsTo('App\designation_model');
    }

    public function district_model()
    {
        return $this->belongsTo('App\district_model');
    }

    public function state_model()
    {
        return $this->belongsTo('App\state_model');
    }

    public function openNewAcModels()
    {
        return $this->belongsToMany(open_new_ac_model::class, 'user_open_new_ac_model');
    }
}
