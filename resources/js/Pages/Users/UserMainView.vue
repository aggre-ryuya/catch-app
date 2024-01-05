<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';

import UserPayForm from '@/Pages/Users/UserPayForm.vue';
import UserSalesPayList from '@/Pages/Users/UserSalesPayList.vue';
import UserSalary from '@/Pages/Users/UserSalary.vue';

import axios from 'axios';
const props = defineProps({
  User: Object,
  Stores: Object,
});
onMounted(() => {
  fetchData()
});

const modelValue = ref(null);
const editSale = ref(null);

const storePay = ref([])
// saleデータを格納
props.User.sale.forEach(user => {
    storePay.value.push(user)
});

const fetchData = async () => {
  try {
    const response = await axios.get(`/user/salePayList/${props.User.id}`);
    modelValue.value = response.data;
  } catch (error) {
    console.error(error);
  }
};

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

    <div class="lg:w-4/5 w-full py-5 mt-10 mx-auto h-[850px] shadow-lg rounded bg-white sm:rounded-lg">
      <p class="sm:text-2xl text-3xl ml-5 font-bold">売上入力</p>
      <div class="flex flex-wrap justify-around"> <!-- flex-wrap を追加 -->
        <div class="w-full sm:w-7/12 mb-4"> <!-- w-full を追加 -->
          <user-sales-pay-list
            v-model="modelValue"
            @sale-update="handleSaleUpdate"
          >
          </user-sales-pay-list>
        </div>
        <div class="w-full sm:w-4/12  bg-white">
          <user-pay-form
            :Stores="props.Stores"
            :User="props.User"
            :EditSale="editSale"
            @sale-created="saleCreated"></user-pay-form>
        </div>
      </div><!-- flex -->
      <div class="w-full bg-white pb-10">
        <p class="sm:text-2xl text-3xl ml-5 mb-5 font-bold">売上トータル</p>
          <user-salary
            v-model="modelValue"
            :User="props.User"
            :Stores="props.Stores"
          >
          </user-salary>
          </div>
    </div>
  </AuthenticatedLayout>
</template> 