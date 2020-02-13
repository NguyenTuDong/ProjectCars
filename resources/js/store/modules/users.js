const state = {
  users: {},
  user: {},
  userCount: 'Đang tải...',
  userPerMonth: [],
};

const getters = {
  users(state) {
    return state.users.data;
  },
  user(state) {
    return state.user;
  },
  userCount(state) {
    return state.userCount;
  },
  userPerMonth(state) {
    return state.userPerMonth;
  },
  usersPagination(state) {
    return state.users;
  },
};

const mutations = {
  retrieveUsers(state, data) {
    state.users = data;
  },
  getUser(state, data) {
    state.user = data;
  },
  userCount(state, data) {
    state.userCount = data;
  },
  userPerMonth(state, data) {
    state.userPerMonth = data;
  },
};

const actions = {
  retrieveUsers({commit}, data) {
    $.ajax({
      url : '/admin/api/user?page='+data.page+'&q='+data.q,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveUsers', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  getUser({commit}, id) {
    $.ajax({
      url : '/admin/api/user/'+id,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('getUser', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  userCount({commit}) {
    $.ajax({
      url : '/admin/api/user/count',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('userCount', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  userPerMonth({commit}) {
    $.ajax({
      url : '/admin/api/user/countPerMonth',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('userPerMonth', data);
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