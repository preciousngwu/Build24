<template>
    <div class="relative h-fit ">
        <div class="h-full w-fit absolute top-0 grid place-items-center left-lg">
            <slot name="start"></slot>
        </div>
        <div class="h-full w-fit absolute top-0 grid place-items-center right-lg">
            <slot name="end"></slot>
        </div>
        <input :autocomplete="'new-password'" @input="$emit('get', $event.target.value)"
            :class="(width ?? 'lg:min-w-[378px] w-full ') + ' py-md pr-lg pl-[40px] border border-border-primary  rounded-lg h-fit'"
            :type="type" :placeholder="placeholder" :id="id">
    </div>
</template>

<script setup>
import { ref } from "vue";

const emits = defineEmits(['get']);

const props = defineProps({
    id: String,
    type: String,
    placeholder: String,
    width: String
})

</script>