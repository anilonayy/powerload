import { createRouter, createWebHistory } from 'vue-router'
import { useStore } from 'vuex';
import { computed } from 'vue';

const store =  useStore();
const isAuthenticated = computed(() => store.getters['_isAuthenticated']);


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
    },
    {
      path: '/uye-ol',
      name: 'register',
      component: () => import('@/Pages/Auth/Register.vue'),
      meta: {
        requiresGuest: true
      }
    }
  ]
});


router.beforeEach((to, from, next) => {
  if (to.meta.requiresGuest && isAuthenticated) {  
    next('/');
  } else {
    next();
  }
});


export default router
