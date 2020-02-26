const state = {
  origins: {},
};

const getters = {
  origins(state) {
    return state.origins.data;
  },
  originsPagination(state) {
    return state.origins;
  },
};

const mutations = {
  retrieveOrigins(state, data) {
    state.origins = data;
  },
  createOrigin(state, data) {
    data.count = 0;
    state.origins.data.push(data);
  },
  updateOrigin(state, data) {
    state.origins.data.forEach((element, index) => {
      if(element.id === data.id) {
          state.origins.data[index].ten = data.ten;
      }
    });
    var temp = state.origins.data;
    state.origins.data = [];
    state.origins.data = temp;
  },
  deleteOrigin(state, data) {
    var index = state.origins.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.origins.data.splice(index, 1);
  },
};

const actions = {
  retrieveOrigins({commit}, data) {
    $.ajax({
      url : '/admin/api/origin?page='+data.page+'&q='+data.q,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveOrigins', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createOrigin({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/origin',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createOrigin', data);
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
  updateOrigin({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/origin/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateOrigin', data);

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
  deleteOrigin({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/origin/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteOrigin', data);

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
};

export default {
  namespace: true,
  state,
  getters,
  mutations,
  actions
}