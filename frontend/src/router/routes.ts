import type { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/pages/Home.vue'),
    meta: {
      title: 'Powerload - Progressive overload ile gücüne güç kat!'
    }
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('@/pages/About.vue'),
    meta: {
      title: 'Hakkımızda - Powerload'
    }
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/pages/auth/LoginPage.vue'),
    meta: {
      title: 'Giriş Yap - Powerload',
      requiresGuest: true
    }
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/pages/auth/RegisterPage.vue'),
    meta: {
      title: 'Üye Ol - Powerload',
      requiresGuest: true
    }
  },
  {
    path: '/forgot-password',
    name: 'forgot-password',
    component: () => import('@/pages/auth/ForgotPassword.vue'),
    meta: {
      title: 'Şifremi Unuttum - Powerload',
      requiresGuest: true
    }
  },
  {
    path: '/password-reset/:token',
    name: 'password-reset',
    component: () => import('@/pages/auth/PasswordReset.vue'),
    meta: {
      title: 'Şifre yenile - Powerload',
      requiresGuest: true
    }
  },
  {
    path: '/gym-side',
    name: 'GymSide',
    children: [
      {
        path: 'dashboard',
        name: 'dashboard',
        component: () => import('@/pages/UserDashboard.vue'),
        meta: {
          title: 'Genel Bakış - Powerload'
        }
      },
      {
        path: 'workout-history',
        name: 'workout-history',
        component: () => import('@/pages/workout-history/Index.vue'),
        meta: {
          title: 'Antrenman Geçmişi - Powerload'
        }
      },
      {
        path: 'workout-history/:workoutLogId',
        name: 'show-workout-history',
        component: () => import('@/pages/workout-history/Show.vue'),
        meta: {
          title: 'Geçmiş Antrenman - Powerload'
        }
      },
      {
        path: 'workouts',
        name: 'workout-list',
        component: () => import('@/pages/workouts/Index.vue'),
        meta: {
          title: 'Antrenmanlar - Powerload'
        }
      },
      {
        path: 'workouts/:trainId',
        name: 'workout',
        component: () => import('@/pages/workouts/Edit.vue'),
        meta: {
          title: 'Antrenman - Powerload'
        }
      },
      {
        path: 'workouts/add',
        name: 'add-train',
        component: () => import('@/pages/workouts/Add.vue'),
        meta: {
          title: 'Antrenman Ekle - Powerload'
        }
      },
      {
        path: 'profile-settings',
        name: 'profile',
        component: () => import('@/pages/user/ProfileSettings.vue'),
        meta: {
          title: 'Profil Ayarları - Powerload'
        }
      },
      {
        path: 'reset-password',
        name: 'reset-password',
        component: () => import('@/pages/user/ResetPassword.vue'),
        meta: {
          title: 'Şifre Yenile - Powerload'
        }
      }
    ],
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/on-workout/:workoutLogId',
    name: 'on-workout',
    component: () => import('@/pages/OnWorkout.vue'),
    meta: {
      title: 'Antrenman - Powerload',
      requiresAuth: true
    }
  },
  {
    path: '/workout-completed/:workoutLogId',
    name: 'train-completed',
    component: () => import('@/pages/WorkoutCompleted.vue'),
    meta: {
      title: 'Antrenman Tamamlandı! - Powerload',
      requiresAuth: true
    }
  }
];

export default routes;
