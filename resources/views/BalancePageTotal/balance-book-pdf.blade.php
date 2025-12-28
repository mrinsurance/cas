@extends('mylayout.master')

@push('extra_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@section('body')

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side strech">
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN BORDERED TABLE PORTLET-->
                    <div class="portlet box primary">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Book
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <!-- Print view                         -->

                                    <table class="table table-bordered table-hover" id="mytable_css">
                                        <thead>
                                        <tr>
                                            <td colspan="8">
                                                <div class="col-md-12 text-center">
                                                    <h3>
                                                        {{$company_address->name}}
                                                    </h3>
                                                    {{$company_address->address}}
                                                    <h4>
                                                        @foreach($members as $val)
                                                            @if($val->id == $member_type)
                                                                {{$val->name}}
                                                            @endif
                                                        @endforeach
                                                        Balance Book as on {{date('d-M-Y',strtotime($from_date))}}
                                                    </h4>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>A/C No.</th>
                                            <th>Share</th>
                                            <th>Loan</th>
                                            <th>Last Recovery</th>
                                            <th>Rec Intr</th>
                                            <th>Saving</th>
                                            {{-- <th>confirmation</th> --}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $rec = 0;
                                            $share_prv_total = 0;
                                            $share_page_total = 0;
                                            $share_grand_total = 0;
                                            $loan_grand_total = 0;
                                            $loan_intr_grand_total = 0;

                                            $saving_prv_total = 0;
                                            $saving_page_total = 0;
                                            $saving_grand_total = 0;

                                            $total_of_balance = 0;
                                            $total_recover_int = 0;

                                            $loan_page_total = 0;
                                            $loan_intr_page_total = 0;

                                            $loan_tintr = 0;

                                            $srn = 0;
                                            $trec = 0;
                                        @endphp
                                        @foreach($ac_holders as $val)
                                            @php
                                                //Share Balance
                                                                              $share_deposit = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<=',$from_date)->sum('amount');

                                                                              $share_withdraw = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<=',$from_date)->sum('amount');

                                                                              $share_balance = ($share_deposit - $share_withdraw);

                                                                              $share_page_total += $share_balance;
                                                                              $share_grand_total = ($share_grand_total + $share_balance);
                                               // Saving Balance
                                                                              $saving_deposit = \App\saving_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<=',$from_date)->sum('amount');

                                                                              $saving_withdraw = \App\saving_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<=',$from_date)->sum('amount');

                                                                              $saving_balance = ($saving_deposit - $saving_withdraw);

                                                                              $saving_page_total += $saving_balance;
                                                                              $saving_grand_total = ($saving_grand_total + $saving_balance);
                                               // Loan Balance
                                               $loan_tntr = [];
                                               $loan_date = [];
                                               $loan_amount = [];
                                               $cintr = 0;
                                               $ointr = 0;
                                               $tintr = 0;
                                               $fdate = '';
                                               $_over_amount = 0;
                                               $_amount = 0;
                                                //Sum of received principal from loan return table
                                                $loan_ac_holders = \App\loan_ac_model::where('open_new_ac_model_id',$val->id)->where('loan_type','!=',3)->where('date_of_advance','<=',request()->from_date)->get();

                                                foreach($loan_ac_holders as $loan_ac_by_holder)
                                                {

                                                //Sum of received principal from loan return table
                                                   $tbl_loan_return_model_sum = \App\tbl_loan_return_model::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(tbl_loan_return_models.received_principal),0) total_received_principal'))
                                                   ->where('loan_ac_model_id',$loan_ac_by_holder->id)
                                                   ->where('received_date','<=',$from_date)
                                                   ->first();
                                                   if($tbl_loan_return_model_sum->loan_ac_model_id == null)
                                                   {
                                                       $received_pr = 0;
                                                   }
                                                   else
                                                   {
                                                       $received_pr = $tbl_loan_return_model_sum->total_received_principal;
                                                   }

                                                   if(($loan_ac_by_holder->amount - $received_pr) > 0)
                                                   {
                                                       //Get days from loan return table
                                                           $tbl_loan_return_model_days = \App\tbl_loan_return_model::select('id','loan_ac_model_id','received_date','pending_intr')
                                                           ->orderBy('received_date','desc')
                                                           ->where('loan_ac_model_id',$loan_ac_by_holder->id)
                                                           ->where('received_date','<=',$from_date)
                                                           ->first();

                                                           if($tbl_loan_return_model_days)
                                                           {
                                                               $_rdate = $tbl_loan_return_model_days->received_date;
                                                               $pendingInterest =  $tbl_loan_return_model_days->pending_intr;
                                                           }
                                                           else
                                                           {
                                                               $_rdate = $loan_ac_by_holder->date_of_advance;
                                                               $pendingInterest = 0;
                                                           }
                                                           $fdate=date('Y-m-d',strtotime($_rdate));
                                                           $tdate=date('Y-m-d',strtotime($from_date));

                                                           $to = \Carbon\Carbon::createFromFormat('Y-m-d', $fdate);
                                                           $from = \Carbon\Carbon::createFromFormat('Y-m-d', $tdate);
                                                           $diff_in_days = $to->diffInDays($from);
                                               //Overdue principal from loan installment table
                                                           $loan_ac_installment_sum = \App\loan_ac_installment::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(loan_ac_installments.principal),0) total_principal'))
                                                           ->where('loan_ac_model_id',$loan_ac_by_holder->id)
                                                           ->where('installment_date','<=',$from_date)
                                                           ->first();

                                               $_over_amount = 0;
                                               $_amount = 0;
                                               if($loan_ac_installment_sum->total_principal > $tbl_loan_return_model_sum->total_received_principal)
                                               {
                                                   $_over_amount = $loan_ac_installment_sum->total_principal - $tbl_loan_return_model_sum->total_received_principal;
                                               }
                                               $_amount = ($loan_ac_by_holder->amount - $tbl_loan_return_model_sum->total_received_principal) - $_over_amount;

                                               //Calculating interest Reduce and flat


                                                             if(($_over_amount + $_amount) > 0)
                                                             {
                                                               $ointr = ((($_over_amount * $diff_in_days) * $loan_ac_by_holder->pannelty_int) / 36500);

                                                               $cintr = ((($_amount * $diff_in_days) * $loan_ac_by_holder->interest) / 36500);

                                                               $tintr = $cintr + $ointr;
                                                             }
                                                             else{
                                                               $tintr = 0;

                                                           }

                                                      $tintr = round($tintr + $pendingInterest);
                                                   }
                                                   else
                                                   {
                                                       $tintr = 0;
                                                   }
                                                   if(($loan_ac_by_holder->amount - $received_pr) > 0)
                                                   {
                                                       $loan_tntr[] = $tintr;
                                                       $loan_date[] = $fdate;
                                                       $loan_amount[] = ($_over_amount + $_amount);
                                                   }

                                                   $loan_page_total += ($_over_amount + $_amount);
                                                   $loan_intr_page_total += $tintr;
                                                   $loan_grand_total = (($_over_amount + $_amount) + $loan_grand_total);
                                                   $loan_intr_grand_total = ($tintr + $loan_intr_grand_total);
                                                   $_over_amount = 0;
                                                   $_amount = 0;
                                                   $tintr = 0;
                                                }

                                                                              $trec++;

                                            @endphp
                                            @if($share_balance != 0)
                                                @php
                                                    $srn++;
                                                    $rec++;
                                                    if(count($loan_amount) > 1)
                                                    {
                                                        $srn = (($srn + count($loan_amount)) - 1);
                                                    }
                                                    $id = $val->id;
                                                @endphp
                                                @if(count($ac_holders) > 32)
                                                    @if($rec == 1)
                                                        <tr>
                                                            <td colspan="3"><strong>Previous Total </strong></td>
                                                            <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format(0,2)}}</strong></td>
                                                            <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format(0,2)}}</strong></td>
                                                            <td></td>
                                                            <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format(0,2)}}</strong></td>
                                                            <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format(0,2)}}</strong></td>
                                                            {{-- <td></td> --}}
                                                        </tr>
                                                    @endif
                                                @endif
                                                <tr>
                                                    <td>{{$rec}}</td>
                                                    <td>{{str_limit(trim($val->full_name),13)}}</td>
                                                    <td>{{$val->account_no}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($share_balance,2)}}</td>
                                                    <td class="align_right">
                                                        @foreach($loan_amount as $val)
                                                            <i class="fa fa-inr"></i> {{$val}}
                                                            <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="align_right">
                                                        @foreach($loan_date as $val)
                                                            {{date('d-M-Y',strtotime($val))}}
                                                            <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="align_right">
                                                        @foreach($loan_tntr as $val)
                                                            <i class="fa fa-inr"></i> {{$val}}
                                                            <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($saving_balance,2)}}</td>
                                                    {{-- <td>
                                                        @php
                                                          $status_data =  DB::table('balance_book_status')->where(['ac_holder_id'=>$id])->first();
                                                        @endphp
                                                        @if(@$status_data->status==1) Yes @endif @if(@$status_data->status==2) No @endif
                                                    </td> --}}
                                                </tr>
                                            @endif
                                            @if($srn == 32)

                                                <tr>
                                                    <td colspan="3"><strong>Page Total</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($share_page_total,2)}}</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_page_total,2)}}</strong></td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_intr_page_total,2)}}</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($saving_page_total,2)}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><strong>Grand Total</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($share_grand_total,2)}}</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_grand_total,2)}}</strong></td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_intr_grand_total,2)}}</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($saving_grand_total,2)}}</strong></td>
                                                </tr>
                                                @if(count($ac_holders) > $trec)
                                                    <tr>
                                                        <td colspan="3"><strong>Previous Total</strong></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($share_grand_total,2)}}</strong></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_grand_total,2)}}</strong></td>
                                                        <td></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_intr_grand_total,2)}}</strong></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($saving_grand_total,2)}}</strong></td>
                                                    </tr>
                                                @endif
                                                @php
                                                    $share_page_total = 0;
                                                    $saving_page_total = 0;
                                                    $loan_page_total = 0;
                                                    $loan_intr_page_total = 0;

                                                    $srn = 0; @endphp
                                            @else
                                                @if(count($ac_holders) == $trec)
                                                    <tr>
                                                        <td colspan="3"><strong>Page Total</strong></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($share_page_total,2)}}</strong></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_page_total,2)}}</strong></td>
                                                        <td></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_intr_page_total,2)}}</strong></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($saving_page_total,2)}}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><strong>Grand Total</strong></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($share_grand_total,2)}}</strong></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_grand_total,2)}}</strong></td>
                                                        <td></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($loan_intr_grand_total,2)}}</strong></td>
                                                        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($saving_grand_total,2)}}</strong></td>
                                                    </tr>

                                                @endif
                                            @endif

                                        @endforeach
                                        </tbody>
                                    </table>


                            </div>
                        </div>
                    </div>
                    <!-- END BORDERED TABLE PORTLET-->
                </div>
            </div>
        </section>
        <!-- content -->
    </aside>
    <!-- right-side -->
@endsection