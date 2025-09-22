import { defineStore } from 'pinia';
import { ref } from 'vue';

export const usePagesStore = defineStore('pages', () => {
    const currentPage = ref(0);

    const setCurrentPage = (page) => {
        currentPage.value = page;
    };

    return { currentPage, setCurrentPage };
});
