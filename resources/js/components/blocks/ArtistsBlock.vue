<script setup>
import AppTooltip from '@/components/partials/AppTooltip.vue';
import { Pagination, PaginationContent, PaginationEllipsis, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow, } from '@/components/ui/table'
import { useArtistsStore } from '@/stores/artists';
import { usePagesStore } from '@/stores/pages';
import { onMounted } from 'vue';
import AppEmpty from '../partials/AppEmpty.vue';

const artistsStore = useArtistsStore();
const pagesStore = usePagesStore();

onMounted(() => {
    pagesStore.setCurrentPage(0);
    artistsStore.getArtists(pagesStore.currentPage);
})
</script>

<template>
    <div v-if="artistsStore.total > 0" class="flex flex-col grow justify-between">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead class="text-center">Id</TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead class="text-center">Songs</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="artist in artistsStore.artists" :key="artist.id" class="h-12">
                    <TableCell class="font-medium text-center">
                        {{ artist.id }}
                    </TableCell>
                    <TableCell>
                        <RouterLink :to="`/artists/${artist.id}`" class="hover:opacity-75">
                            {{ artist.name }}
                        </RouterLink>
                    </TableCell>
                    <TableCell class="text-center">
                        {{ artist.songs_count }}
                    </TableCell>
                    <TableCell class="w-36">
                        <AppTooltip :id="artist.id" :type="'artists'" />
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <Pagination v-slot="{ page }" :items-per-page="10" :total="artistsStore.total" :default-page="1">
            <PaginationContent v-slot="{ items }">
                <template v-for="(item, index) in items" :key="index">
                    <PaginationItem
                        @click="pagesStore.setCurrentPage(item.value - 1); artistsStore.getArtists(pagesStore.currentPage)"
                        class="cursor-pointer" v-if="item.type === 'page'" :value="item.value"
                        :is-active="item.value === page">
                        {{ item.value }}
                    </PaginationItem>
                </template>
                <PaginationEllipsis v-show="artistsStore.total > 50" />
            </PaginationContent>
        </Pagination>
    </div>
    <AppEmpty v-else />
</template>