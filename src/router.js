import { createRouter, createWebHistory } from "vue-router";
import indexView from "./views/user/indexView";

const routes = [

  {
    path: '/',
    name: 'index',
    component: indexView
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;