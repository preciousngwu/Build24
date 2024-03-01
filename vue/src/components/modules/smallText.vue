<template>
    <p
        :class="(Class ?? '') + ' w-fit font-' + (font ?? 'regular') + ' leading-' + (line ?? 'sm') + ' text-' + (size ?? 'sm') + ' text-' + (color ?? 'content-secondary') + ' '">
        <slot></slot>
    </p>
</template>

<script setup>
defineProps({
    font: String,
    color: String,
    Class: String,
    size: String,
    line: String
})
</script>   