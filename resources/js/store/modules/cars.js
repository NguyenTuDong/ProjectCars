const state = {
  cars: {},
  car: {},
};

const getters = {
  cars(state) {
    return state.cars.data;
  },
  car(state) {
    return state.car;
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
  updateCar(state, data) {
    state.cars.data.forEach((element, index) => {
      if(element.id === data.id) {
          state.cars.data[index] = data;
      }
    });
    var temp = state.cars.data;
    state.cars.data = [];
    state.cars.data = temp;
  },
  deleteCar(state, data) {
    var index = state.cars.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.cars.data.splice(index, 1);
  },
};

const actions = {
  retrieveCars({commit}, page) {
    $.ajax({
      url : '/admin/api/car?page='+page,
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
        commit('getCar', data);
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
  deleteCar({commit, rootGetters}, id) {
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