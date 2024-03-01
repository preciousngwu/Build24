<template>
    <!-- User Right bar -->
    <div v-if="tabData !== undefined && Object.keys(tabData).length > 0"
        class="bg-background-overlay fixed w-full h-full flex justify-end top-0 right-0 ">
        <div class=" bg-background-primary w-[613px] ">

            <div class="flex flex-col">
                <!-- Header section -->
                <div
                    class="flex items-start py-2xl pl-2xl pr-lg gap-lg  border-b border-border-secondary h-fit justify-between">
                    <div class="flex gap-lg">
                        <div @click="$emit('close')" class="p-md cursor-pointer">
                            <Close></Close>
                        </div>
                        <div class="flex items-center gap-lg">
                            <img :src="tabData.image ? tabData.image.link : '/src/assets/images/user.jpg'"
                                class="w-[64px] h-[64px] rounded-circular" alt="">
                            <div class="grid gap-sm">
                                <HeaderText>{{ tabData.name.first_name }}</HeaderText>
                                <smallText :font="'medium'" :color="'content-secondary'">{{ tabData.email }}</smallText>
                            </div>
                        </div>
                    </div>
                    <div ref="dropdown" tabindex="0"
                        @click="payload.option ? payload.option = false : payload.option = true" class="p-md">
                        <Options></Options>
                        <div v-if="payload.option"
                            class="bg-background-primary min-w-[245px] drop-shadow-[0_4px_6px_#0000000D] absolute right-3 border border-primary rounded-lg py-lg grid gap-lg">
                            <div @click="interactStore.notify({ open: true }, { accept: banUser })"
                                class="flex items-center gap-md px-lg cursor-pointer">
                                <ban></ban>
                                <smallText>Ban user account</smallText>
                            </div>
                            <div class="flex items-center gap-md px-lg cursor-pointer">
                                <sidebar-cap :fill="'#6B7280'"></sidebar-cap>
                                <smallText>Add user to course</smallText>
                            </div>
                            <div @click="payload.editUser = true" class="flex items-center gap-md px-lg cursor-pointer">
                                <edit></edit>
                                <smallText>Edit user account</smallText>
                            </div>
                            <div class="flex items-center gap-md px-lg cursor-pointer">
                                <Locked></Locked>
                                <smallText>Reset user password</smallText>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Options -->
                <div class="px-2xl flex gap-2xl border-b border-border-secondary">
                    <smallText @click="payload.tabs = 'basic'"
                        :Class="'py-xl cursor-pointer ' + (payload.tabs == 'basic' ? '!text-content-accent-A border-b-xs border-border-accent-A ' : '')"
                        :font="'medium'">
                        Basic
                    </smallText>
                    <smallText @click="payload.tabs = 'activities'"
                        :Class="'py-xl cursor-pointer ' + (payload.tabs == 'activities' ? '!text-content-accent-A border-b-xs border-border-accent-A ' : '')"
                        :font="'medium'">
                        Activities
                    </smallText>
                    <smallText @click="payload.tabs = 'notes'"
                        :Class="'py-xl cursor-pointer ' + (payload.tabs == 'notes' ? '!text-content-accent-A border-b-xs border-border-accent-A ' : '')"
                        :font="'medium'">
                        Notes
                    </smallText>
                </div>

                <!-- Basic -->
                <div v-if="payload.tabs == 'basic'" class="grid">
                    <div class="p-2xl h-fit  border-b border-border-secondary">
                        <div class="grid gap-2xl">
                            <smallText :font="'medium'" :color="'content-tertiary'" :Class="'uppercase'">Biography
                            </smallText>

                            <div class="grid grid-cols-3">
                                <div class="grid gap-md">
                                    <smallText :font="'medium'" :color="'content-tertiary'" :Class="'uppercase'">First name
                                    </smallText>
                                    <smallText :color="'content-tertiary'">{{ tabData.name.first_name }}</smallText>
                                </div>

                                <div class="grid gap-md">
                                    <smallText :font="'medium'" :color="'content-tertiary'" :Class="'uppercase'">Last name
                                    </smallText>
                                    <smallText :color="'content-tertiary'">
                                        {{ tabData.name.last_name }}
                                    </smallText>
                                </div>

                                <div class="grid gap-md">
                                    <smallText :font="'medium'" :color="'content-tertiary'" :Class="'uppercase'">
                                        Last login
                                    </smallText>
                                    <smallText :color="'content-tertiary'">
                                        {{ tabData.latest_authentication ? tabData.latest_authentication.login_at : "" }}
                                    </smallText>
                                </div>
                            </div>

                            <div class="grid grid-cols-3">
                                <div class="grid gap-md">
                                    <smallText :font="'medium'" :color="'content-tertiary'" :Class="'uppercase'">Phone
                                    </smallText>
                                    <smallText :color="'content-tertiary'">
                                        {{ tabData.phone ?? "Empty" }}
                                    </smallText>
                                </div>

                                <div class="grid gap-md">
                                    <smallText :font="'medium'" :color="'content-tertiary'" :Class="'uppercase'">Created_at
                                    </smallText>
                                    <smallText :color="'content-tertiary'">
                                        {{ tabData.created_at }}
                                    </smallText>
                                </div>

                                <div class="grid gap-md">
                                    <smallText :font="'medium'" :color="'content-tertiary'" :Class="'uppercase'">
                                        Country
                                    </smallText>
                                    <smallText :color="'content-tertiary'">
                                        {{ tabData.country ?? 'Empty' }}
                                    </smallText>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2xl h-fit border-b border-border-secondary grid gap-2xl">
                        <smallText :color="'content-tertiary'" :class="'uppercase'">
                            courses
                        </smallText>

                        <div class="grid gap-md">
                            <smallText :font="'medium'" :color="'content-primary'" :size="'sm'">Learn photography in 45 days
                            </smallText>

                            <div class="flex gap-md">
                                <Button :width="'w-fit'"
                                    :classnames="'!bg-background-accent-A-light text-content-tertiary capitalize'"
                                    :text="'content-accent-A'">
                                    <template v-slot:text>
                                        User level 1
                                    </template>
                                </Button>

                                <Button :width="'w-fit'"
                                    :classnames="'!bg-background-accent-A-light text-content-tertiary capitalize'"
                                    :text="'content-accent-A'">
                                    <template v-slot:text>
                                        User level 1
                                    </template>
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Activities -->
                <div v-if="payload.tabs == 'activities'" class="grid gap-xl">
                    <div class="p-2xl h-fit grid gap-2xl">
                        <div class="grid grid-cols-2 w-full gap-lg">
                            <Select :classnames="' text-content-tertiary'">
                                <template v-slot:disabled>Filter by type</template>
                            </Select>
                            <Select :classnames="' text-content-tertiary'">
                                <template v-slot:disabled>Filter by date</template>
                            </Select>
                        </div>
                        <div class="flex items-center gap-md">
                            <img src="@/assets/images/activity-login.svg" alt="">
                            <div class="grid">
                                <smallText :color="'content-tertiary'" :font="'medium'">
                                    Logged in 4 mins ago
                                </smallText>

                                <smallText :size="'xs'" :color="'content-tertiary'">
                                    08 Feb, 2024 at 11:32pm
                                </smallText>
                            </div>
                        </div>

                        <div class="flex items-center gap-md">
                            <img src="@/assets/images/activity-watch.svg" alt="">
                            <div class="grid">
                                <smallText :color="'content-tertiary'" :font="'medium'">
                                    Logged in 4 mins ago
                                </smallText>

                                <smallText :size="'xs'" :color="'content-tertiary'">
                                    08 Feb, 2024 at 11:32pm
                                </smallText>
                            </div>
                        </div>

                        <div class="flex items-center gap-md">
                            <img src="@/assets/images/activity-ban.svg" alt="">
                            <div class="grid">
                                <smallText :color="'content-tertiary'" :font="'medium'">
                                    Logged in 4 mins ago
                                </smallText>

                                <smallText :size="'xs'" :color="'content-tertiary'">
                                    08 Feb, 2024 at 11:32pm
                                </smallText>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notes -->
                <div v-if="payload.tabs == 'notes'" class="grid gap-xl">
                    <div class="p-2xl h-fit grid gap-2xl">
                        <div class="grid gap-md ">
                            <smallText :color="'content-tertiary'" :font="'medium'">
                                Write notes here
                            </smallText>

                            <div
                                class="border border-border-primary  rounded-lg grid gap-md  px-xl pt-xl pl-md pb-md pr-xl">
                                <text-area :classnames="'!pr-2 !pt-0 !border-none'"></text-area>
                                <div class="w-full flex justify-end">
                                    <Button :width="'w-fit'" :classnames="'!bg-transparent border border-border-primary '"
                                        :text="'content-tertiary'">
                                        <template v-slot:text>
                                            Add note
                                        </template>
                                    </Button>
                                </div>
                            </div>
                        </div>
                        <div class=" bg-background-secondary p-xl grid gap-md rounded-lg">
                            <smallText>
                                We're glad to be leading the future of startup development through incubators and
                                accelerators.
                                We're glad to be leading the future of startup development through incubators and
                                accelerators.
                            </smallText>

                            <smallText :size="'xs'" :color="'content-tertiary'">
                                08 Feb, 2024 at 11:32pm
                            </smallText>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- // Edit modal -->
        <user-edit @close="payload.editUser = false" v-if="payload.editUser" :user="tabData"></user-edit>

    </div>
