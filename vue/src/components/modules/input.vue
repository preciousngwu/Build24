<template>
    <div class="relative h-fit ">
        <div class="h-full w-fit absolute top-0 grid place-items-center left-lg">
            <slot name="start"></slot>
        </div>
        <div class="h-full w-fit absolute top-0 grid place-items-center right-lg">
            <slot name="end"></slot>
        </div>
        <input  @input="$emit('get', $event.target.value)"
            :class="(width ?? 'lg:min-w-[378px] w-full ') + (classnames ?? '') + ' text-start py-md pr-lg pl-[40px] border ' + (border ?? 'border-border-primary ') + '  rounded-lg ' + (height ?? 'h-fit ')"
            :type="type" :placeholder="placeholder" :id="id" :value="value">
    </div>
</template>

<script setup>
import { ref } from "vue";

const emits = defineEmits(['get']);

const props = defineProps({
    id: String,
    type: String,
    placeholder: String,
    width: String,
    height: String,
    border: String,
    classnames: String,
    value: String
})

</script>