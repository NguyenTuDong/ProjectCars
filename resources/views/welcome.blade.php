@extends('layouts/header')

@section('content')
    <div class="container-fluid px-5">
        <div class="row mt-3">
            <div class="col search-menu">
                <div class="block">
                    <form action="{{route('search')}}" method="get">
                        Bạn muốn tìm gì?
                        <div class="my-3">
                            <input type="text" id="name" name="name" @if (isset($name)) value="{{$name}}" @endif>
                        </div>
                        <a class="link" data-toggle="collapse" href="#location" role="button" aria-expanded="false"
                            aria-controls="location">
                            <div class="d-flex justify-content-between my-2">
                                Khu vực
                                <i class="fas fa-sort-down"></i>
                            </div>
                        </a>
                        <div class="collapse show" id="location">
                            <div class="my-3" name="location" id="locations" @if (isset($location)) data-old="{{$location}}" @endif></div>
                        </div>
                        <a class="link" data-toggle="collapse" href="#car" role="button" aria-expanded="false" aria-controls="locations">
                            <div class="d-flex justify-content-between my-2">
                                Mẫu xe
                                <i class="fas fa-sort-down"></i>
                            </div>
                        </a>
                        <div class="collapse show" id="car">
                            <div class="my-3" name="brand" id="brands" @if (isset($brand)) data-old="{{$brand}}" @endif></div>
                            <div class="my-3" name="type" id="types" @if (isset($type)) data-old="{{$type}}" @endif></div>
                            <div class="row my-3">
                                <div class="col-5 pr-0">
                                    <div name="namsx_s" id="namsxs-start" @if (isset($namsxS)) data-old="{{$namsxS}}" @endif></div>
                                </div>
                                <div class="col-2 px-0 d-flex align-items-end justify-content-center">
                                    đến
                                </div>
                                <div class="col-5 pl-0">
                                    <div name="namsx_e" id="namsxs-end" @if (isset($namsxE)) data-old="{{$namsxE}}" @endif></div>
                                </div>
                            </div>
                        </div>
                        <a class="link" data-toggle="collapse" href="#price" role="button" aria-expanded="false" aria-controls="prices">
                            <div class="d-flex justify-content-between my-2">
                                Giá
                                <i class="fas fa-sort-down"></i>
                            </div>
                        </a>
                        <div class="collapse show" id="price">
                            <div class="row mt-3">
                                <div class="col">
                                    <div name="gia_s" id="gias-start" @if (isset($giaS)) data-old="{{$giaS}}" @endif></div>
                                </div>
                                <div class="col">
                                    <div name="gia_e" id="gias-end" @if (isset($giaE)) data-old="{{$giaE}}" @endif></div>
                                </div>
                            </div>
                            <div id="gias-kq" class="mb-3"></div>
                        </div>
                        <a class="link" data-toggle="collapse" href="#condition" role="button" aria-expanded="false" aria-controls="conditions">
                            <div class="d-flex justify-content-between my-2">
                                Tình trạng
                                <i class="fas fa-sort-down"></i>
                            </div>
                        </a>
                        <div class="collapse @if (isset($tinhtrang)) show @endif my-3" id="condition">
                            @foreach ($conditions as $condition)
                                <div class="custom-control custom-checkbox">
                                    <input id="condition{{$condition->id}}" class="custom-control-input" type="checkbox" name="condition[]"
                                        @if (isset($tinhtrang))
                                        @foreach ($tinhtrang as $item)
                                        @if ($item == $condition->id)
                                        checked
                                        @endif
                                        @endforeach
                                        @endif
                                        value={{$condition->id}}>
                                    <label class="custom-control-label" for="condition{{$condition->id}}">{{$condition->ten}}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%">Tìm</button>
                    </form>
                </div>
            </div>
            <div class="col">
                @foreach ($cars as $car)
                    <div class="block car mb-3">
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
                    </div>
                @endforeach
            </div>
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

            var oldlocation = $("#locations").data("old") - 1;
            var oldbrand = $("#brands").data("old") - 1;
            var oldtype = $("#types").data("old") - 1;
            var oldnamsxs = $("#namsxs-start").data("old");
            var oldnamsxe = $("#namsxs-end").data("old");
            var oldgias = $("#gias-start").data("old");
            var oldgiae = $("#gias-end").data("old");

            $("#name").jqxInput({placeHolder: "Tên", height: h, width: w, minLength: 1, theme: 'material'});

            $("#locations").jqxComboBox(
            {
                searchMode: 'containsignorecase',
                width: w,
                height: h,
                theme: 'material',
                promptText: "Tỉnh/thành",
                displayMember: 'ten',
                valueMember: 'id',
            });
            jQuery.ajax({
                url : '/getlocations',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    var locationsSource = data;
                    var locationsAdapter = new $.jqx.dataAdapter(locationsSource);
                    $("#locations").jqxComboBox(
                    {
                        source: locationsAdapter,
                        selectedIndex: oldlocation,
                    });
                }
            });

            $("#brands").jqxComboBox(
            {
                searchMode: 'containsignorecase',
                width: w,
                height: h,
                theme: 'material',
                promptText: "Hãng xe",
                displayMember: 'ten',
                valueMember: 'id',
            });
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
                        source: brandsAdapter,
                        selectedIndex: oldbrand,
                        renderer: function (index, label, value) {
                            var datarecord = brandsSource[index];
                            var img = '<img src="' + datarecord.logo_path + '" />';
                            var table = '<table style="min-width: 150px;"><tr><td style="width: 55px;">' + img + '</td><td>' + datarecord.ten + '</td></tr></table>';
                            return table;
                            }
                    });
                }
            });

            $("#types").jqxComboBox(
            {
                searchMode: 'containsignorecase',
                width: w,
                height: h,
                theme: 'material',
                disabled: true,
                promptText: "Dòng xe",
                displayMember: 'ten',
                valueMember: 'id'
            });
            jQuery.ajax({
                url : '/gettypes',
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    typesSource = data;
                    typesAdapter = new $.jqx.dataAdapter(typesSource);

                    if (oldbrand != null)
                    {
                        $("#types").jqxComboBox({ disabled: false});
                        let index = new Array();
                        var value = oldbrand + 1;
                        oldtype = oldtype + 1;
                        typesSource.data = {id: value};
                        typesAdapter = new $.jqx.dataAdapter(typesSource, {
                            beforeLoadComplete: function (records) {
                                var filteredRecords = new Array();
                                for (var i = 0, length = records.length; i < length; i++) { 
                                    if (records[i].brands_id==value) filteredRecords.push(records[i]);
                                    if (records[i].id==oldtype) index.push(filteredRecords.length - 1);
                                } 
                                return filteredRecords; 
                            } 
                        });
                        $("#types").jqxComboBox({ source: typesAdapter, selectedIndex: index, autoDropDownHeight: typesAdapter.records.length > 10 ? false : true});
                    }
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
                            for (var i = 0, length = records.length; i < length; i++) { 
                                if (records[i].brands_id==value) filteredRecords.push(records[i]); 
                            } 
                            return filteredRecords; 
                        } 
                    }); 
                    $("#types").jqxComboBox({ source: typesAdapter, autoDropDownHeight: typesAdapter.records.length > 10 ? false : true});
                }
            });

            var d = new Date();
            var year = d.getFullYear();
            var years = new Array();
            for (let i = 0; i < 10; i++) {
                years.push(year - i);
            }

            $("#namsxs-start").jqxComboBox(
            {
                source: years,
                width: w,
                height: h,
                theme: 'material',
                promptText: "Năm",
            });
            $("#namsxs-start").jqxComboBox('selectItem', oldnamsxs );

            var namsxS = $("#namsxs-start").val();
            var yearsE = new Array();
            for (var i = 0, length = years.length; i < length; i++) { 
                if (years[i] > namsxS) yearsE.push(years[i]); 
            }
            $("#namsxs-end").jqxComboBox(
            {
                source: yearsE,
                width: w,
                height: h,
                theme: 'material',
                promptText: "Năm",
                autoDropDownHeight: yearsE.length > 7 ? false : true,
            });
            $("#namsxs-end").jqxComboBox('selectItem', oldnamsxe );

            $("#namsxs-start").bind('select', function(event)
            {
                if (event.args)
                {
                    var start = event.args.item.value;
                    var item = $("#namsxs-end").jqxComboBox('getSelectedItem');
                    var end = $("#namsxs-end").val();
                    var filteredRecords = new Array();
                    for (var i = 0, length = years.length; i < length; i++) { 
                        if (years[i] > start) filteredRecords.push(years[i]); 
                    } 
                    $("#namsxs-end").jqxComboBox({ source: filteredRecords, autoDropDownHeight: filteredRecords.length > 7 ? false : true});
                    if (end != "") {
                        $("#namsxs-end").jqxComboBox('selectItem', item.value );
                    }
                }
            });

            var prices = [
                {value: 0, title: '0 tr'},
                {value: 50, title: '50 tr'},
                {value: 100, title: '100 tr'},
                {value: 150, title: '150 tr'},
                {value: 200, title: '200 tr'},
                {value: 300, title: '300 tr'},
                {value: 400, title: '400 tr'},
                {value: 500, title: '500 tr'},
                {value: 600, title: '600 tr'},
                {value: 700, title: '700 tr'},
                {value: 800, title: '800 tr'},
                {value: 900, title: '900 tr'},
                {value: 1000, title: '1 tỷ'},
            ]

            $("#gias-start").jqxComboBox(
            {
                source: prices,
                width: w,
                height: h,
                theme: 'material',
                promptText: "Từ",
                displayMember: 'title',
                valueMember: 'value',
            });
            $("#gias-start").jqxComboBox('selectItem', oldgias);

            var giaS = $("#gias-start").val();
            var pricesEnd = new Array();
            for (var i = 0, length = prices.length; i < length; i++) { 
                if (prices[i].value > giaS) pricesEnd.push(prices[i]); 
            } 
            $("#gias-end").jqxComboBox(
            {
                source: pricesEnd,
                width: w,
                height: h,
                theme: 'material',
                promptText: "Đến",
                displayMember: 'title',
                valueMember: 'value',
                autoDropDownHeight: pricesEnd.length > 7 ? false : true,
            });
            $("#gias-end").jqxComboBox('selectItem', oldgiae);

            $("#gias-start").bind('select', function(event)
            {
                if (event.args)
                {
                    var start = event.args.item.value;
                    var item = $("#gias-end").jqxComboBox('getSelectedItem');
                    var end = $("#gias-end").val();
                    var filteredRecords = new Array();
                    for (var i = 0, length = prices.length; i < length; i++) { 
                        if (prices[i].value > start) filteredRecords.push(prices[i]); 
                    } 
                    $("#gias-end").jqxComboBox({ source: filteredRecords, autoDropDownHeight: filteredRecords.length > 7 ? false : true});
                    if (end != "") {
                        $("#gias-end").jqxComboBox('selectItem', item.value );
                    }
                }
            });

            $('#gias-start').on('select', function (event) {
                $('#gias-kq').children().remove();
                var valueelement = $("<small></small>");
                var args = event.args;
                var end = $('#gias-end').val();
                if (args != undefined) {
                    var item = event.args.item;
                    if (item != null) {
                        if (end.length == 0) {
                            valueelement.text('Trên ' + item.label);
                        }
                        else {
                            valueelement.text('Từ ' + item.label + ' đến ' + end + 'tr');
                        }
                        $('#gias-kq').append(valueelement);
                    }
                }
            });

            $('#gias-end').on('select', function (event) {
                $('#gias-kq').children().remove();
                var valueelement = $("<small></small>");
                var args = event.args;
                var start = $('#gias-start').val();
                if (args != undefined) {
                    var item = event.args.item;
                    if (item != null) {
                        if (start.length == 0) {
                            valueelement.text('Dưới ' + item.label);
                        }
                        else {
                            valueelement.text('Từ ' + start + ' tr đến ' + item.label);
                        }
                        $('#gias-kq').append(valueelement);
                    }
                }
            });
        });
    </script>
@endsection
