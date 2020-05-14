// prepare the data

var w = '100%';
var h = 30;

var brandsSource = null;
var brandsAdapter = null;
var typesSource = null;
var typesAdapter = null;

$("#name").jqxInput({ placeHolder: "(*) Tên", height: h, width: w, minLength: 1, theme: 'material' });

jQuery.ajax({
  url: '/getorigins',
  type: "GET",
  dataType: "json",
  success: function (data) {
    var adapter = new $.jqx.dataAdapter(data);
    $("#origins").jqxDropDownList({
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
  url: '/getconditions',
  type: "GET",
  dataType: "json",
  success: function (data) {
    var adapter = new $.jqx.dataAdapter(data);
    $("#conditions").jqxDropDownList({
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
  url: '/getlocations',
  type: "GET",
  dataType: "json",
  success: function (data) {
    var adapter = new $.jqx.dataAdapter(data);
    $("#locations").jqxComboBox({
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
  url: '/getstyles',
  type: "GET",
  dataType: "json",
  success: function (data) {
    var adapter = new $.jqx.dataAdapter(data);
    $("#styles").jqxDropDownList({
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

$("#doixes").jqxComboBox({
  source: years,
  width: w,
  height: h,
  theme: 'material',
  promptText: "Đời xe",
});

$("#namsxs").jqxComboBox({
  source: years,
  width: w,
  height: h,
  theme: 'material',
  promptText: "Năm sản xuất",
});

$("#socuas").jqxComboBox({
  source: ['2', '3', '4', '5'],
  width: w,
  height: h,
  theme: 'material',
  promptText: "Số cửa",
  autoDropDownHeight: true,
});

$("#sochongois").jqxComboBox({
  source: ['2', '4', '5', '7', '9', '12', '16', '24', '29', '45', 'Khác'],
  width: w,
  height: h,
  theme: 'material',
  promptText: "Số chổ ngồi",
});

jQuery.ajax({
  url: '/gettransmissions',
  type: "GET",
  dataType: "json",
  success: function (data) {
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
  url: '/getfuels',
  type: "GET",
  dataType: "json",
  success: function (data) {
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

$("#kichthuoc").jqxInput({ placeHolder: "Kích thước", height: h, width: w, minLength: 1, theme: 'material' });
$("#cannang").jqxInput({ placeHolder: "Cân nặng", height: h, width: w, minLength: 1, theme: 'material' });
$("#dungtich").jqxInput({ placeHolder: "Dung tích", height: h, width: w, minLength: 1, theme: 'material' });
$("#phanh").jqxInput({ placeHolder: "Phanh", height: h, width: w, minLength: 1, theme: 'material' });
$("#giamxoc").jqxInput({ placeHolder: "Giảm xóc", height: h, width: w, minLength: 1, theme: 'material' });
$("#lopxe").jqxInput({ placeHolder: "Lốp xe", height: h, width: w, minLength: 1, theme: 'material' });

$("#gia").jqxInput({ placeHolder: "(*) Giá tiền", height: h, width: w, minLength: 1, theme: 'material' });

jQuery.ajax({
  url: '/getbrands',
  type: "GET",
  dataType: "json",
  success: function (data) {
    brandsSource = data;
    brandsAdapter = new $.jqx.dataAdapter(brandsSource);
    $("#brands").jqxComboBox({
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
        var img = '<img src="' + datarecord.logo_path + '" />';
        var table = '<table style="min-width: 150px;"><tr><td style="width: 55px;">' + img + '</td><td>' + datarecord.ten + '</td></tr></table>';
        return table;
      }
    });
  }
});

jQuery.ajax({
  url: '/gettypes',
  type: "GET",
  dataType: "json",
  success: function (data) {
    typesSource = data;
    typesAdapter = new $.jqx.dataAdapter(typesSource);

    $("#types").jqxComboBox({
      searchMode: 'containsignorecase',
      width: w,
      height: h,
      theme: 'material',
      disabled: true,
      promptText: "(*) Dòng xe",
      displayMember: 'ten',
      valueMember: 'id',
      autoDropDownHeight: false,
    });
  }
});

$("#brands").bind('select', function (event) {
  if (event.args) {
    $("#types").jqxComboBox({ disabled: false, selectedIndex: -1 });
    var value = event.args.item.value;
    typesSource.data = { id: value };
    typesAdapter = new $.jqx.dataAdapter(typesSource, {
      beforeLoadComplete: function (records) {
        var filteredRecords = new Array();
        for (var i = 0; i < records.length; i++) {
          if (records[i].brands_id == value) filteredRecords.push(records[i]);
        }
        return filteredRecords;
      }
    });
    $("#types").jqxComboBox({ source: typesAdapter });
  }
});

jQuery.ajax({
  url: '/getcolors',
  type: "GET",
  dataType: "json",
  success: function (data) {
    var adapter = new $.jqx.dataAdapter(data);
    $("#colors").jqxDropDownList({
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
    $("#furnitures").jqxDropDownList({
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


var today = new Date();

today.setDate(today.getDate() - 1);

$("#start").jqxDateTimeInput({ 
  width: w, 
  height: h,
  theme: 'material',
  min: today,
});

$('#start').on('change', function (event) {
  var date = new Date(event.args.date);
  var end = $('#end').jqxDateTimeInput('getDate');
  if(date >= end){
    date.setDate(date.getDate() + 1);
    $('#end').jqxDateTimeInput('setDate', date);
  }
  setCost();
});

today.setDate(today.getDate() + 1);
var tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);

$("#end").jqxDateTimeInput({ 
  width: w, 
  height: h,
  theme: 'material',
  min: today,
  value: tomorrow,
});

$('#end').on('change', function (event) {
  var date = new Date(event.args.date);
  var start = $('#start').jqxDateTimeInput('getDate');
  if(date <= start){
    date.setDate(date.getDate() - 1);
    $('#start').jqxDateTimeInput('setDate', date);
  }
  setCost();
});

function setCost(){
  var start = $('#start').jqxDateTimeInput('getDate');
  var end = $('#end').jqxDateTimeInput('getDate');
  var days = Math.floor((end - start) / (1000*60*60*24));
  $('#days').text(days);
  $('#total').text(numberWithCommas(days * 1000));
}

function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

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

$('#form-create').jqxValidator({
  onSuccess: function () {
    $('#form-create').submit();
  }
});

//
function imagePreview(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#demoimage').remove();
      $('#image').after('<img class="image" id="demoimage" src="' + e.target.result + '" width="100%"/>');
    }
    reader.readAsDataURL(input.files[0]);
  }
}
document.getElementById('get_img').onclick = function () { document.getElementById('hinhanh').click(); };
$("#hinhanh").change(function () { imagePreview(this); });
