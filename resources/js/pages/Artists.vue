<script setup>
import { Pagination, PaginationContent, PaginationEllipsis, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow, } from '@/components/ui/table'
</script>

<template>
    <!-- Đây chỉ là mẫu table và pagination, chưa bao gồm các tương tác người dùng -->
    <div class="flex flex-col grow justify-between">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead class="w-[100px]">
                        Invoice
                    </TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Method</TableHead>
                    <TableHead class="text-right">
                        Amount
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="i in 10" class="h-12 cursor-pointer">
                    <TableCell class="font-medium">
                        INV001
                    </TableCell>
                    <TableCell>Paid</TableCell>
                    <TableCell>Credit Card</TableCell>
                    <TableCell class="text-right">
                        $250.00
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <Pagination>
            <PaginationContent>
                <PaginationPrevious />
                <template v-for="item in 10">
                    <PaginationItem class="cursor-pointer">{{ item }}</PaginationItem>
                </template>
                <PaginationEllipsis />
                <PaginationNext />
            </PaginationContent>
        </Pagination>
    </div>
</template>