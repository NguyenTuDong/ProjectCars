<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Nguyen Tu Dong">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>


  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,600i,700,700i&display=swap"
    rel="stylesheet">
  <script src="https://kit.fontawesome.com/c04a2363e8.js"></script>

  <link rel="stylesheet" href="{{asset('js/jqwidgets/styles/jqx.base.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('js/jqwidgets/styles/jqx.material.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('js/jqwidgets/styles/jqx.light.css')}}" type="text/css" />

  <link rel="stylesheet" href="{{asset('css/app.css')}}" type="text/css">
  
  <script src="{{asset('js/app.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/scripts/jquery-1.11.1.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jqwidgets/jqx-all.js')}}"></script>
</head>

<body>

  <div id="app">
    <main>
      @yield('content')
    </main>
  </div>

  @yield('script')
</body>

</html>