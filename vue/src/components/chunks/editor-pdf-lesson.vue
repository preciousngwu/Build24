<template>
    <div v-if="!preview && !getLessonPdf" class="grid gap-[30px] w-full place-content-center place-items-center h-full overflow-y-auto">
        <input @change="getPdf()" ref="pdf" type="file" class="hidden" id="file">
        <Image :custom-class="'w-[177.64px]'" :src="'/src/assets/images/pdfupload.png'"></Image>

        <div class="grid gap-[16px] place-items-center">
            <headerText>Let’s build your PDF lesson</headerText>
            <smallText>You can upload a PDF and create the course structure</smallText>
            <label for="file" class=" cursor-pointer">
                <Button :isDiv="true" :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary '"
                    :text="'content-tertiary'">
                    <template v-slot:icon>  
                        <upload></upload>
                    </template>
                    <template v-slot:text>
                        Upload PDF
                    </template>
                </Button>
            </label>
        </div>
    </div>
    <div v-if="preview || getLessonPdf" class="h-full overflow-y-auto">
        <div class=" bg-background-overlay flex justify-end px-lg py-md rounded-t-md">
            <div class="flex gap-md items-center">
                <trash :stroke="'white'"></trash>
            </div>
        </div>
        <object class="h-full w-full" :data="preview ?? getLessonPdf">
            <a :href="preview ?? getLessonPdf">pdf file</a>
        </object>
    </div>
</template>

<script setup>
import _ from 'lodash'
import { ref, computed } from "vue"
import { useEditorStore } from '@/stores/editor';

import Image from '../modules/image.vue';
import headerText from '../modules/headerText.vue';
import smallText from '../modules/smallText.vue';
import Button from '../modules/button.vue';
import upload from '../icons/upload.vue';
import trash from "../icons/trash.vue";

const props = defineProps(['selected'])
const editor = useEditorStore();

const pdf = ref(undefined)
const preview = ref(undefined)


const getLessonPdf = computed(() => {
    let pdf = undefined
    if (!_.isArray(editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].resources)) {
        return pdf
    }
    editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].resources.map((v) => {
        if (v.title == 'lesson_pdf') {
            pdf = v.link
        }
    })
    return pdf
})


function getPdf() {
    if (pdf.value.files != undefined && pdf.value.files.length > 0) {
        preview.value = URL.createObjectURL(pdf.value.files[0])
        editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].lesson_pdf = pdf.value.files[0]
    }
}
</script>