import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useUserStore = defineStore('users', () => {
  const data = ref(undefined);

  function clearUser() {
    data.value = undefined
  }

  return { data, clearUser }
})
