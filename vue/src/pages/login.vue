<template>
    <div class="flex flex-col justify-center h-full">
        <div class="flex md:justify-center w-full h-fit bg-background-primary px-md">
            <form @submit.prevent="login()"
                class="md:w-fit w-full h-fit grid gap-2xl rounded-lg border border-border-secondary px-2xl md:px-4xl pt-4xl pb-5xl">
                <div class="pb-lg flex justify-center">
                    <img class="w-[145.9px]" src="@/assets/images/logo-w-text.png" alt="">
                </div>
                <div class="text-center text-content-secondary grid gap-sm">
                    <h3 class="font-semibold text-xl">Sign in to Build24 learning center</h3>
                    <p class="text-sm">Hey there! log in to your account</p>
                </div>
                <error-event v-if="payload.error">
                    {{ payload.error }}
                </error-event>
                <div class="grid gap-md">
                    <label class="flex justify-between">
                        <span class="text-content-tertiary text-sm font-medium">Email</span>
                        <span v-if="is_admin()" class="text-content-accent-A text-xs font-medium">
                            <router-link to="/reset/email">Reset email</router-link>
                        </span>
                    </label>
                    <Input @get="payload.form.email = $event" :type="'email'" :placeholder="'e.g. olivia@gmail.com'">
                    <template v-slot:start>
                        <envelope></envelope>
                    </template>
                    </Input>
                </div>

                <div class="grid gap-md">
                    <label class="flex justify-between">
                        <span class="text-content-tertiary text-sm font-medium">Password</span>
                        <span class="text-content-accent-A text-xs font-medium">
                            <router-link to="/reset/password">Forgot password?</router-link>
                        </span>
                    </label>

                    <div class="relative h-fit ">
                        <div class="h-full w-fit absolute top-0 grid place-items-center left-lg">
                            <locked></locked>
                        </div>
                        <div class="h-full w-fit absolute top-0 grid place-items-center right-lg">
                            <eyeOpen v-if="!payload.see" @click="payload.see = true"></eyeOpen>
                            <eyeClose v-if="payload.see" @click="payload.see = false"></eyeClose>
                        </div>
                        <input v-model="payload.form.password"
                            class="lg:min-w-[378px] w-full  text-start py-md pr-lg pl-[40px] border  border-border-primary  rounded-lg height "
                            :type="(payload.see ? 'text' : 'password')">
                    </div>
                </div>

                <Button :type="'submit'" :load="payload.load">
                    <template v-slot:icon>
                        <arrowRight></arrowRight>
                    </template>
                    <template v-slot:text>
                        Sign in
                    </template>
                </Button>

            </form>
        </div>
    </div>
</template>

<script setup>

import { onMounted, ref } from "vue";
import axios from 'axios'
import router from "@/router/index.js"
import { is_admin } from "@/helper.js"

// Icons
import envelope from "@/components/icons/envelope.vue"
import locked from "@/components/icons/locked.vue"
import eyeOpen from "@/components/icons/eye-open.vue"
import eyeClose from "@/components/icons/eye-close.vue"
import arrowRight from "@/components/icons/arrow-right.vue"


// Modules
import Button from "@/components/modules/button.vue"
import Input from "@/components/modules/input.vue"
import errorEvent from "@/components/modules/error-event.vue"

const payload = ref({
    form: {
        account: is_admin()
    },
    see: false,
    error: "",
    load: false,
})

function login() {

    if (payload.value.load) {
        return
    }

    payload.value.load = true;
    axios.post('login', payload.value.form).then((e) => {
        payload.value.load = false;
        router.push("/")
    }).catch((e) => {
        console.log(e)
        payload.value.load = false;
        payload.value.error = e.response.data.message
    })
}
</script>

