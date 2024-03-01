<template>
    <div class="h-fit grid gap-3xl py-3xl lg:w-[727px]">
        <div class="flex items-center justify-between">
            <div class="grid gap-sm pb-3xl">
                <h1 class="font-semibold">User levels</h1>
                <p class="text-content-tertiary">
                    User levels help you set permissions to who can view your course content
                </p>
            </div>
            <div class="w-fit" @click="config.create = true">
                <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary text-nowrap'"
                    :text="'content-tertiary'">
                    <template v-slot:text>
                        + New user level
                    </template>
                </Button>
            </div>
        </div>
        <div v-for="(v, i) in config.levels" :key="i" class="border border-border-primary rounded-lg">
            <div class="rounded-t-lg bg-background-secondary flex justify-between py-md px-lg">
                <h1 class="font-medium">{{ v.title }}</h1>
                <Trash @click="remove(v)"></Trash>
            </div>
            <div class="py-md px-lg">
                <ol class="grid gap-md text-content-tertiary">
                    <li v-for="(v, i) in v.benefits" class="flex w-fit gap-md">
                        <span>{{ i + 1 }}.</span>
                        <span>{{ v }}</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <editorCreateLevel @added="push($event)" @close="config.create = false" v-if="config.create"></editorCreateLevel>
</template>

<script setup>
import Trash from '@/components/icons/trash.vue';
import Button from '@/components/modules/button.vue';

import editorCreateLevel from "@/components/chunks/editor-create-level.vue"
import { onBeforeMount, onMounted, ref } from 'vue';
import axios from 'axios';
import { useEditorStore } from '@/stores/editor';
import _ from 'lodash';

const editor = useEditorStore();
const emits = defineEmits(['currentLevels'])

const config = ref({
    create: false,
    levels: []
});

function push(e) {
    config.value.levels.push(e)
    config.value.create = false
    emits('currentLevels', editor.removeRef(config.value.levels))
}

function remove(v) {
    axios.post('/admin/levels/delete', { level_id: v.id }).then((e) => {
        _.remove(config.value.levels, v)
        emits('currentLevels', editor.removeRef(config.value.levels))
    }).catch((e) => {
        console.log(e)
    })
}

onBeforeMount(() => {
    axios.get('/admin/course/levels?course_id=' + editor.getCurrentCourse.id).then((e) => {
        config.value.levels = e.data.data
    }).catch((e) => {
        console.log(e)
    })
})
</script>