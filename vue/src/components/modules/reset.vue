<template>
    <div v-if="!preload.status" class="grid place-content-center w-full h-full bg-background-primary px-md">
        <form @submit.prevent="sendLink()"
            class="grid gap-2xl rounded-lg border border-border-secondary px-2xl lg:px-4xl pt-4xl pb-5xl">
            <div v-if="type == 'email'" class="pb-lg flex justify-center">
                <img class="w-[145.9px]" src="@/assets/images/email-vector.png" alt="">
            </div>

            <error-event v-if="preload.error">
                {{ preload.error }}
            </error-event>

            <div class="text-center text-content-secondary grid gap-sm">
                <h3 class="font-semibold text-xl">Reset your {{ route.params.type }}</h3>
                <p class="text-sm">Add your email where you will receive a verification to reset</p>
            </div>
            <div class="grid gap-md">
                <div class="relative">
                    <div class="h-full w-fit absolute top-0 grid place-items-center left-lg">
                        <envelope></envelope>
                    </div>
                    <input v-model="form.email" class="py-md pr-lg pl-[40px] border border-border-primary w-full rounded-lg"
                        type="email" placeholder="e.g. olivia@gmail.com">
                </div>
            </div>
            <Button :load="preload.load">
                <template v-slot:icon>
                    <resend></resend>
                </template>

                <template v-slot:text>
                    Get verification link
                </template>
            </Button>
        </form>
    </div>

    <div v-else class="grid place-content-center w-full h-full bg-background-primary px-md">
        <form @submit.prevent="sendLink()"
            class="grid gap-2xl rounded-lg border border-border-secondary px-2xl lg:px-4xl pt-4xl pb-5xl">
            <div class="pb-lg flex justify-center">
                <img class="w-[145.9px]" src="@/assets/images/mailsent.png" alt="">
            </div>

            <error-event v-if="preload.error">
                {{ preload.error }}
            </error-event>

            <div class="text-center text-content-secondary grid gap-sm">
                <h3 class="font-semibold text-xl">Verification email sent</h3>
                <p class="text-sm">A confirmation email is sent at {{ form.email }} </p>
            </div>

            <Button :load="preload.load">
                <template v-slot:icon>
                    <resend></resend>
                </template>

                <template v-slot:text>
                    Resend Link
                </template>
            </Button>

        </form>
    </div>
</template>

<script setup>

// icons
import resend from "@/components/icons/resend.vue"
import envelope from "@/components/icons/envelope.vue"
import errorEvent from "@/components/modules/error-event.vue"

// Modules
import Button from "@/components/modules/button.vue"

import { useRoute } from "vue-router"
import axios from 'axios'
import { ref } from "vue";

const props = defineProps({
    type: String
})
const emits = defineEmits(['sent']);

const route   = useRoute();
const preload = ref({
    status: false,
    load: false,
    error: ""
})

const form = ref({
    email: ""
})

function sendLink() {
    if (preload.value.load) {
        return
    }

    preload.value.load   = true;
    axios.post('send_token/' + route.params.type, form.value).then(() => {
        preload.value.load   = false;
        preload.value.status = true;
        emits('sent');
    }).catch((e) => {
        preload.value.load = false;
        preload.value.error = e.response.data.message;
    })
}
</script>