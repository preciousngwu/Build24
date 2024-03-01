<template>
    <div class="p-2xl overflow-y-auto">
        <div class=" flex flex-col border border-border-secondary bg-white rounded-lg  ">
            <div class="flex justify-between bg-white h-fit px-xl py-2xl rounded-t-lg items-center ">
                <span>Course students</span>
                <div class="flex gap-md">
                    <Input :width="'w-[405px]'" :placeholder="'Search by name, course etc.'">
                    <template v-slot:start>
                        <Search></Search>
                    </template>
                    </Input>
                    <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary '">
                        <template v-slot:icon>
                            <Filter></Filter>
                        </template>
                        <template v-slot:text>
                            <span class="text-content-tertiary">Filter</span>
                        </template>
                    </Button>
                    <Button :width="'w-fit'" :classnames="'!bg-background-accent-A border border-border-primary '">
                        <template v-slot:icon>
                            <Plus></Plus>
                        </template>
                        <template v-slot:text>
                            <span class="text-content-inverse-primary">Add new user</span>
                        </template>
                    </Button>
                </div>
            </div>
            <table class="mb-2">
                <thead>
                    <tr class="text-content-tertiary text-xs uppercase bg-background-tertiary ">
                        <th class="p-xl font-medium text-start">NAME</th>
                        <th class="p-xl font-medium text-start ">email</th>
                        <th class="p-xl font-medium text-start ">Created at</th>
                        <th class="p-xl font-medium text-start ">courses</th>
                        <th class="p-xl font-medium text-start ">Country</th>
                        <th class="p-xl font-medium text-start ">last login</th>
                        <th class="p-xl font-medium text-start ">status</th>
                        <th class="p-xl font-medium text-start ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v, i) in payload.users" :key="i" class="bg-white text-content-secondary text-sm">
                        <td class="p-xl font-regular ">
                            <div class="h-full flex gap-md">
                                <img :src="v.image ? v.image.link : '/src/assets/images/user.jpg'"
                                    class="w-[20px] h-[20px] rounded-circular" alt="">
                                <span>{{ v.name.first_name }}</span>
                            </div>
                        </td>
                        <td class="p-xl font-regular ">{{ v.email }}</td>
                        <td class="p-xl font-regular ">{{ v.created_at }}</td>
                        <td class="p-xl font-regular ">12</td>
                        <td class="p-xl font-regular ">{{ v.country }}</td>
                        <td class="p-xl font-regular ">{{ v.latest_authentication ? v.latest_authentication.login_at : "" }}
                        </td>
                        <td class="p-xl font-regular ">{{ v.status ? 'Active' : "Blocked" }}</td>
                        <td @click="openTab(v)" class="p-xl font-regular cursor-pointer ">
                            <Options></Options>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <user-tab v-if="Object.keys(payload.tabData).length > 0" :tabData="payload.tabData" @close="closeTab()"></user-tab>
</template>

<script setup>

import axios from 'axios'
import { onBeforeMount, ref } from 'vue'

// Icons
import Filter from "@/components/icons/filter.vue"
import Plus from "@/components/icons/plus.vue"
import Search from "@/components/icons/search.vue"
import Options from "@/components/icons/options.vue"

// Modules
import Input from "@/components/modules/input.vue"
import Button from "@/components/modules/button.vue"

// Chunks
import userTab from "@/components/chunks/user-tab.vue"



const payload = ref({
    onload: false,
    users: {},
    tabs: 'basic',
    tabData: {}
});

// Toggle tab
function openTab(data) {
    payload.value.tabData = data;
}
function closeTab() {
    payload.value.tabData = {};
}


onBeforeMount(() => {
    payload.value.onload = true

    axios.get('/admin/user?account=student').then((e) => {
        payload.value.onload = false;
        payload.value.users = e.data.data.data
    }).catch((e) => {
        console.log(e)
    })
})
</script>