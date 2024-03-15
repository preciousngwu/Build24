<template>
    <div v-if="!_.isEmpty(selected)" class="flex flex-col h-full">

        <div class="flex px-3xl border-b border-border-primary">
            <div @click="config.tab = 'content'"
                :class="'p-xl  cursor-pointer ' + (config.tab == 'content' ? 'border-b-2 border-border-dark' : '')">
                Content
            </div>
            <div @click="config.tab = 'settings'"
                :class="'p-xl  cursor-pointer ' + (config.tab == 'settings' ? 'border-b-2 border-border-dark' : '')">
                Settings
            </div>
        </div>



        <div v-if="config.tab == 'content'" class="p-3xl h-full overflow-x-hidden">
            <standardLesson
                v-if="editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].type == 'standard'"
                :selected="selected"></standardLesson>
            <noteLesson
                v-if="editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].type == 'note'"
                :selected="selected">
            </noteLesson>
            <pdfLesson
                v-if="editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].type == 'pdf'"
                :selected="selected">
            </pdfLesson>

            <tableLesson
                v-if="editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].type == 'table'"
                :selected="selected">
            </tableLesson>
        </div>
        <div v-if="config.tab == 'settings' && selected != undefined" class="p-3xl overflow-y-auto">
            <lessonSetting :selected="selected"></lessonSetting>
        </div>
    </div>
</template>

<script setup>
import _ from "lodash"
import { useEditorStore } from '@/stores/editor';

// lessons
import noteLesson from "@/components/chunks/editor-note-lesson.vue"
import standardLesson from "@/components/chunks/editor-standard-lesson.vue"
import pdfLesson from "@/components/chunks/editor-pdf-lesson.vue"
import tableLesson from "@/components/chunks/editor-table-lesson.vue"


import lessonSetting from "@/components/chunks/editor-lesson-settings.vue"

import { ref } from "vue";

const props = defineProps(['selected'])
const editor = useEditorStore();


// console.log(editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].type)
const config = ref({
    tab: 'content'
});



</script>