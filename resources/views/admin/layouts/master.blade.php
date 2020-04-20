<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- <base href="{{ asset('libs/sb-admin2') }}"> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Custom fonts for this template-->
    <link href="{{ asset('libs/sb-admin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('libs/sb-admin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('libs/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    @stack('css')

    @routes
</head>
<body id="page-top">
    <div id="app">
        <div id="wrapper">
            @include('admin.layouts.sidebar')

            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    @include('admin.layouts.header')

                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">@yield('heading-name')</h1>
                        </div>

                        {{-- Page content --}}
                        @yield('content')
                    </div>
                </div>
                <!-- End of Main Content -->

                @include('admin.layouts.footer')
            </div>
        </div>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">@csrf</form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- development version, includes helpful console warnings -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <!-- production version, optimized for size and speed -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> --}}

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('libs/sb-admin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/sb-admin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('libs/sb-admin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('libs/sb-admin2/js/sb-admin-2.min.js') }}"></script>
    
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    
    <script src="{{ asset('libs/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    @stack('script')

    <script>
        @if(session('success') || session('error'))
            alert('{{ session('success') ?? session('error') }}');
        @endif
    </script>
</body>
</html>
