<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';

import UserDetail from './UserDetail.vue';
import UserPay from '@/Pages/Users/UserPay.vue';
import axios from 'axios';
const props = defineProps({
  User: Object,
  Stores: Object,
});

const modelValue = ref(null);
const editSale = ref(null);

const fetchData = async () => {
  try {
    const response = await axios.get(`/userPay/getUser/${props.User.id}`);
    modelValue.value = response.data;
  } catch (error) {
    console.error(error);
  }
};
onMounted(fetchData);

const saleCreated = () => {
  fetchData();
}

const handleSaleUpdate = (dataFromChild) => {
    editSale.value = dataFromChild;
}

</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ User.name }}</h2>
    </template>
    
    <div class="lg:w-4/5 w-full py-5 mt-10 mx-auto shadow-lg rounded bg-white sm:rounded-lg">
    <div class="flex flex-wrap justify-around"> <!-- flex-wrap を追加 -->

        <div class="w-full sm:w-7/12 mb-4"> <!-- w-full を追加 -->
            <user-detail v-model="modelValue" @sale-update="handleSaleUpdate"></user-detail>
        </div>

        <div class="w-full sm:w-4/12 " style="order: -1;">
            <user-pay :Stores="props.Stores" :User="props.User" :EditSale="editSale" @sale-created="saleCreated"></user-pay>
        </div>

    </div><!-- flex -->
</div>

  </AuthenticatedLayout>
</template> 