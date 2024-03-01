<template>
    <div class="fixed top-0 right-0 h-full w-full grid place-content-center bg-background-overlay">
        <div class=" bg-background-primary p-2xl rounded-md grid gap-xl">
            <div class="flex gap-xl">
                <slot name="icon"></slot>

                <div class="grid gap-sm">
                    <p class="font-semibold text-md">
                        <slot name="title"></slot>
                    </p>
                    <p class="font-regular text-content-secondary text-sm">
                        <slot name="content"></slot>
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-lg">
                <div @click="$emit('cancel')" class="w-fit">
                    <ButtonVue :width="'w-fit'" :classnames="'bg-transparent border border-border-primary'">
                        <template v-slot:text>
                            <smallText>
                                Cancel
                            </smallText>
                        </template>
                    </ButtonVue>
                </div>
                <div @click="$emit('accept')" class="w-fit">
                    <ButtonVue :width="'w-fit'" :classnames="' bg-background-danger'">
                        <template v-slot:text>
                            <smallText :color="'content-inverse-primary'">
                                <slot name="accept"></slot>
                            </smallText>
                        </template>
                    </ButtonVue>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ButtonVue from '@/components/modules/button.vue';
import smallText from '@/components/modules/smallText.vue';

const emits = defineEmits(['cancel', 'accept'])

</script>