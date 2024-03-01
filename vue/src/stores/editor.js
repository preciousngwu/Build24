import { ref, computed, watchEffect, watch, toRaw, unref } from 'vue'
import { defineStore } from 'pinia'

import _, { forIn, remove } from 'lodash'
import axios from 'axios'
import router from '@/router'
import { useInteractStore } from "@/stores/interact"

export const useEditorStore = defineStore('editor', () => {

    const interact = useInteractStore()
    const drafts = ref({
        sections: [],
        course: {}
    })
    const old = ref({
        sections: [],
        course: {}
    })
    const configs = ref({
        alert: false,
        currentCourse: undefined,
        tab: {}
    })

    function setCurrentCourse(v, first = false) {
        saveToDraft('course', v, first)
    }

    const getCurrentCourse = computed(() => {
        return drafts.value.course;
    })

    function setTab(name, tab) {
        configs.value.tab[name] = tab
    }

    function getTab(name) {
        return configs.value.tab[name];
    }

    function alert() {
        configs.value.alert = true
        setTimeout(() => { configs.value.alert = false }, 3000);
    }

    function removeRef(value) {
        return JSON.parse(JSON.stringify(value))
    }
    function saveToDraft(key, value, first = false) {
        drafts.value[key] = removeRef(value);
        if (first === true) {
            setOld(key, value)
        }
    }
    function addToDraft(key, value) {
        drafts.value[key].unshift(value)
    }

    function setOld(key, value) {
        old.value[key] = removeRef(value);
    }

    function updateSection() {

        /** Section check */
        if (!_.isEqual(drafts.value.sections, old.value.sections)) {
            let toUpdate = [];
            const current = removeRef(drafts.value.sections);
            current.map((v) => {
                if (!_.find(old.value.sections, v)) {
                    toUpdate.push(_.pick(v, ['title', 'id', 'summary', 'extras', 'section_levels']))
                }
            });
            axios.post('/admin/sections/bulk_update', { course_id: router.currentRoute.value.params.course, updates: toUpdate }).then((e) => {
                saveToDraft('sections', current, true);
                alert()
            })
        }

        /** Course check */
        if (!_.isEqual(drafts.value.course, old.value.course)) {
            var current = (drafts.value.course);
            const previous = removeRef(old.value.course);

            let toUpdate = new FormData();
            toUpdate.append('id', current.id);

            for (const key in _.pick(current, ['title', 'summary', 'signup_link', 'cover', 'teaser', 'overview'])) {
                if (previous[key] === undefined) {
                    toUpdate.append(key, (current[key]));
                }
                if (previous[key] != undefined && !_.isEqual(current[key], previous[key])) {
                    toUpdate.append(key, current[key]);
                }
            }

            axios.post('/admin/course/update', toUpdate).then((e) => {

                // Delete temporal data
                delete drafts.value.course.cover
                delete drafts.value.course.teaser
                delete drafts.value.course.overview

                saveToDraft('course', current, true);
                alert()
            }).catch((e) => {
                interact.notify({ alert: true, content: e.response.data.message })
            })
        }
    }

    function saveDrafts() {
        updateSection();
    }

    // watch(drafts, (n, o) => {
    //     if (!_.isEqual(drafts.value.sections, old.value.sections)) {
    //         console.log("proceed with update")
    //     }
    // }, { deep: true });

    function autoSave() {
        setInterval(() => { saveDrafts() }, 20000)
    }

    return { removeRef, saveToDraft, addToDraft, drafts, configs, autoSave, saveDrafts, setCurrentCourse, getCurrentCourse, setTab, getTab }
})
