<script setup lang="ts">
import { Button } from '../ui/button';
import { Pencil, Trash2, Ellipsis } from 'lucide-vue-next';
</script>

<template>
    <div class="flex gap-2 w-20 items-center">
        <Button size="icon" variant="outline" class="cursor-pointer">
            <Pencil class="size-3.5" />
        </Button>
        <Button size="icon" variant="outline" class="cursor-pointer">
            <Trash2 class="size-3.5" />
        </Button>
    </div>
</template>