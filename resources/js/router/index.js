import { createRouter, createWebHistory } from 'vue-router';
import { AudioLines, LayoutDashboard, UserRound } from 'lucide-vue-next';
import Artists from '@/pages/Artists.vue';
import Songs from '@/pages/Songs.vue';
import Dashboard from '@/pages/Dashboard.vue';
import { ref, unref } from 'vue';

export const routes = [
    {
        id: 0,
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        icon: LayoutDashboard,
        active: false,
    },
    {
        id: 1,
        path: '/artists',
        name: 'Artists',
        component: Artists,
        icon: UserRound,
        active: false,
    },
    {
        id: 2,
        path: '/songs',
        name: 'Songs',
        component: Songs,
        icon: AudioLines,
        active: false,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
