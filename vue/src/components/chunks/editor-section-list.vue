<template>
    <div class="h-full grid relative  ">
        <div class="h-fit"
            @click="editor.addToDraft('sections', { title: 'untitled', summary: 'summary...', lessons: [], levels: [], extras: [{ type: 'text', content: '' }], })">
            <Button :width="'w-full'" :classnames="'!bg-transparent border border-border-primary text-nowrap'"
                :text="'content-tertiary'">
                <template v-slot:icon>
                    <Plus :fill="'#6B7280'"></Plus>
                </template>

                <template v-slot:text>
                    Add section
                </template>
            </Button>
        </div>
        <div v-if="(Object.keys(editor.drafts.sections).length > 0)" v-for="(v, i) in editor.drafts.sections" :key="i"
            :id="`drag${i}`" @dragstart="dragElement($event)" draggable="true">
            <div @drop="drop($event)" class="h-xl above" @dragover="allowDrop($event)">

            </div>
            <div
                :class="(configs.selected.section === i ? 'border-border-accent-A' : 'border-border-primary') + ' border relative rounded-md p-xl cursor-pointer'">
                <div @click="select('section', { section: i })" class=" grid grid-cols-12 items-center  gap-md pb-md ">
                    <drag></drag>
                    <span class=" col-span-11 overflow-hidden text-ellipsis text-nowrap">{{ v.title ?? "" }}</span>
                </div>

                <div v-if="_.isEmpty(v.lessons)" class=" grid gap-md py-xl ">
                    <span>No lessons added</span>
                    <span class="">Click the “Add lesson” button to get started</span>
                </div>

                <div v-else v-for="(item, index) in v.lessons" :key="index"
                    @click="select('section', { section: i }); select('lesson', { lesson: index })"
                    :class="`my-xl grid grid-cols-6 border  p-md rounded-md items-center place-content-between gap-xl ${configs.selected.lesson == index && configs.selected.section === i ? 'border-border-accent-A' : 'border-border-primary'}`">
                    <div class="flex items-center gap-xl overflow-hidden text-ellipsis col-span-5">
                        <div>
                            <drag></drag>
                        </div>
                        <span class="overflow-hidden text-ellipsis text-nowrap">{{ item.title }}</span>
                    </div>
                    <div>
                        <trash></trash>
                    </div>
                </div>

                <div class="drop-box">
                    <div class="relative">
                        <div ref="lessonTypes"
                            @click="configs.add[i] !== undefined && configs.add[i] !== false ? configs.add[i] = false : configs.add[i] = true"
                            class="addButton absolute  top-0 right-0 w-full h-full bg-transparent"></div>
                        <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary '"
                            :text="'content-tertiary'">

                            <template v-slot:icon>
                                <Plus :fill="'#6B7280'"></Plus>
                            </template>

                            <template v-slot:text>
                                Add lesson
                            </template>
                        </Button>

                        <div v-show="configs.add[i]"
                            class="drop-list  border border-border-primary  rounded-md p-xl absolute bg-background-primary z-[1000] w-max mt-md grid gap-md ">
                            <span>Select page style</span>

                            <div class="grid grid-cols-2 gap-lg">
                                <div @click="openSection(editor.drafts.sections[i].lessons, v, 'standard')">
                                    <Button :width="'min-w-[130px]'"
                                        :classnames="'!bg-transparent border border-border-primary text-nowrap !p-md !justify-start '"
                                        :text="'content-tertiary'">

                                        <template v-slot:icon>
                                            <Plus :fill="'#6B7280'"></Plus>
                                        </template>

                                        <template v-slot:text>
                                            Standard
                                        </template>
                                    </Button>
                                </div>
                                <div @click="openSection(editor.drafts.sections[i].lessons, v, 'table')">
                                    <Button :width="'min-w-[130px]'"
                                        :classnames="'!bg-transparent border border-border-primary text-nowrap !p-md !justify-start'"
                                        :text="'content-tertiary'">

                                        <template v-slot:icon>
                                            <Plus :fill="'#6B7280'"></Plus>
                                        </template>

                                        <template v-slot:text>
                                            Table
                                        </template>
                                    </Button>
                                </div>
                                <div @click="openSection(editor.drafts.sections[i].lessons, v, 'note')">
                                    <Button :width="'min-w-[130px]'"
                                        :classnames="'!bg-transparent border border-border-primary text-nowrap !p-md !justify-start'"
                                        :text="'content-tertiary'">

                                        <template v-slot:icon>
                                            <Plus :fill="'#6B7280'"></Plus>
                                        </template>

                                        <template v-slot:text>
                                            Note
                                        </template>
                                    </Button>
                                </div>
                                <div @click="openSection(editor.drafts.sections[i].lessons, v, 'pdf')">
                                    <Button :width="'min-w-[130px]'"
                                        :classnames="'!bg-transparent border border-border-primary text-nowrap !p-md !justify-start'"
                                        :text="'content-tertiary'">

                                        <template v-slot:icon>
                                            <Plus :fill="'#6B7280'"></Plus>
                                        </template>

                                        <template v-slot:text>
                                            PDF
                                        </template>
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div @drop="drop($event)" class="h-xl below" @dragover="allowDrop($event)">

            </div>

        </div>
    </div>
</template>

<script setup>


import _ from 'lodash';
import axios from 'axios';
import { onBeforeMount, onMounted, ref } from 'vue';
import { useEditorStore } from '@/stores/editor';
import { onClickOutside } from '@vueuse/core'

import drag from '@/components/icons/drag.vue';
import Button from '@/components/modules/button.vue';
import Plus from '@/components/icons/plus.vue';
import trash from '@/components/icons/trash.vue';
import { assign } from 'lodash';
import router from '@/router';

const configs = ref({
    add: {},
    selected: {
        lesson: null,
        section: 0
    },
    selectedLesson: 0
})

const emits = defineEmits(['selected'])
const editor = useEditorStore();
const courseTypes = ref('');
const lessonTypes = ref('')


function allowDrop(ev) {
    ev.preventDefault();
}

function dragElement(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData('text');
    var targ = $(ev.target)
    const pa = $(ev.target).parent('div')

    if (targ.hasClass('below')) {
        $(`#${data}`).insertAfter(pa)
    }

    if (targ.hasClass('above')) {
        $(`#${data}`).insertBefore(pa)
    }
}


function openSection(lesson, v, type) {
    let s = { title: 'untitled', summary: 'summary...', type: type, levels: [], content: {}, resources: [], extras: [{ type: 'text', content: '' }], }
    if (v.id != undefined) {
        s.section_id = v.id
    }

    lesson.push(s)
}


onClickOutside(lessonTypes, function (event) {
    if (!$(event.target).hasClass('addButton')) {
        configs.value.add = {}
    }
})

function select(type, selected) {
    const event = configs.value.selected = Object.assign(configs.value.selected, selected)
    emits('selected', { type: type, selected: event })
}


onBeforeMount(() => {
    if (editor.configs.init) {
        return;
    }
    axios.get('/admin/sections?course_id=' + editor.getCurrentCourse.id).then((e) => {
        editor.saveToDraft('sections', e.data.data, true)
        emits('selected', { type: 'section', selected: configs.value.selected })
        editor.configs.init = true;
    })
})


onMounted(() => {
    // courseTypes.addEventListener('blur', (e) => {
    //     console.log("We")
    // });
})

</script>