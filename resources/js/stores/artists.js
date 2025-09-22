import api from '@/api/axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useArtistsStore = defineStore('artists', () => {
    const artists = ref([]);
    const artist = ref({ name: '', songs: [] });
    const total = ref(0);

    const getArtists = async (offset) => {
        await api
            .get('/artists', {
                params: {
                    offset: offset * 10,
                },
            })
            .then((res) => {
                if (res.status == 200) {
                    artists.value = res.data.data.artists;
                    total.value = res.data.data.total;
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const getArtistSongs = async (id, offset) => {
        await api
            .get(`/artists/${id}`, {
                params: {
                    offset: offset * 10,
                },
            })
            .then((res) => {
                if (res.status == 200) {
                    artist.value.songs = res.data.data.user.songs;
                    artist.value.name = res.data.data.user.name;
                    total.value = res.data.data.total;
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const getArtist = () => {
        return artist.value;
    };

    return { artists, total, getArtists, getArtistSongs, artist, getArtist };
});
