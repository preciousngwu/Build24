<template>
    <reset-vue v-if="!payload.verified"></reset-vue>

    <div v-else class="flex flex-col justify-center h-full">
        <div class="flex  justify-center  w-full h-fit bg-background-primary px-2xl">
            <form @submit.prevent="reset()"
                class="lg:w-fit w-full h-fit grid gap-2xl rounded-lg border border-border-secondary px-2xl md:px-4xl pt-4xl pb-5xl">
                <div class="text-center text-content-secondary grid gap-sm">
                    <h3 class="font-semibold text-xl">Reset your {{ route.params.type }}</h3>
                </div>

                <error-event v-if="payload.error">
                    {{ payload.error }}
                </error-event>


                <div v-if="route.params.type == 'email'" class="grid gap-md">
                    <label class="flex justify-between">
                        <span class="text-content-tertiary text-sm font-medium">Email</span>
                    </label>
                    <Input :id="'email'" :type="'email'" :placeholder="'e.g. olivia@gmail.com'">
                    <template v-slot:start>
                        <envelope></envelope>
                    </template>
                    </Input>
                </div>

                <div class="grid gap-md">
                    <label class="flex justify-between">
                        <span class="text-content-tertiary text-sm font-medium">Password</span>
                    </label>
                    <Input :id="'password'" :type="payload.seePassword ? 'text' : 'password'">
                    <template v-slot:start>
                        <locked></locked>
                    </template>

                    <template v-slot:end>
                        <eye-open v-if="!payload.seePassword" @click="payload.seePassword = true"></eye-open>
                        <eye-close v-if="payload.seePassword" @click="payload.seePassword = false"></eye-close>
                    </template>
                    </Input>
                </div>

                <div class="grid gap-md">
                    <label class="flex justify-between">
                        <span class="text-content-tertiary text-sm font-medium">Confirm Password</span>
                    </label>
                    <Input :id="'password_confirmation'" :type="payload.seeConfirm ? 'text' : 'password'">
                    <template v-slot:start>
                        <locked></locked>
                    </template>

                    <template v-slot:end>
                        <eye-open v-if="!payload.seeConfirm" @click="payload.seeConfirm = true"></eye-open>
                        <eye-close v-if="payload.seeConfirm" @click="payload.seeConfirm = false"></eye-close>
                    </template>
                    </Input>
                </div>

                <Button :load="payload.load">
                    <template v-slot:text>
                        <span v-if="route.params.type == 'email'" class="text-content-inverse-primary ">Log in</span>
                        <span v-if="route.params.type == 'password'" class="text-content-inverse-primary ">Confirm</span>
                    </template>
                </Button>

            </form>
        </div>

    </div>
</template>

<script setup>
import { useRoute } from "vue-router"
import { ref, onBeforeMount } from "vue";
import axios from "axios";
import router from "@/router/index.js"

// Icons
import envelope from "@/components/icons/envelope.vue"
import resend from "@/components/icons/resend.vue"
import eyeOpen from "@/components/icons/eye-open.vue"
import eyeClose from "@/components/icons/eye-close.vue"
import locked from "@/components/icons/locked.vue"

// Modules
import Button from "@/components/modules/button.vue"
import resetVue from "@/components/modules/reset.vue"
import Input from "@/components/modules/input.vue"
import errorEvent from "@/components/modules/error-event.vue"

const route = useRoute();
const payload = ref({
    verified: false,
    seePassword: false,
    seeConfirm: false,
    load: false,
    error: "",
})


function reset() {

    if (payload.value.load) {
        return
    }

    var form = {
        "holder": route.query.email,
        "token": route.query.token,
        "password": $('#password').val(),
        "password_confirmation": $('#password_confirmation').val()
    };

    if (route.params.type == "email") {
        form.email = $('#email').val()
    }

    payload.value.load = true;
    axios.post('reset/' + route.params.type, form).then(() => {
        payload.value.load = false;

        if (route.params.type == "password") {
            router.push({ name: "login" })
        }

        if (route.params.type == "email") {
            router.push({ name: "dash.home" })
        }
    }).catch((e) => {
        payload.value.load = false;
        payload.value.error = e.response.data.message;
    })

}

onBeforeMount(() => {
    if (route.query.token && route.query.email) {
        payload.value.verified = true
        axios.post('verify_token/' + route.params.type, route.query).then(() => {
            payload.value.verified = true
        }).catch((e) => {
            payload.value.verified = false
        })
    }
})

</script>