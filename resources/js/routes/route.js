import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('../pages/employees'),
        },

        {
            path: '/employees',
            name: 'employees',
            component: () => import('../pages/employees'),
        },

        {
            path: '/dtr',
            name: 'dtr',
            component: () => import('../pages/dtr'),
        },
    ],
});
  export default router
