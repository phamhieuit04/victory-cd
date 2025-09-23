import { createRouter, createWebHistory } from 'vue-router';
import {
    AudioLines,
    CircleDollarSign,
    LayoutDashboard,
    Plus,
    UserRound,
} from 'lucide-vue-next';
import DashboardPage from '@/pages/DashboardPage.vue';
import ArtistsPage from '@/pages/ArtistsPage.vue';
import SongsPage from '@/pages/SongsPage.vue';
import BillsPage from '@/pages/BillsPage.vue';
import ArtistsBlock from '@/components/blocks/ArtistsBlock.vue';
import SongsBlock from '@/components/blocks/SongsBlock.vue';
import BillsBlock from '@/components/blocks/BillsBlock.vue';
import UploadBlock from '@/components/blocks/UploadBlock.vue';

export const routes = [
    {
        id: 0,
        path: '/dashboard',
        name: 'Dashboard',
        component: DashboardPage,
        icon: LayoutDashboard,
        isNavigation: true,
    },
    {
        id: 1,
        path: '/artists',
        name: 'Artists',
        component: ArtistsPage,
        icon: UserRound,
        isNavigation: true,
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
        name: 'Songs',
        component: SongsPage,
        icon: AudioLines,
        isNavigation: true,
        children: [
            {
                path: '',
                name: 'Songs page',
                component: SongsBlock,
            },
        ],
    },
    {
        id: 3,
        path: '/bills',
        name: 'Bills',
        component: BillsPage,
        icon: CircleDollarSign,
        isNavigation: true,
        children: [
            {
                path: '',
                name: 'Bills page',
                component: BillsBlock,
            },
        ],
    },
    {
        id: 4,
        path: '/upload',
        name: 'Upload',
        component: BillsPage,
        icon: Plus,
        isNavigation: true,
        children: [
            {
                path: '',
                name: 'Upload page',
                component: UploadBlock,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
