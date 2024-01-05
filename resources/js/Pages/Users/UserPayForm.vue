<script setup>
import { reactive, computed, ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    User: Object,
    Stores: Object,
    EditSale: Object
});

const userSale = reactive({
    stores_id: '',
    created_date: '',
    customer_payment: '',
});

const condition = ref(true);

// 編集アイテムの検知
watch(() => props.EditSale, (newVal) => {
    userSale.stores_id = newVal.stores_id;
    userSale.created_date = formatDateTime(newVal.updated_at);
    userSale.customer_payment = newVal.customer_payment;

    condition.value = false;
});


const formatDateTime = (dateTime) => {
    // JavaScriptのDateオブジェクトを作成
    const dateObject = new Date(dateTime);

    // 年月日の取得
    const year = dateObject.getFullYear();
    const month = String(dateObject.getMonth() + 1).padStart(2, "0");
    const day = String(dateObject.getDate()).padStart(2, "0");

    // 形式に変換
    return `${year}-${month}-${day}`;
}

// 編集をクリアする（登録へ戻す）
const onClear = () => {
    initUserSale();
    condition.value = !condition.value;
}



// イベントUP
const emit = defineEmits(['sale-created']);

// formの入力検知
const allInputsFilled = computed(() => {
    return [userSale.stores_id, userSale.date, userSale.customer_payment].every(value => value !== '');
});

// 登録
const onCreate = () => {
    userSale.users_id = props.User.id;
    axios.post('/user/storePay/', userSale)
    .then(res => {
        emit('sale-created');
        initUserSale();
    })
    .catch(err => {
        console.log(err);
    })
}

// 更新
const onUpdate = (id) => {
    userSale.id = props.EditSale.id;
    userSale.users_id = props.EditSale.users_id;

    axios.post('/userPay/userSaleUpdate/', userSale)
    .then(res => {
        initUserSale();
        emit('sale-created');
    })
    .catch(err => {
        console.log(err);
    })
}

// 初期化関数
const initUserSale = () => {
    userSale.stores_id = '';
    userSale.created_date = '';
    userSale.customer_payment = '';
}

const onBackupState = () => {
      window.history.back();
}

// 日付整形関数
const formatData = (dateString) => {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
}
</script>

<template>
    <section class=" text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto ">
            <form @:submit.prevent class="max-w-md mx-auto">
                <div class="relative z-0 w-full mb-10 group">
                    <label for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">店舗選択</label>
                    <select id="countries" v-model="userSale.stores_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="store in props.Stores" :key="store.id" :value="store.id"
                            selected>{{ store.store_name }}
                        </option>
                    </select>
                </div>
                <div class="relative z-0 w-full mb-10 group">
                    <input type="date" name="created_date" id="created_date" v-model="userSale.created_date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bgstore_number-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required />
                    <label for="created_date" class="peer-focus:font-
                     absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">日付</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input v-model="userSale.customer_payment" type="text" name="pay" id="pay" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="pay" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">金額</label>
                </div>
                <div class="flex justify-end">
                    
                <div v-if="condition">
                    <button @click="onCreate"
                            :disabled="!allInputsFilled"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :class="{ 'bg-gray-400 cursor-not-allowed': !allInputsFilled }">
                        登録
                    </button>
                </div>

                <div v-else>
                    <button @click="onUpdate"
                            :disabled="!allInputsFilled"
                            class="text-white bg-yellow-300 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :class="{ 'bg-gray-400 cursor-not-allowed': !allInputsFilled }">
                        編集
                    </button>
                    <button @click="onClear"
                            :disabled="!allInputsFilled"
                            class=" text-white bg-yellow-300 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full ml-5 sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :class="{ 'bg-gray-400 cursor-not-allowed': !allInputsFilled }">
                        クリア
                    </button>
                </div>
                    <button @click="onBackupState" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-5">戻る</button>
                </div>
            </form>
        </div>
    </section>
</template> 