import router from '../../router'

const state = {
  costReport: [],
};

const getters = {
  costReport(state) {
      return state.costReport;
  }
};

const mutations = {
  costReport(state, data) {
      state.costReport = data;
  }
};

const actions = {
  getCostReport({commit}, data) {
    $.ajax({
      url : '/admin/api/report/cost?date='+data,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit("costReport", data);
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