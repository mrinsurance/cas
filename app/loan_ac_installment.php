<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class loan_ac_installment extends Model
{
    protected $table = 'loan_ac_installments';
    protected $fillable = ['id','principal'];
}
