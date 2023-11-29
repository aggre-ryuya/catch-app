<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    users: Array,
})
// console.log(props.users);

</script>

<template>
    <Head title="ユーザ一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ユーザー覧</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-col text-center w-full mb-20">
                                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Our Team</h1>
                            </div>


                            <div class="flex flex-wrap -m-2">
                                <div v-for="user in users" :key="user.id" class="p-2 lg:w-1/3 md:w-1/2 w-full">
                                    <Link :href="route('users.index')">
                                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg shadow-lg hover:bg-gray-100 transition duration-500 ease-in-out">
                                        <img alt="team" class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4" src="https://dummyimage.com/80x80">
                                        <div class="flex-grow">
                                            <h2 class="text-gray-900 title-font font-medium">{{user.name}}</h2>
                                        </div>
                                        </div>
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