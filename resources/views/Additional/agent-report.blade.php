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

@endpush

@push('extra_js')
    <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
    <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
    <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
    <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
    <script src="{{ASSETS_JS}}day_book.js"></script></script>
    <!-- end of page level js -->
@endpush

@section('body')

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Agent Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Agent Report</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
    <div class="col-md-12">
        <div class="panel-body">
            <form class="form-horizontal" action="{{ADDITIONAL_REPORT_URL_AGENT}}" method="get">
                {{csrf_field()}}
                <fieldset>
                    <!-- Name input-->
                    <div class="form-group">
                        
                        @if(Auth::user()->staff_type == 'Staff')
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">Branch</label>
                                <div class="col-md-10 text-left">
                                    <select name="branch" class="form-control">
                                        <option value="">All</option>
                                        @foreach($branches as $_item)
                                        <option value="{{$_item->id}}" {{@$branch == $_item->id ? 'selected' : ''}}>{{$_item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">User</label>
                                <div class="col-md-10 text-left">
                                    <select name="agent_name" class="form-control">
                                        <option value="">All</option>
                                        @foreach($users as $val)
                                        <option value="{{$val->id}}" {{@$agent_name == $val->id ? 'selected' : ''}}>{{$val->name}} ({{@$val->designation_model->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="email">
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">View</button>
                                    <button type="submit" class="btn btn-responsive btn-warning btn-sm">Print</button>
                                </label>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>                   
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box primary">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> 
                            Receipt (Collection Report of {{@$search_branch != '' ? $branch_name->name : 'All'}} Branch, collect by {{@$search_user != '' ? $user_name->name : 'All'}})
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive fixed-table-body">
                            <table class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>A/C Type</th>
                                        <th>A/C No</th>
                                        <th>Saving</th>
                                        <th>DRD</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $_item)
                                        @php
                                            $_saving = \App\saving_ac_model::select('id','open_new_ac_model_id')
                                            ->where('open_new_ac_model_id',$_item->id)
                                            ->first();
                                            
                                            $_drd = 
                                            \App\drd_model::select('id','open_new_ac_model_id')
                                            ->where('open_new_ac_model_id',$_item->id)
                                            ->first();
                                        @endphp
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$_item->member_type_model->name}}</td>
                                        <td>{{$_item->account_no}}</td>
                                        <td>
                                            @if($_saving)
                                                <i class="fa fa-check text-success"></i>   
                                            @else
                                                <i class="fa fa-close text-danger"></i>   
                                            @endif
                                        </td>
                                        <td>
                                            @if($_drd)
                                                <i class="fa fa-check text-success"></i>   
                                            @else
                                                <i class="fa fa-close text-danger"></i>   
                                            @endif
                                        </td>
                                    </tr>
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