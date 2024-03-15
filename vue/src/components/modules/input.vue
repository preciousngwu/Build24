<template>
    <div class="relative h-fit ">
        <div class="h-full w-fit absolute top-0 grid place-items-center left-lg">
            <slot name="start"></slot>
        </div>
        <div class="h-full w-fit absolute top-0 grid place-items-center right-lg">
            <slot name="end"></slot>
        </div>
        <input :disabled="disabled" @input="$emit('get', $event.target.value)"
            :class="`${width} ${classnames} ${border} disabled:border-none text-start py-md pr-lg pl-[40px] border rounded-lg`"
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
    disabled: {
        type: Boolean,
        default: false
    },
    width: {
        type: String,
        default: "lg:min-w-[378px] w-full"
    },
    height: {
        type: String,
        default: 'h-fit'
    },
    border: {
        type: String,
        default: 'border-border-primary'
    },
    classnames: String,
    value: String
})

</script>