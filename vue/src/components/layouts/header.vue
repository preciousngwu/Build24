<template>
    <header class=" border-b border-r-sidebar-border-primary h-[52px] flex justify-end px-xl bg-background-primary ">
        <div class="w-fit h-full grid place-content-center">
            <img :src="useStore.data.image ? useStore.data.image.link : '/src/assets/images/user.jpg'"
                class="w-[20px] h-[20px] rounded-circular">
        </div>
    </header>
</template>


<script setup>
import { useUserStore } from "@/stores/users"
const useStore = useUserStore()
</script>