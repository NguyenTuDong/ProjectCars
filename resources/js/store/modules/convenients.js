const state = {
  convenients: {},
};

const getters = {
  convenients(state) {
    return state.convenients.data;
  },
  convenientsPagination(state) {
    return state.convenients;
  },
};

const mutations = {
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
    var temp = state.convenients.data;
    state.convenients.data = [];
    state.convenients.data = temp;
  },
  deleteConvenient(state, data) {
    var index = state.convenients.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.convenients.data.splice(index, 1);
  },
};

const actions = {
  retrieveConvenients({commit}, page) {
    $.ajax({
      url : '/admin/api/convenient?page='+page,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveConvenients', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createConvenient({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/convenient',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createConvenient', data);
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
  updateConvenient({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/convenient/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateConvenient', data);

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
  deleteConvenient({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/convenient/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteConvenient', data);

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