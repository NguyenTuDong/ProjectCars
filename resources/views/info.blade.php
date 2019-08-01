@extends('layouts/header')

@section('content')
<div class="container-fluid px-5">
    <div class="row my-3">
        <div class="col-9">
            <div class="block">
                <div style="position:relative;">
                    <form id="cover-form" class="cover" action="{{route('update.cover')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="black-gradient"></div>
                        <img id="show-cover" class="image" src="{{Auth::user()->cover_path}}" alt="">
                        <input type="button" class="input-cover far fa-edit" id="get_cover" value="&#xf044">
                        <input type="file" name="cover" id="cover">
                    </form>
                    <form id="avatar-form" class="avatar" action="{{route('update.avatar')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <img id="show-avatar" class="image" src="{{Auth::user()->avatar_path}}" alt="">
                        <input type="button" class="input-avatar far fa-edit" id="get_avatar" value="&#xf044">
                        <input type="file" name="avatar" id="avatar">
                    </form>
                    <div class="user-name">
                        {{Auth::user()->ten}}
                    </div>
                    <div class="update-button">
                        <button id="button-update-avatar" type="button" class="btn btn-primary" style="display:none" onclick="event.preventDefault(); document.getElementById('avatar-form').submit();">Lưu avatar</button>
                        <button id="button-update-cover" type="button" class="btn btn-primary" style="display:none" onclick="event.preventDefault(); document.getElementById('cover-form').submit();">Lưu cover</button>
                    </div>
                </div>
                <div class="mt-5">
                    <h4>GIỚI THIỆU</h4>
                    <div>
                        @if (empty(Auth::user()->gioithieu))
                            Chưa cập nhật
                        @else
                            {!!Auth::user()->gioithieu!!}
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
                        <span>{{Auth::user()->sdt}}</span>
                    </div>
                    <div>
                        <span class="mr-2"><i class="fas fa-map-marker-alt"></i></i></span>
                        <span>
                            @if (empty(Auth::user()->diachi))
                                Chưa cập nhật
                            @else
                                {{Auth::user()->diachi}}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="block contact mt-4">
                <h4>YÊU CẦU LIÊN HỆ</h4>
                <table class="table table-sm table-striped">
                    @foreach ($contacts as $contact)
                    <tr>
                        <td>
                            <div>
                                <a href="#" class="info-popover" data-toggle="popover" data-placement="left" data-trigger="hover" data-html="true"
                                data-content="Email: {{$contact->email}}</br>Sdt: {{$contact->sdt}}">
                                    <strong>{{$contact->ten}}</strong>
                                </a>
                            </div>
                            <div>
                                {{$contact->noidung}}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        function coverPreview(input) 
        { 
            if (input.files && input.files[0]) 
            {
                var reader = new FileReader(); 
                reader.onload = function(e) { 
                    $('#democover').remove();
                    $('#show-cover').after('<img class="image" id="democover" src="'+e.target.result+'" width="100%"/>'); 
                } 
                reader.readAsDataURL(input.files[0]); 
                document.getElementById('button-update-cover').style.display = "block";
            } 
        }
        function avatarPreview(input) 
        { 
            if (input.files && input.files[0]) 
            {
                var reader = new FileReader(); 
                reader.onload = function(e) { 
                    $('#demoavatar').remove();
                    $('#show-avatar').after('<img class="image" id="demoavatar" src="'+e.target.result+'" width="100%"/>'); 
                } 
                reader.readAsDataURL(input.files[0]);
                document.getElementById('button-update-avatar').style.display = "block";
            } 
        }
        document.getElementById('get_cover').onclick = function() { document.getElementById('cover').click(); };
        $("#cover").change(function () { coverPreview(this); });
        document.getElementById('get_avatar').onclick = function() { document.getElementById('avatar').click(); };
        $("#avatar").change(function () { avatarPreview(this); });
        
    </script>
@endsection