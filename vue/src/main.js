import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import jquery from "jquery";
import axios from 'axios'

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.baseURL = import.meta.env.VITE_API_BASEURL;

window.$ = jquery

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')


// Add a request interceptor
axios.interceptors.request.use(async function (config) {
    if ((
        config.method == 'post' ||
        config.method == 'put' ||
        config.method == 'delete'
    )) {
        const url = import.meta.env.VITE_API_BASEURL.toString().replace('/api/', '')
        await axios.get(url + '/sanctum/csrf-cookie')
    }

    return config;
}, function (error) {
    // Do something with request error
    console.error(error)
    return Promise.reject(error);
});



// Add a response interceptor
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response != undefined && error.response.status == 401) {
            router.push({ name: 'login' })
        }
        throw error;
    });