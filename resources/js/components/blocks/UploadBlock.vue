<script setup>
import { Label } from '../ui/label';
import { Input } from '../ui/input';
import { Button } from '../ui/button';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '../ui/select';
import { useSongsStore } from '@/stores/songs';
import { CircleCheck, Upload } from 'lucide-vue-next';
import { useArtistsStore } from '@/stores/artists';
import { onMounted, ref } from 'vue';
import { useUploadStore } from '@/stores/upload';
import { useRouter } from 'vue-router';

const songsStore = useSongsStore();
const artistStore = useArtistsStore();
const uploadStore = useUploadStore();
const router = useRouter();

const fileSongName = ref('...');
const song = ref();
const songUrl = ref('');
const songName = ref('');
const songArtist = ref('');
const artistId = ref(0);
const thumbnail = ref();
const thumbnailUrl = ref('');

const chooseSong = async (event) => {
    song.value = event.target.files[0];
    fileSongName.value = song.value.name;
    let songFormData = new FormData();
    songFormData.append('file', song.value);
    songUrl.value = await uploadStore.upload(songFormData, 'song');
    uploadStore.setUploadStatus(true);
}

const chooseThumbnail = async (event) => {
    thumbnail.value = event.target.files[0];
    let thumbnailFormData = new FormData();
    thumbnailFormData.append('file', thumbnail.value);
    thumbnailUrl.value = await uploadStore.upload(thumbnailFormData, 'thumbnail');
}

const postSong = async () => {
    let isPosted = await songsStore.postSong(songUrl.value, thumbnailUrl.value, songName.value, artistId.value);
    if (isPosted) {
        router.push('/songs');
    }
}

onMounted(() => {
    artistStore.getArtists(0);
})
</script>

<template>
    <div class="flex flex-col gap-5">
        <div class="dark:bg-[#18181b] bg-[#fafafa] rounded-md overflow-hidden mt-6 outline">
            <div class="flex justify-between p-4">
                <div class="flex flex-col grow gap-2">
                    <h1 class="font-bold">{{ fileSongName }}</h1>
                    <div v-if="uploadStore.getUploadProgress() == 100" class="flex items-center gap-1">
                        <CircleCheck size="16" class="text-green-500" />
                        <p class="text-sm dark:text-[#a1a1aa] text-[#71717a]">Uploaded (15MB)</p>
                    </div>
                    <div v-else class="flex items-center gap-1">
                        <p class="text-sm dark:text-[#a1a1aa] text-[#71717a]">Progress: </p>
                        <p class="text-sm dark:text-[#a1a1aa] text-[#71717a]">
                            {{ uploadStore.getUploadProgress() }}%
                        </p>
                    </div>
                </div>
                <div>
                    <Button asChild>
                        <Label for="song" class="cursor-pointer">Choose file</Label>
                        <Input @change="chooseSong($event)" id="song" type="file" hidden name="song" accept=".mp3" />
                    </Button>
                </div>
            </div>
            <div class="h-0.5 bg-white/70">
                <div class="h-0.5 bg-green-600 transition-all"
                    :style="{ width: uploadStore.getUploadProgress() + '%' }" />
            </div>
        </div>
        <div class="flex flex-col gap-2">
            <h1>Details</h1>
            <div class="flex gap-5 justify-between">
                <div class="outline rounded-md dark:bg-[#18181b] bg-[#fafafa] grow px-4 py-6 flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <Label for="name">Song name</Label>
                        <Input v-model="songName" type="text" id="name" name="name"
                            placeholder="Dung lam trai tim anh dau" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <Label>Artist name</Label>
                        <Select>
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Select an artist" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem @select="() => { songArtist = item.name; artistId = item.id }"
                                    v-for="item in artistStore.artists" :key="item.id" :value="item.name">
                                    {{ item.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <div class="flex justify-end mt-5">
                        <Button :class="uploadStore.getUploadStatus() ? 'cursor-pointer'
                            : 'dark:bg-[#818182] dark:text-[#101013] bg-[#8b8b8d] text-[#fcfcfc] select-none'"
                            @click="postSong()">
                            Post song
                        </Button>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <img class="size-96 object-cover aspect-square" :src="thumbnailUrl" alt="">
                    <div class="flex flex-col gap-2">
                        <Label for="thumbnail">Thumbnail</Label>
                        <Input accept=".png,.jpg,.jpeg" @change="chooseThumbnail($event)" type="file" id="thumbnail"
                            name="thumbnail" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>