<template>
    <textarea
        :class="(classnames ?? '') + ' rounded-lg relative px-xl pt-xl pl-md pb-md pr-xl border border-border-primary ' + (width ?? 'lg:min-w-[148px] w-full ')"
        :rows="rows ?? 5"></textarea>
    <slot> </slot>
</template>
<script setup>
defineProps({
    width: String,
    text: String,
    font: String,
    bg: String,
    rows: Number,
    classnames: String
})
</script>