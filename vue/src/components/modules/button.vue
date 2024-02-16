<template>
    <button
        :class="(width ?? 'lg:min-w-[376px] w-full') + ' h-fit bg-background-accent-B flex justify-center items-center rounded-lg gap-md text-start py-md px-xl ' + (classnames)">
        <spinner v-if="load"></spinner>
        <slot v-else name="icon"></slot>
        <span class="text-content-inverse-primary ">
            <slot name="text"> </slot>
        </span>
    </button>



    <div>

    </div>
</template>

<script setup>
import spinner from "@/components/icons/spinner.vue"

defineProps({
    load: Boolean,
    width: String,
    classnames: String
})
</script>