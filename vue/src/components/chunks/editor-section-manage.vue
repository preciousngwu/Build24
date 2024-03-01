<template>
    <div v-if="editor.drafts.sections[props.section]" class="flex w-full gap-3xl h-full">
        <div class=" lg:w-[727px]  py-3xl overflow-y-auto h-full">
            <div class="h-fit grid gap-3xl">
                <div class="grid gap-sm pb-3xl">
                    <h1 class="font-semibold">Edit section</h1>
                    <p class="text-content-tertiary">A section provides a way to manage your content and permissions
                    </p>
                </div>
                <div class="grid h-fit">
                    <SmallText>Section title</SmallText>
                    <input @input="draft('title', $event.target.value)" :value="editor.drafts.sections[props.section].title"
                        class="border border-border-primary rounded-lg  text-start p-md  w-full ">
                </div>
                <div class="grid h-fit">
                    <SmallText :Class="'text-nowrap'">Section summary</SmallText>
                    <textarea rows="5" @input="draft('summary', $event.target.value)"
                        :value="editor.drafts.sections[props.section].summary"
                        class="rounded-lg relative px-xl pt-xl pl-md pb-md pr-xl border border-border-primary  w-[530px]"></textarea>
                </div>
                <div class="grid h-fit relative">
                    <SmallText :Class="'text-nowrap'">Select user level</SmallText>
                    <div class="relative w-full">
                        <div v-if="!_.isEmpty(editor.drafts.sections[props.section].levels)"
                            class="bg-white rounded-tl-lg rounded-bl-lg max-w-[80%] absolute top-0 border-y border-l border-border-primary h-full overflow-y-auto flex gap-4 flex-wrap py-sm px-md cursor-pointer">
                            <div v-for="(v, i) in editor.drafts.sections[props.section].levels" :key="i"
                                class="bg-background-accent-A-light flex items-center px-sm py-xs rounded-md gap-sm">
                                <span class="text-content-accent-A text-xs">{{ v.title }}</span>
                                <div class="p-md" @click="removeLevel(v)">
                                    <Close :fill="'#3B82F6'" :width="8" :height="8"></Close>
                                </div>
                            </div>
                        </div>
                        <select @change="pushLevel($event.target.value)" v-model="config.current_level"
                            class=" focus-visible:outline-0  border border-border-primary rounded-lg p-md w-full cursor-pointer"
                            name="" id="">
                            <option value="0" selected disabled> user level </option>
                            <option v-for="(v, i) in courseLevels" :key="i" :value="v.id">
                                {{ v.title }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="grid gap-lg h-fit">
                    <SmallText>Quick links & tips</SmallText>
                    <div v-for="(ex, index) in editor.drafts.sections[props.section].extras " :key="index" class="">
                        <div class="flex items-center gap-md relative">
                            <input
                                @input="editor.drafts.sections[props.section].extras[index].content = $event.target.value"
                                :value="ex.content"
                                class="border border-border-primary rounded-lg  text-start p-md  w-full ">
                            <div
                                class="bg-background-accent-B grid place-content-center rounded-circular h-[28px] w-[28px] absolute right-3">
                                <link-icon></link-icon>
                            </div>
                        </div>
                    </div>
                    <div @click="editor.drafts.sections[props.section].extras.push({
                        type: 'text', content: '', 'levels': []
                    })" class="w-fit">
                        <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary text-nowrap'"
                            :text="'content-tertiary'">
                            <template v-slot:icon>
                                <Plus :fill="'#6B7280'"></Plus>
                            </template>
                            <template v-slot:text>
                                Add more
                            </template>
                        </Button>
                    </div>
                </div>

            </div>
        </div>
        <!-- <div class="w-[20%] grid gap-3xl h-fit  py-3xl">
            <SmallText>Security settings</SmallText>

            <div class="grid gap-md ">
                <div class="flex gap-md">
                    <input type="checkbox">
                    <SmallText>Disable right click</SmallText>
                </div>
                <div class="flex gap-md">
                    <input type="checkbox">
                    <SmallText>Disable right click</SmallText>
                </div>
                <div class="flex gap-md">
                    <input type="checkbox">
                    <SmallText>Disable right click</SmallText>
                </div>
            </div>
        </div> -->
    </div>
</template>

<script setup>

import _ from 'lodash'
import axios from 'axios';
import { computed, onBeforeMount, onMounted, ref } from 'vue';
import { useEditorStore } from '@/stores/editor';


// Icons
import Button from '@/components/modules/button.vue';
import Plus from '@/components/icons/plus.vue';
import SmallText from '@/components/modules/smallText.vue';
import linkIcon from '@/components/icons/link.vue';
import Close from '@/components/icons/close.vue';

const props = defineProps({
    section: Number,
    courseLevels: Array
});

const editor = useEditorStore();
const extras = ref([])
const config = ref({
    init: false,
    current_level: 0,
    section_levels: []
})

function init() {
    if (!config.value.init) {
        config.value.init = true
        if (!_.isEmpty(editor.drafts.sections[props.section])) {
            return editor.drafts.sections[props.section].levels.map((v) => {
                config.value.section_levels.push(parseInt(v.id))
            })
        }
    }
}

function pushLevel(id) {
    init()
    id = parseInt(id)
    config.value.current_level = 0
    const levels = editor.removeRef(config.value.section_levels);
    if (_.indexOf(levels, id) < 0) {
        config.value.section_levels.push(id)
        props.courseLevels.map((v) => {
            if (v.id == id) {
                editor.drafts.sections[props.section].levels.push(v)
            }
        })
        draft('section_levels', config.value.section_levels)
    }
}

function removeLevel(v) {
    init()
    const id = parseInt(v.id)
    config.value.current_level = 0
    const levels = editor.removeRef(config.value.section_levels);
    config.value.section_levels = _.remove(levels, (n) => { return n != id })
    editor.drafts.sections[props.section].levels = _.remove(editor.drafts.sections[props.section].levels, function ($v) { return $v != v })
    draft('section_levels', config.value.section_levels)
}
function draft(key, value) {
    editor.drafts.sections[props.section][key] = value
}
</script>