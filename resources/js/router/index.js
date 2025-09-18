import { createRouter, createWebHistory } from 'vue-router';
import Artists from '../pages/Artists.vue';
import Songs from '../pages/Songs.vue';
import Dashboard from '@/pages/Dashboard.vue';

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
    },
    {
        path: '/artists',
        name: 'artists',
        component: Artists,
    },
    {
        path: '/songs',
        name: 'songs',
        component: Songs,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
