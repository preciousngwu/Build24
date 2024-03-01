<template>
    <div class="fixed top-0 right-0 h-full w-full grid place-content-center bg-background-overlay">
        <form @submit.prevent="create()" class="bg-background-primary min-w-[843px] px-2xl rounded-md">
            <div class=" pt-2xl pb-xl">
                <HeaderText>Create new course</HeaderText>
            </div>

            <div class="grid gap-2xl py-2xl px-3xl">
                <div class="flex justify-between items-center">
                    <SmallText>Course name</SmallText>
                    <input v-model="form.title" class="border border-border-primary rounded-lg  text-start p-md w-[530px]">
                </div>

                <div class="flex justify-between items-center">
                    <SmallText>Cover image</SmallText>
                    <div class="w-[530px] grid gap-lg">
                        <input ref="cover" @change="getPreview()" type="file" class="hidden" id="cover">
                        <div v-if="preview != undefined"
                            class=" bg-background-accent-A-light flex justify-between px-lg py-md rounded-md">
                            <span>{{ preview }}</span>
                            <div class="flex gap-md items-center ">
                                <Upload></Upload>
                                <Close></Close>
                            </div>
                        </div>
                        <label for="cover"
                            class="cursor-pointer p-xl border border-dashed rounded-md grid place-content-center place-items-center text-center gap-md bg-background-secondary">
                            <img class="w-[48px] h-[48px] " src="@/assets/images/minisample.png" alt="">
                            <SmallText :font="'semibold'">Drag and drop or click here</SmallText>
                            <SmallText :font="'regular'">Recommended image size 1920x1080px</SmallText>
                        </label>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <SmallText>Course sign up link</SmallText>
                    <input v-model="form.signup_link"
                        class="border border-border-primary rounded-lg  text-start p-md w-[530px]">
                </div>

                <div class="flex justify-between items-center">
                    <SmallText :Class="'text-nowrap'">Lesson summary</SmallText>
                    <textarea v-model="form.summary" rows="5"
                        class="rounded-lg relative px-xl pt-xl pl-md pb-md pr-xl border border-border-primary  w-[530px]"></textarea>
                </div>
            </div>

            <div class="flex gap-md justify-end py-xl px-3xl">
                <div @click="$emit('close')">
                    <ButtonVue :type="'button'" :text="'content-tertiary'"
                        :classnames="'!bg-transparent border border-border-primary '" :width="'w-fit'">
                        <template v-slot:text>
                            Cancel
                        </template>
                    </ButtonVue>
                </div>
                <ButtonVue :type="'submit'" :text="'content-inverse-primary'"
                    :classnames="'!bg-background-accent-A border border-border-primary '" :width="'w-fit'">
                    <template v-slot:text>
                        Create
                    </template>
                </ButtonVue>
            </div>

        </form>
    </div>
</template>

<script setup>

import { ref } from 'vue';
import axios from 'axios';
import { useInteractStore } from "@/stores/interact"


import HeaderText from '@/components/modules/headerText.vue';
import SmallText from '@/components/modules/smallText.vue';
import InputVue from '@/components/modules/input.vue';
import textArea from '@/components/modules/text-area.vue';
import ButtonVue from '@/components/modules/button.vue';
import Upload from '../icons/upload.vue';
import Close from '../icons/close.vue';

const interactStore = useInteractStore();


const emits = defineEmits(['close', 'added']);

const form = ref({});
const cover = ref('')
const preview = ref(undefined)


const getPreview = () => {
    if (cover.value.files != undefined && cover.value.files.length > 0) {
        preview.value = cover.value.files[0].name
    }
}

function create() {

    const payload = new FormData();

    if (cover.value.files != undefined && cover.value.files.length > 0) {
        payload.append('cover', cover.value.files[0]);
    }

    for (const key in form.value) {
        payload.append(key, form.value[key])
    }

    axios.post("/admin/course/store", payload).then((e) => {
        emits('added', e.data.data);
        console.log(e)
        interactStore.notify({ alert: true, content: "course inserted" })

    }).catch((e) => {
        interactStore.notify({ alert: true, content: e.response.data.message })
    })
}

</script>