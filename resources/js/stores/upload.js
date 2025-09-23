import api from '@/api/axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useUploadStore = defineStore('upload', () => {
    const file = ref();
    const getFile = () => {
        return file.value;
    };
    const setFile = (value) => {
        file.value = value;
    };

    const uploadStatus = ref(false);
    const getUploadStatus = () => {
        return uploadStatus.value;
    };
    const setUploadStatus = (value) => {
        uploadStatus.value = value;
    };

    const uploadProgress = ref(0);
    const getUploadProgress = () => {
        return uploadProgress.value;
    };
    const setUploadProgress = (value) => {
        uploadProgress.value = value;
    };

    async function upload(file, type) {
        return await api
            .post('/upload', file, {
                params: {
                    type: type,
                },
                onUploadProgress: (event) => {
                    if (event.total) {
                        uploadProgress.value = Math.round(
                            (event.loaded * 100) / event.total,
                        );
                    }
                },
            })
            .then((res) => {
                if (res.status == 200) {
                    return res.data.data.file_url;
                }
            })
            .catch((err) => {
                console.log(err);
                return null;
            });
    }

    return {
        getFile,
        setFile,
        getUploadStatus,
        setUploadStatus,
        getUploadProgress,
        setUploadProgress,
        upload,
    };
});
