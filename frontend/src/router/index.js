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
      component: () => import('@/pages/auth/LoginPage.vue'),
      meta: {
        requiresGuest: true
      }
    },
    {
      path: '/uye-ol',
      name: 'register',
      component: () => import('@/pages/auth/RegisterPage.vue'),
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
            component: () => import('@/pages/UserDashboard.vue')
          },
          {
            path: 'antrenman-gecmisi',
            name: 'workout-history',
            component: () => import('@/pages/workout-history/Index.vue')
          },
          {
            path: 'antrenman-gecmisi/:workoutLogId',
            name: 'show-workout-history',
            component: () => import('@/pages/workout-history/Show.vue')
          },
          {
            path: 'antrenmanlar',
            name: 'workout-list',
            component: () => import('@/pages/workouts/Index.vue')
          },
          {
            path: 'antrenmanlar/:trainId',
            name: 'workout',
            component: () => import('@/pages/workouts/Edit.vue')
          },
          {
            path: 'antrenmanlar/ekle',
            name: 'add-train',
            component: () => import('@/pages/workouts/Add.vue'),
          },
          {
            path: 'profil-ayarlari',
            name: 'profile',
            component: () => import('@/pages/user/ProfileSettings.vue')
          },
          {
            path: 'sifre-yenile',
            name: 'reset-password',
            component: () => import('@/pages/user/ResetPassword.vue')
          },
        ],
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/on-train/:workoutLogId',
      name: 'on-train',
      component: () => import('@/pages/OnWorkout.vue'),
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/antrenman-tamamlandi/:workoutLogId',
      name: 'train-completed',
      component: () => import('@/pages/WorkoutCompleted.vue'),
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