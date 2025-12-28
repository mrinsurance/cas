<!DOCTYPE html>
<html>

@include('mylayout.head')

<body class="skin-josh">
@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
<div id="overlay">
        <img id="loading-image" src="{{url('assets/img/loading-2.gif')}}"/>
</div>    
@include('mylayout.header')
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
     @if(AuthRole()['name']  != 'SALEMAN')
        @include('mylayout.sidebar')
    @endif
        <!-- Right side column. Contains the navbar and content of the page -->
@yield('body')       
        <!-- right-side -->
    </div>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!-- global js -->
@include('mylayout.footer')
@include('mylayout.search-account-popup')
@include('mylayout.cash-in-hand-popup')
    <!-- end of page level js -->
<script src="{{ asset('assets/js/get-product-name.js') }}"></script>

<script src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/clockface/js/clockface.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/datepicker.js')}}" type="text/javascript"></script>
<script>
    // resources/js/app.js
    Echo.private('balance-sheet')
        .listen('BalanceSheetUpdated', (e) => {
            alert(e.message); // Or update the DOM as necessary
        });

</script>
</body>

</html>
