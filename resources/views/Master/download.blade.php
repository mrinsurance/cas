@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
<link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
<link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
<link href="{{ASSETS_CSS}}pages/form2.css" rel="stylesheet"/>
@endpush

@push('extra_js')
    <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
    <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
    <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
@endpush

@section('body')
<style>
    .list-group > .list-group {
  display: none;
  margin-bottom: 0;
}
.list-group-item:focus-within + .list-group {
  display: block;
}

.list-group > .list-group-item {
  border-radius: 0;
  border-width: 1px 0 0 0;
}

.list-group > .list-group-item:first-child {
  border-top-width: 0;
}

.list-group  > .list-group > .list-group-item {
  padding-left: 2.5rem;
}
    </style>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Downloads</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
           
            
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <!--main content-->
        <div class="row">
            <!--row starts-->
            <div class="col-md-6 col-md-offset-3">
                <!--lg-6 starts-->
                <!--basic form starts-->
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Master / Downloads
                        </h3>
                    </div>
                    <div class="panel-body">
                        
                            <fieldset>
                                <!-- Message body -->
                               
                                
                                <div class="form-group">
                                  <div class="col-md-12 ">
                                    <div class="panel-group" id="accordion">
                                        <?php 
                                        $arr_session = array(2000,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030);
                                        foreach ($arr_session as $key => $value) {
                                            # code...
                                        
                                        ?>
                                        <div class="panel panel-default">
                                          <div class="panel-heading">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$value}}">
                                                Audit Note {{$value}}</a>
                                            </h4>
                                          </div>
                                          <div id="collapse{{$value}}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                            <ul class="toggle_menu">
                                                @php
                                        $url = 'public/download/Audit Note '.$value;
                                       if ($handle = opendir($url)) {

                                        while (false !== ($entry = readdir($handle))) {

                                            if ($entry != "." && $entry != "..") {
                                                $fileName = pathinfo($entry, PATHINFO_FILENAME);

                                                echo '<li><a href="'.$url.'/'.$entry.'" download>'.$fileName.' download</a><br></li>';
                                            }
                                        }

                                        closedir($handle);
                                        } 
                                      @endphp
                                       
                                         </ul>
                                        </div>
                                          </div>
                                        </div>
                                        <?php } ?>
                                        
                                       
                                      </div>
                                    
                                     
                                  
                                  </div>
                                   
                                </div>
                            </fieldset>
                       
                    </div>
                </div>
            </div>
            </div>
        <!--main content ends--> 
      </section>
    <!-- content --> 
  </aside>
<!-- right-side -->
@endsection