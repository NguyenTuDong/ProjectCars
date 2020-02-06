const state = {
  conditions: {},
};

const getters = {
  conditions(state) {
    return state.conditions.data;
  },
  conditionsPagination(state) {
    return state.conditions;
  },
};

const mutations = {
  retrieveConditions(state, data) {
    state.conditions = data;
  },
  createCondition(state, data) {
    state.conditions.data.push(data);
  },
  updateCondition(state, data) {
    state.conditions.data.forEach((element, index) => {
      if(element.id === data.id) {
          state.conditions.data[index] = data;
      }
    });
    var temp = state.conditions.data;
    state.conditions.data = [];
    state.conditions.data = temp;
  },
  deleteCondition(state, data) {
    var index = state.conditions.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.conditions.data.splice(index, 1);
  },
};

const actions = {
  retrieveConditions({commit}, page) {
    $.ajax({
      url : '/admin/api/condition?page='+page,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveConditions', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createCondition({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/condition',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createCondition', data);
        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Thêm tình trạng thành công."

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
          message: "Thêm tình trạng thất bại!"

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
  updateCondition({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/condition/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateCondition', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Cập nhật tình trạng <b>#"+data.id+"</b> thành công."

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
          message: "Cập nhật tình trạng <b>#"+data.id+"</b> thất bại."

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
  deleteCondition({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/condition/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteCondition', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Xóa tình trạng <b>#"+data.id+"</b> thành công."

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
          message: "Xóa tình trạng <b>#"+data.id+"</b> thất bại."
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