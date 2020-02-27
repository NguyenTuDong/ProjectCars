const state = {
  employees: {},
  employee: {},
  employeeCount: 'Đang tải...',
  employeePerMonth: [],
};

const getters = {
  employees(state) {
    return state.employees.data;
  },
  employee(state) {
    return state.employee;
  },
  employeeCount(state) {
    return state.employeeCount;
  },
  employeePerMonth(state) {
    return state.employeePerMonth;
  },
  employeesPagination(state) {
    return state.employees;
  },
};

const mutations = {
  retrieveEmployees(state, data) {
    state.employees = data;
  },
  getEmployee(state, data) {
    state.employee = data;
  },
  createEmployee(state, data) {
    data.count = 0;
    state.employees.data.push(data);
  },
  updateEmployee(state, data) {
    state.employees.data.forEach((element, index) => {
      if(element.id === data.id) {
          state.employees.data[index].ten = data.ten;
      }
    });
    var temp = state.employees.data;
    state.employees.data = [];
    state.employees.data = temp;
  },
  employeeCount(state, data) {
    state.employeeCount = data;
  },
  employeePerMonth(state, data) {
    state.employeePerMonth = data;
  },
};

const actions = {
  retrieveEmployees({commit}, data) {
    $.ajax({
      url : '/admin/api/employee?page='+data.page+'&q='+data.q,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveEmployees', data);
      },
      error: function (errors) {
        console.log(errors);
        commit('retrieveEmployees', {});
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
  getEmployee({commit}, id) {
    $.ajax({
      url : '/admin/api/employee/'+id,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('getEmployee', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  createEmployee({commit, rootGetters}, formData) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/employee',
      type : "POST",
      data: formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('createEmployee', data);
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
  updateEmployee({commit, rootGetters}, data) {
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': rootGetters.csrf,
      },
      url : '/admin/api/employee/'+data.id,
      type : "POST",
      data: data.formData,
      processData: false,
      contentType: false,
      success:function(data)
      {
        commit('updateEmployee', data);

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
  employeeCount({commit}) {
    $.ajax({
      url : '/admin/api/employee/count',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('employeeCount', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  employeePerMonth({commit}) {
    $.ajax({
      url : '/admin/api/employee/countPerMonth',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('employeePerMonth', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
};

export default {
  namespace: true,
  state,
  getters,
  mutations,
  actions
}