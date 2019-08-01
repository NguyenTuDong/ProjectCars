<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mua bán ô tô, xe hơi, ô tô cũ giá rẻ</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c04a2363e8.js"></script>

    <link rel="stylesheet" href="{{asset('js/jqwidgets/styles/jqx.base.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('js/jqwidgets/styles/jqx.material.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('js/jqwidgets/styles/jqx.light.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('css/app.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/style.scss')}}" type="text/plain">

</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid mx-4">
            <a class="navbar-brand pt-2" href="{{route('home')}}"><h3><strong>Cars</strong></h3></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto my-2">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('home')}}">Trang chủ</a>
                    </li>
                </ul>
                <div>
                    @auth
                    <div class="d-flex justify-content-end align-items-center">
                        <a class="login mx-5" href="{{route('car.create')}}"><i class="fas fa-plus mr-2"></i>Đăng tin</a>
                        <div class="dropdown">
                            <a id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                v-pre>
                                <div class="img-user">
                                    <img class="image" src="{{Auth::user()->avatar_path}}" alt="" width="100%">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('user.index')}}">Thông tin chi tiết</a>
                                <a class="dropdown-item" href="{{route('user.edit', Auth::user())}}">Cập nhật thông tin</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Đăng xuất') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    
                    @if (Route::has('register'))
                    <a class="register mx-1" href="{{ route('register') }}">Đăng ký</a>
                    @endif

                    <a class="login mx-1" href="{{ route('login') }}">Đăng nhập</a>
                    
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(Session::has('flash_message'))
    <div class="alert noti text-center alert-dismissible fade show" role="alert">
        <div class="noti-container">
            {{ Session::get('flash_message') }}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @yield('content')
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/ckeditor3/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxcore.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxbuttons.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxscrollbar.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxsplitter.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxlistbox.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxdata.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxcombobox.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxinput.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxpasswordinput.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxtooltip.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxexpander.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxvalidator.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxmaskedinput.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxdropdownlist.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jqwidgets/jqxtextarea.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/scripts/demos.js')}}"></script>
    <script>
       $(document).ready(function() {
            $("[data-toggle=popover]").popover();
        });
    </script>
    @yield('script')
</body>

</html>