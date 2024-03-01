import router from "./router";



function is_admin() {
    const subdomain = window.location.hostname.split('.')[0];
    return subdomain == "admin" ? true : false;
}

function inspectRedirectFrom(r = '') {
    // const route = useRoute();
    // const subdomain = window.location.hostname.split('.')[0];

    // router.afterEach((to, from) => {
    //     console.log(from)
    // })
}

export { is_admin, inspectRedirectFrom };