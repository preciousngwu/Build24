<template>
    <div class="flex flex-col h-full">
        <div class="flex flex-col">
            <Header></Header>
            <Summary></Summary>
        </div>
        <div class="p-2xl bg-background-secondary  overflow-y-auto">
            <div class=" flex flex-col border border-border-secondary  rounded-lg  ">
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
                <table>
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
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>

                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                        <tr class="bg-white text-content-secondary text-sm">
                            <td class="p-xl font-regular ">Kim Joffery</td>
                            <td class="p-xl font-regular ">kim.jof@gmail.com</td>
                            <td class="p-xl font-regular ">Jan 24, 2024</td>
                            <td class="p-xl font-regular ">12</td>
                            <td class="p-xl font-regular ">Romania</td>
                            <td class="p-xl font-regular ">4 hours ago</td>
                            <td class="p-xl font-regular ">Active</td>
                            <td class="p-xl font-regular ">
                                <Options></Options>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios'
import { onMounted } from 'vue'

// Icons
import Filter from "@/components/icons/filter.vue"
import Plus from "@/components/icons/plus.vue"
import Search from "@/components/icons/search.vue"
import Options from "@/components/icons/options.vue"


// Layouts
import Header from "@/components/layouts/header.vue"
import Summary from "@/components/layouts/summary.vue"

// Modules
import Input from "@/components/modules/input.vue"
import Button from "@/components/modules/button.vue"





onMounted(() => {
    axios.post('')
        .then((e) => {
            console.log(e)
        })
        .catch((e) => {
            console.log(e)
        })
})
</script>