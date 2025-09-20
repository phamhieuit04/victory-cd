<script setup>
import api from '@/api/axios';
import AppTooltip from '@/components/partials/AppTooltip.vue';
import { Pagination, PaginationContent, PaginationEllipsis, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow, } from '@/components/ui/table'
import { onMounted, ref } from 'vue';

var artists = ref([]);
const total = ref(0);

const getArtists = (value) => {
    api.get('/artists', {
        params: {
            offset: value * 10
        }
    }).then((res) => {
        if (res.status == 200) {
            artists.value = res.data.data.artists;
            total.value = res.data.data.total;
        };
    }).catch((err) => {
        console.log(err);
    })
}

onMounted(() => {
    getArtists(0);
})
</script>

<template>
    <!-- Đây chỉ là mẫu table và pagination, chưa bao gồm các tương tác người dùng -->
    <div class="flex flex-col grow justify-between">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead class="text-center">Id</TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead class="text-center">Songs</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="artist in artists" :key="artist.id" class="h-12">
                    <TableCell class="font-medium text-center">
                        {{ artist.id }}
                    </TableCell>
                    <TableCell>
                        <RouterLink :to="`/artists/${artist.id}/songs`">
                            {{ artist.name }}
                        </RouterLink>
                    </TableCell>
                    <TableCell class="text-center">
                        {{ artist.songs_count }}
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
                    <PaginationItem @click="getArtists(item.value - 1)" class="cursor-pointer"
                        v-if="item.type === 'page'" :value="item.value" :is-active="item.value === page">
                        {{ item.value }}
                    </PaginationItem>
                </template>
                <PaginationEllipsis v-show="total > 50" />
            </PaginationContent>
        </Pagination>
    </div>
</template>