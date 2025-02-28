import axios from "axios";
import { useAuthStore } from "@/Stores/auth";
import { useRouter } from "vue-router";

const router = useRouter();

const api = axios.create({
    baseURL: "/api/v1",
    headers: {},
});

api.interceptors.request.use((config) => {
    const auth = useAuthStore();
    if (auth.token) {
        config.headers.Authorization = `Bearer ${auth.token}`;
    }
    return config;
});

api.interceptors.response.use(
    (response) => {
        return response;
    },
    async (error) => {
        if (error.response.status === 401) {
            router.push({ name: "login" });
        }
        return Promise.reject(error);
    }
);

export default api;
