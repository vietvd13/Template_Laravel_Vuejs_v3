import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Layout from '../layout';
import ErrorPage from './modules/errorPage.js';

export const constantRoutes = [
  {
    path: '/redirect',
    component: Layout,
    redirect: { name: 'redirect' },
    hidden: true,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import(/* webpackChunkName: "Redirect" */ '../components/Redirect/index.vue'),
        name: 'redirect',
      },
    ],
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import(/* webpackChunkName: "Login" */ '../pages/Login/index.vue'),
    meta: {
      title: 'ROUTER_LOGIN',
    },
    hidden: true,
  },
  {
    path: '',
    redirect: { name: 'VehicleList' },
    hidden: true,
  },
  ErrorPage,
  {
    path: '*',
    redirect: { name: 'Page404' },
    hidden: true,
  },
  {
    path: '/vehicle',
    name: 'Vehicle',
    meta: {
      title: 'ROUTER_VEHICLE',
      breadcrumb: 'BREADCRUMB_VEHICLE',
    },
    component: Layout,
    redirect: { name: 'VehicleList' },
    children: [
      {
        path: 'list',
        name: 'VehicleList',
        meta: {
          title: 'ROUTER_VEHICLE_LIST',
          breadcrumb: 'BREADCRUMB_VEHICLE_LIST',
        },
        component: () => import(/* webpackChunkName: "VehicleList" */ '../pages/Vehicle/List.vue'),
      },
      {
        path: 'create',
        name: 'VehicleCreate',
        meta: {
          title: 'ROUTER_VEHICLE_CREATE',
          breadcrumb: 'BREADCRUMB_VEHICLE_CREATE',
        },
        component: () => import(/* webpackChunkName: "VehicleCreate" */ '../pages/Vehicle/Create.vue'),
      },
      {
        path: 'detail/:id',
        name: 'VehicleDetail',
        meta: {
          title: 'ROUTER_VEHICLE_DETAIL',
          breadcrumb: 'BREADCRUMB_VEHICLE_DETAIL',
        },
        component: () => import(/* webpackChunkName: "VehicleDetail" */ '../pages/Vehicle/Detail.vue'),
      },
      {
        path: 'edit/:id',
        name: {
          title: 'ROUTER_VEHICLE_EDIT',
          breadcrumb: 'BREADCRUMB_VEHICLE_EDIT',
        },
        component: () => import(/* webpackChunkName: "VehicleEdit" */ '../pages/Vehicle/Edit.vue'),
      },
    ],
  },
  {
    path: '/degitacho',
    name: 'Degitacho',
    meta: {
      title: 'ROUTER_DEGITACHO',
      breadcrumb: 'BREADCRUMB_DEGITACHO',
    },
    component: Layout,
    redirect: { name: 'DegitachoList' },
    children: [
      {
        path: 'list',
        name: 'DegitachoList',
        meta: {
          title: 'ROUTER_DEGITACHO_LIST',
          breadcrumb: 'BREADCRUMB_DEGITACHO_LIST',
        },
        component: () => import(/* webpackChunkName: "DegitachoList" */ '../pages/Degitacho/List.vue'),
      },
      {
        path: 'create',
        name: 'DegitachoCreate',
        meta: {
          title: 'ROUTER_DEGITACHO_CREATE',
          breadcrumb: 'BREADCRUMB_DEGITACHO_CREATE',
        },
        component: () => import(/* webpackChunkName: "DegitachoCreate" */ '../pages/Degitacho/Create.vue'),
      },
      {
        path: 'detail/:id',
        name: 'DegitachoDetail',
        meta: {
          title: 'ROUTER_DEGITACHO_DETAIL',
          breadcrumb: 'BREADCRUMB_DEGITACHO_DETAIL',
        },
        component: () => import(/* webpackChunkName: "DegitachoDetail" */ '../pages/Degitacho/Detail.vue'),
      },
      {
        path: 'edit/:id',
        name: 'DegitachoEdit',
        meta: {
          title: 'ROUTER_DEGITACHO_EDIT',
          breadcrumb: 'BREADCRUMB_DEGITACHO_EDIT',
        },
        component: () => import(/* webpackChunkName: "DegitachoEdit" */ '../pages/Degitacho/Edit.vue'),
      },
    ],
  },
  {
    path: '/etcdevice',
    name: 'ETCdevice',
    meta: {
      title: 'ROUTER_ETC_DEVICE',
      breadcrumb: 'BREADCRUMB_ETC_DEVICE',
    },
    component: Layout,
    redirect: { name: 'ETCdeviceList' },
    children: [
      {
        path: 'list',
        name: 'ETCdeviceList',
        meta: {
          title: 'ROUTER_ETC_DEVICE_LIST',
          breadcrumb: 'BREADCRUMB_ETC_DEVICE_LIST',
        },
        component: () => import(/* webpackChunkName: "ETCdeviceList" */ '../pages/ETCdevice/List.vue'),
      },
      {
        path: 'create',
        name: 'ETCdeviceCreate',
        meta: {
          title: 'ROUTER_ETC_DEVICE_CREATE',
          breadcrumb: 'BREADCRUMB_ETC_DEVICE_CREATE',
        },
        component: () => import(/* webpackChunkName: "ETCdeviceCreate" */ '../pages/ETCdevice/Create.vue'),
      },
      {
        path: 'detail/:id',
        name: 'ETCdeviceDetail',
        meta: {
          title: 'ROUTER_ETC_DEVICE_DETAIL',
          breadcrumb: 'BREADCRUMB_ETC_DEVICE_DETAIL',
        },
        component: () => import(/* webpackChunkName: "ETCdeviceDetail" */ '../pages/ETCdevice/Detail.vue'),
      },
      {
        path: 'edit/:id',
        name: 'ETCdeviceEdit',
        meta: {
          title: 'ROUTER_ETC_DEVICE_EDIT',
          breadcrumb: 'BREADCRUMB_ETC_DEVICE_EDIT',
        },
        component: () => import(/* webpackChunkName: "ETCdeviceEdit" */ '../pages/ETCdevice/Edit.vue'),
      },
    ],
  },
  {
    path: '/mastermanagement',
    name: 'MasterManagement',
    meta: {
      title: 'ROUTER_MASTER_MANAGEMENT',
      breadcrumb: 'BREADCRUMB_MASTER_MANAGEMENT',
    },
    component: Layout,
    redirect: { name: 'MasterManagementList' },
    children: [
      {
        path: 'list',
        name: 'MasterManagementList',
        meta: {
          title: 'ROUTER_MASTER_MANAGEMENT_LIST',
          breadcrumb: 'BREADCRUMB_MASTER_MANAGEMENT_LIST',
        },
        component: () => import(/* webpackChunkName: "MasterManagementList" */ '../pages/MasterManagement/List.vue'),
      },
      {
        path: 'create',
        name: 'MasterManagementCreate',
        meta: {
          title: 'ROUTER_MASTER_MANAGEMENT_CREATE',
          breadcrumb: 'BREADCRUMB_MASTER_MANAGEMENT_CREATE',
        },
        component: () => import(/* webpackChunkName: "MasterManagementCreate" */ '../pages/MasterManagement/Create.vue'),
      },
      {
        path: 'detail/:id',
        name: 'MasterManagementDetail',
        meta: {
          title: 'ROUTER_MASTER_MANAGEMENT_DETAIL',
          breadcrumb: 'BREADCRUMB_MASTER_MANAGEMENT_DETAIL',
        },
        component: () => import(/* webpackChunkName: "MasterManagementDetail" */ '../pages/MasterManagement/Detail.vue'),
      },
      {
        path: 'edit/:id',
        name: 'MasterManagementEdit',
        meta: {
          title: 'ROUTER_MASTER_MANAGEMENT_EDIT',
          breadcrumb: 'BREADCRUMB_MASTER_MANAGEMENT_EDIT',
        },
        component: () => import(/* webpackChunkName: "MasterManagementEdit" */ '../pages/MasterManagement/Edit.vue'),
      },
    ],
  },
  {
    path: '/usermanagement',
    name: 'UserManagement',
    meta: {
      title: 'ROUTER_USER_MANAGEMENT',
      breadcrumb: 'BREADCRUMB_USER_MANAGEMENT',
    },
    component: Layout,
    redirect: { name: 'UserManagementList' },
    children: [
      {
        path: 'list',
        name: 'UserManagementList',
        meta: {
          title: 'ROUTER_USER_MANAGEMENT_LIST',
          breadcrumb: 'BREADCRUMB_USER_MANAGEMENT_LIST',
        },
        component: () => import(/* webpackChunkName: "UserManagementList" */ '../pages/UserManagement/List.vue'),
      },
      {
        path: 'create',
        name: 'UserManagementCreate',
        meta: {
          title: 'ROUTER_USER_MANAGEMENT_CREATE',
          breadcrumb: 'BREADCRUMB_USER_MANAGEMENT_CREATE',
        },
        component: () => import(/* webpackChunkName: "UserManagementCreate" */ '../pages/UserManagement/Create.vue'),
      },
      {
        path: 'detail/:id',
        name: 'UserManagementDetail',
        meta: {
          title: 'ROUTER_USER_MANAGEMENT_DETAIL',
          breadcrumb: 'BREADCRUMB_USER_MANAGEMENT_DETAIL',
        },
        component: () => import(/* webpackChunkName: "UserManagementDetail" */ '../pages/UserManagement/Detail.vue'),
      },
      {
        path: 'edit/:id',
        name: 'UserManagementEdit',
        meta: {
          title: 'ROUTER_USER_MANAGEMENT_EDIT',
          breadcrumb: 'BREADCRUMB_USER_MANAGEMENT_EDIT',
        },
        component: () => import(/* webpackChunkName: "UserManagementEdit" */ '../pages/UserManagement/Edit.vue'),
      },
    ],
  },
  {
    path: '/dev',
    component: Layout,
    redirect: { name: 'dev' },
    meta: {
      title: 'ROUTER_DEV',
      breadcrumb: 'BREADCRUMB_DEV',
    },
    children: [
      {
        path: 'index',
        name: 'dev',
        meta: {
          title: 'ROUTER_DEV',
          breadcrumb: 'BREADCRUMB_DEV_INDEX',
        },
        component: () => import(/* webpackChunkName: "Dev" */ '../pages/Dev/index.vue'),
      },
    ],
  },
];

export const asyncRoutes = [];

const createRouter = () => new VueRouter({
  mode: 'history',
  hash: false,
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes,
});

const router = createRouter();

export function resetRouter() {
  const newRouter = createRouter();
  router.matcher = newRouter.matcher;
}

export default router;
