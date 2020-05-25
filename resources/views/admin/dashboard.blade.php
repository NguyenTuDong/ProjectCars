<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="author" content="Nguyen Tu Dong">
  <base href="/" />
  <title>
    Admin | Cars
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('css/app.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('css/admin.css')}}" type="text/css">
</head>

<body class="">
  <div id="app">
    <master></master>
  </div>
  <script>
    window.__user__ = @json($user);
    window.__routes__ = @json(collect(\Route::getRoutes())->map(function ($route) {
        $route->uri = URL::to($route->uri);;
        return $route;
      }));
  </script>
  <script src="{{asset('js/admin.js')}}"></script>
  <!--   Core JS Files   -->
  {{-- <script src="js/admin/plugins/perfect-scrollbar.jquery.min.js"></script> --}}
  <!-- Chart JS -->
  <script src="js/admin/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="js/admin/plugins/bootstrap-notify.js"></script>
  <script src="js/admin/now-ui-dashboard.js"></script>

</body>

</html>