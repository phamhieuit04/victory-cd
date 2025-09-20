<script setup>
import api from '@/api/axios';
import AppTooltip from '@/components/partials/AppTooltip.vue';
import { Pagination, PaginationContent, PaginationEllipsis, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow, } from '@/components/ui/table'
import { onMounted, ref } from 'vue';

const props = defineProps({
    artistId: {
        type: [String, Number],
        default: null
    }
});

var songs = ref([]);
var artistName = ref([]);
const total = ref(0);

const getSongs = async (offset) => {
    await api.get('/songs', {
        params: {
            offset: offset * 10
        }
    }).then((res) => {
        if (res.status == 200) {
            songs.value = res.data.data.songs;
            total.value = res.data.data.total;
        };
    }).catch((err) => {
        console.log(err);
    })
}

const getArtistSongs = async (id, offset) => {
    await api.get(`/artists/${id}`, {
        params: {
            offset: offset * 10
        }
    }).then((res) => {
        if (res.status == 200) {
            songs.value = res.data.data.user.songs;
            artistName.value = res.data.data.user.name;
            total.value = res.data.data.total;
        }
    }).catch((err) => {
        console.log(err);
    })
}

function fetchSongs(offset) {
    if (props.artistId) {
        getArtistSongs(props.artistId, offset);
    } else {
        getSongs(offset);
    }
}

onMounted(() => {
    fetchSongs();
})
</script>

<template>
    <div class="flex flex-col grow justify-between">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead class="text-center">Id</TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead>Artist</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="song in songs" :key="song.id" class="h-12">
                    <TableCell class="font-medium text-center">
                        {{ song.id }}
                    </TableCell>
                    <TableCell>
                        {{ song.name }}
                    </TableCell>
                    <TableCell>
                        {{ song.artist_name ?? artistName }}
                    </TableCell>
                    <TableCell class="w-36">
                        <AppTooltip />
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <Pagination v-slot="{ page }" :items-per-page="10" :total="total" :default-page="1">
            <PaginationContent v-slot="{ items }">
                <template v-for="(item, index) in items" :key="index">
                    <PaginationItem @click="fetchSongs(item.value - 1)" class="cursor-pointer"
                        v-if="item.type === 'page'" :value="item.value" :is-active="item.value === page">
                        {{ item.value }}
                    </PaginationItem>
                </template>
                <PaginationEllipsis v-show="total > 50" />
            </PaginationContent>
        </Pagination>
    </div>
</template>