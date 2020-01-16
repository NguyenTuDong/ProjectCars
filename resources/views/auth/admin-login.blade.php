@extends('layouts.app')

@section('content')
<table style="width:100%">
    <tr>
        <td class="img-login text-center" style="width: 50%;">
            <a class="top-img" href="{{route('home')}}"><strong>Cars</strong></a>
            <a class="bottom-img" href="{{route('register')}}">Tạo tài khoản</a>
        </td>
        <td class="form" style="width: 50%;">
            <h1><strong>Đăng nhập Admin</strong></h1>

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="my-4">
                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus />
                </div>

                @error('email')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror

                <div class="my-4">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        required autocomplete="current-password">
                </div>

                @error('password')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror

                <div class="form-check my-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Ghi nhớ đăng nhập') }}
                    </label>
                </div>

                <div class="my-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Đăng nhập') }}
                    </button>

                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                    @endif
                </div>
            </form>
        </td>
    </tr>
</table>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#email").jqxInput({placeHolder: "Email", height: 40, width: 350, minLength: 1, theme: 'material'});
            $("#password").jqxInput({placeHolder: "Mật khẩu", height: 40, width: 350, minLength: 1, theme: 'material'});
        });
    </script>
@endsection
