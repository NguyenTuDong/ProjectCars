const state = {
  contacts: {},
};

const getters = {
  contacts(state) {
    return state.contacts.data;
  },
  contactsPagination(state) {
    return state.contacts;
  },
};

const mutations = {
  retrieveContacts(state, data) {
    state.contacts = data;
  },
};

const actions = {
  retrieveContacts({commit}, data) {
    $.ajax({
      url : '/admin/api/contact?page='+data.page+'&q='+data.q,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('retrieveContacts', data);
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