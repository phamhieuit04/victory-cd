<script setup lang="ts">
import DeleteModal from '@/modals/DeleteModal.vue';
import { Button } from '../ui/button';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';
import EditModal from '@/modals/EditModal.vue';

const props = defineProps({
    id: [String, Number],
    type: String,
    artistId: {
        type: [String, Number],
        default: null
    }
});
var isDisplayDeleteModal = ref(false);
var isDisplayEditModal = ref(false);
</script>

<template>
    <div class="flex gap-2 w-20 items-center">
        <Button size="icon" variant="outline" class="cursor-pointer" @click="() => { isDisplayEditModal = true }">
            <Pencil class="size-3.5" />
        </Button>
        <Button size="icon" variant="outline" class="cursor-pointer" @click="() => { isDisplayDeleteModal = true }">
            <Trash2 class="size-3.5" />
        </Button>
    </div>

    <DeleteModal :isDisplay="isDisplayDeleteModal" :id="props.id" :type="props.type" :artistId="props.artistId"
        @close_modal="() => { isDisplayDeleteModal = false }" />

    <EditModal :isDisplay="isDisplayEditModal" :id="props.id" :type="props.type"
        @close_modal="() => { isDisplayEditModal = false }" />
</template>