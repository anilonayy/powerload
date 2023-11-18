import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/Pages/Home.vue')
    },
    {
      path: '/hakkimizda',
      name: 'about',
      component: () => import('@/Pages/About.vue')
    },
    {
      path: '/giris-yap',
      name: 'login',
      component: () => import('@/Pages/Auth/Login.vue')
    }
  ]
})

export default router
