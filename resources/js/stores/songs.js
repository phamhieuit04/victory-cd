import api from '@/api/axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useLoadingStore } from './loading';
import { useArtistsStore } from './artists';
import { usePagesStore } from './pages';
import { useUploadStore } from './upload';

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
        let thumbnail_url = await upload(thumbnail, 'thumbnail');
        if (thumbnail_url == null) {
            return;
        }
        await api
            .put(`/songs/${id}`, {
                name: name,
                thumbnail_url: thumbnail_url,
            })
            .then((res) => {
                if (res.status == 200) {
                    fetchSongs(artistId);
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
    const upload = async (file, type) => {
        const uploadStore = useUploadStore();
        let uploadForm = new FormData();
        uploadForm.append('file', file);
        return await uploadStore.upload(uploadForm, type);
    };
    const postSong = async (songUrl, thumbnailUrl, songName, userId) => {
        let formData = new FormData();
        formData.append('name', songName);
        formData.append('user_id', userId);
        formData.append('song_url', songUrl);
        formData.append('thumbnail_url', thumbnailUrl);
        return await api
            .post('/songs', formData)
            .then((res) => {
                if (res.status == 200) {
                    return true;
                }
            })
            .catch((err) => {
                console.log(err);
                return false;
            });
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
        upload,
        postSong,
    };
});
