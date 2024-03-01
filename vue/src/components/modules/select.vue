<template>
    <div :class="'relative ' + (width ?? 'lg:min-w-[148px] w-full')">
        <select
            :class="'w-full appearance-none  h-fit bg-' + (bg ?? 'transparent') + ' flex justify-center items-center rounded-lg gap-md text-start py-md px-xl relative border border-border-primary ' + (classnames ?? '')">
            <option selected disabled>
                <slot name="disabled"></slot>
            </option>
            <slot name="option"></slot>
        </select>
        <div class="absolute top-0 z-50 right-3 h-full w-fit flex flex-col justify-center">
            <arrowDown></arrowDown>
        </div>
    </div>
</template>

<script setup>
import arrowDown from "@/components/icons/arrow-down.vue"

defineProps({
    load: Boolean,
    width: String,
    classnames: String,
    text: String,
    font: String,
    bg: String
})
</script>