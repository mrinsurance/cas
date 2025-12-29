@extends('mylayout.master')

@push('extra_meta')
  <!-- // -->
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link href="{{ASSETS_VENDORS}}fullcalendar/css/fullcalendar.css" rel="stylesheet" type="text/css" />
    <link href="{{ASSETS_CSS}}pages/calendar_custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" media="all" href="{{ASSETS_VENDORS}}bower-jvectormap/css/jquery-jvectormap-1.2.2.css" />
    <link rel="stylesheet" href="{{ASSETS_VENDORS}}animate/animate.min.css">
    <link rel="stylesheet" type="text/css" href="{{ASSETS_VENDORS}}datetimepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="{{ASSETS_CSS}}pages/only_dashboard.css" />
@endpush
@push('extra_js')
    <script src="{{ASSETS_VENDORS}}jquery.easy-pie-chart/js/easypiechart.min.js"></script>
    <script src="{{ASSETS_VENDORS}}jquery.easy-pie-chart/js/jquery.easypiechart.min.js"></script>
    <script src="{{ASSETS_JS}}jquery.easingpie.js"></script>
    <!--end easy pie chart -->
    <!--for calendar-->

    <!--   Realtime Server Load  -->
    <script src="{{ASSETS_VENDORS}}flotchart/js/jquery.flot.js" type="text/javascript"></script>
    <script src="{{ASSETS_VENDORS}}flotchart/js/jquery.flot.resize.js" type="text/javascript"></script>
    <!--Sparkline Chart-->
    <script src="{{ASSETS_VENDORS}}sparklinecharts/jquery.sparkline.js"></script>
    <!-- Back to Top-->

    <!--  todolist-->
    <script src="{{ASSETS_JS}}pages/todolist.js"></script>
    <script src="{{ASSETS_JS}}pages/dashboard.js" type="text/javascript"></script>
@endpush

@section('body')
 <aside class="right-side strech">

    <div class="alert alert-primary alert-dismissable margin5">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Success:</strong> You have successfully logged in.
    </div>
    <!-- Main content -->
    <section class="content-header">
        <h1>Welcome to New Dashboard 
<!-- User roles         -->
            
            
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="livicon" data-name="home" data-size="14" data-color="#333" data-hovercolor="#333"></i> Dashboard
                </a>
            </li>
        </ol>
    </section>
    <!-- Agent Dashboard -->

            @if(AuthRole()['name'] == 'AGENT')
                @include('component.agent-dashboard')
            @endif

            @if(AuthRole()['name'] == 'STAFF' || AuthRole()['name'] == 'SuperAdmin')
                @include('component.staff-dashboard')
            @endif

            @if(AuthRole()['name'] == 'SALEMAN')
                 @include('component.saleman-dashboard')
            @endif
                                        
</aside>
@endsection