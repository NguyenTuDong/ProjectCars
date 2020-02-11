@extends('layouts/header')

@section('content')
<div class="container-fluid px-5">
    <div class="row my-3">
        <div class="col-9">
            <div class="block">
                <div style="position:relative;">
                    <div class="cover">
                        <div class="black-gradient"></div>
                        <img id="show-cover" class="image" src="{{$user->cover_path}}" alt="">
                    </div>
                    <div class="avatar">
                        <img id="show-avatar" class="image" src="{{$user->avatar_path}}" alt="">
                    </div>
                    <div class="user-name">
                        {{$user->ten}}
                    </div>
                </div>
                <div class="mt-5">
                    <h4>GIỚI THIỆU</h4>
                    <div>
                        @if (empty($user->gioithieu))
                            Chưa cập nhật
                        @else
                            {!!$user->gioithieu!!}
                        @endif
                    </div>
                    <h4 class="my-3">XE ĐANG BÁN</h4>
                    <div class="line"></div>
                    <div>
                        @foreach ($cars as $car)
                            <div class="row">
                                <div class="col thumbnail">
                                    <div style="position: relative;">
                                        <div class="thumbnail-create">
                                            <img id="image" class="image" src="{{$car->hinhanh_path}}" alt="">
                                        </div>
                                        <div class="price">
                                            {{substr_replace(number_format($car->gia)," tr",-8)}} VND
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <a href="{{route('car.show', $car->id)}}"><h4><strong>{{$car->ten}}</strong></h4></a>
                                    <div>
                                        <span class="mr-1"><i class="fas fa-map-marker-alt"></i></span>
                                        <span class="mr-3">{{$car->locations['ten']}}</span>
                                        <span>{{$car->created_at->diffForHumans()}}</span>
                                    </div>
                                    <div class="mt-2">
                                        @if (!empty($car->namsx))
                                            <span class="badge">{{$car->namsx}}</span>
                                        @endif
                                        <span class="badge">{{$car->conditions['ten']}}</span>
                                        <span class="badge">{{$car->fuels['ten']}}</span>
                                        @if (!empty($car->dungtich))
                                            <span class="badge">{{$car->dungtich}} cc</span>
                                        @endif
                                    </div>
                                    <div class="description mt-2">
                                        {{strip_tags($car->mota)}}
                                    </div>
                                </div>
                            </div>
                            <div class="line"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="block">
                <h4>THÔNG TIN CHUNG</h4>
                <div class="my-3">
                    <div>
                        <span class="mr-2"><i class="fas fa-phone-alt"></i></span>
                        <span>{{$user->sdt}}</span>
                    </div>
                    <div>
                        <span class="mr-2"><i class="fas fa-map-marker-alt"></i></i></span>
                        <span>
                            @if (empty($user->diachi))
                                Chưa cập nhật
                            @else
                                {{$user->diachi}}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="block contact mt-4">
                <h4>THÔNG TIN LIÊN HỆ</h4>
                <form id="form-create" class="form-contact" action="{{route('contact')}}" method="post">
                    @csrf
                    <input type="text" name="user" style="display:none" value="{{$user->id}}">
                    <div class="my-4">
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" />
                    </div>
                    <div class="my-4">
                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" />
                    </div>
                    <div class="my-4">
                        <input type="number" id="sdt" class="form-control @error('sdt') is-invalid @enderror" name="sdt"
                            value="{{ old('sdt') }}" />
                    </div>
                    <div class="my-4">
                        <textarea id="noidung" class="form-control" name="noidung" value="{{ old('noidung')}}"></textarea>
                    </div>
                    <button id="btnSubmit" type="button" class="btn btn-primary" style="width: 100%;">Gửi</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
                $("#name").jqxInput({placeHolder: "(*) Họ và tên", height: 30, width: '100%', minLength: 1, theme: 'material'});
                $("#email").jqxInput({placeHolder: "(*) Email", height: 30, width: '100%', minLength: 1, theme: 'material'});
                $("#sdt").jqxInput({placeHolder: "(*) Số điện thoại", height: 30, width: '100%', minLength: 1, theme: 'material'});
                $("#noidung").jqxTextArea({placeHolder: "(*) Nội dung", height: 90, width: '100%', minLength: 1, theme: 'material'});
            });
    
            $('#form-create').jqxValidator({
                rules: [
                    { input: '#name', message: 'Vui lòng nhập trường này!', action: 'keyup, blur', rule: 'required' },
                    { input: '#email', message: 'Vui lòng nhập trường này!', action: 'keyup, blur', rule: 'required' },
                    { input: '#sdt', message: 'Vui lòng nhập trường này!', action: 'keyup, blur', rule: 'required' },
                    { input: '#noidung', message: 'Vui lòng nhập trường này!', action: 'keyup, blur', rule: 'required' },
                ]
            });
    
            $('#btnSubmit').on('click', function () {
                $('#form-create').jqxValidator('validate');
            });
    
            $('#form-create').jqxValidator({ onSuccess: function () { 
                $('#form-create').submit();
            } });
    </script>
@endsection