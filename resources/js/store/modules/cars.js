import router from '../../router'

const state = {
  cars: {},
  car: {},
  carCount: 'Đang tải...',
  carCountApprove: 0,
  carCountCost: 'Đang tải...',
  carPerMonth: [],
  carApprovePerMonth: [],
  carCostPerMonth: [],
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
  carCountApprove(state) {
    return state.carCountApprove;
  },
  carCountCost(state) {
    return state.carCountCost;
  },
  carPerMonth(state) {
    return state.carPerMonth;
  },
  carApprovePerMonth(state) {
    return state.carApprovePerMonth;
  },
  carCostPerMonth(state) {
    return state.carCostPerMonth;
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
  carCountApprove(state, data) {
    state.carCountApprove = data;
  },
  carCountCost(state, data) {
    state.carCountCost = data;
  },
  carPerMonth(state, data) {
    state.carPerMonth = data;
  },
  carApprovePerMonth(state, data) {
    state.carApprovePerMonth = data;
  },
  carCostPerMonth(state, data) {
    state.carCostPerMonth = data;
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
      url : '/admin/api/car?page='+data.page+'&q='+data.q+'&orderBy='+data.orderBy+'&direction='+data.direction,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveCars', data);
      },
      error: function (errors) {
        console.log(errors);
        commit('retrieveCars', {});
        if(errors.responseJSON.message){
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: errors.responseJSON.message,
  
          }, {
            type: 'danger',
            timer: 3000,
            placement: {
            from: 'top',
            align: 'right'
            }
          });
        }
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
        commit('getCar', {});
        if(errors.responseJSON.message){
          $.notify({
            icon: "now-ui-icons ui-1_bell-53",
            message: errors.responseJSON.message,
  
          }, {
            type: 'danger',
            timer: 3000,
            placement: {
            from: 'top',
            align: 'right'
            }
          });
        }
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
  carCountApprove({commit}) {
    $.ajax({
      url : '/admin/api/car/countApprove',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('carCountApprove', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  carCountCost({commit}) {
    $.ajax({
      url : '/admin/api/car/countCost',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('carCountCost', data);
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
  carApprovePerMonth({commit}) {
    $.ajax({
      url : '/admin/api/car/countApprovePerMonth',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('carApprovePerMonth', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  carCostPerMonth({commit}) {
    $.ajax({
      url : '/admin/api/car/countCostPerMonth',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('carCostPerMonth', data);
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