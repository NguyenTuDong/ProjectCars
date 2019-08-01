@extends('layouts.app')

@section('content')
<table style="width:100%">
    <tr>
        <td class="form" style="width: 50%;">
            <h1><strong>Đăng ký</strong></h1>

            <form id="form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="my-4">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="my-4">
                    <div id="location" type="number" class="@error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required>
                
                    @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="my-4">
                    <div class="row mx-0">
                        <div class="col-xs-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">
                            
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-xs-6 ml-4">
                            <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
                            
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="my-4">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        required autocomplete="new-password">
                
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="my-4">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="row mx-0">
                    <div class="col-xs-6">
                        <input id="sodk" type="text" class="form-control @error('sodk') is-invalid @enderror" name="sodk" value="{{ old('sodk') }}">
                        
                        @error('sodk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-xs-6 ml-4">
                        <input id="mst" type="text" class="form-control @error('mst') is-invalid @enderror" name="mst" value="{{ old('mst') }}">
                        
                        @error('mst')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="my-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Đăng ký') }}
                    </button>
                </div>
            </form>
        </td>
        <td class="img-register text-center" style="width: 50%;">
            <a class="top-img" href="{{route('home')}}"><strong>Cars</strong></a>
            <a class="bottom-img" href="{{route('login')}}">Đã có tài khoản</a>
        </td>
    </tr>
</table>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $("#name").jqxInput({placeHolder: "(*) Tên", height: 40, width: 400, minLength: 1, theme: 'material'});
        $("#email").jqxInput({placeHolder: "(*) Email", height: 40, width: 188, minLength: 1, theme: 'material'});
        $("#password").jqxPasswordInput({placeHolder: "(*) Mật khẩu", height: 40, width: 400, showStrength: true, showStrengthPosition: "right", theme: 'material' });
        $("#password-confirm").jqxPasswordInput({placeHolder: "(*) Nhập lại mật khẩu", height: 40, width: 400, minLength: 1, theme: 'material'});
        $("#phone").jqxInput({placeHolder: "(*) Số điện thoại", height: 40, width: 188, theme: 'material'});
        $("#sodk").jqxInput({placeHolder: "Số đăng ký kinh doanh", height: 40, width: 188, theme: 'material'});
        $("#mst").jqxInput({placeHolder: "Mã số thuế", height: 40, width: 188, theme: 'material'});
        jQuery.ajax({
                url : 'getlocations',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var locationsSource = data;
                    var locationsAdapter = new $.jqx.dataAdapter(locationsSource);
                    $("#location").jqxComboBox(
                    {
                        searchMode: 'containsignorecase',
                        source: locationsAdapter,
                        width: 400,
                        height: 40,
                        theme: 'material',
                        promptText: "(*) Tỉnh/thành",
                        displayMember: 'ten',
                        valueMember: 'id',
                    });
                }
            });
    });
    $("#form").jqxValidator({
        rules: [
            {
                input: "#password-confirm", message: "Mật khẩu phải trùng!", action: 'keyup, blur', rule: function (input, commit) {
                    var firstPassword = $("#password").jqxPasswordInput('val');
                    var secondPassword = $("#password-confirm").jqxPasswordInput('val');
                    return firstPassword == secondPassword;
                }
            },
        ],
        theme: 'material'
    });
</script>
@endsection
