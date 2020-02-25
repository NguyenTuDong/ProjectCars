import Vue from 'vue';
import Vuex from 'vuex';
import brands from './modules/brands';
import types from './modules/types';
import colors from './modules/colors';
import conditions from './modules/conditions';
import origins from './modules/origins';
import fuels from './modules/fuels';
import transmissions from './modules/transmissions';
import styles from './modules/styles';
import convenients from './modules/convenients';
import cars from './modules/cars';
import users from './modules/users';
import contacts from './modules/contacts';

Vue.use(Vuex);

export const store = new Vuex.Store({
  modules: {
    brands,
    types,
    colors,
    conditions,
    origins,
    fuels,
    transmissions,
    styles,
    convenients,
    cars,
    users,
    contacts,
  },
  state: {
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
  getters: {
    csrf(state){
      return state.csrf;
    }
  }
})