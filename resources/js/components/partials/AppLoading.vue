<script setup>
import { useLoadingStore } from '@/stores/loading';
import { Loader2 } from 'lucide-vue-next';

const loadingStore = useLoadingStore();
</script>

<template>
    <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 translate-y-2"
        enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-2">
        <div v-if="loadingStore.getLoadingState()"
            class="flex fixed inset-0 z-10 items-center justify-center grow shrink bg-white/70 dark:bg-[#09090b]/70">
            <Loader2 class="size-16 animate-spin" />
        </div>
    </Transition>
</template>