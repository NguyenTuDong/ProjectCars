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
    colors: {},
    conditions: {},
    origins: {},
    fuels: {},
    transmissions: {},
    styles: {},
    convenients: {},
    cars: {},
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
    },
    colors(state) {
      return state.colors.data;
    },
    colorsPagination(state) {
      return state.colors;
    },
    conditions(state) {
      return state.conditions.data;
    },
    conditionsPagination(state) {
      return state.conditions;
    },
    origins(state) {
      return state.origins.data;
    },
    originsPagination(state) {
      return state.origins;
    },
    fuels(state) {
      return state.fuels.data;
    },
    fuelsPagination(state) {
      return state.fuels;
    },
    transmissions(state) {
      return state.transmissions.data;
    },
    transmissionsPagination(state) {
      return state.transmissions;
    },
    styles(state) {
      return state.styles.data;
    },
    stylesPagination(state) {
      return state.styles;
    },
    convenients(state) {
      return state.convenients.data;
    },
    convenientsPagination(state) {
      return state.convenients;
    },
    cars(state) {
      return state.cars.data;
    },
    carsPagination(state) {
      return state.cars;
    },
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
    deleteType(state, data) {
      var index = state.types.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.types.data.splice(index, 1);
    },
    //Color =======================================================
    retrieveColors(state, data) {
      state.colors = data;
    },
    createColor(state, data) {
      state.colors.data.push(data);
    },
    updateColor(state, data) {
      state.colors.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.colors.data[index] = data;
        }
      });
    },
    deleteColor(state, data) {
      var index = state.colors.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.colors.data.splice(index, 1);
    },
    //Condition =======================================================
    retrieveConditions(state, data) {
      state.conditions = data;
    },
    createCondition(state, data) {
      state.conditions.data.push(data);
    },
    updateCondition(state, data) {
      state.conditions.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.conditions.data[index] = data;
        }
      });
    },
    deleteCondition(state, data) {
      var index = state.conditions.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.conditions.data.splice(index, 1);
    },
    //Origin =======================================================
    retrieveOrigins(state, data) {
      state.origins = data;
    },
    createOrigin(state, data) {
      state.origins.data.push(data);
    },
    updateOrigin(state, data) {
      state.origins.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.origins.data[index] = data;
        }
      });
    },
    deleteOrigin(state, data) {
      var index = state.origins.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.origins.data.splice(index, 1);
    },
    //Fuel =======================================================
    retrieveFuels(state, data) {
      state.fuels = data;
    },
    createFuel(state, data) {
      state.fuels.data.push(data);
    },
    updateFuel(state, data) {
      state.fuels.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.fuels.data[index] = data;
        }
      });
    },
    deleteFuel(state, data) {
      var index = state.fuels.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.fuels.data.splice(index, 1);
    },
    //Transmission =======================================================
    retrieveTransmissions(state, data) {
      state.transmissions = data;
    },
    createTransmission(state, data) {
      state.transmissions.data.push(data);
    },
    updateTransmission(state, data) {
      state.transmissions.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.transmissions.data[index] = data;
        }
      });
    },
    deleteTransmission(state, data) {
      var index = state.transmissions.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.transmissions.data.splice(index, 1);
    },
    //Style =======================================================
    retrieveStyles(state, data) {
      state.styles = data;
    },
    createStyle(state, data) {
      state.styles.data.push(data);
    },
    updateStyle(state, data) {
      state.styles.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.styles.data[index] = data;
        }
      });
    },
    deleteStyle(state, data) {
      var index = state.styles.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.styles.data.splice(index, 1);
    },
    //Convenient =======================================================
    retrieveConvenients(state, data) {
      state.convenients = data;
    },
    createConvenient(state, data) {
      state.convenients.data.push(data);
    },
    updateConvenient(state, data) {
      state.convenients.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.convenients.data[index] = data;
        }
      });
    },
    deleteConvenient(state, data) {
      var index = state.convenients.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.convenients.data.splice(index, 1);
    },
    //Car =======================================================
    retrieveCars(state, data) {
      state.cars = data;
    },
    approveCar(state, data) {
      state.cars.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.cars.data[index] = data;
        }
      });
    },
    denyCar(state, data) {
      state.cars.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.cars.data[index] = data;
        }
      });
    },
    deleteCar(state, data) {
      var index = state.cars.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.cars.data.splice(index, 1);
    },
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
        url : '/admin/api/brand?page='+page,
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
        url : '/admin/api/brand',
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
        url : '/admin/api/brand/'+data.id,
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
        url : '/admin/api/brand/delete/'+id,
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
        url : '/admin/api/type/'+data.brands_id+'/?page='+data.page,
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
        url : '/admin/api/type',
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
        url : '/admin/api/type/'+data.id,
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
        url : '/admin/api/type/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteType', data);

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
    },
    //Color =======================================================
    retrieveColors(context, page) {
      $.ajax({
        url : '/admin/api/color?page='+page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveColors', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    createColor(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/color',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('createColor', data);
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Thêm màu xe thành công."

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
            message: "Thêm màu xe thất bại!"

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
    updateColor(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/color/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('updateColor', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Cập nhật màu xe <b>#"+data.id+"</b> thành công."

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
            message: "Cập nhật màu xe <b>#"+data.id+"</b> thất bại."

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
    deleteColor(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/color/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteColor', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Xóa màu xe <b>#"+data.id+"</b> thành công."

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
            message: "Xóa màu xe <b>#"+data.id+"</b> thất bại."
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
    //Condition =======================================================
    retrieveConditions(context, page) {
      $.ajax({
        url : '/admin/api/condition?page='+page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveConditions', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    createCondition(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/condition',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('createCondition', data);
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Thêm tình trạng thành công."

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
            message: "Thêm tình trạng thất bại!"

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
    updateCondition(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/condition/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('updateCondition', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Cập nhật tình trạng <b>#"+data.id+"</b> thành công."

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
            message: "Cập nhật tình trạng <b>#"+data.id+"</b> thất bại."

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
    deleteCondition(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/condition/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteCondition', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Xóa tình trạng <b>#"+data.id+"</b> thành công."

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
            message: "Xóa tình trạng <b>#"+data.id+"</b> thất bại."
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
    //Origin =======================================================
    retrieveOrigins(context, page) {
      $.ajax({
        url : '/admin/api/origin?page='+page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveOrigins', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    createOrigin(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/origin',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('createOrigin', data);
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Thêm nguồn gốc thành công."

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
            message: "Thêm nguồn gốc thất bại!"

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
    updateOrigin(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/origin/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('updateOrigin', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Cập nhật nguồn gốc <b>#"+data.id+"</b> thành công."

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
            message: "Cập nhật nguồn gốc <b>#"+data.id+"</b> thất bại."

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
    deleteOrigin(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/origin/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteOrigin', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Xóa nguồn gốc <b>#"+data.id+"</b> thành công."

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
            message: "Xóa nguồn gốc <b>#"+data.id+"</b> thất bại."
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
    //Fuel =======================================================
    retrieveFuels(context, page) {
      $.ajax({
        url : '/admin/api/fuel?page='+page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveFuels', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    createFuel(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/fuel',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('createFuel', data);
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Thêm nhiên liệu thành công."

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
            message: "Thêm nhiên liệu thất bại!"

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
    updateFuel(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/fuel/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('updateFuel', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Cập nhật nhiên liệu <b>#"+data.id+"</b> thành công."

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
            message: "Cập nhật nhiên liệu <b>#"+data.id+"</b> thất bại."

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
    deleteFuel(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/fuel/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteFuel', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Xóa nhiên liệu <b>#"+data.id+"</b> thành công."

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
            message: "Xóa nhiên liệu <b>#"+data.id+"</b> thất bại."
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
    //Transmission =======================================================
    retrieveTransmissions(context, page) {
      $.ajax({
        url : '/admin/api/transmission?page='+page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveTransmissions', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    createTransmission(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/transmission',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('createTransmission', data);
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Thêm hộp số thành công."

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
            message: "Thêm hộp số thất bại!"

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
    updateTransmission(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/transmission/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('updateTransmission', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Cập nhật hộp số <b>#"+data.id+"</b> thành công."

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
            message: "Cập nhật hộp số <b>#"+data.id+"</b> thất bại."

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
    deleteTransmission(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/transmission/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteTransmission', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Xóa hộp số <b>#"+data.id+"</b> thành công."

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
            message: "Xóa hộp số <b>#"+data.id+"</b> thất bại."
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
    //Style =======================================================
    retrieveStyles(context, page) {
      $.ajax({
        url : '/admin/api/style?page='+page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveStyles', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    createStyle(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/style',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('createStyle', data);
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Thêm kiểu dáng thành công."

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
            message: "Thêm kiểu dáng thất bại!"

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
    updateStyle(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/style/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('updateStyle', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Cập nhật kiểu dáng <b>#"+data.id+"</b> thành công."

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
            message: "Cập nhật kiểu dáng <b>#"+data.id+"</b> thất bại."

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
    deleteStyle(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/style/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteStyle', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Xóa kiểu dáng <b>#"+data.id+"</b> thành công."

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
            message: "Xóa kiểu dáng <b>#"+data.id+"</b> thất bại."
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
    //Convenient =======================================================
    retrieveConvenients(context, page) {
      $.ajax({
        url : '/admin/api/convenient?page='+page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveConvenients', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    createConvenient(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/convenient',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('createConvenient', data);
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Thêm tiện nghi thành công."

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
            message: "Thêm tiện nghi thất bại!"

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
    updateConvenient(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/convenient/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('updateConvenient', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Cập nhật tiện nghi <b>#"+data.id+"</b> thành công."

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
            message: "Cập nhật tiện nghi <b>#"+data.id+"</b> thất bại."

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
    deleteConvenient(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/convenient/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteConvenient', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Xóa tiện nghi <b>#"+data.id+"</b> thành công."

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
            message: "Xóa tiện nghi <b>#"+data.id+"</b> thất bại."
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
    //Car =======================================================
    retrieveCars(context, page) {
      $.ajax({
        url : '/admin/api/car?page='+page,
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveCars', data);
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    },
    approveCar(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/car/approve/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('approveCar', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Duyệt mẫu tin <b>#"+data.id+"</b> thành công."

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
            message: "Duyệt mẫu tin <b>#"+data.id+"</b> thất bại."

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
    denyCar(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/car/deny/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('denyCar', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Từ chối mẫu tin <b>#"+data.id+"</b> thành công."

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
            message: "Từ chối mẫu tin <b>#"+data.id+"</b> thất bại."

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
    deleteCar(context, id) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/admin/api/car/delete/'+id,
        type : "POST",
        processData: false,
        contentType: false,
        success:function(data)
        {
          context.commit('deleteCar', data);

          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: "Xóa tiện nghi <b>#"+data.id+"</b> thành công."

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
            message: "Xóa tiện nghi <b>#"+data.id+"</b> thất bại."
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
  }
})