<template>
    <div class="flex flex-col h-full bg-background-secondary">
        <div class="flex flex-col">
            <Header></Header>
            <Summary></Summary>
        </div>
        <users></users>
    </div>
</template>

<script setup>
import axios from 'axios'
import { onBeforeMount, onMounted, ref } from 'vue'


// Layouts
import Header from "@/components/layouts/header.vue"
import Summary from "@/components/layouts/summary.vue"

// Modules
import users from "@/components/chunks/users.vue"

</script>