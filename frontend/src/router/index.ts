import { createRouter, createWebHistory } from 'vue-router'
import { useStore } from 'vuex';
import routes from '@/router/routes';

const router = createRouter({
    routes,
    history: createWebHistory(),
});

router.beforeEach((to, from, next) => {
    const store = useStore();
    const isAuthenticated = store.getters['_isAuthenticated'];

    setTimeout(() => {
        store.dispatch('updateAsideOpen', false);
    }, 200);

    if(to.meta.title) {
        window.document.title = to.meta.title.toString();
    }

    if ((to.meta.requiresGuest && isAuthenticated) ||
        (to.meta.requiresAuth && !isAuthenticated)) {
        next('/');
    } else {
        next();
    }
});

export default router;




