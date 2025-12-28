<?php

namespace App\Http\Controllers\Calculation;

use App\branch_model;
use App\company_address_model;
use App\fd_ac_model;
use App\member_type_model;
use App\open_new_ac_model;
use App\session_master_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class interestOnFd extends Controller
{
    protected $session, $from, $to, $dividend_at, $minimum_share, $branch, $memberType;
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        $this->member = $request->member_type;
        $this->DT = $request->deposit_type;

        $data['branch'] = $request->branch;
        $data['member_type'] = $request->member_type;
        $data['branches'] = branch_model::orderBy('name','asc')->get();
        $data['members'] = member_type_model::orderBy('name','asc')->get();
        $data['company_address'] = company_address_model::first();

        // return $this->from;
        $data['from_date'] = $this->from;

        $items = fd_ac_model::with('open_new_ac_model');
        if($request->orderBy == 1)
        {
            $items->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        }
        else
        {
            $items->orderBy(DB::raw('CAST(fd_no AS UNSIGNED), fd_no'));
        }

        $items->where(function($query){
            $query->where('transaction_date', '<=', $this->from);
            if($this->member)
            {
                $query->where('member_type_model_id',$this->member);
            }
            if($this->DT)
            {
                $query->where('type_of_deposite',$this->DT);
            }
            $query->where('status',1);
        })->orWhere(function($query){
            $query->where('transaction_date', '<=', $this->from)
                ->where('matured_on_date', '>', $this->from)
                ->where('status',0);
            if($this->member)
            {
                $query->where('member_type_model_id',$this->member);
            }
            if($this->DT)
            {
                $query->where('type_of_deposite',$this->DT);
            }
        });
        if($request->from_date){
            $data['items'] = $items->get();
        }else{
            $data['items'] = [];
        }
        return view('Calculation.interest-on-fd')->with($data);
    }
}
