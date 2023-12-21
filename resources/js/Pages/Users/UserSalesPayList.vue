<script setup>
import { ref, watch} from 'vue';
import axios from 'axios';
const props = defineProps(['modelValue']);

const userData = ref(props.modelValue);

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
                    <div class="w-full mx-auto overflow-auto h-[500px]">
                        <table class="table-auto w-full text-left whitespace-no-wrap  relative">
                            <thead class="sticky top-[-1px] left-0 right-0">
                                <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl w-3/12 border">店舗</th>
                                    <th class="px-4 py-3 title-font t my-autoracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-3/12 border">日時</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rou-br w-3/12 border">金額</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rou-br w-1/12 border"></th>
                                </tr>
                            </thead>
                            <tbody class="overflow-hidden">
                                <tr v-if="modelValue" v-for="(sale, index) in modelValue.sale" :key="index">
                                    <td class="px-4 py-2 border">{{ sale.store.store_name }}</td>
                                    <td class="px-4 py-2 border">{{ formatData(sale.created_date) }}</td>
                                    <td class="px-4 py-2 border">{{ pricePrefix(sale.customer_payment) }}円</td>
                                    <td class="px-2 py-1 border ">
                                        <div class="bg-yellow-300 w-full text-center rounded">
                                            <button @click="onUpdate(sale.id)" class="rounded text-black" >編集</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
    </div>
</template> 