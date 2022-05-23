<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Simple Sidebar - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    @yield('css')
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->

        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light"></div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{url('/')}}">Dashboard</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{url('/add-survivor')}}">Add Survivor</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{url('/update-location')}}">Update Location</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{url('/list-robots')}}">List Robots</a> 
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{url('/list-survivors')}}">List Survivors</a> 
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href=""></a>
                
            </div>
        </div>

        
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    @auth
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    @endauth
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page content-->
            <div class="container-fluid">
                <input type="hidden" name="_tocken" id="_tocken" value="{{ csrf_token() }}">
               
                @yield('content')
            </div>

        </div>
    </div>

</body>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{ asset('js/scripts.js') }}"></script>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<!-- <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->

<!-- Core plugin JavaScript-->
<!-- <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script> -->



<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('#_tocken').val()
        }
    });
</script>
@yield('script')
</html>
