import { createRouter, createWebHistory } from 'vue-router'
import Login from '../pages/login.vue'
import ResetAuth from '../pages/reset-auth.vue'
import Dashboard from '../pages/dashboard.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login
    },

    {
      path: '/reset/:type',
      name: 'reset',
      component: ResetAuth
    },

    {
      path: '/',
      name: 'dash.home',
      component: Dashboard
    },
  ]
})  

export default router
