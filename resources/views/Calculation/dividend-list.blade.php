@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
    <link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
    <link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ASSETS_CSS}}jquery-ui.css" />
    <style>
        #mytable_css >tbody>tr>td{
          height:20px;
          padding:1px 2px;
          border-top: 0px;
        }
        #mytable_css >thead>tr>th{
            border-bottom: 1px solid #ccc !important;
        }
        .align_right{
            text-align: right !important;
        }
    </style>
@endpush

@push('extra_js')
    <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
    <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
    <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
    <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
    <script src="{{ASSETS_JS}}day_book.js"></script></script>
    <!-- end of page level js -->
    <script type="text/javascript">
            function printDiv(printRecord){
          var printContents = $('#record').html();
          var originalContents = document.body.innerHTML;      
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
    };

       $('#allcb').click(function(e) {
        $('[name="cb[]"]').prop('checked', this.checked);
    });
    /*
    * Click on another checkbox can affect the select all checkbox
    */
    $('[name="cb[]"]').click(function(e) {
        if ($('[name="cb[]"]:checked').length == $('[name="cb[]"]').length || !this.checked)
            $('#allcb').prop('checked', this.checked);
    });
    </script>
@endpush

@section('body')

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Dividend Calculation</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Dividend Calculation</li>
        </ol>
    </section>
    <!--section ends-->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet box primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Dividend List
                    </div>
                </div>
                <div class="portlet-body">                             
                        <form class="form-horizontal" action="{{DIVIDEND_LIST_URL}}" method="get">
                    <div class="row">
                        {{csrf_field()}}
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Session Year</label>
                            <div class="col-md-6">
                                <select name="session_year" class="form-control" required>
                                    <option value="">--- Select ---</option>
                                    @foreach($session_list as $list)
                                        <option value="{{$list->id}}" {{$list->id == $session_year ? 'selected' : ''}}>{{date('Y',strtotime($list->start_date))}} - {{date('Y',strtotime($list->end_date))}}</option>
                                    @endforeach    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Share On</label>
                            <div class="col-md-6">
                                <input type="date" name="share_on" value="{{$share_on}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Paid On</label>
                            <div class="col-md-6">
                                <input type="date" name="paid_on" value="{{$paid_on}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Branch</label>
                            <div class="col-md-6">
                                <select name="branch" class="form-control">
                                    <option value="">--- Select ---</option>
                                    @foreach($brancheLists as $list)
                                        <option value="{{$list->id}}" {{$list->id == $branch ? 'selected' : ''}}>{{$list->name}}</option>
                                    @endforeach    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Member Type</label>
                            <div class="col-md-6">
                                <select name="member_type" class="form-control">
                                    <option value="">--- Select ---</option>
                                    @foreach($memberLists as $list)
                                        <option value="{{$list->id}}" {{$list->id == $member_type ? 'selected' : ''}}>{{$list->name}}</option>
                                    @endforeach    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="view" class="btn btn-warning btn_sizes" value="1"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>                            
                        </div>
                    </div>
                    </form> 
                    @if(session()->has('errors'))
                    <div class="alert alert-danger">
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                      {{ session()->get('errors') }}
                                  </div>
                              @endif
                  @if(session()->has('success'))
                    <div class="alert alert-info">
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                      {{ session()->get('success') }}
                                  </div>
                              @endif
                              {{@($_REQUEST['view'])?$items->appends(['_token' => $_REQUEST['_token'],'session_year' => $_REQUEST['session_year'],'paid_on' => $_REQUEST['paid_on'],'branch' => $_REQUEST['branch'],'share_on' => $_REQUEST['share_on'],'member_type' => $_REQUEST['member_type'],'view' => $_REQUEST['view']])->render():'' }}
                     
                    <form class="form-horizontal" action="{{DIVIDEND_LIST_URL}}"  method="post"> 
                        
                    <div class="table-scrollable">
                       
                           <!-- Print view                         -->
                        <div class="prnt" id="record">       
                            @if(isset($_REQUEST['_token']))
                                     <p> Page - {{(@$_REQUEST['page'])?$_REQUEST['page']:1}} <span style="float: right">
                                      Total  Dividend Amt	:   <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($divident_total)}}</strong></span> </p>  
                                        @endif      
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="11">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                            <h4>
                                                Dividend Paid Upto <strong>{{date('d-M-Y',strtotime($share_on))}}</strong> Paid on <strong> {{date('d-M-Y',strtotime($paid_on))}}</strong>
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>                               
                                <tr>
                                    <th><input type="checkbox" id="allcb" name="allcb"/> All</th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>                                    
                                    <th>Share</th>
                                    {{-- <th>Share On</th>
                                    <th>Paid On</th> --}}
                                    <th>Dividend Amt</th>
                                    <th>Dividend@</th>
                                    {{-- <th>Session</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $t4 = 0;
                                    $t5 = 0;
                                @endphp
                                @foreach($items as $item)
                                
                                <tr>
                                    <th>
                                        @if($item->status == 1)
                                        <input type="checkbox" disabled>
                                        @else
                                        <input type="checkbox" id="cb{{$loop->index + 1}}" name="cb[]" value="{{$item->id}}">
                                        @endif
                                    </th>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$item->open_new_ac_model->full_name}}</td>
                                    <td>{{$item->account_no}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$item->share}}</td>
                                    {{-- <td>{{$item->share_on}}</td>
                                    <td>{{$item->paid_on}}</td> --}}
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$item->dividend_amt}}</td>
                                    <td class="align_right">{{$item->dividend_at}}%</td>
                                    {{-- <td>{{date('Y',strtotime($item->session_master_model->start_date))}} - {{date('Y',strtotime($item->session_master_model->end_date))}}</td> --}}
                                    <td>

                                        <button type="button" onclick="window.location.href='{{DIVIDEND_LIST_URL.'/'.$item->id}}/edit'" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-edit"></i></button>
                                        @if($item->status == 1)
                                            <button class="btn btn-success btn-sm">Paid</button>
                                        @endif
                                    </td>
                                </tr>
                                    @php 
                                        $t4 += $item->share; 
                                        $t5 += $item->dividend_amt;
    
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="4"><strong>Total</strong></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t4,2)}}</strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t5,2)}}</strong>
                                    </td>
                                    <td></td>
                                    <td></td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                      
                    <div class="row">
                        {{csrf_field()}}
                        
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button type="submit" class="btn btn-primary btn_sizes
                            "> Update
                            </button>
                            <br>
                            @include('mylayout.ajax-msg')
                        </div>                       
                    </div>
                </form>
                
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