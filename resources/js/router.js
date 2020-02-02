import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard'
import Brand from './components/brand/Brand'
import Type from './components/type/Type'
import Color from './components/color/Color'
import Condition from './components/condition/Condition'

Vue.use(VueRouter);

const routes = [
  { 
    path: '/admin/', 
    name: 'dashboard',
    component: Dashboard,
    meta: {
      title: 'Admin | Dashboard'
    }
  },
  { 
    path: '/admin/brand', 
    name: 'brand',
    component: Brand,
    meta: {
      title: 'Admin | Thương hiệu'
    }
  },
  { 
    path: '/admin/type', 
    name: 'type',
    component: Type,
    meta: {
      title: 'Admin | Dòng xe'
    }
  },
  { 
    path: '/admin/color', 
    name: 'color',
    component: Color,
    meta: {
      title: 'Admin | Màu xe'
    }
  },
  { 
    path: '/admin/condition', 
    name: 'condition',
    component: Condition,
    meta: {
      title: 'Admin | Tình trạng'
    }
  },
]

export const router = new VueRouter({
  mode: 'history',
  routes,
  linkExactActiveClass: 'active',
});