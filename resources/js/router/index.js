import { createRouter, createWebHistory } from 'vue-router';
import { AudioLines, LayoutDashboard, UserRound } from 'lucide-vue-next';
import Artists from '@/pages/Artists.vue';
import Songs from '@/pages/Songs.vue';
import Dashboard from '@/pages/Dashboard.vue';
import ArtistsBlock from '@/components/blocks/ArtistsBlock.vue';
import SongsBlock from '@/components/blocks/SongsBlock.vue';

export const routes = [
    {
        id: 0,
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        icon: LayoutDashboard,
    },
    {
        id: 1,
        path: '/artists',
        name: 'Artists',
        component: Artists,
        icon: UserRound,
        children: [
            {
                path: '',
                name: 'Artists page',
                component: ArtistsBlock,
            },
            {
                path: ':id',
                name: "Artist's song page",
                component: SongsBlock,
                props: (route) => ({ artistId: route.params.id }),
            },
        ],
    },
    {
        id: 2,
        path: '/songs',
        name: 'Songs page',
        component: Songs,
        icon: AudioLines,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
