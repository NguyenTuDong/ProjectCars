const state = {
  permissions: [],
};

const getters = {
  permissions(state) {
    return state.permissions;
  },
};

const mutations = {
  retrievePermissions(state, data) {
    state.permissions = data;
  },
  createPermission(state, data) {
    state.permissions.data.push(data);
  },
  updatePermission(state, data) {
    state.permissions.data.forEach((element, index) => {
      if(element.id === data.id) {
          state.permissions.data[index] = data;
      }
    });
    var temp = state.permissions.data;
    state.permissions.data = [];
    state.permissions.data = temp;
  },
  deletePermission(state, data) {
    var index = state.permissions.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.permissions.data.splice(index, 1);
  },
};

const actions = {
  retrievePermissions({commit}) {
    $.ajax({
      url : '/admin/api/permission',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrievePermissions', data);
      },
      error: function (errors) {
        console.log(errors);
        commit('retrievePermissions', {});
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
  createPermission({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/permission',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createPermission', data);
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
  updatePermission({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/permission/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updatePermission', data);

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
  deletePermission({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/permission/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deletePermission', data);

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