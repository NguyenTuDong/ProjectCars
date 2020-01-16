import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    routes: [],
  },
  getters: {
    
  },
  mutations: {
    setRoutes(state, routes) {
      state.routes = routes;
    },
  },
  actions: {
    setRoutes(context, routes) {
      context.commit('setRoutes', routes);
    },
  }
})