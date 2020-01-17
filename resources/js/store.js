import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    routes: [],
    brands: [],
  },
  getters: {
    route(state) {
      return name => {
        return state.routes.filter(item => {
          return item.action.as == name;
        })[0].uri;
      };
    },
    getBrands(state) {
      return state.brands;
    }
  },
  mutations: {
    setRoutes(state, routes) {
      state.routes = routes;
    },
    retrieveBrands(state, data) {
      state.brands = data;
    }
  },
  actions: {
    setRoutes(context, routes) {
      context.commit('setRoutes', routes);
    },
    retrieveBrands(context) {
      $.ajax({
        url : '/getbrands',
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveBrands', data);
        }
      });
    },
    updateBrand(context) {
      
    }
  }
})