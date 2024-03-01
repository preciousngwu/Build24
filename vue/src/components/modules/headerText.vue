<template>
    <div :class="'w-fit font-' + (font ?? 'semibold') + ' leading-xl text-2xl text-' + (color ?? 'content-primary') + ' '">
        <slot></slot>
    </div>
</template>

<script setup>
defineProps({
    font: String,
    color: String
})
</script>   