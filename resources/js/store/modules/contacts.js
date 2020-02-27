const state = {
  contacts: {},
  contactCount: 'Đang tải...',
  contactPerMonth: [],
};

const getters = {
  contacts(state) {
    return state.contacts.data;
  },
  contactCount(state) {
    return state.contactCount;
  },
  contactPerMonth(state) {
    return state.contactPerMonth;
  },
  contactsPagination(state) {
    return state.contacts;
  },
};

const mutations = {
  retrieveContacts(state, data) {
    state.contacts = data;
  },
  contactCount(state, data) {
    state.contactCount = data;
  },
  contactPerMonth(state, data) {
    state.contactPerMonth = data;
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
        commit('retrieveContacts', {});
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
  contactCount({commit}) {
    $.ajax({
      url : '/admin/api/contact/count',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('contactCount', data);
      },
      error: function (errors) {
        console.log(errors);
      }
    });
  },
  contactPerMonth({commit}) {
    $.ajax({
      url : '/admin/api/contact/countPerMonth',
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit('contactPerMonth', data);
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