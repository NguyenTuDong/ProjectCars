const state = {
  allBrands: [],
  brands: {},
};

const getters = {
  allBrands(state) {
    return state.allBrands;
  },
  brands(state) {
    return state.brands.data;
  },
  brandsPagination(state) {
    return state.brands;
  },
};

const mutations = {
  allBrands(state, data) {
    state.allBrands = data;
  },
  retrieveBrands(state, data) {
    state.brands = data;
  },
  createBrand(state, data) {
    state.brands.data.push(data);
  },
  updateBrand(state, data) {
    state.brands.data.forEach((element, index) => {
      if(element.id === data.id) {
          state.brands.data[index] = data;
      }
    });
    var temp = state.brands.data;
    state.brands.data = [];
    state.brands.data = temp;
  },
  deleteBrand(state, data) {
    var index = state.brands.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.brands.data.splice(index, 1);
  },
};

const actions = {
  allBrands({commit}) {
    $.ajax({
      url : '/getbrands',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('allBrands', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  retrieveBrands({commit}, page) {
    $.ajax({
      url : '/admin/api/brand?page='+page,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveBrands', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createBrand({commit, rootGetters}, formData) {
    console.log(rootGetters.csrf);
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/brand',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createBrand', data);
        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Thêm thương hiệu thành công."

        }, {
          type: 'success',
          timer: 3000,
          placement: {
          from: 'top',
          align: 'right'
          }
        });
      },
      error: function (errors) {
        console.log(errors);
        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Thêm thương hiệu thất bại!"

        }, {
          type: 'danger',
          timer: 3000,
          placement: {
          from: 'top',
          align: 'right'
          }
        });
      }
    })
  },
  updateBrand({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/brand/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateBrand', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Cập nhật thương hiệu <b>#"+data.id+"</b> thành công."

        }, {
          type: 'success',
          timer: 3000,
          placement: {
          from: 'top',
          align: 'right'
          }
        });
      },
      error: function (errors) {
        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Cập nhật thương hiệu <b>#"+data.id+"</b> thất bại."

        }, {
          type: 'danger',
          timer: 3000,
          placement: {
          from: 'top',
          align: 'right'
          }
        });
      }
    })
  },
  deleteBrand({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/brand/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteBrand', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Xóa thương hiệu <b>#"+data.id+"</b> thành công."

        }, {
          type: 'success',
          timer: 3000,
          placement: {
          from: 'top',
          align: 'right'
          }
        });
      },
      error: function (errors) {
        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Xóa thương hiệu <b>#"+data.id+"</b> thất bại."
        }, {
          type: 'danger',
          timer: 3000,
          placement: {
          from: 'top',
          align: 'right'
          }
        });
      }
    })
  },
};

export default {
  namespace: true,
  state,
  getters,
  mutations,
  actions
}