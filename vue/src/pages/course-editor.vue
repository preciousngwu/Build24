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
        <div class="overflow-y-hidden h-full">
            <div class="flex h-full">
                <div
                    class="h-full overflow-y-auto overflow-x-hidden w-[20%] p-xl border-r border-border-primary grid gap-3xl ">
                    <sectionList v-if="editor.getTab('course-tab') == 'content'" @section="getSection($event)">
                    </sectionList>
                    <editor-course-settings-sidebar @tab="editor.setTab('course-settings', $event)"
                        v-if="editor.getTab('course-tab') == 'settings'"></editor-course-settings-sidebar>
                </div>
                <div class="w-[80%] pl-3xl grid gap-lg full overflow-y-auto ">
                    <sectionManage :courseLevels="configs.course.levels" v-if="editor.getTab('course-tab') == 'content'"
                        :section="configs.section">
                    </sectionManage>
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


import { onBeforeMount, onMounted, ref } from 'vue';
import { useEditorStore } from '@/stores/editor';


import Options from '@/components/icons/options.vue';
import Button from '@/components/modules/button.vue';

// Editor chunks
import sectionList from "@/components/chunks/editor-section-list.vue"
import sectionManage from "@/components/chunks/editor-section-manage.vue"
import editorCourseSettings from "@/components/chunks/editor-course-settings.vue"
import editorCourseSettingsSidebar from "@/components/chunks/editor-course-settings-sidebar.vue"



const editor = useEditorStore();
const configs = ref({
    id: router.currentRoute.value.params.course,
    section: 0,
    course: {},
    courseSetting: {}
})

function getSection($event) {
    configs.value.section = $event
}

onBeforeMount(() => {
    editor.setTab('course-tab', 'content')
})

onMounted(() => {

    if (configs.value.id) {
        axios.get('/admin/course/show?id=' + configs.value.id).then((e) => {
            configs.value.course = e.data.data
            editor.saveToDraft('course', _.pick(e.data.data, ['id', 'title', 'summary', 'signup_link']), true)
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