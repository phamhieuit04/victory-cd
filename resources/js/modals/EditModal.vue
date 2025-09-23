<script setup>
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Label } from '@/components/ui/label';
import { Loader2 } from 'lucide-vue-next';
import { ref } from 'vue';
import { useArtistsStore } from '@/stores/artists';

const props = defineProps({
    id: [String, Number],
    isDisplay: Boolean,
    type: String
});

const modal = ref(null);
const name = ref("");
const loading = ref(false);
const emit = defineEmits(['close_modal']);

const artistsStore = useArtistsStore();

</script>

<template>
    <Teleport to="#modal">
        <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 translate-y-2"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-2">
            <div v-show="props.isDisplay" :id="props.id"
                class="flex z-10 fixed inset-0 items-center justify-center bg-black/70">
                <div ref="modal"
                    class="dark:bg-[#09090b] bg-white p-6 rounded-md flex flex-col gap-2 w-96 dark:outline">
                    <div v-if="props.type == 'artists'" class="flex flex-col gap-5">
                        <div class="flex gap-1 flex-col">
                            <h1 class="font-bold text-lg dark:text-[#fafafa] text-black">Edit artist</h1>
                            <p class="text-[#71717a] dark:text-[#a1a1aa] text-wrap text-sm">Make changes to
                                your profile here. Click save when you're done.</p>
                        </div>
                        <div class="flex gap-2 items-center">
                            <Label for="name">Name</Label>
                            <Input id="name" placeholder="Son tung mtp" v-model="name" />
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <Button class="cursor-pointer" variant="outline" @click="$emit('close_modal')">
                                Cancel
                            </Button>
                            <Button :class="loading ? 'dark:bg-[#818182] dark:text-[#101013] bg-[#8b8b8d] text-[#fcfcfc] select-none'
                                : 'cursor-pointer'"
                                @click="artistsStore.updateArtist(props.id, name); $emit('close_modal')">
                                Save change
                                <Loader2 v-if="loading" class="w-4 h-4 animate-spin" />
                            </Button>
                        </div>
                    </div>
                    <div v-if="props.type == 'songs'" class="flex flex-col gap-5">
                        <div class="flex gap-1 flex-col">
                            <h1 class="font-bold text-lg dark:text-[#fafafa] text-black">Edit song</h1>
                            <p class="text-[#71717a] dark:text-[#a1a1aa] text-wrap text-sm">Make changes to
                                your song here. Click save when you're done.</p>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-2 items-center">
                                <Label for="name" class="w-12">Name</Label>
                                <Input id="name" placeholder="Em cua ngay hom qua" />
                            </div>
                            <div class="flex gap-2 items-center">
                                <Label class="w-12">Artist</Label>
                                <Select>
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Select an artist" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="artist in artistsStore.artists" :value="artist.name">
                                            {{ artist.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <Button class="cursor-pointer" variant="outline" @click="$emit('close_modal')">
                                Cancel
                            </Button>
                            <Button :class="loading ? 'dark:bg-[#818182] dark:text-[#101013] bg-[#8b8b8d] text-[#fcfcfc] select-none'
                                : 'cursor-pointer'">
                                Save change
                                <Loader2 v-if="loading" class="w-4 h-4 animate-spin" />
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>