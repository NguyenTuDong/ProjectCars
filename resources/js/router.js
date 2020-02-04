import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard'
import Brand from './components/brand/Brand'
import Type from './components/type/Type'
import Color from './components/color/Color'
import Condition from './components/condition/Condition'
import Origin from './components/origin/Origin'
import Fuel from './components/fuel/Fuel'
import Transmission from './components/transmission/Transmission'
import Style from './components/style/Style'
import Convenient from './components/convenient/Convenient'
import Car from './components/car/Car'

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
  { 
    path: '/admin/origin', 
    name: 'origin',
    component: Origin,
    meta: {
      title: 'Admin | Nguồn gốc'
    }
  },
  { 
    path: '/admin/fuel', 
    name: 'fuel',
    component: Fuel,
    meta: {
      title: 'Admin | Nhiên liệu'
    }
  },
  { 
    path: '/admin/transmission', 
    name: 'transmission',
    component: Transmission,
    meta: {
      title: 'Admin | Hộp số'
    }
  },
  { 
    path: '/admin/style', 
    name: 'style',
    component: Style,
    meta: {
      title: 'Admin | Kiểu dáng'
    }
  },
  { 
    path: '/admin/convenient', 
    name: 'convenient',
    component: Convenient,
    meta: {
      title: 'Admin | Tiện nghi'
    }
  },
  { 
    path: '/admin/car', 
    name: 'car',
    component: Car,
    meta: {
      title: 'Admin | Mẫu tin'
    }
  },
]

export const router = new VueRouter({
  mode: 'history',
  routes,
  linkExactActiveClass: 'active',
});