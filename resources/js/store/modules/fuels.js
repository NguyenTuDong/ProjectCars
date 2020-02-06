const state = {
  fuels: {},
};

const getters = {
  fuels(state) {
    return state.fuels.data;
  },
  fuelsPagination(state) {
    return state.fuels;
  },
};

const mutations = {
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
    var temp = state.fuels.data;
    state.fuels.data = [];
    state.fuels.data = temp;
  },
  deleteFuel(state, data) {
    var index = state.fuels.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.fuels.data.splice(index, 1);
  },
};

const actions = {
  retrieveFuels({commit}, page) {
    $.ajax({
      url : '/admin/api/fuel?page='+page,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveFuels', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createFuel({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/fuel',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createFuel', data);
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
  updateFuel({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/fuel/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateFuel', data);

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
  deleteFuel({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/fuel/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteFuel', data);

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
};

export default {
  namespace: true,
  state,
  getters,
  mutations,
  actions
}