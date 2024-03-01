<template>
    <div v-if="editor.getTab('course-settings') == 'settings'" class="h-fit grid gap-3xl py-3xl lg:w-[727px]">
        <div class="grid gap-sm pb-3xl">
            <h1 class="font-semibold">Basic settings</h1>
            <p class="text-content-tertiary">
                Some general things about your course
            </p>
        </div>
        <div class="grid h-fit">
            <SmallText>Course name</SmallText>
            <input @input="draft('title', $event.target.value)" :value="course.title"
                class="border border-border-primary rounded-lg  text-start p-md  w-full ">
        </div>
        <div class="grid h-fit">
            <SmallText :Class="'text-nowrap'">Short description</SmallText>
            <textarea @input="draft('summary', $event.target.value)" :value="course.summary" rows="5"
                placeholder="Start writing something"
                class="rounded-lg relative px-xl pt-xl pl-md pb-md pr-xl border border-border-primary  w-full"></textarea>
        </div>

        <div class="grid  items-center w-full">
            <SmallText>Cover image</SmallText>
            <div class="w-full grid gap-lg">
                <input ref="cover" @change="draft_preview()" type="file" class="hidden" id="cover">
                <div class=" bg-background-accent-A-light flex justify-between px-lg py-md rounded-md">
                    <span>{{ previews.cover ?? getResource('cover').alt }}</span>
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

        <div class="grid h-fit">
            <SmallText>Course sign up link</SmallText>
            <input @input="draft('signup_link', $event.target.value)" :value="course.signup_link"
                class="border border-border-primary rounded-lg  text-start p-md  w-full ">
        </div>

        <div class="grid  items-center">
            <SmallText>Course overview video
            </SmallText>
            <div class="w-full grid gap-lg">
                <input ref="overview" @change="draft_preview()" type="file" class="hidden" id="overview">
                <div class=" bg-background-accent-A-light flex justify-between px-lg py-md rounded-md">
                    <span>{{ previews.overview ?? getResource('overview').alt }}</span>
                    <div class="flex gap-md items-center ">
                        <Upload></Upload>
                        <Close></Close>
                    </div>
                </div>
                <label for="overview"
                    class="cursor-pointer p-xl border border-dashed rounded-md grid place-content-center place-items-center text-center gap-md bg-background-secondary">
                    <img class="w-[48px] h-[48px] " src="@/assets/images/minisample.png" alt="">
                    <SmallText :font="'semibold'">Drag and drop or click here</SmallText>
                    <SmallText :font="'regular'">Recommended image size 1920x1080px</SmallText>
                </label>
            </div>
        </div>


        <div class="grid  items-center">
            <SmallText>Teaser videos</SmallText>
            <div class="w-full grid gap-lg">
                <input ref="teaser" @change="draft_preview()" type="file" class="hidden" id="teaser">
                <div class=" bg-background-accent-A-light flex justify-between px-lg py-md rounded-md">
                    <span>{{ previews.teaser ?? getResource('teaser').alt }}</span>
                    <div class="flex gap-md items-center ">
                        <Upload></Upload>
                        <Close></Close>
                    </div>
                </div>
                <label for="teaser"
                    class="cursor-pointer p-xl border border-dashed rounded-md grid place-content-center place-items-center text-center gap-md bg-background-secondary">
                    <img class="w-[48px] h-[48px] " src="@/assets/images/minisample.png" alt="">
                    <SmallText :font="'semibold'">Drag and drop or click here</SmallText>
                    <SmallText :font="'regular'">Recommended image size 1920x1080px</SmallText>
                </label>
            </div>
        </div>
    </div>

    <div v-if="editor.getTab('course-settings') == 'levels'">
        <editor-level-settings @currentLevels="$emit('currentLevels', $event)"></editor-level-settings>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import router from '@/router';
import { useEditorStore } from '@/stores/editor';


import Close from '@/components/icons/close.vue';
import Upload from '@/components/icons/upload.vue';
import SmallText from '@/components/modules/smallText.vue';

import editorLevelSettings from "@/components/chunks/editor-level-settings.vue"

const props = defineProps({
    course: Object
})

const emits = defineEmits(['currentLevels'])
const editor = useEditorStore();
const course = ref(props.course ?? {});


const cover = ref('')
const overview = ref('')
const teaser = ref('')

const previews = ref({})

function draft_preview() {
    if (cover.value.files != undefined && cover.value.files.length > 0) {
        previews.value.cover = cover.value.files[0].name
        draft('cover', cover.value.files[0])
    }
    if (overview.value.files != undefined && overview.value.files.length > 0) {
        previews.value.overview = overview.value.files[0].name
        draft('overview', overview.value.files[0])
    }
    if (teaser.value.files != undefined && teaser.value.files.length > 0) {
        previews.value.teaser = teaser.value.files[0].name
        draft('teaser', teaser.value.files[0])
    }
}

function draft(key, value) {
    editor.drafts.course[key] = value
}


function getResource(title) {
    if (!course.value.resources) {
        return {};
    }
    let resource = {};
    course.value.resources.map((v) => {
        if (v.title === title) {
            resource = v;
        }
    })
    return resource;
}
</script>