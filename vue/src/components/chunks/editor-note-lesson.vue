<template>
    <div class="editor">
        <QuillEditor @ready="setContent()" ref="quill" @update:content="getElement($event)" theme="snow"
            :modules="modules" :toolbar="toolbar">
        </QuillEditor>
    </div>

</template>

<script setup>
import { ref } from 'vue';
import { useEditorStore } from '@/stores/editor';

import { QuillEditor } from '@vueup/vue-quill'
import ImageResize from '@taoqf/quill-image-resize-module';
import ImageUploader from 'quill-image-uploader';
import BlotFormatter from 'quill-blot-formatter';

const editor = useEditorStore();
const props = defineProps(['selected'])
const quill = ref('')

const toolbar = [
    [{
        'header': [1, 2, 3, 4, 5, 6, false]
    }],
    ['bold', 'italic', 'underline', 'strike'],
    [{
        'color': []
    }, {
        'background': []
    }],
    [{
        'align': []
    }],
    ['link', 'image',],
    ['clean']
];

const modules = [{
    name: 'imageUploader',
    module: ImageUploader,
    options: () => { }
},
{
    name: 'imageResize',
    module: ImageResize,
},
{
    name: 'blotFormatter',
    module: BlotFormatter,
}
]

function getElement() {
    editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].content.editorHtml = quill.value.getHTML()
    editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].content.editorObject = quill.value.getContents()
}

function setContent() {
    quill.value.setHTML(editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].content.editorHtml ?? '')
}
</script>
