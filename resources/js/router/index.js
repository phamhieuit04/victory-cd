import { createRouter, createWebHistory } from 'vue-router';
import Artists from '../pages/artists.vue';
import Songs from '../pages/songs.vue';

const routes = [
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
