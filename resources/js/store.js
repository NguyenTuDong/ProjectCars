import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    routes: [],
    brands: [],
    createBrandSuccess: false,
  },
  getters: {
    route(state) {
      return name => {
        return state.routes.filter(item => {
          return item.action.as == name;
        })[0].uri;
      };
    },
  },
  mutations: {
    setRoutes(state, routes) {
      state.routes = routes;
    },
    retrieveBrands(state, data) {
      state.brands = data;
    },
    changeCreateBrandState(state, data) {
      state.createBrandSuccess = data;
    },
    createBrand(state, data) {
      state.brands.push(data);
      state.createBrandSuccess = true;
    },
    updateBrand(state, data) {
      state.brands.forEach((element, index) => {
        if(element.id === data.id) {
            state.brands[index] = data;
        }
      });
    }
  },
  actions: {
    setRoutes(context, routes) {
      context.commit('setRoutes', routes);
    },
    retrieveBrands(context) {
      $.ajax({
        url : '/brand',
        type : "GET",
        dataType : "json",
        success:function(data)
        {
          context.commit('retrieveBrands', data);
        }
      });
    },
    changeCreateBrandState(context, data) {
      context.commit('changeCreateBrandState', data);
    },
    createBrand(context, formData) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/brand',
        type : "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          console.log(data);
          context.commit('createBrand', data);
        },
        error: function (data) {
          console.log(data);
        }
      })
    },
    updateBrand(context, data) {
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': context.state.csrf,
        },
        url : '/brand/'+data.id,
        type : "POST",
        data: data.formData,
        processData: false,
        contentType: false,
        success:function(data)
        {
          console.log(data);
          context.commit('updateBrand', data);
        },
        error: function (data) {
          console.log(data);
        }
      })
    }
  }
})