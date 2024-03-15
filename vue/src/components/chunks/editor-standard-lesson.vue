<template>
    <div v-if="!_.isEmpty(editor.drafts.sections[selected.section].lessons[selected.lesson])"
        class="grid w-full gap-lg">
        <div class="grid gap-sm pb-3xl">
            <h1 class="font-semibold">Edit lesson</h1>
            <p class="text-content-tertiary">A section provides a way to manage your content and permissions
            </p>
        </div>

        <div class="grid items-center w-full">
            <div class=" grid gap-lg">
                <input @change="draft_preview()" ref="lesson_video" type="file" class="hidden" id="lesson_video">
                <div class=" bg-background-accent-A-light flex justify-between px-lg py-md rounded-md">
                    <span> {{ preview ?? getLessonVideo }}</span>
                    <div class="flex gap-md items-center">
                        <Upload></Upload>
                        <Close></Close>
                    </div>
                </div>
                <label for="lesson_video"
                    class="cursor-pointer p-xl border border-dashed rounded-md grid place-content-center place-items-center text-center gap-md bg-background-secondary">
                    <img class="w-[48px] h-[48px] " src="@/assets/images/minisample.png" alt="">
                    <SmallText :font="'semibold'">Drag and drop or click here</SmallText>
                    <SmallText :font="'regular'">Recommended image size 1920x1080px</SmallText>
                </label>
            </div>
        </div>

        <!-- @input="draft('title', $event.target.value)" :value="editor.drafts.sections[props.section].title" -->
        <div class="grid h-fit">
            <SmallText>Embeddable URL</SmallText>
            <input
                @input="editor.drafts.sections[selected.section].lessons[selected.lesson].content.embedded_url = $event.target.value"
                :value="editor.drafts.sections[selected.section].lessons[selected.lesson].content.embedded_url"
                class="border border-border-primary rounded-lg  text-start p-md  w-full ">
        </div>
        <div class="grid h-fit">
            <SmallText>Video title</SmallText>
            <input
                @input="editor.drafts.sections[selected.section].lessons[selected.lesson].content.title = $event.target.value"
                :value="editor.drafts.sections[selected.section].lessons[selected.lesson].content.title"
                class="border border-border-primary rounded-lg  text-start p-md  w-full ">
        </div>

        <div class="grid h-fit">
            <SmallText :Class="'text-nowrap'">Video description</SmallText>
            <textarea
                @input="editor.drafts.sections[selected.section].lessons[selected.lesson].content.description = $event.target.value"
                :value="editor.drafts.sections[selected.section].lessons[selected.lesson].content.description" rows="5"
                class="rounded-lg relative px-xl pt-xl pl-md pb-md pr-xl border border-border-primary "></textarea>
        </div>

        <div class="grid h-fit relative">
            <SmallText :Class="'text-nowrap'">Select User level</SmallText>
            <div class="relative w-full">
                <div v-if="!_.isEmpty(editor.drafts.sections[selected.section].lessons[selected.lesson].levels)"
                    class="bg-white rounded-tl-lg rounded-bl-lg max-w-[80%] absolute top-0 border-y border-l border-border-primary h-full overflow-y-auto flex gap-4 flex-wrap py-sm px-md cursor-pointer">
                    <div v-for="(v, i) in editor.drafts.sections[selected.section].lessons[selected.lesson].levels"
                        :key="i" class="bg-background-accent-A-light flex items-center px-sm py-xs rounded-md gap-sm">
                        <span class="text-content-accent-A text-xs">{{ v.title }}</span>
                        <div class="p-md"
                            @click="editor.removeLevel(v.id, editor.drafts.sections[selected.section].lessons[selected.lesson])">
                            <Close :fill="'#3B82F6'" :width="8" :height="8"></Close>
                        </div>
                    </div>
                </div>
                <select v-model="config.current_level"
                    @change="editor.pushLevel($event.target.value, editor.drafts.sections[selected.section].lessons[selected.lesson]); config.current_level = 0"
                    class=" focus-visible:outline-0  border border-border-primary rounded-lg p-md w-full cursor-pointer"
                    name="" id="">
                    <option value="0" selected disabled> user level </option>
                    <option v-for="(v, i) in editor.getCurrentCourse.levels" :key="i" :value="v.id">
                        {{ v.title }}
                    </option>
                </select>
            </div>
        </div>

        <div class="grid h-fit">
            <SmallText>Users can take stamp notes</SmallText>
            <input
                @click="editor.drafts.sections[selected.section].lessons[selected.lesson].content.config ? editor.drafts.sections[selected.section].lessons[selected.lesson].content.config.notes = $event.target.checked : editor.drafts.sections[selected.section].lessons[selected.lesson].content.config = { notes: $event.target.checked }"
                :checked="getConfig ? getConfig.notes : false"
                class="border border-border-primary rounded-lg  text-start p-md  w-fit" type="checkbox">
        </div>

    </div>
</template>

<script setup>
import _ from 'lodash'

import SmallText from '@/components/modules/smallText.vue';
import Close from '@/components/icons/close.vue';
import Upload from '@/components/icons/upload.vue';

import { useEditorStore } from '@/stores/editor';
import { computed, onBeforeMount, onMounted, ref } from 'vue';

const config = ref({
    current_level: 0
})
const editor = useEditorStore();
const props = defineProps(['selected'])

const lesson_video = ref('')
const preview = ref(undefined)

const getLessonVideo = computed(() => {
    let video = ''
    if (!_.isArray(editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].resources)) {
        return video
    }
    editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].resources.map((v) => {
        if (v.title == 'lesson_video') {
            video = v.alt
        }
    })
    return video
})

const getConfig = computed(() => {
    return editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].content.config ?? undefined
})

function draft_preview() {
    if (lesson_video.value.files != undefined && lesson_video.value.files.length > 0) {
        preview.value = lesson_video.value.files[0].name
        editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].lesson_video = lesson_video.value.files[0]
    }
}
</script>