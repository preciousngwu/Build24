<template>
    <svg @mouseover="fillable = 'white'" @mouseout="fillable = '#9CA3AF'" width="14" height="16" viewBox="0 0 14 16"
        fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M7.00098 6C8.65783 6 10.001 4.65685 10.001 3C10.001 1.34315 8.65783 0 7.00098 0C5.34412 0 4.00098 1.34315 4.00098 3C4.00098 4.65685 5.34412 6 7.00098 6Z"
            :fill="fill ?? fillable" />
        <path
            d="M0.466147 12.4935C0.271263 13.0016 0.445325 13.571 0.875175 13.9046C2.56753 15.218 4.69299 16 7.00109 16C9.31154 16 11.439 15.2164 13.1322 13.9006C13.5618 13.5667 13.7355 12.9971 13.5403 12.4892C12.531 9.86354 9.98517 8 7.00404 8C4.02129 8 1.47427 9.86557 0.466147 12.4935Z"
            :fill="fill ?? fillable" />
    </svg>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    fill: String
})

const fillable = ref('#9CA3AF');
</script>