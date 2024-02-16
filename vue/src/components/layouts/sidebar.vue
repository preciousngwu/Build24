<template>
    <div class="w-fit  overflow-y-auto h-full bg-sidebar-background-dark border-r border-r-sidebar-border-primary">
        <div class="w-[52px] h-full flex flex-col justify-between ">
            <div class="w-full h-fit">
                <div
                    class=" hover:cursor-pointer  grid place-content-center h-[52px] border-b border-sidebar-border-primary">
                    <hambuger></hambuger>
                </div>
                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center h-[52px]">
                    <dashboard></dashboard>
                </div>
                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center h-[52px]">
                    <sidebarUser></sidebarUser>
                </div>

                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center h-[52px]">
                    <sidebarCap></sidebarCap>
                </div>

                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center h-[52px]">
                    <sidebarUsers></sidebarUsers>
                </div>
            </div>
            <div class="w-full h-fit">
                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center h-[52px]">
                    <sidebar-hint></sidebar-hint>
                </div>
                <div class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center h-[52px]">
                    <sidebar-setting></sidebar-setting>
                </div>

                <form @click="logout()" class="hover:bg-sidebar-background-accent-A hover:cursor-pointer grid place-content-center h-[52px]">
                    <Logout></Logout>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>

import axios from 'axios';
import router from '@/router/index.js'
// Icons
import hambuger from "@/components/icons/hambuger.vue"
import dashboard from "@/components/icons/dashboard.vue"
import sidebarUser from "@/components/icons/sidebar-user.vue"
import sidebarCap from "@/components/icons/sidebar-cap.vue"
import sidebarUsers from "@/components/icons/sidebar-users.vue"
import sidebarHint from "@/components/icons/sidebar-hint.vue"
import sidebarSetting from "@/components/icons/sidebar-setting.vue"
import Logout from "@/components/icons/logout.vue"



function logout() {
    axios.post('logout').then(() => {
        router.push({ name: 'login' })
    })
}


</script>