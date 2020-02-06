const state = {
  colors: {},
};

const getters = {
  colors(state) {
    return state.colors.data;
  },
  colorsPagination(state) {
    return state.colors;
  },
};

const mutations = {
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
    var temp = state.colors.data;
    state.colors.data = [];
    state.colors.data = temp;
  },
  deleteColor(state, data) {
    var index = state.colors.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.colors.data.splice(index, 1);
  },
};

const actions = {
  retrieveColors({commit}, page) {
    $.ajax({
      url : '/admin/api/color?page='+page,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveColors', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createColor({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/color',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createColor', data);
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
  updateColor({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/color/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateColor', data);

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
  deleteColor({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/color/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteColor', data);

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
};

export default {
  namespace: true,
  state,
  getters,
  mutations,
  actions
}