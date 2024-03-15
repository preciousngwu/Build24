<template>
    <div v-if="isDiv"
        :class="(width ?? 'lg:min-w-[376px] w-full') + ' h-fit bg-background-accent-B flex justify-center items-center rounded-lg gap-md text-start py-md px-xl ' + (classnames ?? '')">
        <spinner v-if="load"></spinner>
        <slot v-else name="icon"></slot>
        <span :class="'text-' + (text ?? 'content-inverse-primary') + ' text-' + (font ?? 'sm')">
            <slot name="text"> </slot>
        </span>
    </div>

    <button v-else :type="type ?? 'button'"
        :class="(width ?? 'lg:min-w-[376px] w-full') + ' h-fit bg-background-accent-B flex justify-center items-center rounded-lg gap-md text-start py-md px-xl ' + (classnames ?? '')">
        <spinner v-if="load"></spinner>
        <slot v-else name="icon"></slot>
        <span :class="'text-' + (text ?? 'content-inverse-primary') + ' text-' + (font ?? 'sm')">
            <slot name="text"> </slot>
        </span>
    </button>
</template>

<script setup>
import spinner from "@/components/icons/spinner.vue"

defineProps({
    load: Boolean,
    width: String,
    classnames: String,
    text: String,
    font: String,
    type: String,
    isDiv: Boolean
})
</script>