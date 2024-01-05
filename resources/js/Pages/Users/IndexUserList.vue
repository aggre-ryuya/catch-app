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
        <template #header >
            <div class="flex items-center justify-between" >
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">ユーザー覧</h2>
                <Link as="button" class="font-bold border-2 border-black rounded-lg p-2 " :href="route('user.Create')" >キャッチ登録</Link>
            </div>
        </template>

        <div class="lg:py-5 sm:py-2">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <section class="text-gray-600 body-font overflow-hidden">
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