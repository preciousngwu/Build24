<template>
    <div
        class="w-fit overflow-x-hidden  overflow-y-auto h-full bg-sidebar-background-dark border-r border-r-sidebar-border-primary">
        <div class=" h-full flex flex-col justify-between ">
            <div class="w-full h-fit">
                <div class=" hover:cursor-pointer  grid place-content-center p-xl border-b border-sidebar-border-primary">
                    <hambuger></hambuger>
                </div>
                <router-link :to="{ name: 'dash.home' }">
                    <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center p-xl">
                        <dashboard></dashboard>
                    </div>
                </router-link>

                <!-- <router-link :to="{ name: 'dash.course' }"> -->
                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center p-xl">
                    <sidebarUser>
                    </sidebarUser>
                </div>
                <!-- </router-link> -->

                <router-link :to="{ name: 'dash.course' }">
                    <div
                        :class="(router.currentRoute.value.name.includes('course') ? 'bg-sidebar-background-accent-A' : '') + ' hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center p-xl'">
                        <sidebarCap :fill="(router.currentRoute.value.name.includes('course') ? '#FFFFFF' : undefined)">
                        </sidebarCap>
                    </div>
                </router-link>

                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center p-xl">
                    <sidebarUsers></sidebarUsers>
                </div>
            </div>
            <div class="w-full h-fit">
                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center p-xl">
                    <sidebar-hint></sidebar-hint>
                </div>
                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center p-xl">
                    <sidebar-setting></sidebar-setting>
                </div>

                <form @click="logout()"
                    class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center p-xl">
                    <Logout></Logout>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>

import axios from 'axios';
import router from '@/router/index.js'
import { useUserStore } from "@/stores/users"


// Icons
import hambuger from "@/components/icons/hambuger.vue"
import dashboard from "@/components/icons/dashboard.vue"
import sidebarUser from "@/components/icons/sidebar-user.vue"
import sidebarCap from "@/components/icons/sidebar-cap.vue"
import sidebarUsers from "@/components/icons/sidebar-users.vue"
import sidebarHint from "@/components/icons/sidebar-hint.vue"
import sidebarSetting from "@/components/icons/sidebar-setting.vue"
import Logout from "@/components/icons/logout.vue"


const userStore = useUserStore();


function logout() {
    axios.post('logout').then(() => {
        userStore.clearUser()

        router.currentRoute
        router.push({ name: 'login' })
    })
}


</script>