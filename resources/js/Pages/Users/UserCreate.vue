<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed, watch, reactive } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import axios from 'axios';

const props = defineProps({
  Stores: Object,
});

const userDetail = reactive({
  name: '',
  stores_id: '',
  email: '',
  password: '',
  role: '0',
});


const message = ref(null);
const errors = ref({
  
});

// formの入力検知
const allInputsFilled = computed(() => {
    return [userDetail.name, userDetail.stores_id,userDetail.email, userDetail.password, userDetail.role].every(value => value !== '');
});

watch(() => allInputsFilled, () => {
  console.log(allInputsFilled);
});

const onCreate = () => {

  console.log(userDetail)
    axios.post('/user/userStore', userDetail)
    .then(res => {
      console.log(res.data);
      errors.value = {};
      message.value = res.data.message;
      console.log(message.value);
      setTimeout(() => {
        message.value = null;
      }, 3000);
    })
    .catch(err => {
        console.log(err.response.data.errors);
        errors.value = err.response.data.errors;
        console.log(errors.value);
    })
}
// formの入力検知
</script>
<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">ユーザー登録</h2>
    </template>
    <div v-if="message" class="toast-message">{{ message }}

    </div>
    <div class="lg:w-4/5 w-full py-5 mt-10 mx-auto shadow-lg rounded bg-white sm:rounded-lg">
      <section class=" text-gray-600 body-font">
        <div class="bg-white py-6 sm:py-8 lg:py-12">
          <div class="mx-auto max-w-screen-2xl px-4 md:px-8">

            <!-- form - start -->
            <form  @:submit.prevent class="mx-auto grid max-w-screen-md gap-4 sm:grid-cols-2">
              <div>
                <label for="first-name" class="mb-2 inline-block text-sm text-gray-800 sm:text-base">名前*</label>
                <input name="first-name" v-model="userDetail.name"
                  class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring" />
                  <p class="text-red-600" v-if="errors.name">{{ errors.name[0] }}</p>
              </div>

              <div class="sm:col-span-2">
                <label for="countries" class="mb-2 inline-block text-sm text-gray-800 sm:text-base">専属店舗</label>
                <select id="countries" v-model="userDetail.stores_id"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option v-for="store in props.Stores" :key="store.id" :value="store.id" selected>{{ store.store_name }}
                  </option>
                </select>
                <p class="text-red-600" v-if="errors.stores_id">{{ errors.stores_id[0] }}</p>
              </div>

              <div class="sm:col-span-2">
                <label for="email" class="mb-2 inline-block text-sm text-gray-800 sm:text-base">メールアドレス*</label>
                <input type="email" name="email" v-model="userDetail.email"
                  class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring" />
                <p class="text-red-600" v-if="errors.email">{{ errors.email[0] }}</p>
              </div>

              <div class="sm:col-span-2">
                <label for="subject" class="mb-2 inline-block text-sm text-gray-800 sm:text-base">パスワード*</label>
                <input type="password" name="subject" v-model="userDetail.password"
                  class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring" />
                  <p class="text-red-600" v-if="errors.password">{{ errors.password[0] }}</p>
              </div>
              

              <div class="sm:col-span-2">

                <div class="flex items-center mb-4">
                <input id="enabled-radio-1" type="radio" value="1" name="disabled-radio" v-model="userDetail.role"
                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="enabled-radio-1"
                  class="ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">あり</label>
              </div>

              <div class="flex items-center">
                <input checked id="disabled-radio-2" type="radio" value="0" name="disabled-radio" v-model="userDetail.role"
                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="disabled-radio-2"
                  class="ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">なし</label>
              </div>
              </div>
              


              <div class="flex ">

                <button
                  @click="onCreate"
                  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                  :class="{ 'bg-gray-400 cursor-not-allowed': !allInputsFilled }">
                  登録
                </button>

                <Link 
                  :href="route('UserLists')"
                  as="button"
                  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-5">
                  戻る
                </Link>
              </div>

            </form>
            <!-- form - end -->
          </div>
        </div>
      </section>

      <!-- </div>flex -->
    </div>

</AuthenticatedLayout>
</template>


<style scoped>
.toast-message {
  position: fixed;
  top: 10%;
  left: 0;
  right: 0;
  background-color: #99ccff; /* トーストの背景色 */
  color: white;
  padding: 16px;
  text-align: center;
  width: 50%;
  margin: 0 auto;
  border-radius: 10px;
}
</style>