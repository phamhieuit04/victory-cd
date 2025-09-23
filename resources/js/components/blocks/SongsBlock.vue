<script setup>
import api from '@/api/axios';
import AppTooltip from '@/components/partials/AppTooltip.vue';
import { Pagination, PaginationContent, PaginationEllipsis, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow, } from '@/components/ui/table'
import { useArtistsStore } from '@/stores/artists';
import { usePagesStore } from '@/stores/pages';
import { useSongsStore } from '@/stores/songs';
import { onMounted } from 'vue';
import AppEmpty from '../partials/AppEmpty.vue';

const props = defineProps({
    artistId: {
        type: [String, Number],
        default: null
    }
});

const pagesStore = usePagesStore();
const artistsStore = useArtistsStore();
const songsStore = useSongsStore();

async function fetchSongs(offset) {
    if (props.artistId) {
        await artistsStore.getArtistSongs(props.artistId, offset);
        songsStore.setSongs(artistsStore.getArtist().songs);
        songsStore.setTotal(artistsStore.total);
    } else {
        await songsStore.getSongs(offset);
    }
}

onMounted(() => {
    pagesStore.setCurrentPage(0);
    fetchSongs(pagesStore.currentPage);
})
</script>

<template>
    <div v-if="songsStore.total > 0" class="flex flex-col grow justify-between">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead class="text-center">Id</TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead>Thumbnail</TableHead>
                    <TableHead>Artist</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="song in songsStore.songs" :key="song.id">
                    <TableCell class="font-medium text-center">
                        {{ song.id }}
                    </TableCell>
                    <TableCell>
                        {{ song.name }}
                    </TableCell>
                    <TableCell>
                        <img class="size-10 aspect-square object-cover" :src="song.thumbnail_url">
                    </TableCell>
                    <TableCell>
                        {{ song.artist_name ?? artistsStore.artist.name }}
                    </TableCell>
                    <TableCell class="w-36">
                        <AppTooltip :id="song.id" :type="'songs'" :artistId="props.artistId" />
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <Pagination v-slot="{ page }" :items-per-page="10" :total="songsStore.total" :default-page="1">
            <PaginationContent v-slot="{ items }">
                <template v-for="(item, index) in items" :key="index">
                    <PaginationItem
                        @click="pagesStore.setCurrentPage(item.value - 1); fetchSongs(pagesStore.currentPage)"
                        class="cursor-pointer" v-if="item.type === 'page'" :value="item.value"
                        :is-active="item.value === page">
                        {{ item.value }}
                    </PaginationItem>
                </template>
                <PaginationEllipsis v-show="songsStore.total > 50" />
            </PaginationContent>
        </Pagination>
    </div>
    <AppEmpty v-else />
</template>