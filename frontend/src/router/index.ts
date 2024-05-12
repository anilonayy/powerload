import { createRouter, createWebHistory } from 'vue-router';
import { useStore } from 'vuex';
import routes from '@/router/routes';
import { updateExercises } from '@/utils/exerciseHelper';

const router = createRouter({
  routes,
  history: createWebHistory()
});

router.beforeEach((to, from, next) => {
  const store = useStore();
  const isAuthenticated = store.getters['_isAuthenticated'];

  setTimeout(async () => {
    await store.dispatch('updateAsideOpen', false);
  }, 200);

  if (to.meta.title) {
    window.document.title = to.meta.title.toString();
  }

  if ((to.meta.requiresGuest && isAuthenticated) || (to.meta.requiresAuth && !isAuthenticated)) {
    next('/');
  } else {
    next();
  }

  // Fake middlewares
  updateExercises();
});

export default router;
