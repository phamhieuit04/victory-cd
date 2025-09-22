import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useLoadingStore = defineStore('loading', () => {
    const isLoading = ref(false);

    const getLoadingState = () => {
        return isLoading.value;
    };
    const setLoadingState = (state) => {
        isLoading.value = state;
    };

    return { getLoadingState, setLoadingState, isLoading };
});
