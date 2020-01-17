import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard'
import Brand from './components/brand/Brand'

Vue.use(VueRouter);

const routes = [
  { 
    path: '/', 
    component: Dashboard,
    meta: {
      title: 'Admin - Dashboard'
    }
  },
  { 
    path: '/brand', 
    component: Brand,
    meta: {
      title: 'Admin - Brand'
    }
  },
]

export const router = new VueRouter({
  routes,
  linkExactActiveClass: 'active',
});