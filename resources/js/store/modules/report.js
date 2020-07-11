import router from '../../router'

const state = {
    revenue: {
        chartData: [],
        records: []
    }
};

const getters = {
    revenueChart(state) {
        return state.revenue.chartData;
    },
    revenueRecords(state) {
        return state.revenue.records;
    }
};

const mutations = {
  revenueReport(state, data) {
      state.revenue = data;
  }
};

const actions = {
  getRevenueReport({commit}, data) {
    $.ajax({
      url : '/admin/api/report/revenue?start='+data.start+'&end='+data.end,
      type : "GET",
      dataType : "json",
      success:function(data)
      {
        commit("revenueReport", data);
        console.log(data);
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