@extends('layouts/header')

@section('content')
<div class="container-fluid px-5 pt-3">
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
<script type="text/javascript">
    $(document).ready(function () {        
            // prepare the data

            var w = '100%';
            var h = 30;

            var brandsSource = null;
            var brandsAdapter = null;
            var typesSource = null;
            var typesAdapter = null;

            $("#name").jqxInput({placeHolder: "(*) Tên", height: h, width: w, minLength: 1, theme: 'material'});

            jQuery.ajax({
                url : '/getorigins',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var adapter = new $.jqx.dataAdapter(data);
                    $("#origins").jqxDropDownList(
                    {
                        source: adapter,
                        width: w,
                        height: h,
                        theme: 'material',
                        promptText: "(*) Xuất xứ",
                        displayMember: 'ten',
                        valueMember: 'id',
                        autoDropDownHeight: adapter.records.length > 10 ? false : true
                    });
                }
            });

            jQuery.ajax({
                url : '/getconditions',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var adapter = new $.jqx.dataAdapter(data);
                    $("#conditions").jqxDropDownList(
                    {
                        source: adapter,
                        width: w,
                        height: h,
                        theme: 'material',
                        promptText: "(*) Tình trạng",
                        displayMember: 'ten',
                        valueMember: 'id',
                        autoDropDownHeight: adapter.records.length > 10 ? false : true
                    });
                }
            });

            jQuery.ajax({
                url : '/getlocations',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var adapter = new $.jqx.dataAdapter(data);
                    $("#locations").jqxComboBox(
                    {
                        searchMode: 'containsignorecase',
                        source: adapter,
                        width: w,
                        height: h,
                        theme: 'material',
                        promptText: "(*) Tỉnh/thành",
                        displayMember: 'ten',
                        valueMember: 'id',
                    });
                }
            });

            jQuery.ajax({
                url : '/getstyles',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var adapter = new $.jqx.dataAdapter(data);
                    $("#styles").jqxDropDownList(
                    {
                        source: adapter,
                        width: w,
                        height: h,
                        theme: 'material',
                        promptText: "(*) Kiểu dáng",
                        displayMember: 'ten',
                        valueMember: 'id',
                        dropDownHeight: 300,
                        renderer: function (index, label, value) {
                            var datarecord = data[index];
                            var imgurl = '/img/style/' + datarecord.hinhanh;
                            var img = '<img src="' + imgurl + '" />';
                            var table = '<table style="width: 100%; min-width: 150px; min-height: 100px;"><tr><td style="width: 150px;">' + img + '</td><td>' + datarecord.ten + '</td></tr></table>';
                            return table;
                            }
                    });
                }
            });

            var d = new Date();
            var year = d.getFullYear();
            var years = new Array();
            for (let i = 0; i < 10; i++) {
                years.push(year - i);
            }

            $("#doixes").jqxComboBox(
            {
                source: years,
                width: w,
                height: h,
                theme: 'material',
                promptText: "Đời xe",
            });

            $("#namsxs").jqxComboBox(
            {
                source: years,
                width: w,
                height: h,
                theme: 'material',
                promptText: "Năm sản xuất",
            });

            $("#socuas").jqxComboBox(
            {
                source: ['2', '3', '4', '5'],
                width: w,
                height: h,
                theme: 'material',
                promptText: "Số cửa",
                autoDropDownHeight: true,
            });

            $("#sochongois").jqxComboBox(
            {
                source: ['2', '4', '5', '7', '9', '12', '16', '24', '29', '45', 'Khác'],
                width: w,
                height: h,
                theme: 'material',
                promptText: "Số chổ ngồi",
            });

            jQuery.ajax({
                url : '/gettransmissions',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var adapter = new $.jqx.dataAdapter(data);
                    $("#transmissions").jqxDropDownList(
                    {
                        source: adapter,
                        width: w,
                        height: h,
                        theme: 'material',
                        promptText: "(*) Hộp số",
                        displayMember: 'ten',
                        valueMember: 'id',
                        autoDropDownHeight: adapter.records.length > 10 ? false : true
                    });
                }
            });

            jQuery.ajax({
                url : '/getfuels',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var adapter = new $.jqx.dataAdapter(data);
                    $("#fuels").jqxDropDownList(
                    {
                        source: adapter,
                        width: w,
                        height: h,
                        theme: 'material',
                        promptText: "(*) Nhiên liệu",
                        displayMember: 'ten',
                        valueMember: 'id',
                        autoDropDownHeight: adapter.records.length > 10 ? false : true
                    });
                }
            });
            
            $("#kichthuoc").jqxInput({placeHolder: "Kích thước", height: h, width: w, minLength: 1, theme: 'material'});
            $("#cannang").jqxInput({placeHolder: "Cân nặng", height: h, width: w, minLength: 1, theme: 'material'});
            $("#dungtich").jqxInput({placeHolder: "Dung tích", height: h, width: w, minLength: 1, theme: 'material'});
            $("#phanh").jqxInput({placeHolder: "Phanh", height: h, width: w, minLength: 1, theme: 'material'});
            $("#giamxoc").jqxInput({placeHolder: "Giảm xóc", height: h, width: w, minLength: 1, theme: 'material'});
            $("#lopxe").jqxInput({placeHolder: "Lốp xe", height: h, width: w, minLength: 1, theme: 'material'});

            $("#gia").jqxInput({placeHolder: "(*) Giá tiền", height: h, width: w, minLength: 1, theme: 'material'});

            jQuery.ajax({
                url : '/getbrands',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    brandsSource = data;
                    brandsAdapter = new $.jqx.dataAdapter(brandsSource);
                    $("#brands").jqxComboBox(
                    {
                        searchMode: 'containsignorecase',
                        source: brandsAdapter,
                        width: w,
                        height: h,
                        theme: 'material',
                        promptText: "(*) Hãng xe",
                        displayMember: 'ten',
                        valueMember: 'id',
                        renderer: function (index, label, value) {
                            var datarecord = brandsSource[index];
                            var imgurl = '/img/logo/' + datarecord.logo;
                            var img = '<img src="' + imgurl + '" />';
                            var table = '<table style="min-width: 150px;"><tr><td style="width: 55px;">' + img + '</td><td>' + datarecord.ten + '</td></tr></table>';
                            return table;
                            }
                    });
                }
            });

            jQuery.ajax({
                url : '/gettypes',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    typesSource = data;
                    typesAdapter = new $.jqx.dataAdapter(typesSource);
            
                    $("#types").jqxComboBox(
                    {
                        searchMode: 'containsignorecase',
                        width: w,
                        height: h,
                        theme: 'material',
                        disabled: true,
                        promptText: "(*) Dòng xe",
                        displayMember: 'ten',
                        valueMember: 'id'
                    });
                }
            });
            
            $("#brands").bind('select', function(event)
            {
                if (event.args)
                {
                    $("#types").jqxComboBox({ disabled: false, selectedIndex: -1});
                    var value = event.args.item.value;
                    typesSource.data = {id: value};
                    typesAdapter = new $.jqx.dataAdapter(typesSource, {
                        beforeLoadComplete: function (records) {
                            var filteredRecords = new Array();
                            for (var i = 0; i < records.length; i++) { 
                                if (records[i].brands_id==value) filteredRecords.push(records[i]); 
                            } 
                            return filteredRecords; 
                        } 
                    }); 
                    $("#types").jqxComboBox({ source: typesAdapter, autoDropDownHeight: typesAdapter.records.length > 10 ? false : true});
                }
            });

            jQuery.ajax({
                url : '/getcolors',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var adapter = new $.jqx.dataAdapter(data);
                    $("#colors").jqxDropDownList(
                    {
                        source: adapter,
                        width: w,
                        height: h,
                        theme: 'material',
                        promptText: "(*) Màu xe",
                        displayMember: 'ten',
                        valueMember: 'id',
                        renderer: function (index, label, value) {
                            var datarecord = data[index];
                            var imgurl = '/img/color/' + datarecord.rgb;
                            var img = '<img src="' + imgurl + '" />';
                            var table = '<table style="min-width: 150px;"><tr><td style="width: 55px;">' + img + '</td><td>' + datarecord.ten + '</td></tr></table>';
                            return table;
                            }
                    });
                }
            });
            

            jQuery.ajax({
                url : '/getcolors',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var adapter = new $.jqx.dataAdapter(data);
                    $("#furnitures").jqxDropDownList(
                    {
                        source: adapter,
                        width: w,
                        height: h,
                        theme: 'material',
                        promptText: "(*) Màu nội thất",
                        displayMember: 'ten',
                        valueMember: 'id',
                        renderer: function (index, label, value) {
                            var datarecord = data[index];
                            var imgurl = '/img/color/' + datarecord.rgb;
                            var img = '<img src="' + imgurl + '" />';
                            var table = '<table style="min-width: 150px;"><tr><td style="width: 55px;">' + img + '</td><td>' + datarecord.ten + '</td></tr></table>';
                            return table;
                            }
                    });
                }
            });
        });

        $('#form-create').jqxValidator({
            rules: [
                { input: '#name', message: 'Vui lòng nhập trường này!', action: 'keyup, blur', rule: 'required' },
                { input: '#gia', message: 'Vui lòng nhập trường này!', action: 'keyup, blur', rule: 'required' },
                {
                    input: '#brands', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#brands').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#origins', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#origins').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#conditions', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#conditions').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#locations', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#locations').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#transmissions', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#transmissions').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#fuels', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#fuels').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#types', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#types').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#styles', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#styles').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#colors', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#colors').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#furnitures', message: 'Vui lòng nhập trường này!', action: 'blur', rule: function (input, commit) {
                        var value = $('#furnitures').val();
                        if (value.length == 0) {
                            return false;
                        }
                        return true;
                    }
                },
                {
                    input: '#namsxs', message: 'Năm sản xuất phải lớn hơn hoặc bằng đời xe.', action: 'keyup', rule: function (input, commit) {
                        var doixe = $('#doixes').jqxComboBox('val');
                        var namsx = $('#namsxs').jqxComboBox('val');
                        var result = namsx >= doixe;
                        // call commit with false, when you are doing server validation and you want to display a validation error on this field. 
                        return result;
                    }
                },
                {
                    input: '#gia', message: 'Giá tiền phải là số nguyên dương.', action: 'keyup', rule: function (input, commit) {
                        var gia = $('#gia').jqxInput('val');
                        var result = gia >= 0;
                        // call commit with false, when you are doing server validation and you want to display a validation error on this field. 
                        return result;
                    }
                },
                {
                    input: '#doixes', message: 'Đời xe phải là số nguyên dương.', action: 'keyup', rule: function (input, commit) {
                        var gia = $('#doixes').jqxComboBox('val');
                        var result = gia >= 0;
                        // call commit with false, when you are doing server validation and you want to display a validation error on this field. 
                        return result;
                    }
                },
                {
                    input: '#namsxs', message: 'Năm sản xuất phải là số nguyên dương.', action: 'keyup', rule: function (input, commit) {
                        var gia = $('#namsxs').jqxComboBox('val');
                        var result = gia >= 0;
                        // call commit with false, when you are doing server validation and you want to display a validation error on this field. 
                        return result;
                    }
                },
                {
                    input: '#socuas', message: 'Số cửa phải là số nguyên dương.', action: 'keyup', rule: function (input, commit) {
                        var gia = $('#socuas').jqxComboBox('val');
                        var result = gia >= 0;
                        // call commit with false, when you are doing server validation and you want to display a validation error on this field. 
                        return result;
                    }
                },
                {
                    input: '#sochongois', message: 'Số chổ ngồi phải là số nguyên dương.', action: 'keyup', rule: function (input, commit) {
                        var gia = $('#sochongois').jqxComboBox('val');
                        var result = gia >= 0;
                        // call commit with false, when you are doing server validation and you want to display a validation error on this field. 
                        return result;
                    }
                },
            ]
        });

        $('#btnSubmit').on('click', function () {
            $('#form-create').jqxValidator('validate');
        });

        $('#form-create').jqxValidator({ onSuccess: function () { 
            $('#form-create').submit();
        } });

</script>
<script>
    function imagePreview(input) 
    { 
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader(); 
            reader.onload = function(e) { 
                $('#demoimage').remove();
                $('#image').after('<img class="image" id="demoimage" src="'+e.target.result+'" width="100%"/>'); 
            } 
            reader.readAsDataURL(input.files[0]); 
        } 
    }
    document.getElementById('get_img').onclick = function() { document.getElementById('hinhanh').click(); };
    $("#hinhanh").change(function () { imagePreview(this); });
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