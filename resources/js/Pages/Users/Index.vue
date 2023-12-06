<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';

import UserDetail from './UserDetail.vue';

const props = defineProps({
  user: Object,
});

</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ user.name }}</h2>
    </template>

      <user-detail :userDetail="props.user"></user-detail>
  
  </AuthenticatedLayout>
</template> 