import { createApp } from "vue";

const application = createApp({
    components: {
    }
})

if (document.getElementById('admin')) {
    application.mount('#admin');
}
