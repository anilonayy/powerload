import { computed } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'
import { getCookie } from '../Utils/helpers';
import { useStore } from 'vuex'


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
            name: 'dashboard',
            component: () => import('@/Pages/Panel/Dashboard.vue')
          },
          {
            path: 'antrenmanlar',
            name: 'trainings',
            component: () => import('@/Pages/Panel/Trainings/Index.vue')
          },
          {
            path: 'antrenmanlar/:trainId',
            name: 'training',
            component: () => import('@/Pages/Panel/Trainings/Edit.vue')
          },
          {
            path: 'antrenmanlar/ekle',
            name: 'add-train',
            component: () => import('@/Pages/Panel/Trainings/Add.vue'),
          },
          {
            path: 'profil-ayarlari',
            name: 'profile',
            component: () => import('@/Pages/Panel/ProfileSettings.vue')
          },
          {
            path: 'sifre-yenile',
            name: 'reset-password',
            component: () => import('@/Pages/Panel/ResetPassword.vue')
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


  console.log('isAuthenticated :>> ', isAuthenticated);

  if (to.meta.requiresGuest && isAuthenticated) {
    next('/');
  } else if (to.meta.requiresAuth && !isAuthenticated) {
    next('/');
  } else {
    next();
  }
});



export default router;