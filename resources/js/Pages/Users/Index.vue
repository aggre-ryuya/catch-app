<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
  user: Object,
})

const formatNumber = (value) => {
  return new Intl.NumberFormat().format(value);
}

</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ user.name }}</h2>
    </template>

    <div class="py-12">
      <div class="max-w-10 mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
              <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">売上</h1>
              </div>
              <div class="lg:w-2/3 w-full mx-auto">

                <div class="scroll-box">
                  <div class="table-header">
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                      <thead>
                        <tr>
                          <th
                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                            店舗名</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">日時
                          </th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">金額
                          </th>
                        </tr>
                      </thead>
                    </table>
                  </div>

                  <div class="table-body overflow-y-auto max-h-200">
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                      <tbody>
                        <tr v-for="sale in user.sale" :key="sale.id">
                          <td class="px-4 py-3">{{ sale.stores_id }}</td>
                          <td class="px-4 py-3">{{ sale.formatted_created_at }}</td>
                          <td class="px-4 py-3">{{ formatNumber(sale.customer_payment) }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<style scoped>
.scroll-box {
  width: 100%;
  overflow-x: auto;
  overflow-y: hidden;
  /* 初期状態では縦方向のスクロールバーを非表示にする */
}

.scroll-box:hover {
  overflow-y: auto;
  /* ホバー時に縦方向のスクロールバーを表示する */
}

.table-header table,
.table-body table {
  table-layout: fixed;
  /* テーブルの横幅を固定する */
}

.table-header th,
.table-body td {
  white-space: nowrap;
  text-align: left;
  padding: 8px;
  /* border: 1px solid #ddd; Optional: Add borders for better visibility */
}

.table-header {
  position: sticky;
  top: 0;
  background-color: #fff;
  /* Optional: ヘッダーの背景色を指定 */
  z-index: 1;
  /* Optional: ヘッダーを他の要素の上に表示 */
}

.table-body {
  max-height: 200px;
  /* ボディの最大高さを指定 */
  overflow-y: auto;
  /* 縦方向のスクロールを有効にする */
}</style>
