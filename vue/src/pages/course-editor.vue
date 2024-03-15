<template>
    <div v-if="!_.isEmpty(configs.course)" class="flex flex-col h-full">
        <div class="flex flex-col">
            <div class="py-xl px-2xl flex justify-between border-b border-primary">
                <div class="flex gap-md items-center">
                    <router-link :to="{ name: 'dash.course' }">
                        <button
                            class=" justify-center items-center rounded-lg gap-md text-start py-md px-xl border border-primary">
                            Exit
                        </button>
                    </router-link>
                    <div class="border-l border-primary px-md">
                        Course: {{ configs.course.title }}
                    </div>
                    <Options></Options>
                    <div class="bg-background-dark text-content-inverse-primary text-xs py-xs px-md rounded-md">Draft
                        content
                    </div>
                </div>

                <div class="flex gap-md items-center">
                    <span v-if="editor.configs.alert" class="text-content-success">All changes saved</span>
                    <button
                        class="text-content-inverse-primary justify-center items-center rounded-lg gap-md text-start py-md px-xl bg-background-accent-A">
                        Publish
                    </button>
                </div>
            </div>

            <div class="flex px-3xl border border-border-primary">
                <div @click="editor.setTab('course-tab', 'content')"
                    :class="'p-xl  cursor-pointer ' + (editor.getTab('course-tab') == 'content' ? 'border-b-2 border-border-dark' : '')">
                    Content
                </div>
                <div @click="editor.setTab('course-tab', 'settings')"
                    :class="'p-xl  cursor-pointer ' + (editor.getTab('course-tab') == 'settings' ? 'border-b-2 border-border-dark' : '')">
                    Settings
                </div>
                <div @click="editor.setTab('course-tab', 'content')" class="p-xl  cursor-pointer">Preview</div>
                <div @click="editor.setTab('course-tab', 'content')" class="p-xl  cursor-pointer">User questions</div>
            </div>
        </div>
        <div class="overflow-hidden h-full">
            <div class="flex h-full">
                <div
                    class="overflow-y-clip side-weeler min-h-full   w-[20%] p-xl border-r border-border-primary  gap-3xl ">
                    <div class="">
                        <sectionList v-if="editor.getTab('course-tab') == 'content'" @selected="getSelected($event)">
                        </sectionList>
                        <editor-course-settings-sidebar @tab="editor.setTab('course-settings', $event)"
                            v-if="editor.getTab('course-tab') == 'settings'"></editor-course-settings-sidebar>
                    </div>
                </div>
                <div class="w-[80%]  grid gap-lg  overflow-y-auto overflow-x-hidden">
                    <div class="w-full" v-if="editor.getTab('course-tab') == 'content'">
                        <editor-lessons v-if="configs.content.type == 'lesson'"
                            :selected="configs.content.selected"></editor-lessons>
                        <div v-if="configs.content.type == 'section' && configs.content.selected.section != undefined">
                            <sectionManage :courseLevels="configs.course.levels"
                                :section="configs.content.selected.section">
                            </sectionManage>
                        </div>
                    </div>
                    <editorCourseSettings @currentLevels="configs.course.levels = $event"
                        v-if="editor.getTab('course-tab') == 'settings'" :course="configs.course">
                    </editorCourseSettings>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import _ from 'lodash'
import axios from 'axios';
import router from '@/router';


import { onBeforeMount, onBeforeUnmount, onMounted, ref } from 'vue';
import { useEditorStore } from '@/stores/editor';


import Options from '@/components/icons/options.vue';
import Button from '@/components/modules/button.vue';

// Editor chunks
import sectionList from "@/components/chunks/editor-section-list.vue"
import sectionManage from "@/components/chunks/editor-section-manage.vue"
import editorLessons from "@/components/chunks/editor-lessons.vue"
import editorCourseSettings from "@/components/chunks/editor-course-settings.vue"
import editorCourseSettingsSidebar from "@/components/chunks/editor-course-settings-sidebar.vue"



const editor = useEditorStore();
const configs = ref({
    id: router.currentRoute.value.params.course,
    content: {
        selected: {},
        type: 'section'
    },
    course: {},
    courseSetting: {}
})

function getSelected(e) {
    configs.value.content = e
}

onBeforeMount(() => {
    router.beforeEach(() => {
        editor.resetDraft()
        editor.configs.init = false
    })

    editor.setTab('course-tab', 'content')
})

onMounted(() => {

    if (configs.value.id) {
        axios.get('/admin/course/show?id=' + configs.value.id).then((e) => {
            configs.value.course = e.data.data

            editor.saveToDraft('course', _.pick(e.data.data, ['id', 'title', 'summary', 'signup_link', 'levels']), true)
            editor.autoSave()
            document.onkeydown = function (e) {
                if (e.key === "s" && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault();
                    editor.saveDrafts()
                }
            };
        });
    }
})

</script>