@extends('layouts.admin')

@section('content')
<nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="{{route('home')}}">Trang chủ</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
      aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
    </button>
  </div>
</nav>
<div class="wrapper wrapper-full-page ">
  <div class="full-page login-page section-image">
    <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    <div class="content">
      <div class="container">
        <div class="col-md-4 ml-auto mr-auto">
          <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="card card-login card-plain">
              <div class="card-header ">
                <div class="logo-container">
                  Đăng nhập Admin
                </div>
              </div>
              <div class="card-body ">
                <div class="input-group no-border form-control-lg">
                  <span class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </span>
                  <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus />
                </div>
                <div class="input-group no-border form-control-lg">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons text_caps-small"></i>
                    </div>
                  </div>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    required autocomplete="current-password">
                </div>
              </div>
              <div class="card-footer ">
                <button type="submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">Đăng nhập</button>
                {{-- <div class="pull-left">
                  
                </div> --}}
                <div class="text-center">
                  <h6><a href="{{ route('admin.password.request') }}" class="link footer-link">Quên mật khẩu?</a></h6>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="full-page-background" style="background-image: url(../img/background/login.jpg) "></div>
    @endsection