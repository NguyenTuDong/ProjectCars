const state = {
  styles: {},
};

const getters = {
  styles(state) {
    return state.styles.data;
  },
  stylesPagination(state) {
    return state.styles;
  },
};

const mutations = {
  retrieveStyles(state, data) {
    state.styles = data;
  },
  createStyle(state, data) {
    data.count = 0;
    state.styles.data.push(data);
  },
  updateStyle(state, data) {
    state.styles.data.forEach((element, index) => {
      if(element.id === data.id) {
          state.styles.data[index].ten = data.ten;
          state.styles.data[index].hinhanh = data.hinhanh;
          state.styles.data[index].hinhanh_path = data.hinhanh_path;
      }
    });
    var temp = state.styles.data;
    state.styles.data = [];
    state.styles.data = temp;
  },
  deleteStyle(state, data) {
    var index = state.styles.data.findIndex((obj) => {
      return obj.id == data.id;
    });
    state.styles.data.splice(index, 1);
  },
};

const actions = {
  retrieveStyles({commit}, data) {
    $.ajax({
      url : '/admin/api/style?page='+data.page+'&q='+data.q,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveStyles', data);
      },
      error: function (errors) {
        console.log(errors);
        commit('retrieveStyles', {});
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
  createStyle({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/style',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createStyle', data);
        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Thêm kiểu dáng thành công."

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
          message: "Thêm kiểu dáng thất bại!"

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
  updateStyle({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/style/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateStyle', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Cập nhật kiểu dáng <b>#"+data.id+"</b> thành công."

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
          message: "Cập nhật kiểu dáng <b>#"+data.id+"</b> thất bại."

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
  deleteStyle({commit, rootGetters}, id) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/style/delete/'+id,
      type : "POST",
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('deleteStyle', data);

        $.notify({
          icon: "now-ui-icons ui-1_bell-53",
          message: "Xóa kiểu dáng <b>#"+data.id+"</b> thành công."

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
          message: "Xóa kiểu dáng <b>#"+data.id+"</b> thất bại."
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