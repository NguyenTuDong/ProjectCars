@extends('layouts/header')

@section('content')
<div class="container-fluid px-5">
    <div class="block my-4">
        <form id="form-update" action="{{route('user.update', Auth::user()->id)}}" method="post">
            @csrf @method('patch')
            <h4 class="my-2">THÔNG TIN CHUNG</h4>
            <div class="my-4">
                <input type="text" id="name" name="name" value="{{Auth::user()->ten}}">
            </div>
            <div class="my-4">
                <div class="row">
                    <div class="col-9">
                        <input type="text" id="diachi" name="diachi" value="{{Auth::user()->diachi}}">
                    </div>
                    <div class="col-3">
                        <select name="location" id="locations">
                            @foreach ($locations as $location)
                                <option 
                                @if ($location->id == Auth::user()->locations_id)
                                    selected
                                @endif
                                value="{{$location->id}}">{{$location->ten}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <div class="row">
                    <div class="col">
                        <input type="number" id="sdt" name="sdt" value="{{Auth::user()->sdt}}">
                    </div>
                    <div class="col">
                        <input type="number" id="cmnd" name="cmnd" value="{{Auth::user()->cmnd}}">
                    </div>
                    <div class="col">
                        <input type="text" id="sodkkd" name="sodkkd" value="{{Auth::user()->sodkkd}}">
                    </div>
                    <div class="col">
                        <input type="text" id="mst" name="mst" value="{{Auth::user()->mst}}">
                    </div>
                </div>
            </div>
            <div class="my-4">
                <h4 class="my-2">GIỚI THIỆU</h4>
                <textarea name="gioithieu" id="editor1"  rows="10">{{Auth::user()->gioithieu}}</textarea>
            </div>
            <button id="btnSubmit" type="button" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script>
        var w = '100%';
        var h = 30;
        var select_location = $("#user-location").val();

        $("#name").jqxInput({placeHolder: "Tên", height: h, width: w, minLength: 1, theme: 'material'});
        $("#diachi").jqxInput({placeHolder: "Địa chỉ", height: h, width: w, minLength: 1, theme: 'material'});
        $("#sdt").jqxInput({placeHolder: "Số điện thoại", height: h, width: w, minLength: 1, theme: 'material'});
        $("#cmnd").jqxInput({placeHolder: "CMND", height: h, width: w, minLength: 1, theme: 'material'});
        $("#sodkkd").jqxInput({placeHolder: "Số đăng kí kinh doanh", height: h, width: w, minLength: 1, theme: 'material'});
        $("#mst").jqxInput({placeHolder: "Mã số thuế", height: h, width: w, minLength: 1, theme: 'material'});

        $("#locations").jqxComboBox(
        {
            searchMode: 'containsignorecase',
            width: w,
            height: h,
            theme: 'material',
            promptText: "(*) Tỉnh/thành",
        });

        $('#form-update').jqxValidator({
            rules: [
                { input: '#name', message: 'Vui lòng nhập trường này!', action: 'keyup, blur', rule: 'required' },
                { input: '#sdt', message: 'Vui lòng nhập trường này!', action: 'keyup, blur', rule: 'required' },
                {
                    input: '#locations', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#locations').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
            ]
        });

        $('#btnSubmit').on('click', function () {
            $('#form-update').jqxValidator('validate');
        });

        $('#form-update').jqxValidator({ onSuccess: function () {
            document.getElementById("form-update").submit();
        } });
    </script>
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