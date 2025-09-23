import api from '@/api/axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useLoadingStore } from './loading';
import { useArtistsStore } from './artists';
import { usePagesStore } from './pages';

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
    const updateSong = async (id, name, thumbnail, artistId) => {
        let uploadForm = new FormData();
        uploadForm.append('file', thumbnail);
        api.post('/upload', uploadForm, {
            params: {
                type: 'thumbnail',
            },
        })
            .then((res) => {
                if (res.status == 200) {
                    api.put(`/songs/${id}`, {
                        name: name,
                        thumbnail_url: res.data.data.file_url,
                    })
                        .then((res) => {
                            if (res.status == 200) {
                                fetchSongs(artistId);
                            }
                        })
                        .catch((err) => {
                            console.log(err);
                        });
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const fetchSongs = async (artistId) => {
        const artistsStore = useArtistsStore();
        const pagesStore = usePagesStore();
        const loadingStore = useLoadingStore();
        loadingStore.setLoadingState(true);
        if (artistId) {
            await artistsStore.getArtistSongs(artistId, pagesStore.currentPage);
            songs.value = artistsStore.getArtist().songs;
            total.value = artistsStore.total;
        } else {
            await getSongs(pagesStore.currentPage);
        }
        loadingStore.setLoadingState(false);
    };
    const setSongs = (value) => {
        songs.value = value;
    };
    const setTotal = (value) => {
        total.value = value;
    };

    return {
        songs,
        total,
        getSongs,
        setSongs,
        setTotal,
        updateSong,
        fetchSongs,
    };
});
