import { createApp } from "vue";
import { createPinia } from "pinia";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import router from "@/routes";
import App from "@/App.vue";

import "./bootstrap";

const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);
app.use(Toast);
app.mount("#app");

import { useAuthStore } from "@/Stores/auth";
const authStore = useAuthStore();

setInterval(async () => {
    try {
        await authStore.refreshToken();
    } catch (error) {
        router.push({ name: "login" });
    }
}, 15 * 60 * 1000); // 15 dakika = 900.000 ms
