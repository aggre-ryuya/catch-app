<script setup>
import { ref, onMounted } from 'vue';
import PButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    userDetail: Object,
})

const userData = ref(props.userDetail);

const today = new Date();
const yearMonth = today.getFullYear() + "/" + (today.getMonth() + 1) + "/" + today.getDate();

// 月、日の0パディング
const formatData = (dateString) => {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}/${month}/${day}`;
}

const onBackupState = () => {
      window.history.back();
}

console.log(userData.value);

</script>

<template>
    <div class="py-12">
        <div class="max-w-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-10 mx-auto ">

                        <div class="flex flex-col text-center w-full mb-5">
                            <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">{{ yearMonth }}</h1>
                        </div>

                        <div class="lg:w-2/3 w-full mx-auto overflow-auto h-[500px]">
                            <table class="table-auto w-full text-left whitespace-no-wrap  relative">
                                <thead class="sticky top-[-1px] left-0 right-0">
                                    <tr>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl w-3/12 border">店舗</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-3/12 border">日時</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rou-br w-3/12 border">金額</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rou-br w-1/12 border"></th>
                                    </tr>
                                </thead>
                                <tbody class="overflow-hidden">
                                    <tr v-for="(sale, index) in userData.sale" :key="index">
                                        <td class="px-4 py-3 border">{{ sale.store.store_name }}</td>
                                        <td class="px-4 py-3 border">{{ formatData(sale.updated_at) }}</td>
                                        <td class="px-4 py-3 border">{{ sale.customer_payment }}</td>
                                        <td class="px-4 py-3 border"><p-button class="bg-yellow-300 text-black" >編集</p-button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="lg:w-2/3 w-full mx-auto mt-4 flex justify-end">
                            <p-button @click="onBackupState" class="bg-gray-400  hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-600 mr-5">戻る</p-button>
                            <p-button class="bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900">登録</p-button>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
</template> 