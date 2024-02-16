<template>
  <div class="w-full h-full flex">
    <sidebar v-if="is_dash"></sidebar>
    <div class="w-full h-full ">
      <RouterView></RouterView>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import sidebar from "@/components/layouts/sidebar.vue"


const route = useRoute();

const is_dash = computed(() => {
  return (route.name != undefined && route.name.includes('dash'));
})

</script>