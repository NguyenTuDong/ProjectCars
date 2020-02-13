import {router} from '../../router'

const state = {
  cars: {},
  car: {},
  carCount: 'Đang tải...',
  carPerMonth: [],
  carActivePerMonth: [],
};

const getters = {
  cars(state) {
    return state.cars.data;
  },
  car(state) {
    return state.car;
  },
  carCount(state) {
    return state.carCount;
  },
  carPerMonth(state) {
    return state.carPerMonth;
  },
  carActivePerMonth(state) {
    return state.carActivePerMonth;
  },
  carsPagination(state) {
    return state.cars;
  },
};

const mutations = {
  retrieveCars(state, data) {
    state.cars = data;
  },
  getCar(state, data) {
    state.car = data;
  },
  carCount(state, data) {
    state.carCount = data;
  },
  carPerMonth(state, data) {
    state.carPerMonth = data;
  },
  carActivePerMonth(state, data) {
    state.carActivePerMonth = data;
  },
  updateCar(state, data) {
    if(!$.isEmptyObject(state.cars)){
      state.cars.data.forEach((element, index) => {
        if(element.id === data.id) {
            state.cars.data[index] = data;
        }
      });
      var temp = state.cars.data;
      state.cars.data = [];
      state.cars.data = temp;
    }
    if(!$.isEmptyObject(state.car)){
      state.car = data;
    }
  },
  deleteCar(state, data) {
    if(!$.isEmptyObject(state.cars)){
      var index = state.cars.data.findIndex((obj) => {
        return obj.id == data.id;
      });
      state.cars.data.splice(index, 1);
    }
    if(!$.isEmptyObject(state.car)){
      router.go(-1);
    }
    
  },
};

const actions = {
  retrieveCars({commit}, data) {
    $.ajax({
      url : '/admin/api/car?page='+data.page+'&q='+data.q,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveCars', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  getCar({commit}, id) {
    $.ajax({
      url : '/admin/api/car/'+id,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        // console.log(data);
        commit('getCar', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  carCount({commit}) {
    $.ajax({
      url : '/admin/api/car/count',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('carCount', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  carPerMonth({commit}) {
    $.ajax({
      url : '/admin/api/car/countPerMonth',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('carPerMonth', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  carActivePerMonth({commit}) {
    $.ajax({
      url : '/admin/api/car/countActivePerMonth',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        console.log(data);
        commit('carActivePerMonth', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  approveCar({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/car/approve/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateCar', data);

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
        console.log(errors);
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
  denyCar({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/car/deny/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateCar', data);

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
        console.log(errors);
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
  deleteCar({state, commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/car/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteCar', data);

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
};

export default {
  namespace: true,
  state,
  getters,
  mutations,
  actions
}