import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './components/dashboard/Dashboard'
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
import CarDetail from './components/car/CarDetail'
import User from './components/user/User'
import UserDetail from './components/user/UserDetail'
import Contact from './components/contact/Contact'
import Role from './components/role/Role'
import Employee from './components/employee/Employee'
import EmployeeDetail from './components/employee/EmployeeDetail'
import EmployeeEdit from './components/employee/EmployeeEdit'

import {store} from './store/store';

Vue.use(VueRouter);

const routes = [
  { 
    path: '/admin/', 
    name: 'dashboard',
    component: Dashboard,
    meta: {
      title: 'Admin | Dashboard',
    }
  },
  { 
    path: '/admin/brand', 
    name: 'brand',
    component: Brand,
    meta: {
      title: 'Admin | Thương hiệu',
      requiredPermissions: ['quan-ly-danh-muc'],
    }
  },
  { 
    path: '/admin/type', 
    name: 'type',
    component: Type,
    meta: {
      title: 'Admin | Dòng xe',
      requiredPermissions: ['quan-ly-danh-muc'],
    }
  },
  { 
    path: '/admin/color', 
    name: 'color',
    component: Color,
    meta: {
      title: 'Admin | Màu xe',
      requiredPermissions: ['quan-ly-danh-muc'],
    }
  },
  { 
    path: '/admin/condition', 
    name: 'condition',
    component: Condition,
    meta: {
      title: 'Admin | Tình trạng',
      requiredPermissions: ['quan-ly-danh-muc'],
    }
  },
  { 
    path: '/admin/origin', 
    name: 'origin',
    component: Origin,
    meta: {
      title: 'Admin | Nguồn gốc',
      requiredPermissions: ['quan-ly-danh-muc'],
    }
  },
  { 
    path: '/admin/fuel', 
    name: 'fuel',
    component: Fuel,
    meta: {
      title: 'Admin | Nhiên liệu',
      requiredPermissions: ['quan-ly-danh-muc'],
    }
  },
  { 
    path: '/admin/transmission', 
    name: 'transmission',
    component: Transmission,
    meta: {
      title: 'Admin | Hộp số',
      requiredPermissions: ['quan-ly-danh-muc'],
    }
  },
  { 
    path: '/admin/style', 
    name: 'style',
    component: Style,
    meta: {
      title: 'Admin | Kiểu dáng',
      requiredPermissions: ['quan-ly-danh-muc'],
    }
  },
  { 
    path: '/admin/convenient', 
    name: 'convenient',
    component: Convenient,
    meta: {
      title: 'Admin | Tiện nghi',
      requiredPermissions: ['quan-ly-danh-muc'],
    }
  },
  { 
    path: '/admin/car', 
    name: 'car',
    component: Car,
    meta: {
      title: 'Admin | Mẫu tin',
      requiredPermissions: ['xem-tin', 'duyet-tin', 'xoa-tin'],
    }
  },
  {
    path: '/admin/car/:id',
    name: 'car-detail',
    component: CarDetail,
    meta: {
      title: 'Admin | Chi tiết mâu tin',
      requiredPermissions: ['xem-tin', 'duyet-tin', 'xoa-tin'],
    }
  },
  { 
    path: '/admin/user', 
    name: 'user',
    component: User,
    meta: {
      title: 'Admin | Người dùng',
      requiredPermissions: ['xem-khach-hang'],
    }
  },
  {
    path: '/admin/user/:id',
    name: 'user-detail',
    component: UserDetail,
    meta: {
      title: 'Admin | Chi tiết người dùng',
      requiredPermissions: ['xem-khach-hang'],
    }
  },
  { 
    path: '/admin/contact', 
    name: 'contact',
    component: Contact,
    meta: {
      title: 'Admin | Liên hệ',
      requiredPermissions: ['xem-lien-he'],
    }
  },
  { 
    path: '/admin/role', 
    name: 'role',
    component: Role,
    meta: {
      title: 'Admin | Chức vụ',
      requiredPermissions: ['quan-ly-chuc-vu'],
    }
  },
  { 
    path: '/admin/employee', 
    name: 'employee',
    component: Employee,
    meta: {
      title: 'Admin | Nhân viên',
      requiredPermissions: ['xem-nhan-vien'],
    }
  },
  {
    path: '/admin/employee/edit',
    name: 'employee-edit',
    component: EmployeeEdit,
    meta: {
      title: 'Admin | Chỉnh sửa thông tin',
    }
  },
  {
    path: '/admin/employee/:id',
    name: 'employee-detail',
    component: EmployeeDetail,
    meta: {
      title: 'Admin | Chi tiết nhân viên',
      requiredPermissions: ['xem-nhan-vien'],
    }
  },
]

const router = new VueRouter({
  mode: 'history',
  routes,
  linkExactActiveClass: 'active',
});

router.beforeEach((to, from, next) => {
  var auth = window.__user__;
  store.dispatch('auth');
  if(store.getters.auth.permissions && store.getters.auth.roles) {
    auth = store.getters.auth;
  }
  if(to.meta.requiredPermissions){
    var check = false;
    if(to.meta.requiredPermissions.includes('xem-nhan-vien')){
      if(to.params.id == auth.id) check = true;
    }
    auth.permissions.forEach(element => {
      if (to.meta.requiredPermissions.includes(element.slug)) check = true;
    });
    auth.roles.forEach(element => {
      element.permissions.forEach(ele => {
        if (to.meta.requiredPermissions.includes(ele.slug)) check = true;
      })
    });
    if (check) {
      next()
    } else {
      alert('Bạn không có quyền truy cập trang web này!');
      window.history.back();
    }
  } else {
    next();
  }
})

export default router