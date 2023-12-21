<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    users: Array,
})


const search = ref(null);

/**
 * 価格を3桁ごとのカンマ付きで返す
 * @param {number} price 価格
 */
 function pricePrefix(price) {

return Number(price).toLocaleString()
}

</script>

<template>
    <Head title="ユーザ一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ユーザー覧</h2>
            <Link :href="route('user.Create')" >登録</Link>
        </template>

        <div class="lg:py-5 sm:py-2">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <section class="text-gray-600 body-font overflow-hidden">
                        <div class="my-5 flex items-center justify-center">
                            <div class="flex xl:flex-nowrap md:flex-nowrap lg:flex-wrap flex-wrap justify-center items-center md:justify-start">
                                <!-- <div class="relative w-40 sm:w-auto xl:mr-4 lg:mr-0 sm:mr-4 mr-2">
                                    <input v-model="search" type="text" id="footer-field" name="footer-field" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div> -->
                                <!-- <Link :href="route('users.index')" :data="{ search: search }" class="lg:mt-2 xl:mt-0 flex-shrink-0 inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded" >検索</Link>
                                <p>{{ search }}</p> -->
                            </div>
                        </div>


                        <div class="flex flex-wrap -m-4"    >
                            <div v-for="user in users" :key="user.id" class="p-10 xl:w-4/12 md:w-1/2 w-full mx-auto">

                                <div class="h-full p-6 rounded-lg border-2 border-gray-300 flex flex-col relative overflow-hidden">
                                    <h1 class="text-2xl text-gray-900 pb-4 mb-4 border-b border-gray-200 leading-none">{{user.name}}</h1>
                                    <p v-for="(value, storeName) in user.store_pay" :key="storeName" class="flex items-center text-gray-600 mb-2">
                                            <span  class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">
                                                <path v-if="user.store.store_name === storeName" d="M20 6L9 17l-5-5"></path>
                                            </svg>
                                            </span>
                                            {{storeName}}：{{pricePrefix(value)}}円
                                    </p>
                                    <Link :href="route('user.show', {userId: user.id})" class="flex items-center mt-auto text-white bg-gray-400 border-0 py-2 px-4 w-full focus:outline-none hover:bg-gray-500 rounded">詳細へ
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-auto" viewBox="0 0 24 24">
                                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                                        </svg>
                                    </Link>
                                </div>

                            </div>
                            
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>