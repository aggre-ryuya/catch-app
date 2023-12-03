<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    users: Array,
})

</script>

<template>
    <AuthenticatedLayout>
      <h1>user.vue</h1>
    </AuthenticatedLayout>
</template>