import api from '@/api/axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useLoadingStore } from './loading';
import { usePagesStore } from './pages';

export const useArtistsStore = defineStore('artists', () => {
    const artists = ref([]);
    const artist = ref({ name: '', songs: [] });
    const total = ref(0);

    const getArtists = async (offset) => {
        const loadingStore = useLoadingStore();
        loadingStore.setLoadingState(true);
        await api
            .get('/artists', {
                params: {
                    offset: offset * 10,
                },
            })
            .then((res) => {
                if (res.status == 200) {
                    loadingStore.setLoadingState(false);
                    artists.value = res.data.data.artists;
                    total.value = res.data.data.total;
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const getArtistSongs = async (id, offset) => {
        const loadingStore = useLoadingStore();
        loadingStore.setLoadingState(true);
        await api
            .get(`/artists/${id}`, {
                params: {
                    offset: offset * 10,
                },
            })
            .then((res) => {
                if (res.status == 200) {
                    loadingStore.setLoadingState(false);
                    artist.value.songs = res.data.data.user.songs;
                    artist.value.name = res.data.data.user.name;
                    total.value = res.data.data.total;
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const updateArtist = async (id, name) => {
        const loadingStore = useLoadingStore();
        const pagesStore = usePagesStore();
        loadingStore.setLoadingState(true);
        api.put(`/artists/${id}`, {
            name: name,
        })
            .then(async (res) => {
                if (res.status == 200) {
                    await getArtists(pagesStore.currentPage);
                }
            })
            .catch((err) => {
                console.log(err);
            });
        loadingStore.setLoadingState(false);
    };
    const getArtist = () => {
        return artist.value;
    };

    return {
        artists,
        total,
        getArtists,
        getArtistSongs,
        artist,
        getArtist,
        updateArtist,
    };
});
