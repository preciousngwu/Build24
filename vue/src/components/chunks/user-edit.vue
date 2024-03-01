<template>
    <div class="fixed top-0 right-0 h-full w-full grid place-content-center bg-background-overlay">
        <form @submit.prevent="edit()" class=" bg-background-primary p-2xl rounded-md grid gap-xl">
            <div class="grid gap-lg">
                <smallText :font="'bold'" :color="'content-primary'" :text="'md'">
                    Edit user account details
                </smallText>

                <input @change="getPreview()" ref="avatar" id="avatar" type="file" class="hidden">

                <div class="py-md px-lg grid gap-lg">
                    <label for="avatar" class="flex gap-md cursor-pointer ">
                        <img class="w-[64px] h-[64px] rounded-circular"
                            :src="preview ?? (user.image ? user.image.link : '/src/assets/images/user.jpg')" alt="">
                        <div class="grid gap-sm">
                            <smallText>Change picture</smallText>

                            <label for="avatar">
                                <Button :width="'w-fit'" :classnames="'bg-transparent border border-border-primary'"
                                    :text="'content-tertiary'">
                                    <template v-slot:icon>
                                        <upload></upload>
                                    </template>
                                    <template v-slot:text>
                                        upload image
                                    </template>
                                </Button>

                            </label>
                        </div>
                    </label>
                </div>

                <div>
                    <smallText :color="'content-tertiary'" :text="'md'">
                        Name
                    </smallText>
                    <InputVue @get="form.name = $event"
                        :value="user.name.first_name.concat(' ', user.name.middle_name ?? '', ' ', user.name.last_name)"
                        :placeholder="'jon snow'" :classnames="'!px-lg text-content-secondary'"></InputVue>
                </div>

                <div>
                    <smallText :color="'content-tertiary'" :text="'md'">
                        Email
                    </smallText>
                    <InputVue @get="form.email = $event" :value="user.email" :type="'email'"
                        :placeholder="'jon.snow@gmail.com'" :classnames="'!px-lg text-content-secondary'"></InputVue>
                </div>

                <div>
                    <smallText :color="'content-tertiary'" :text="'md'">
                        Contact no
                    </smallText>
                    <InputVue @get="form.phone = $event" :value="user.phone" type="'tel'" :placeholder="'+1 2222 23333'"
                        :classnames="'!px-lg text-content-secondary'">
                    </InputVue>
                </div>



                <div class="flex justify-end pt-xl  gap-lg">
                    <div @click="$emit('close')">
                        <Button :width="'w-fit'" :classnames="'bg-transparent border border-border-primary'"
                            :text="'content-tertiary'">
                            <template v-slot:text>
                                Cancel
                            </template>
                        </Button>
                    </div>


                    <Button :type="'submit'" :width="'w-fit'" :classnames="'bg-background-accent-A'"
                        :text="'content-inverse-primary'">
                        <template v-slot:text>
                            Update
                        </template>
                    </Button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import smallText from '@/components/modules/smallText.vue';
import Button from '@/components/modules/button.vue';

// Icons
import upload from '@/components/icons/upload.vue'
import InputVue from '../modules/input.vue';
import { ref, computed } from 'vue';
import axios from 'axios';
import { useInteractStore } from "@/stores/interact"

const interactStore = useInteractStore();

const props = defineProps({
    user: Object
})

defineEmits(['close', 'updated'])

const avatar = ref('')
const form = ref({})
const preview = ref(null)

const getPreview = () => {
    if (avatar.value.files != undefined && avatar.value.files.length > 0) {
        preview.value = URL.createObjectURL(avatar.value.files[0]);
    }
}


function edit() {

    const payload = new FormData();

    if (avatar.value.files != undefined && avatar.value.files.length > 0) {
        payload.append('avatar', avatar.value.files[0]);
    }

    for (const key in form.value) {
        payload.append(key, form.value[key])
    }
    payload.append('user_id', props.user.id)
    axios.post('/admin/user/update', payload).then((e) => {
        console.log(e)
        interactStore.notify({ alert: true, content: "updated successfully" })
    }).catch((e) => {
        console.log(e)
    })
}
</script>