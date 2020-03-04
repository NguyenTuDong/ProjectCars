/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import {store} from './store/store';
import router from './router';


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('master', require('./components/layout/Master.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    data: {
        routes: window.__routes__,
    },
    created(){
      this.$store.dispatch('auth');
    },
    computed: {
      auth() {
        return this.$store.getters.auth;
      }
    },
    methods: {
      route(name) {
        return this.routes.filter(item => {
            return item.action.as == name;
        })[0].uri;
      },
      changeToSlug(text) {
        //Đổi chữ hoa thành chữ thường
        var slug = text.toLowerCase();
    
        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
        slug = slug.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
        slug = slug.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
        slug = slug.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
        slug = slug.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
        slug = slug.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
        slug = slug.replace(/(đ)/g, 'd');
    
        // Xóa ký tự đặc biệt
        slug = slug.replace(/([^0-9a-z-\s])/g, '');
    
        // Xóa khoảng trắng thay bằng ký tự -
        slug = slug.replace(/(\s+)/g, '-');
    
        // xóa phần dự - ở đầu
        slug = slug.replace(/^-+/g, '');
    
        // xóa phần dư - ở cuối
        slug = slug.replace(/-+$/g, '');
        //In slug ra textbox có id “slug”
        return slug;
      },
      userCan(slug) {
        var check = false;
        if(this.auth.permissions && this.auth.roles){
          this.auth.permissions.forEach(element => {
            if (element.slug == slug) check = true;
          });
          this.auth.roles.forEach(element => {
            element.permissions.forEach(ele => {
              if (ele.slug == slug) check = true;
            })
          });
        }
        return check;
      }
    },
    store,
    router,
});

