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
      component: () => import('@/Pages/Auth/Login.vue'),
      meta: {
        requiresGuest: true
      }
    },
    {
      path: '/uye-ol',
      name: 'register',
      component: () => import('@/Pages/Auth/Register.vue'),
      meta: {
        requiresGuest: true
      }
    },
    {
      path: '/gym-side',
      name: 'GymSide',
      children: 
      [
        {
            path: 'genel-bakis',
            name: 'genel-bakis',
            component: () => import('@/Pages/Panel/Dashboard.vue')
        },
        {
            path: 'profil-ayarlari',
            name: 'profil-ayarlari',
            component: () => import('@/Pages/Panel/ProfileSettings.vue'),
          meta: {
            requiresAuth: true
          }
        }
      ]
}
  ]
});


router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('_token');

  if (to.meta.requiresGuest && isAuthenticated) {
    next('/');
  } else if(to.meta.requiresAuth && !isAuthenticated) {
    next('/');
  } else {
    next();
  }
});






export default router
