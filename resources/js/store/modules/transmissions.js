const state = {
  transmissions: {},
};

const getters = {
  transmissions(state) {
    return state.transmissions.data;
  },
  transmissionsPagination(state) {
    return state.transmissions;
  },
};

const mutations = {
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
    var temp = state.transmissions.data;
    state.transmissions.data = [];
    state.transmissions.data = temp;
  },
  deleteTransmission(state, data) {
    var index = state.transmissions.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.transmissions.data.splice(index, 1);
  },
};

const actions = {
  retrieveTransmissions({commit}, page) {
    $.ajax({
      url : '/admin/api/transmission?page='+page,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveTransmissions', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createTransmission({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/transmission',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createTransmission', data);
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
  updateTransmission({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/transmission/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateTransmission', data);

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
  deleteTransmission({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/transmission/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteTransmission', data);

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
};

export default {
  namespace: true,
  state,
  getters,
  mutations,
  actions
}