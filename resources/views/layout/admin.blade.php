<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CenterStock Panel</title>
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" >
    {{--  <link href="https://fonts.googleapis.com/css?family=Comfortaa|Open+Sans" rel="stylesheet">  --}}
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin.css')}}" rel="stylesheet">
    <link href="{{asset('css/summernote/summernote-bs4.css')}}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">CenterStock</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
            <form class="form-inline" method="POST" action="#">
                    {{ csrf_field() }}
                    {{-- <a class="nav-link" href="#">@lang('adminLang.logout')</a> --}}
                    <button type="submit" class="btn btn-secondary">@lang('adminLang.logout')</button>
                </form>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <span data-feather="home"></span>
                                @lang('adminLang.dashboard') <span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>@lang('adminLang.admin-panel')</span>
                        <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.customer.index')}}">
                                <span data-feather="file-text"></span>
                                @lang('adminLang.customers')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.product.index')}}">
                                <span data-feather="file-text"></span>
                                @lang('adminLang.products')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.salesman.index')}}">
                                <span data-feather="file-text"></span>
                                @lang('adminLang.salesmans')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.area.index')}}">
                                <span data-feather="file-text"></span>
                                @lang('adminLang.areas')
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </nav>
            <main role="main" class="main col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

                    <div class="row">
                        <div class="col-6">
                            @include('admin.inc.error')
                            @include('admin.inc.flash')
                        </div>
                    </div>

                    @yield('content') 
                
            </main>
        </div>
    </div>



    
    


    <script src="{{asset('js/jquery-3.3.1.slim.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/holder.min.js')}}"></script>
    <script src="{{asset('css/summernote/summernote-bs4.js')}}"></script>
    {{-- <script src="{{asset('js/app.js')}}"></script> --}}
    <script src="{{asset('js/popper.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300
            });
            $('#summernote-short').summernote({
                height: 100
            });
        });
    </script>

    @stack('scripts')
    </body>
</html>