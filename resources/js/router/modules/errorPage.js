import Layout from '../../layout';

const errorRoutes = {
  path: '/error',
  component: Layout,
  name: 'ErrorPages',
  meta: {
    title: 'ROUTER_ERROR_PAGE',
    breadcrumb: 'BREADCRUMB_ERROR_PAGE',
  },
  hidden: true,
  children: [
    {
      path: '404',
      component: () => import(/* webpackChunkName: "Error404" */ '../../pages/ErrorPage/index.vue'),
      name: 'Page404',
      meta: {
        title: 'ROUTER_ERROR_PAGE',
        breadcrumb: 'BREADCRUMB_ERROR_PAGE_404',
      },
    },
  ],
};

export default errorRoutes;
