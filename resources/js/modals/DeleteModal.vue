<script setup>
import { Button } from '@/components/ui/button';
import { Loader2 } from 'lucide-vue-next';
import { onClickOutside } from '@vueuse/core';
import { ref } from 'vue';
import api from '@/api/axios';
import { useArtistsStore } from '@/stores/artists';
import { usePagesStore } from '@/stores/pages';
import { useSongsStore } from '@/stores/songs';
import { useLoadingStore } from '@/stores/loading';

const props = defineProps({
    id: [String, Number],
    isDisplay: Boolean,
    type: String,
    artistId: {
        type: [String, Number],
        default: null
    }
});
const modal = ref(null);
const loading = ref(false)
const emit = defineEmits(['close_modal']);

const pagesStore = usePagesStore();
const artistsStore = useArtistsStore();
const songsStore = useSongsStore();
const loadingStore = useLoadingStore();

onClickOutside(modal, () => {
    emit('close_modal');
})

const deleteItem = async (type) => {
    loading.value = true;
    loadingStore.setLoadingState(true);
    await api.delete(`/${type}/${props.id}`).then(async (res) => {
        if (res.status == 200) {
            if (type == 'artists') {
                await artistsStore.getArtists(pagesStore.currentPage);
                loading.value = false;
                loadingStore.setLoadingState(false);
            }
            if (type == 'songs') {
                if (props.artistId) {
                    await artistsStore.getArtistSongs(props.artistId, pagesStore.currentPage);
                    songsStore.setSongs(artistsStore.getArtist().songs);
                    songsStore.setTotal(artistsStore.total);
                    loading.value = false;
                    loadingStore.setLoadingState(false);
                } else {
                    await songsStore.getSongs(pagesStore.currentPage);
                    loading.value = false;
                    loadingStore.setLoadingState(false);
                }
            }
        }
    }).catch((err) => {
        console.log(err);
    })
}

</script>

<template>
    <Teleport to="#modal">
        <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 translate-y-2"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-2">
            <div v-show="props.isDisplay" :id="props.id"
                class="flex z-10 fixed inset-0 items-center justify-center bg-black/70">
                <div ref="modal"
                    class="dark:bg-[#09090b] bg-white p-6 rounded-md flex flex-col gap-2 w-[500px] dark:outline">
                    <h1 class="font-bold text-lg dark:text-[#fafafa] text-black">Are you absolutely sure?</h1>
                    <p class="text-[#71717a] dark:text-[#a1a1aa] text-wrap text-justify">
                        This action cannot be undone. This will permanently delete your data and remove your data from
                        servers.
                    </p>
                    <div class="flex gap-2 justify-end mt-3">
                        <Button class="cursor-pointer" variant="outline" @click="$emit('close_modal')">
                            Cancel
                        </Button>
                        <Button :class="loading ? 'dark:bg-[#818182] dark:text-[#101013] bg-[#8b8b8d] text-[#fcfcfc] select-none'
                            : 'cursor-pointer'" @click="deleteItem(props.type); $emit('close_modal')">
                            Continue
                            <Loader2 v-if="loading" class="w-4 h-4 animate-spin" />
                        </Button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>