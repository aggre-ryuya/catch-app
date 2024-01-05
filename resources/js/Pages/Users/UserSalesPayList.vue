<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
const props = defineProps({
    modelValue: Object
});

// 月、日の0パディング
const formatData = (dateString) => {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}/${month}/${day}`;
}
const emit = defineEmits(['sale-update']);

const onUpdate = (saleId) => {
    axios.get('/user/userSalePay/' + saleId)
        .then(res => {
            console.log(res.data)
            emit('sale-update', res.data);
        })
        .catch(err => {
            console.log(err);
        })
}

/**
 * 価格を3桁ごとのカンマ付きで返す
 * @param {number} price 価格
 */
function pricePrefix(price) {
    return Number(price).toLocaleString()
}
</script>

<template>
    <div class="max-w-10 mx-auto px-2">
        <section class="text-gray-600 body-font">
            <div class="container py-10 mx-auto ">

                <div class="w-full mx-auto overflow-auto h-[400px] ">

                    <table class=" border-2 table-auto w-full text-left whitespace-no-wrap relative ">

                        <thead class="sticky top-[-1px] left-0 right-0 overflow-auto">
                            <tr>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tl rounded-bl w-3/12 border">
                                    店舗</th>
                                <th
                                    class="px-4 py-3 title-font t my-autoracking-wider font-medium text-gray-900 text-sm bg-gray-200 w-3/12 border">
                                    日時</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tr rou-br w-3/12 border">
                                    金額</th>
                            </tr>
                        </thead>

                        <tbody class="overflow-hidden h-[100px]">
                            <tr v-if="modelValue" v-for="(sale, index) in modelValue.sale" :key="index"
                                @click="onUpdate(sale.id)"
                                class="rounded text-black cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <td class="px-4 py-2 border">{{ sale.store.store_name }}</td>
                                <td class="px-4 py-2 border">{{ formatData(sale.created_date) }}</td>
                                <td class="px-4 py-2 border">{{ pricePrefix(sale.customer_payment) }}円</td>
                            </tr>
                        </tbody>

                    </table>

                </div>
            </div>
        </section>
    </div>
</template> 