</template>

<script setup>

import axios from "axios";
import { onMounted, ref } from "vue";
import { useInteractStore } from "@/stores/interact"

import userEdit from "@/components/chunks/user-edit.vue"



// Modules
import inputVue from "@/components/modules/input.vue"
import Button from "@/components/modules/button.vue"
import smallText from "@/components/modules/smallText.vue"
import HeaderText from '@/components/modules/headerText.vue'
import Select from '@/components/modules/select.vue'
import textArea from '@/components/modules/text-area.vue'


// Icons
import Options from "@/components/icons/options.vue"
import Close from '@/components/icons/close.vue'
import sidebarCap from '@/components/icons/sidebar-cap.vue'
import Locked from "@/components/icons/locked.vue";
import edit from "@/components/icons/edit.vue";
import ban from "@/components/icons/ban.vue";

const interactStore = useInteractStore();

const props = defineProps({
    tabData: Object,
})

defineEmits(['close'])

const dropdown = ref('');
const payload = ref({
    tabs: 'basic',
    option: false,
    editUser: false
});

function banUser(u) {
    axios.post('/admin/user/update', { user_id: props.tabData.id, status: false }).then((e) => {
        console.log(e)
    }).catch((e) => {
        console.log(e)
    })
}

onMounted(() => {
    dropdown.value.addEventListener('blur', (e) => {
        payload.value.option = false
    });
})

</script>