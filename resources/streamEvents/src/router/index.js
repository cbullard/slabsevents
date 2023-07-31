import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: import.meta.env.BASE_URL,
  routes: [
    {
      path: '/',
      redirect: { name: 'sign-in' }
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/UserDashboardView.vue')
    },
    {
      path: '/sign-in',
      name: 'sign-in',
      component: () => import('../views/Login.vue')
    }
  ]
})

export default router
