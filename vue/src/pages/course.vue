
<template>
    <div class=" flex flex-col h-full">
        <div class="flex justify-between py-2xl px-3xl">
            <HeaderText>Courses</HeaderText>
            <div class="flex gap-md">
                <InputVue :placeholder="'Search course by name, description...'"
                    :classnames="'bg-background-primary h-full'">
                    <template v-slot:start>
                        <Search></Search>
                    </template>
                </InputVue>
                <div @click="configs.create = true">
                    <ButtonVue :width="'w-fit'" :classnames="'!bg-background-accent-A'">
                        <template v-slot:text>
                            Add new course
                        </template>
                    </ButtonVue>
                </div>

            </div>
        </div>
        <div class="grid xl:grid-cols-3 lg:grid-cols-2 gap-2xl flex-wrap overflow-y-auto h-full px-7xl pb-2xl">
            <div v-for="(v, i) in courses " :key="i"
                class=" h-fit border border-border-primary rounded-md pt-8 px-xl pb-xl">
                <div class="h-[100px] pb-xl">
                    <img :src="v.resource ? v.resource.link : '/src/assets/images/user.png'"
                        class="w-full rounded-md  h-full object-cover" alt="">

                </div>
                <div class="py-xl gap-md">
                    <p class="overflow-hidden text-ellipsis text-nowrap text-content-tertiary "><span class="font-medium">
                            Sign up link:</span> <a class="font-regular underline" href="">{{ v.summary }}</a></p>
                    <div class="grid gap-md py-md">
                        <SmallText :font="'semibold'">{{ v.title }}</SmallText>
                        <SmallText>
                            {{ v.summary }}
                        </SmallText>
                    </div>
                    <ButtonVue :text="'content-accent-A'" :classnames="'!bg-background-accent-A-light'" :width="'w-fit'">
                        <template v-slot:icon>
                            <SidebarUsers :fill="'#3B82F6'"></SidebarUsers>
                        </template>
                        <template v-slot:text>
                            23 students already enrolled
                        </template>
                    </ButtonVue>
                </div>
                <div class="flex gap-md justify-between items-center">
                    <div class="flex gap-md">
                        <ButtonVue :text="'content-tertiary'" :classnames="'!bg-transparent border border-border-primary  '"
                            :width="'w-fit'">
                            <template v-slot:icon>
                                <SidebarUsers></SidebarUsers>
                            </template>
                            <template v-slot:text>
                                <span class=" text-nowrap">View stats</span>
                            </template>
                        </ButtonVue>
                        <router-link :to="{ name: 'dash.editor', params: { course: v.id } }">
                            <ButtonVue :text="'content-tertiary'"
                                :classnames="'bg-transparent border border-border-primary '" :width="'w-fit'">
                                <template v-slot:icon>
                                    <SidebarUsers></SidebarUsers>
                                </template>
                                <template v-slot:text>
                                    <span class=" text-nowrap">Edit course</span>
                                </template>
                            </ButtonVue>
                        </router-link>
                    </div>
                    <EyeClose></EyeClose>
                </div>
            </div>
        </div>
    </div>

    <create-course @added="courses.push($event); configs.create = false" @close="configs.create = false"
        v-if="configs.create"></create-course>
</template>

<script setup>
import { useEditorStore } from '@/stores/editor';


import EyeClose from '@/components/icons/eye-close.vue';
import Search from '@/components/icons/search.vue';
import SidebarUsers from '@/components/icons/sidebar-users.vue';
import ButtonVue from '@/components/modules/button.vue';
import HeaderText from '@/components/modules/headerText.vue';
import InputVue from '@/components/modules/input.vue';
import SmallText from '@/components/modules/smallText.vue';

import createCourse from "@/components/chunks/create-course.vue"

import axios from 'axios';
import { onBeforeMount, ref } from 'vue';

const editor = useEditorStore();
const courses = ref({})
const configs = ref({
    create: false
})

onBeforeMount(() => {
    axios.get('/admin/course').then((e) => {
        courses.value = e.data.data.data
    })
})
</script>