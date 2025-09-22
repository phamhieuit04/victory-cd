<script setup>
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow, } from '@/components/ui/table'
import { Pagination, PaginationContent, PaginationEllipsis, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { onMounted } from 'vue';
import { Button } from '../ui/button';
import AppEmpty from '../partials/AppEmpty.vue';
import { usePagesStore } from '@/stores/pages';
import { useBillsStore } from '@/stores/bills';

const pagesStore = usePagesStore();
const billsStore = useBillsStore();

onMounted(() => {
    pagesStore.setCurrentPage(0);
    billsStore.getBills(pagesStore.currentPage);
})
</script>

<template>
    <div v-if="billsStore.total > 0" class="flex flex-col grow justify-between">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead class="text-center">Id</TableHead>
                    <TableHead>Order code</TableHead>
                    <TableHead>Song name</TableHead>
                    <TableHead>Price</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Time ago</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="bill in billsStore.bills" :key="bill.id" class="h-14">
                    <TableCell class="font-medium text-center">
                        {{ bill.id }}
                    </TableCell>
                    <TableCell>
                        {{ bill.order_code }}
                    </TableCell>
                    <TableCell>
                        {{ bill.song_name }}
                    </TableCell>
                    <TableCell>
                        {{ bill.price }}
                    </TableCell>
                    <TableCell>
                        {{ bill.status }}
                    </TableCell>
                    <TableCell>
                        {{ bill.time_ago }}
                    </TableCell>
                    <TableCell class="w-36">
                        <Button v-if="bill.status != 'SHIPPED' && bill.status == 'PAID'" class="cursor-pointer"
                            variant="secondary"
                            @click="() => { billsStore.updateBill(bill.id); billsStore.getBills(pagesStore.currentPage) }">Update</Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <Pagination v-slot="{ page }" :items-per-page="10" :total="billsStore.total" :default-page="1">
            <PaginationContent v-slot="{ items }">
                <template v-for="(item, index) in items" :key="index">
                    <PaginationItem
                        @click="pagesStore.setCurrentPage(item.value - 1); billsStore.getBills(pagesStore.currentPage)"
                        class="cursor-pointer" v-if="item.type === 'page'" :value="item.value"
                        :is-active="item.value === page">
                        {{ item.value }}
                    </PaginationItem>
                </template>
                <PaginationEllipsis v-show="billsStore.total > 50" />
            </PaginationContent>
        </Pagination>
    </div>
    <AppEmpty v-else />
</template>