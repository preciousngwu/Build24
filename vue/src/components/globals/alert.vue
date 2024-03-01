<template>
    <div v-if="!error" @click="$emit('close')"
        class=" justify-between rounded-lg px-xl py-lg w-[429px] bg-background-success-light border border-border-success fixed top-10 right-10 z-50 flex items-center">
        <smallText :color="'content-success'" :text="'sm'" :font="'medium'">
            <slot></slot>
        </smallText>

        <close :fill="'#10B981'"></close>
    </div>

    <div v-if="error" @click="$emit('close')"
        class=" justify-between rounded-lg px-xl py-lg w-[429px] bg-background-warning-light border border-background-danger fixed top-10 right-10 z-50 flex items-center">
        <smallText :color="'background-danger'" :text="'sm'" :font="'medium'">
            <slot></slot>
        </smallText>

        <close :fill="'#EF4444'"></close>
    </div>
</template>

<script setup>
import smallText from '@/components/modules/smallText.vue';
import close from '@/components/icons/close.vue';


defineEmits(['close'])


defineProps({
    error: Boolean
})
</script>