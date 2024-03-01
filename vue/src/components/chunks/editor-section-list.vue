<template>
    <div class="h-fit grid gap-xl">
        <div class="h-fit"
            @click="editor.addToDraft('sections', { title: 'untitled', summary: '', lessons: [], levels: [] })">
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
            @click="select(i)"
            :class="(configs.selected === i ? 'border-border-accent-A' : 'border-border-primary') + ' border   rounded-md p-xl cursor-pointer'">
            <div class=" grid grid-cols-12 items-center  gap-md pb-md ">
                <drag></drag>
                <span class=" col-span-11 overflow-hidden text-ellipsis text-nowrap">{{ v.title ?? "" }}</span>
            </div>

            <div v-if="Object.keys(v.lessons).length < 1" class=" grid gap-md py-xl ">
                <span>No lessons added</span>
                <span class="">Click the “Add lesson” button to get started</span>
            </div>

            <div v-else
                class="my-xl grid grid-cols-6 border border-border-primary p-md rounded-md items-center place-content-between gap-xl">
                <div class="flex items-center gap-xl overflow-hidden text-ellipsis col-span-5">
                    <div>
                        <drag></drag>
                    </div>
                    <span class="overflow-hidden text-ellipsis text-nowrap">{{ v.title }}</span>
                </div>
                <div>
                    <trash></trash>
                </div>
            </div>

            <div class="">
                <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary '"
                    :text="'content-tertiary'">
                    <template v-slot:icon>
                        <Plus :fill="'#6B7280'"></Plus>
                    </template>
                    <template v-slot:text>
                        Add lesson
                    </template>
                </Button>
            </div>

            <div class="hidden border border-border-primary  rounded-md p-xl absolute  bg-background-primary z-50">
                <span>Select page style</span>

                <div class="grid grid-cols-2 gap-lg">
                    <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary text-nowrap '"
                        :text="'content-tertiary'">
                        <template v-slot:icon>
                            <Plus :fill="'#6B7280'"></Plus>
                        </template>
                        <template v-slot:text>
                            Add lesson
                        </template>
                    </Button>
                    <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary text-nowrap'"
                        :text="'content-tertiary'">
                        <template v-slot:icon>
                            <Plus :fill="'#6B7280'"></Plus>
                        </template>
                        <template v-slot:text>
                            Add lesson
                        </template>
                    </Button>
                    <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary text-nowrap'"
                        :text="'content-tertiary'">
                        <template v-slot:icon>
                            <Plus :fill="'#6B7280'"></Plus>
                        </template>
                        <template v-slot:text>
                            Add lesson
                        </template>
                    </Button>
                    <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary text-nowrap'"
                        :text="'content-tertiary'">
                        <template v-slot:icon>
                            <Plus :fill="'#6B7280'"></Plus>
                        </template>
                        <template v-slot:text>
                            Add lesson
                        </template>
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { onBeforeMount, ref } from 'vue';
import { useEditorStore } from '@/stores/editor';


import drag from '@/components/icons/drag.vue';
import Button from '@/components/modules/button.vue';
import Plus from '@/components/icons/plus.vue';
import trash from '@/components/icons/trash.vue';

const configs = ref({
    selected: {}
})

const emits = defineEmits(['section'])
const editor = useEditorStore();

function select(v) {
    configs.value.selected = v
    emits('section', v)
}

onBeforeMount(() => {
    axios.get('/admin/sections?course_id=' + editor.getCurrentCourse.id).then((e) => {
        editor.saveToDraft('sections', e.data.data, true)
        configs.value.selected = 0
        emits('section', 0)
    })
})


</script>