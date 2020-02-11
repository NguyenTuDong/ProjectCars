const state = {
  users: {},
  user: {},
};

const getters = {
  users(state) {
    return state.users.data;
  },
  user(state) {
    return state.user;
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
};

const actions = {
  retrieveUsers({commit}, page) {
    $.ajax({
      url : '/admin/api/user?page='+page,
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
};

export default {
  namespace: true,
  state,
  getters,
  mutations,
  actions
}