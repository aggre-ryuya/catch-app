<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';

const props = defineProps({
    User: Object,
    Stores: Object,
    modelValue: Object,
});

const totalPay = ref(null);
const mapData = ref({});

onMounted(() => {
  fetchData(props.User.id);
});

watch(() => props.modelValue, (newVal) => {
  fetchData(newVal.id);
});

watch(() => totalPay.value, (newVal) => {
  updateMapData(newVal);
});

const fetchData = async (userId) => {
  try {
    const response = await axios.get(`/user/totalpay/${userId}`);
    totalPay.value = response.data;
  } catch (error) {
    console.error(error);
  }
};

const updateMapData = (newVal) => {
  newVal.forEach(element => {
    const store = props.Stores.find(store => store.id === element.stores_id);
    if (store) {
      mapData.value[store.store_name] = element.total_payment;
    }
  });
};

/**
 * 価格を3桁ごとのカンマ付きで返す
 * @param {number} price 価格
 */
const  pricePrefix = (price) => {
    return Number(price).toLocaleString()
}
const maney = (pay) => {
  if(props.User.tax === '1'){
    return Math.floor(pay * (props.User.commission / 100));
  }else{
    return Math.floor((pay * 0.9) * (props.User.commission / 100));
  }
}
</script>

<template>
    <section class="text-gray-600 body-font">
        <div class="px-5 mx-auto">
            <table class="border-2 table-auto w-full text-left whitespace-no-wrap relative" style="table-layout: fixed; width: 100%;">
                <thead class="border-2 ">
                    <tr>
                        <th class="border py-4">店舗名</th>
                        <th class="border py-4">総売上</th>
                        <th class="border py-4">歩合金額</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(value, key) in mapData" :key="key" class="border-2">
                        <td  class=" border py-5">{{ key }}</td>
                        <td  class=" border py-5">{{ pricePrefix(value) }}円</td>
                        <td  class=" border py-5">{{ pricePrefix(maney(value)) }}円</td>
                    </tr>
                </tbody>
            </table>
            </div>
    </section>
</template> 