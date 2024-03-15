<template>
    <input @change="getsheet()" ref="sheet" type="file" class="hidden" id="file">
    <div v-if="table.head != undefined" class="grid gap-lg overflow-x-auto">
        <div class=" overflow-x-auto">
            <table class="w-full ">
                <thead>
                    <tr>
                        <th v-for="(v, i) in table.head" :key="i"
                            class="bg-background-tertiary py-lg px-lg text-xs font-medium text-content-tertiary uppercase border-t text-start">
                            <div class="flex items-center gap-md">
                                <edit v-if="toggle.head[i] === true || toggle.head[i] === undefined"
                                    @click="toggle.head[i] = false"></edit>
                                <correct v-if="toggle.head[i] === false" @click="toggle.head[i] = true"></correct>
                                <input-vue :disabled="(toggle.head[i] ?? true)" :width="'w-fit'"
                                    :classnames="'!text-xs !p-md uppercase'" @get="table.head[i] = $event"
                                    :value="v"></input-vue>
                            </div>
                        </th>
                        <th @click="addColumn()"
                            class="bg-background-tertiary-state-hover table-cell py-lg cursor-pointer">
                            <div class="w-full flex justify-center">
                                <tablePlus></tablePlus>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v, i) in table.body" :key="i">
                        <td v-for="(c, index) in v" :key="index" class="border-b  border-border-secondary">
                            <div class="hover:border-border-accent-A border border-white rounded-md m-md">
                                <input @input="table.body[i][index] = $event.target.value" :value="c" type="text"
                                    class="border-none focus-within:outline-none rounded-md p-sm ">
                            </div>
                        </td>
                        <td class="p-xl bg-background-tertiary"> </td>
                    </tr>
                </tbody>
            </table>
        </div>



        <div class="flex gap-[10px]">
            <Button @click="addRow()" :classnames="' !bg-background-accent-A '" :width="'w-fit'">
                <template v-slot:text>
                    Add row
                </template>
            </Button>
            <div class="relative">
                <Button @click="toggle.upload = !toggle.upload ? true : false" :text="'black'"
                    :classnames="' !bg-transparent border border-border-primary '" :width="'w-fit'">
                    <template v-slot:text>
                        Upload new
                    </template>
                </Button>

                <div v-if="toggle.upload"
                    class="drop-list  border border-border-primary  rounded-md p-xl absolute bg-background-primary z-[1000] w-max mt-md grid gap-md top-[-6.5em]">
                    <label @click="toggle.overwriteRow = true" for="file"
                        class="cursor-pointer hover:text-content-accent-A">
                        Update existing information and add new rows
                    </label>
                    <label @click="toggle.overwriteRow = false" for="file"
                        class="cursor-pointer hover:text-content-accent-A">
                        Only add new rows
                    </label>
                </div>
            </div>

        </div>

    </div>

    <div v-else class="grid gap-[30px] w-full place-content-center place-items-center">
        <Image :custom-class="'w-[177.64px]'" :src="'/src/assets/images/excelupload.png'"></Image>

        <div class="grid gap-[16px] place-items-center">
            <headerText>Upload a CSV file</headerText>
            <smallText>Not sure how to format your file? <a>Download sample file</a></smallText>
            <label for="file"
                class=" rounded-lg cursor-pointer bg-background-secondary px-[30px] py-[16px] grid place-items-center border-dashed border border-border-primary ">
                <smallText>Drag and drop a CSV or XLS file to upload</smallText>
                <smallText>OR</smallText>
                <Button :isDiv="true" :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary '"
                    :text="'content-tertiary'">
                    <template v-slot:icon>
                        <upload></upload>
                    </template>
                    <template v-slot:text>
                        Upload PDF
                    </template>
                </Button>
            </label>
        </div>
    </div>

</template>

<script setup>

import _ from 'lodash'
import { ref, computed, watch } from "vue"
import { useEditorStore } from '@/stores/editor';

import { read, utils, writeFile, readFile } from 'xlsx';

import Image from '../modules/image.vue';
import headerText from '../modules/headerText.vue';
import smallText from '../modules/smallText.vue';
import Button from '../modules/button.vue';
import upload from '../icons/upload.vue';
import trash from "../icons/trash.vue";
import tablePlus from "../icons/table-plus.vue";
import edit from "../icons/edit.vue";
import correct from "../icons/correct.vue";

import inputVue from '../modules/input.vue';

const props = defineProps(['selected'])
const editor = useEditorStore();

const sheet = ref(undefined)
const preview = ref([undefined])
const data = ref({})
const toggle = ref({
    head: {},
    upload: false,
    overwriteRow: true
})


const table = computed({
    get: () => {
        return editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].content.table ?? {};
    },
    set: (e) => {
        editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].content.table = e
    }
})

function addRow() {
    let row = []
    for (let index = 0; index < table.value.head.length; index++) {
        row.push('')
    }
    table.value.body.push(row)
}

function addColumn() {
    table.value.head.push("untitled")
    table.value.body.map((v, i) => {
        table.value.body[i].push('')
    })
}


function save() {
    editor.drafts.sections[props.selected.section].lessons[props.selected.lesson].content.table = data.value
}

// watch(())

async function getsheet() {
    const f = sheet.value.files[0];
    const d = await f.arrayBuffer();
    /* data is an ArrayBuffer */
    const wb = read(d);
    const ws = wb.Sheets[wb.SheetNames[0]]; // get the first worksheet
    const wd = utils.sheet_to_json(ws, {
        header: 1,
        defval: '',
        blankrows: true
    }); // generate objects

    let data = {};
    data.head = wd[0];
    data.body = wd.filter((v, k) => {
        return k != 0;
    })
    if (toggle.value.overwriteRow) {
        table.value = data
    } else {
        let lb = [];
        let ts = editor.removeRef(table.value.body)
        for (let index = 0; index < data.body.length; index++) {
            ts.push(data.body[index])
        }
        for (let index = 0; index < ts.length; index++) {
            lb.push(ts[index].length)
        }
        const max = lb.reduce((a, b) => Math.max(a, b), -Infinity);
        for (let index = 0; index < ts.length; index++) {
            if (ts[index].length < max) {
                const add = (max - ts[index].length);
                for (let i = 1; i <= add; i++) {
                    ts[index].push('')
                }
            }
        }
        if (max > table.value.head.length) {
            const add = (max - table.value.head.length)
            for (let index = 0; index < add; index++) {
                table.value.head.push("untitled")
            }
        }
        table.value.body = ts;
    }
}

</script>

<style scoped>
table {
    border-collapse: separate;
    border-spacing: 0;
}

tr:first-child th:first-child {
    border-top-left-radius: 10px;
}


tr:last-child th:last-child {
    border-top-right-radius: 10px;
}


td:first-child {
    border-left: 1px solid #E5E7EB;
}

th:first-child {
    border-left: 1px solid #E5E7EB;
}

tr:last-child td:first-child {
    border-bottom-left-radius: 10px;
}

tr:last-child td:last-child {
    border-bottom-right-radius: 10px;
}
</style>