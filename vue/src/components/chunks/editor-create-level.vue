<template>
    <div class="fixed top-0 right-0 h-full w-full grid place-content-center bg-background-overlay">
        <form @submit.prevent="create()" class=" bg-background-primary p-2xl rounded-md grid gap-xl lg:w-[560px]">
            <div class="grid gap-sm pb-3xl">
                <h1 class="font-semibold text-xl">Create user level</h1>
            </div>

            <div class="grid h-fit">
                <smallTextVue :text="'sm'" :font="'medium'">User level name</smallTextVue>
                <input v-model="form.title" class="border border-border-primary rounded-lg  text-start p-md  w-full ">
            </div>

            <div class="grid h-fit gap-lg">
                <smallTextVue :text="'sm'" :font="'medium'">User level benefits</smallTextVue>
                <div v-for="(v, i) in form.benefits" :key="i" class="w-full relative gap-md">
                    <span class="pl-lg absolute left-0 w-fit grid place-content-center h-full font-semibold">{{ i + 1
                    }}</span>
                    <input v-model="form.benefits[i]"
                        class="border border-border-primary rounded-lg  text-start px-3xl py-md  w-full text-content-secondary">
                </div>
                <!-- 8px, 12px, 8px, 12px -->
            </div>

            <span @click="form.benefits.push('')" class=" cursor-pointer underline text-content-tertiary">+ Add more</span>

            <div class="flex justify-end gap-lg">
                <div class="w-fit" @click="$emit('close')">
                    <Button :type="'button'" :width="'w-fit'"
                        :classnames="'!bg-transparent border border-border-primary text-nowrap'" :text="'content-tertiary'">
                        <template v-slot:text>
                            cancel
                        </template>
                    </Button>
                </div>
                <Button :type="'submit'" :width="'w-fit'"
                    :classnames="'!bg-background-accent-A border border-border-primary text-nowrap'"
                    :text="'content-inverse-primary'">
                    <template v-slot:text>
                        create
                    </template>
                </Button>
            </div>
        </form>
    </div>
</template>


<script setup>

import router from '@/router';
import { ref } from 'vue';
import axios from 'axios';
import { useEditorStore } from '@/stores/editor';

import smallTextVue from '../modules/smallText.vue';
import Button from '@/components/modules/button.vue';

const emits = defineEmits(['close', 'added'])
const editor = useEditorStore();

const form = ref({
    benefits: []
});

function create() {
    const payload = Object.assign(form.value, { course_id: editor.getCurrentCourse.id })
    axios.post('/admin/levels/store', payload).then((e) => {
        emits('added', e.data.data)
    }).catch((e) => {
        console.log(e)
    })
}
</script>