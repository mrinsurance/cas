<?php

use App\product_master_tbl;
use App\product_type_master_tbl;

function BillTypeArray()
    {
        return [
            ['id'=>1, 'label'=>'GST'],
            ['id'=>2, 'label'=>'IGST'],
            ['id'=>3, 'label'=>'UTGST'],
        ];
    }

    function getProductNameByTypeId($id)
    {

        return $data['productMasterList'] = product_master_tbl::orderBy('name','asc')->whereProductTypeMasterTblId($id)->get();
    }

    function getProductTypeById($id)
    {
        $data = product_type_master_tbl::whereId($id)->first();
        if ($data)
        {
            return $data;
        }
        else {
            return '---';
        }
    }

    function getSaleParty()
    {
        return \App\salePartyTbl::orderBy('name','asc')->get();
    }

    function LoanType($id)
    {
        return \App\loan_model::whereId($id)->first();
    }

    function AllUsers()
    {
        return \App\User::orderBy('name','asc')->get();
    }
    function getUserById($id)
    {
        return \App\User::whereId($id)->first();
    }

    function AuthRole()
    {
        return \Auth::user()->roles[0];
    }

    function subGroupsMaster()
    {
        return \App\subgroup_master_model::whereGroupMasterModelId(16)->orderBy('name','asc')->get();
    }

    function CheckLockPermission()
    {
        $LockDate = \Carbon\Carbon::now()->format('Y-m-d');
        return \App\LockPermission::whereLockDate($LockDate)->count();
    }

    function LoanModelById($id)
    {
        return \App\loan_model::whereId($id)->first()->name;
    }
    function PurposeById($id)
    {
        return \App\loanpurpose_model::whereId($id)->first()->name;
    }
    function LoanAccountInstallmentById($id)
    {
        return \App\loan_ac_installment::whereLoanAcModelId($id)->orderBy('installment_date','asc')->first();
    }
    function LoanReturnById($id, $date = null)
    {
        return \App\tbl_loan_return_model::whereLoanAcModelId($id)->orderBy('received_date','asc')->where('received_date','<=',$date)->get();
    }

 ?>