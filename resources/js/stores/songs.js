import api from '@/api/axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useLoadingStore } from './loading';

export const useSongsStore = defineStore('songs', () => {
    const songs = ref([]);
    const total = ref(0);

    const getSongs = async (offset) => {
        const loadingStore = useLoadingStore();
        loadingStore.setLoadingState(true);
        await api
            .get('/songs', {
                params: {
                    offset: offset * 10,
                },
            })
            .then((res) => {
                if (res.status == 200) {
                    loadingStore.setLoadingState(false);
                    songs.value = res.data.data.songs;
                    total.value = res.data.data.total;
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const setSongs = (value) => {
        songs.value = value;
    };
    const setTotal = (value) => {
        total.value = value;
    };

    return { songs, total, getSongs, setSongs, setTotal };
});
