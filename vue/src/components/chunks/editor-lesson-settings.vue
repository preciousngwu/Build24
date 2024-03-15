<template>
    <!-- {{ editor.drafts }} -->
    <div v-if="!_.isEmpty(editor.drafts.sections[selected.section].lessons[selected.lesson])" class="flex gap-3xl">
        <div class="grid gap-lg  w-[80%]">
            <div class="grid gap-sm pb-3xl">
                <h1 class="font-semibold">Lesson settings</h1>
                <p class="text-content-tertiary">Lessons help you manage your content and user permissions
                </p>
            </div>

            <div class="grid h-fit">
                <SmallText>Lesson title</SmallText>
                <input
                    @input="editor.drafts.sections[selected.section].lessons[selected.lesson].title = $event.target.value"
                    :value="editor.drafts.sections[selected.section].lessons[selected.lesson].title"
                    class="border border-border-primary rounded-lg  text-start p-md  w-full ">
            </div>
            <div class="grid h-fit">
                <SmallText :Class="'text-nowrap'">Lesson summary</SmallText>
                <textarea
                    @input="editor.drafts.sections[selected.section].lessons[selected.lesson].summary = $event.target.value"
                    :value="editor.drafts.sections[selected.section].lessons[selected.lesson].summary" rows="5"
                    class="rounded-lg relative px-xl pt-xl pl-md pb-md pr-xl border border-border-primary "></textarea>
            </div>

            <div class="grid h-fit relative">
                <SmallText :Class="'text-nowrap'">Select User level</SmallText>
                <div class="relative w-full">
                    <div v-if="!_.isEmpty(editor.drafts.sections[selected.section].lessons[selected.lesson].levels)"
                        class="bg-white rounded-tl-lg rounded-bl-lg max-w-[80%] absolute top-0 border-y border-l border-border-primary h-full overflow-y-auto flex gap-4 flex-wrap py-sm px-md cursor-pointer">
                        <div v-for="(v, i) in editor.drafts.sections[selected.section].lessons[selected.lesson].levels"
                            :key="i"
                            class="bg-background-accent-A-light flex items-center px-sm py-xs rounded-md gap-sm">
                            <span class="text-content-accent-A text-xs">{{ v.title }}</span>
                            <div class="p-md"
                                @click="editor.removeLevel(v.id, editor.drafts.sections[selected.section].lessons[selected.lesson])">
                                <Close :fill="'#3B82F6'" :width="8" :height="8"></Close>
                            </div>
                        </div>
                    </div>
                    <select v-model="config.current_level"
                        @change="editor.pushLevel($event.target.value, editor.drafts.sections[selected.section].lessons[selected.lesson]); config.current_level = 0"
                        class=" focus-visible:outline-0  border border-border-primary rounded-lg p-md w-full cursor-pointer"
                        name="" id="">
                        <option value="0" selected disabled> user level </option>
                        <option v-for="(v, i) in editor.getCurrentCourse.levels" :key="i" :value="v.id">
                            {{ v.title }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="grid gap-lg h-fit">
                <SmallText>Quick links & tips</SmallText>
                <div class=""
                    v-for="(item, index) in editor.drafts.sections[selected.section].lessons[selected.lesson].extras"
                    :key="index">
                    <div class="flex items-center gap-md relative">
                        <input :value="item.content"
                            @input="editor.drafts.sections[selected.section].lessons[selected.lesson].extras[index].content = $event.target.value"
                            class="border border-border-primary rounded-lg  text-start p-md  w-full ">
                        <div
                            class="bg-background-accent-B grid place-content-center rounded-circular h-[28px] w-[28px] absolute right-3">
                            <link-icon></link-icon>
                        </div>
                    </div>
                </div>
                <div @click="editor.drafts.sections[selected.section].lessons[selected.lesson].extras.push({
        type: 'text', content: ''
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

        <div class="flex w[20%] flex-col gap-3xl">
            <SmallText :size="''">Security settings</SmallText>
            <div class="grid gap-md">
                <div class="flex gap-md items-center">
                    <input
                        @click="editor.drafts.sections[selected.section].lessons[selected.lesson].content.config ? editor.drafts.sections[selected.section].lessons[selected.lesson].content.config.rightclick = $event.target.checked : editor.drafts.sections[selected.section].lessons[selected.lesson].content.config = { rightclick: $event.target.checked }"
                        :checked="getConfig ? getConfig.rightclick : false" type="checkbox">
                    <SmallText>Disable right click</SmallText>
                </div>

                <div class="flex gap-md items-center">
                    <input
                        @click="editor.drafts.sections[selected.section].lessons[selected.lesson].content.config ? editor.drafts.sections[selected.section].lessons[selected.lesson].content.config.copy = $event.target.checked : editor.drafts.sections[selected.section].lessons[selected.lesson].content.config = { copy: $event.target.checked }"
                        :checked="getConfig ? getConfig.copy : false" type="checkbox">
                    <SmallText>Disable copy data</SmallText>
                </div>

                <div class="flex gap-md items-center">
                    <input
                        @click="editor.drafts.sections[selected.section].lessons[selected.lesson].content.config ? editor.drafts.sections[selected.section].lessons[selected.lesson].content.config.download = $event.target.checked : editor.drafts.sections[selected.section].lessons[selected.lesson].content.config = { download: $event.target.checked }"
                        :checked="getConfig ? getConfig.download : false" type="checkbox">
                    <SmallText>Disable download</SmallText>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import _ from 'lodash'
import SmallText from '@/components/modules/smallText.vue';
import Button from '@/components/modules/button.vue';

import Close from '@/components/icons/close.vue';
import Upload from '@/components/icons/upload.vue';
import Plus from '@/components/icons/plus.vue';
import linkIcon from '@/components/icons/link.vue';

import { computed, onBeforeMount, ref } from 'vue';
import { useEditorStore } from '@/stores/editor';


const editor = useEditorStore();
const props = defineProps(['selected'])

const getConfig = computed(() => {
    return editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].content.config ?? undefined
})

const config = ref({
    current_level: 0
})

</script>