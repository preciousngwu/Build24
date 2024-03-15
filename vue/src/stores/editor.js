import { ref, computed, watchEffect, watch, toRaw, unref } from 'vue'
import { defineStore } from 'pinia'

import _, { assign, forIn, isArray, isObject, remove, update } from 'lodash'
import axios from 'axios'
import router from '@/router'
import { useInteractStore } from "@/stores/interact"
import { stringify } from 'postcss'

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
        init: false,
        alert: false,
        currentCourse: undefined,
        tab: {}
    })


    function resetDraft() {
        const empty = {
            sections: [],
            course: {}
        }
        drafts.value = empty
        old.value = empty
    }


    function pushLevel(id, draft) {
        id = parseInt(id)
        getCurrentCourse.value.levels.map((v) => {
            if (v.id == id) {
                if (!_.includes(draft.levels.map((e) => e.id), id)) {
                    draft.levels.push(v)
                };
            }
        })
    }

    function removeLevel(id, draft) {
        id = parseInt(id)
        draft.levels = _.remove(draft.levels, (n) => { return n.id != id })
    }


    /** Course get/set */
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
    function addToDraft(key, value, sub = undefined) {
        drafts.value[key].unshift(value)
    }
    function setOld(key, value) {
        old.value[key] = removeRef(value);
    }

    function updateSection() {

        /** Section check */
        if (!_.isEqual(drafts.value.sections, old.value.sections)) {
            const form = new FormData();
            let current = (drafts.value.sections);
            form.append('course_id', router.currentRoute.value.params.course)
            current.map((v, i) => {
                for (const key in v) {
                    if (!_.includes(['lessons',], key)) {
                        form.append(`updates[${i}][${key}]`, typeof v[key] === 'string' ? v[key] : JSON.stringify(v[key]));
                    }
                    if (_.includes(['lessons'], key) && _.isArray(v[key])) {
                        for (const lkey in v[key]) {
                            for (const each in v[key][lkey]) {
                                // if (_.includes(['created_at', 'updated_at', 'levels', 'resources'], each)) {
                                //     continue;
                                // }
                                if (_.includes(['lesson_video', 'lesson_pdf', 'lesson_sheet'], each)) {
                                    form.append(`updates[${i}][${key}][${lkey}][${each}]`, v[key][lkey][each]);
                                } else {
                                    form.append(`updates[${i}][${key}][${lkey}][${each}]`, typeof v[key][lkey][each] === 'string' ? v[key][lkey][each] : JSON.stringify(v[key][lkey][each]));
                                }
                            }
                        }
                    }
                }
            });

            // console.log(current.map(v => _.omit(v, ['resources'])));
            // current.map((v) => {
            //     toUpdate.push(_.pick(v, ['title', 'id', 'summary', 'extras', 'level_ids', 'lessons']))
            // // });

            axios.post('/admin/sections/bulk_update', form, { headers: { "enctype": 'multipart/form-data' } }).then((e) => {
                // current = e.data.data.updates;
                // updates.map((c, i) => {
                //     // for (let index = 0; index < updates.length; index++) {
                //     console.log(c)
                //     current[i] = _.assign(current[i], updates[index])
                //     // }
                // })
                saveToDraft('sections', e.data.data.updates, true);
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
        // setInterval(() => { saveDrafts() }, 20000)
    }

    return {
        removeLevel,
        pushLevel,
        removeRef,
        saveToDraft,
        addToDraft,
        drafts,
        configs,
        autoSave,
        saveDrafts,
        setCurrentCourse,
        getCurrentCourse,
        setTab,
        getTab,
        resetDraft
    }
})
