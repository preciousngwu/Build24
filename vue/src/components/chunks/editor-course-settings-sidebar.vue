<template>
    <div class="h-full">
        <div class="grid gap-sm h-fit">
            <div class="w-full" @click="change('settings')">
                <Button :width="'w-full'"
                    :classnames="(config.tab == 'settings' ? 'border border-border-accent-A !bg-background-accent-A-light' : '!bg-transparent') + ('   text-nowrap !justify-start')"
                    :text="'content-tertiary'">
                    <template v-slot:text>
                        Basic settings
                    </template>
                </Button>
            </div>
            <div class="w-full" @click="change('levels')">
                <Button :width="'w-full'"
                    :classnames="(config.tab == 'levels' ? ' border border-border-accent-A !bg-background-accent-A-light' : '!bg-transparent') + ('  text-nowrap !justify-start')"
                    :text="'content-tertiary'">
                    <template v-slot:text>
                        User levels
                    </template>
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import Button from '@/components/modules/button.vue';
import { onBeforeMount, onMounted, ref } from 'vue';

const emits = defineEmits(['tab'])

const config = ref({
    tab: 'settings'
})

onMounted(() => {
    emits('tab', config.value.tab)
})
function change(v) {
    config.value.tab = v
    emits('tab', config.value.tab)
}
</script>