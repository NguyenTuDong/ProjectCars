import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard'
import Brand from './components/brand/Brand'
import Type from './components/type/Type'

Vue.use(VueRouter);

const routes = [
  { 
    path: '/', 
    component: Dashboard,
    meta: {
      title: 'Admin | Dashboard'
    }
  },
  { 
    path: '/brand', 
    component: Brand,
    meta: {
      title: 'Admin | Thương hiệu'
    }
  },
  { 
    path: '/type', 
    component: Type,
    meta: {
      title: 'Admin | Dòng xe'
    }
  },
]

export const router = new VueRouter({
  routes,
  linkExactActiveClass: 'active',
});