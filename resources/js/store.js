import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    routes: [],
    allBrands: [],
    brands: {},
    types: {},
  },
  getters: {
    route(state) {
      return name => {
        return state.routes.filter(item => {
          return item.action.as == name;
        })[0].uri;
      };
    },
    allBrands(state) {
      return state.allBrands;
    },
    brands(state) {
      return state.brands.data;
    },
    brandsPagination(state) {
      return state.brands;
    },
    types(state) {
      return state.types.data;
    },
    typesPagination(state) {
      return state.types;
    }
  },
  mutations: {
    setRoutes(state, routes) {
      state.routes = routes;
    },
    //Brand =======================================================
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
    },
    deleteBrand(state, data) {
      var index = state.brands.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.brands.data.splice(index, 1);
    },
    //Type =======================================================
    retrieveTypes(state, data) {
      state.types = data;
    },
    createType(state, data) {
      state.types.data.push(data);
    },
    updateType(state, data) {
      state.types.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.types.data[index] = data;
        }
      });
    },
    deleteBrand(state, data) {
      var index = state.types.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.types.data.splice(index, 1);
    }
  },
  actions: {
    setRoutes(context, routes) {
      context.commit('setRoutes', routes);
    },
    //Brand =======================================================
    allBrands(context) {
      $.ajax({
        url : '/getbrands',
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('allBrands', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    retrieveBrands(context, page) {
      $.ajax({
        url : '/brand?page='+page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveBrands', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    createBrand(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/brand',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('createBrand', data);
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
    updateBrand(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/brand/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('updateBrand', data);

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
    deleteBrand(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/brand/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteBrand', data);

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
    //Type =======================================================
    retrieveTypes(context, data) {
      $.ajax({
        url : '/type/'+data.brands_id+'/?page='+data.page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveTypes', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    createType(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/type',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('createType', data);
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Thêm dòng xe thành công."

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
            message: "Thêm dòng xe thất bại!"

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
    updateType(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/type/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('updateType', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Cập nhật dòng xe <b>#"+data.id+"</b> thành công."

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
            message: "Cập nhật dòng xe <b>#"+data.id+"</b> thất bại."

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
    deleteType(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/type/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteBrand', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Xóa dòng xe <b>#"+data.id+"</b> thành công."

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
            message: "Xóa dòng xe <b>#"+data.id+"</b> thất bại."
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
    }
  }
})