@extends('layouts/header')

@section('content')
    <div class="container-fluid px-5">
        <div class="row my-3">
            <div class="col-9">
                <div class="block">
                    <div class="mb-4">
                        <h1><strong>{{$car->ten}}</strong></h1>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="thumbnail-create">
                                <img id="image" class="image" src="{{$car->hinhanh_path}}" alt="">
                            </div>
                        </div>
                        <div class="col-4">
                            Giá bán:
                            <h2><strong>{{substr_replace(number_format($car->gia)," tr",-8)}} VND</strong></h2>
                            <div>
                                <span class="mr-1"><i class="fas fa-map-marker-alt"></i></span>
                                <span class="mr-3">{{$car->locations['ten']}}</span>
                                <span>{{$car->created_at->diffForHumans()}}</span>
                            </div>
                            <div class="my-3">
                                <div class="row">
                                    <div class="col">
                                        <span></span>
                                        <span><strong>Hãng xe: </strong></span>
                                    </div>
                                    <div class="col">
                                        {{$car->types->brands['ten']}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span></span>
                                        <span><strong>Dòng xe: </strong></span>
                                    </div>
                                    <div class="col">
                                        {{$car->types['ten']}}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <span></span>
                                        <span><strong>Kiểu dáng: </strong></span>
                                    </div>
                                    <div class="col">
                                        {{$car->styles['ten']}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span></span>
                                        <span><strong>Tình trạng: </strong></span>
                                    </div>
                                    <div class="col">
                                        {{$car->conditions['ten']}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span></span>
                                        <span><strong>Xuất xứ: </strong></span>
                                    </div>
                                    <div class="col">
                                        {{$car->origins['ten']}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span></span>
                                        <span><strong>Năm sản xuất: </strong></span>
                                    </div>
                                    <div class="col">
                                        {{$car->namsx}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span></span>
                                        <span><strong>Đời xe: </strong></span>
                                    </div>
                                    <div class="col">
                                        {{$car->doixe}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div>
                        {!!$car->mota!!}
                    </div>
                    <h4 class="mt-2">THÔNG SỐ CƠ BẢN</h4>
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm table-striped">
                                @if (!empty($car->socua))
                                    <tr>
                                        <td>
                                            <strong>Số cửa</strong>
                                        </td>
                                        <td>
                                            {{$car->socua}}
                                        </td>
                                    </tr>
                                @endif
                                @if (!empty($car->sochongoi))
                                    <tr>
                                        <td>
                                            <strong>Số chỗ ngồi</strong>
                                        </td>
                                        <td>
                                            {{$car->sochongoi}}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>
                                        <strong>Nhiên liệu</strong>
                                    </td>
                                    <td>
                                        {{$car->fuels['ten']}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col">
                            <table class="table table-sm table-striped">
                                <tr>
                                    <td>
                                        <strong>Màu xe</strong>
                                    </td>
                                    <td>
                                        {{$car->colors['ten']}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Màu nội thất</strong>
                                    </td>
                                    <td>
                                        {{$car->furnitures['ten']}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Hộp số</strong>
                                    </td>
                                    <td>
                                        {{$car->transmissions['ten']}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if (!empty($car->kichthuoc) || !empty($car->cannang) || !empty($car->dungtich) || !empty($car->phanh) || !empty($car->giamxoc) || !empty($car->lopxe))
                        <h4 class="mt-2">THÔNG SỐ KỸ THUẬT</h4>
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm table-striped">
                                    @if (!empty($car->kichthuoc))
                                    <tr>
                                        <td>
                                            <strong>Dài x Rộng x Cao (mm)</strong>
                                        </td>
                                        <td>
                                            {{$car->kichthuoc}}
                                        </td>
                                    </tr>
                                    @endif
                                    @if (!empty($car->cannang))
                                    <tr>
                                        <td>
                                            <strong>Trọng lượng không tải (kg)</strong>
                                        </td>
                                        <td>
                                            {{$car->cannang}}
                                        </td>
                                    </tr>
                                    @endif
                                    @if (!empty($car->dungtich))
                                    <tr>
                                        <td>
                                            <strong>Dung tích động cơ</strong>
                                        </td>
                                        <td>
                                            {{$car->dungtich}}
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col">
                                <table class="table table-sm table-striped">
                                    @if (!empty($car->phanh))
                                    <tr>
                                        <td>
                                            <strong>Phanh</strong>
                                        </td>
                                        <td>
                                            {{$car->phanh}}
                                        </td>
                                    </tr>
                                    @endif
                                    @if (!empty($car->giamxoc))
                                    <tr>
                                        <td>
                                            <strong>Giảm xóc</strong>
                                        </td>
                                        <td>
                                            {{$car->giamxoc}}
                                        </td>
                                    </tr>
                                    @endif
                                    @if (!empty($car->lopxe))
                                    <tr>
                                        <td>
                                            <strong>Lốp xe</strong>
                                        </td>
                                        <td>
                                            {{$car->lopxe}}
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    @endif
                    @if ($convenientcars->count())
                        <h4 class="mt-2">TIỆN NGHI</h4>
                        <div class="row">
                            @php
                            $divide = $convenientcars->count() / 2;
                            @endphp
                            <div class="col">
                                <table class="table table-sm table-striped">
                                    @foreach ($convenientcars->slice(0,$divide) as $convenient)
                                    <tr>
                                        <td>
                                            <strong>{{$convenient->convenients['ten']}}</strong>
                                        </td>
                                        <td>
                                            <i class="fas fa-check"></i>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="col">
                                <table class="table table-sm table-striped">
                                    @foreach ($convenientcars->slice($divide,$convenientcars->count()) as $convenient)
                                    <tr>
                                        <td>
                                            <strong>{{$convenient->convenients['ten']}}</strong>
                                        </td>
                                        <td>
                                            <i class="fas fa-check"></i>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-3">
                @auth
                    @if ($car->users_id == Auth::user()->id)
                        <div class="block mb-4">
                            <div class="row">
                                <div class="col pr-1">
                                    <a href="{{route('car.edit', $car->id)}}" class="btn btn-primary" style="width:100%"><i class="fas fa-pen"></i> Sửa</a>
                                </div>
                                <div class="col pl-1">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert" style="width:100%">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="alertLable"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="alertLable">Thông báo</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa tin này?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                    <form action="{{route('car.destroy', $car->id)}}" method="post">
                                                        @method('delete') @csrf
                                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
                <div class="block">
                    <h4>THÔNG TIN NGƯỜI BÁN</h4>
                    <div class="d-flex justify-content-start my-3">
                        <div class="thumbnail-avatar">
                            <img id="image" class="image" src="{{$car->users['avatar_path']}}" alt="">
                        </div>
                        <div class="ml-2">
                            <div>
                                <a href="{{route('user.show', $car->users_id)}}"><strong>{{$car->users['ten']}}</strong></a>
                            </div>
                            <div class="d-flex justify-content-start">
                                <div class="mr-2"><i class="fas fa-map-marker-alt"></i></div>
                                <div style="font-size:12px">{{$car->users['diachi']}}</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span class="mr-2"><i class="fas fa-phone-alt"></i></span>
                        <span>{{$car->users['sdt']}}</span>
                    </div>
                </div>
                <div class="block contact mt-4">
                    <h4>THÔNG TIN LIÊN HỆ</h4>
                    <form id="form-create" class="form-contact" action="{{route('contact')}}" method="post">
                        @csrf
                        <input type="text" name="user" style="display:none" value="{{$car->users_id}}">
                        <div class="my-4">
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}"/>
                        </div>
                        <div class="my-4">
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}"/>
                        </div>
                        <div class="my-4">
                            <input type="number" id="sdt" class="form-control @error('sdt') is-invalid @enderror" name="sdt"
                                value="{{ old('sdt') }}"/>
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