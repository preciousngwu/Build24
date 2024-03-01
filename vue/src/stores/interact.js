import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useInteractStore = defineStore('interact', () => {
    const config = ref({
        alert: false,
        open: false,
        content: "",
        title: "",
        icon: "",
        accept: "",
        error: false
    });

    const def = ref({
        alert: false,
        open: false,
        content: "",
        title: "",
        icon: "",
        accept: "",
        error: false
    })

    const callbacks = ref({
        accept: undefined,
        cancel: undefined
    })

    function notify(conf, call) {
        config.value = conf
        callbacks.value = call

        if (config.value.alert) {
            setTimeout(() => {
                suppress()
            }, 3000)
        }
    }

    function suppress() {
        config.value = def.value
    }

    const is_notified = computed(() => {
        return config.value.open;
    })

    const is_alerted = computed(() => {
        return config.value.alert;
    })

    const is_error = computed(() => {
        return config.value.error;
    })

    function accept() {
        suppress()
        const func = callbacks.value.accept;
        if (func != undefined) {
            func()
        }
    }

    function cancel() {
        suppress()

        const func = callbacks.value ? callbacks.value.cancel : undefined;
        if (func != undefined) {
            func()
        }
    }


    return { notify, suppress, is_notified, is_alerted, is_error, accept, cancel, config }
})
