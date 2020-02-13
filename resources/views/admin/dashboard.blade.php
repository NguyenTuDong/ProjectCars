<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
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
  <!-- CSS Files -->
  {{-- <link href="css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" /> --}}
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link href="../assets/demo/demo.css" rel="stylesheet" /> -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('css/admin.css')}}" type="text/css">
</head>

<body class="">
  <div id="app">
    <master routes={{
      collect(\Route::getRoutes())->map(function ($route) {
        $route->uri = URL::to($route->uri);;
        return $route;
      })
    }}></master>
  </div>
  <script src="{{asset('js/app.js')}}"></script>
  <!--   Core JS Files   -->
  <script src="js/admin/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Chart JS -->
  <script src="js/admin/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="js/admin/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="js/admin/now-ui-dashboard.js" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->

</body>

</html>