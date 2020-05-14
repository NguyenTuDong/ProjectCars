@extends('layouts/header')

@section('content')
<div class="container-fluid px-5 py-3">
    <div class="block">
        <form id="form-create" action="{{route('car.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row" >
                <div class="col-4">
                    <div class="thumbnail-create mt-2">
                        <img id="image" class="image" src="{{asset('storage/img/no-img.png')}}" alt="">

                        <input type="button" class="input-image far fa-edit" id="get_img" value="&#xf044">
                        
                        <input type="file" name="hinhanh" id="hinhanh">
                    </div>
                    <div class="my-4">
                        <input type="number" id="gia" name="gia" step="1000000">
                    </div>
                    <div class="my-4" name="brand" id="brands"></div>
                    <div class="my-4" name="type" id="types"></div>
                    <div class="my-4" name="color" id="colors"></div>
                    <div class="my-4" name="furniture" id="furnitures"></div>
                    <div class="row my-4">
                        <div class="col-6">
                            Ngày bắt đầu:
                            <div class="mt-1" name="start" id="start"></div>
                        </div>
                        <div class="col-6">
                            Ngày kết thúc:
                            <div class="mt-1" name="end" id="end"></div>
                        </div>
                    </div>
                    
                    <table class="my-4 cost">
                        <tr>
                            <td>Thời gian hiển thị: </td>
                            <td><span id="days">1</span> ngày</td>
                        </tr>
                        <tr>
                            <td>Phí đăng tin: </td>
                            <td>1.000 VNĐ/ngày</td>
                        </tr>
                        <tr class="total">
                            <td>Tổng tiền: </td>
                            <td><span id="total">1.000</span> VNĐ</td>
                        </tr>
                    </table>
                </div>
                <div class="col-8">
                    <div class="my-4">
                        <input type="text" id="name" name="name">
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div name="origin" id="origins"> </div>
                        </div>
                        <div class="col">
                            <div name="condition" id="conditions"> </div>
                        </div>
                        <div class="col">
                            <div name="location" id="locations"> </div>
                        </div>
                    </div>
                    <div class="my-4" name="style" id="styles"> </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div name="doixe" id="doixes"> </div>
                        </div>
                        <div class="col">
                            <div name="namsx" id="namsxs"> </div>
                        </div>
                        <div class="col">
                            <div name="socua" id="socuas"> </div>
                        </div>
                        <div class="col">
                            <div name="sochongoi" id="sochongois"> </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div name="transmission" id="transmissions"> </div>
                        </div>
                        <div class="col">
                            <div name="fuel" id="fuels"> </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <input type="text" id="kichthuoc" name="kichthuoc">
                        </div>
                        <div class="col">
                            <input type="number" id="cannang" name="cannang">
                        </div>
                        <div class="col">
                            <input type="number" id="dungtich" name="dungtich">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <input type="text" id="phanh" name="phanh">
                        </div>
                        <div class="col">
                            <input type="text" id="giamxoc" name="giamxoc">
                        </div>
                        <div class="col">
                            <input type="text" id="lopxe" name="lopxe">
                        </div>
                    </div>
                    <div class="row mb-2 mx-0">
                        <div class="form-group" style="width: 100%">
                          <label for="mota">Mô tả</label>
                          <textarea class="form-control" name="mota" id="editor1" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="mb-2">
                        Tiện nghi
                    </div>
                    <div class="row mb-4 mx-0">
                        @php
                            $dem = 0;
                        @endphp
                        @foreach ($convenients as $convenient)
                            @php
                                $dem++;
                            @endphp
                            <div class="col-4">
                                <div class="custom-control custom-checkbox">
                                    <input id="convenient{{$convenient->id}}" class="custom-control-input" type="checkbox" name="convenient[]" value={{$convenient->id}}>
                                    <label class="custom-control-label" for="convenient{{$convenient->id}}">{{$convenient->ten}}</label>
                                </div>
                            </div>
                            @if ($dem % 3 ==0)
                                <div class="w-100"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <input id="btnSubmit" type="button" value="Đăng" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/post.js') }}"></script>
<script>
    $(function () {
          CKEDITOR.replace('editor1', {
            filebrowserBrowseUrl: '{{ asset('js/ckfinder/ckfinder.html') }}', 
            filebrowserImageBrowseUrl: '{{ asset('js/ckfinder/ckfinder.html?type=Images')}}', 
            filebrowserFlashBrowseUrl: '{{ asset('js/ckfinder/ckfinder.html?type=Flash') }}', 
            filebrowserUploadUrl: '{{ asset('js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files')}}', 
            filebrowserImageUploadUrl: '{{ asset('js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
            filebrowserFlashUploadUrl: '{{ asset('js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
          })
        })
</script>
@endsection