<template>
    <form class="space-y-6" @submit.prevent="login">
        <div>
            <label for="email" class="block text-sm/6 font-medium text-gray-900"
                >E-Posta</label
            >
            <div class="mt-2">
                <input
                    v-model="email"
                    type="email"
                    name="email"
                    id="email"
                    autocomplete="email"
                    required=""
                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
                <ul v-if="errors.email" class="text-red-500 text-sm mt-1">
                    <li v-for="(error, index) in errors.email" :key="index">
                        {{ error }}
                    </li>
                </ul>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label
                    for="password"
                    class="block text-sm/6 font-medium text-gray-900"
                    >Parola</label
                >
                <div class="text-sm">
                    <router-link
                        to="forgot-password"
                        class="font-semibold text-indigo-600 hover:text-indigo-500"
                        >Parolanızı mı unuttunuz?</router-link
                    >
                </div>
            </div>
            <div class="mt-2">
                <input
                    v-model="password"
                    type="password"
                    name="password"
                    id="password"
                    autocomplete="current-password"
                    required=""
                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
                <ul v-if="errors.password" class="text-red-500 text-sm mt-1">
                    <li v-for="(error, index) in errors.password" :key="index">
                        {{ error }}
                    </li>
                </ul>
            </div>
        </div>

        <div>
            <button
                type="submit"
                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Oturum Aç
            </button>
        </div>
    </form>
</template>

<script>
import { useAuthStore } from "@/stores/auth";
import { ref } from "vue"; // Reactive data için ref kullanıyoruz
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";

export default {
    setup() {
        const authStore = useAuthStore();
        const toast = useToast();
        const router = useRouter(); // Vue Router'ı burada kullanıyoruz

        const email = ref("");
        const password = ref("");
        const errors = ref({});

        const login = async () => {
            const credentials = {
                email: email.value,
                password: password.value,
            };

            await authStore.login(credentials);

            if (authStore.success) {
                errors.value = {};

                toast.success(authStore.message);

                setTimeout(() => {
                    router.push({ name: "dashboard" }); // Yönlendirme işlemi
                }, 2000);
            } else {
                errors.value = authStore.errors;

                toast.error(authStore.message);
            }
        };

        return {
            email,
            password,
            errors,
            login,
        };
    },
};
</script>
