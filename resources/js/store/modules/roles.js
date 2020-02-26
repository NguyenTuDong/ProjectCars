const state = {
  roles: {},
};

const getters = {
  roles(state) {
    return state.roles.data;
  },
  rolesPagination(state) {
    return state.roles;
  },
};

const mutations = {
  retrieveRoles(state, data) {
    state.roles = data;
  },
  createRole(state, data) {
    state.roles.data.push(data);
  },
  updateRole(state, data) {
    state.roles.data.forEach((element, index) => {
      if(element.id === data.id) {
          state.roles.data[index] = data;
      }
    });
    var temp = state.roles.data;
    state.roles.data = [];
    state.roles.data = temp;
  },
  deleteRole(state, data) {
    var index = state.roles.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.roles.data.splice(index, 1);
  },
};

const actions = {
  retrieveRoles({commit}, data) {
    $.ajax({
      url : '/admin/api/role?page='+data.page+'&q='+data.q,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveRoles', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createRole({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/role',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createRole', data);
        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Thêm chức vụ thành công."

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
          message: "Thêm chức vụ thất bại!"

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
  updateRole({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/role/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateRole', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Cập nhật chức vụ <b>#"+data.id+"</b> thành công."

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
          message: "Cập nhật chức vụ <b>#"+data.id+"</b> thất bại."

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
  deleteRole({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/role/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteRole', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Xóa chức vụ <b>#"+data.id+"</b> thành công."

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
          message: "Xóa chức vụ <b>#"+data.id+"</b> thất bại."
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