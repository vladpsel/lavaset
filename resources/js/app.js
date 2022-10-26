import { createApp } from "vue";
import AdminApp from "./vue/AdminApp";

const application = createApp({
    components: {
        AdminApp,
    }
})

if (document.getElementById('admin')) {
    application.mount('#admin');
}
