function is_admin() {
    const  subdomain = window.location.hostname.split('.')[0];
    return subdomain == "admin" ? true : false;
}

export { is_admin };