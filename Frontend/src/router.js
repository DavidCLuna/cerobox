import { createRouter, createWebHistory } from "vue-router";
import indexView from "./views/user/indexView";
import loginView from "./views/admin/loginView";
import dashboardView from "./views/admin/dashboardView";
import AuthMiddleware from './middleware/auth'

const routes = [

  {
    path: '/',
    name: 'index',
    component: indexView
  },
  {
    path: '/admin',
    name: 'admin-login',
    component: loginView
  },
  {
    path: '/admin/dashboard',
    name: 'admin-dashboard',
    component: dashboardView,
    beforeEnter: AuthMiddleware
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;