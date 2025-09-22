import api from '@/api/axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useBillsStore = defineStore('bills', () => {
    const bills = ref([]);
    const total = ref(0);
    const getBills = async (offset) => {
        await api
            .get('/bills', {
                params: {
                    offset: offset * 10,
                },
            })
            .then((res) => {
                if (res.status == 200) {
                    bills.value = res.data.data.bills;
                    total.value = res.data.data.total;
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const updateBill = async (id) => {
        await api
            .put(`/bills/${id}`)
            .then((res) => {
                if (res.status == 200) {
                    console.log('Update thanh cong!');
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };

    return { bills, total, getBills, updateBill };
});
