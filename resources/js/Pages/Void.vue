<script setup>
    const getImageUrl = (filename) => {
        return `/storage/${filename}`;
    }
</script>

<template>
    <div class="w-[150px] flex flex-col items-center m-auto" >
        <p>開発中でチュ</p>
        <img :src="getImageUrl('logo.jpeg')" alt="Example Image">
    </div>
</template>