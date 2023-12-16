import { createRouter, createWebHistory } from 'vue-router'
import { useStore } from 'vuex'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/pages/Home.vue')
    },
    {
      path: '/hakkimizda',
      name: 'about',
      component: () => import('@/pages/About.vue')
    },
    {
      path: '/giris-yap',
      name: 'login',
      component: () => import('@/pages/auth/Login.vue'),
      meta: {
        requiresGuest: true
      }
    },
    {
      path: '/uye-ol',
      name: 'register',
      component: () => import('@/pages/auth/Register.vue'),
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
            name: 'dashboard',
            component: () => import('@/pages/panel/Dashboard.vue')
          },
          {
            path: 'antrenmanlar',
            name: 'trainings',
            component: () => import('@/pages/panel/trainings/Index.vue')
          },
          {
            path: 'antrenmanlar/:trainId',
            name: 'training',
            component: () => import('@/pages/panel/trainings/Edit.vue')
          },
          {
            path: 'antrenmanlar/ekle',
            name: 'add-train',
            component: () => import('@/pages/panel/trainings/Add.vue'),
          },
          {
            path: 'profil-ayarlari',
            name: 'profile',
            component: () => import('@/pages/panel/ProfileSettings.vue')
          },
          {
            path: 'sifre-yenile',
            name: 'reset-password',
            component: () => import('@/pages/panel/ResetPassword.vue')
          },
          {
            path: 'on-train/:trainingLogId',
            name: 'on-train',
            component: () => import('@/pages/panel/OnTrain.vue')

          }
        ],
        meta: {
          requiresAuth: true
        }
    }
  ]
});

router.beforeEach((to, from, next) => {
  const store = useStore();
  const isAuthenticated = store.getters['_isAuthenticated']

  setTimeout(() => {
    store.dispatch('updateAsideOpen', false);
  }, 200);

  if ((to.meta.requiresGuest && isAuthenticated) ||
    (to.meta.requiresAuth && !isAuthenticated)) {
    next('/');
  } else {
    next();
  }
});

export default router;