import { createRouter, createWebHistory } from "vue-router";
import indexView from "./views/user/indexView";
import loginView from "./views/admin/loginView";

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
]

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;