<template>
  <div class="w-full h-full flex" v-if="(is_dash && userStore.data != undefined) || !is_dash">
    <sidebar v-if="is_dash"></sidebar>
    <div class="w-full h-full ">
      <RouterView></RouterView>
    </div>
  </div>


  <notice v-if="interactStore.is_notified" @accept="interactStore.accept()" @cancel="interactStore.cancel()">
    <template v-slot:title>
      Do you confirm to ban this user?
    </template>

    <template v-slot:content>
      You can unban this user account anytime in the future
    </template>


    <template v-slot:accept>
      Ban user account
    </template>
  </notice>


  <alert v-if="interactStore.is_alerted" @close="interactStore.cancel()" :error="interactStore.is_error">
    {{ interactStore.config.content }}
  </alert>
</template>

<script setup>
import { computed, onBeforeMount, onMounted } from "vue";
import sidebar from "@/components/layouts/sidebar.vue"
import axios from "axios";

import { useRoute } from "vue-router";
import { useUserStore } from "@/stores/users"
import { useInteractStore } from "@/stores/interact"
import router from "./router";
import { is_admin } from "@/helper.js"

import notice from '@/components/globals/notice.vue'
import alert from '@/components/globals/alert.vue'


const route = useRoute();
const userStore = useUserStore();
const interactStore = useInteractStore();

const is_dash = computed(() => {
  return (route.name != undefined && route.name.includes('dash'));
})

router.afterEach((to) => {
  if (is_admin() && is_dash.value && userStore.data == undefined) {
    axios.get('/admin/user/show').then((e) => {
      userStore.data = e.data.data
    }).catch(() => {
      userStore.clearUser()
    })
  }
})

onBeforeMount(() => {


})

</script>