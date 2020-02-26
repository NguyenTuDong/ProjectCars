const state = {
  types: {},
};

const getters = {
  types(state) {
    return state.types.data;
  },
  typesPagination(state) {
    return state.types;
  },
};

const mutations = {
  retrieveTypes(state, data) {
    state.types = data;
  },
  createType(state, data) {
    data.count = 0;
    state.types.data.push(data);
  },
  updateType(state, data) {
    state.types.data.forEach((element, index) => {
      if(element.id === data.id) {
          state.types.data[index].ten = data.ten;
      }
    });
    var temp = state.types.data;
    state.types.data = [];
    state.types.data = temp;
  },
  deleteType(state, data) {
    var index = state.types.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.types.data.splice(index, 1);
  },
};

const actions = {
  retrieveTypes({commit}, data) {
    $.ajax({
      url : '/admin/api/type/?page='+data.page+'&brands_id='+data.brands_id+'&q='+data.q,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveTypes', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createType({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/type',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createType', data);
        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Thêm dòng xe thành công."

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
          message: "Thêm dòng xe thất bại!"

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
  updateType({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/type/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateType', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Cập nhật dòng xe <b>#"+data.id+"</b> thành công."

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
          message: "Cập nhật dòng xe <b>#"+data.id+"</b> thất bại."

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
  deleteType({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/type/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteType', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Xóa dòng xe <b>#"+data.id+"</b> thành công."

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
          message: "Xóa dòng xe <b>#"+data.id+"</b> thất bại."
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