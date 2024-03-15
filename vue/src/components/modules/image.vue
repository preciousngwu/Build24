<template>
    <img :class="`${customClass}`" :src="`${src}`">
</template>

<script setup>
defineProps({
    src: String,
    customClass: String
})
</script>