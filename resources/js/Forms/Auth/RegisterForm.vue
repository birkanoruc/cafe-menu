<template>
    <form @submit.prevent="register" class="space-y-6">
        <div>
            <label
                for="firstname"
                class="block text-sm/6 font-medium text-gray-900"
                >Ad:</label
            >
            <input
                type="text"
                v-model="firstname"
                id="firstname"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                required
            />
            <ul v-if="errors?.firstname" class="text-red-500 text-sm mt-1">
                <li v-for="(error, index) in errors?.firstname" :key="index">
                    {{ error }}
                </li>
            </ul>
        </div>
        <div>
            <label
                for="lastname"
                class="block text-sm/6 font-medium text-gray-900"
                >Soyad:</label
            >
            <input
                type="text"
                v-model="lastname"
                id="lastname"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                required
            />
            <ul v-if="errors?.lastname" class="text-red-500 text-sm mt-1">
                <li v-for="(error, index) in errors?.lastname" :key="index">
                    {{ error }}
                </li>
            </ul>
        </div>
        <div>
            <label
                for="username"
                class="block text-sm/6 font-medium text-gray-900"
                >Kullanıcı Adı:</label
            >
            <input
                type="text"
                v-model="username"
                id="username"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                required
            />
            <ul v-if="errors?.username" class="text-red-500 text-sm mt-1">
                <li v-for="(error, index) in errors?.username" :key="index">
                    {{ error }}
                </li>
            </ul>
        </div>
        <div>
            <label for="email" class="block text-sm/6 font-medium text-gray-900"
                >E-Posta:</label
            >
            <input
                type="email"
                v-model="email"
                id="email"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                required
            />
            <ul v-if="errors?.email" class="text-red-500 text-sm mt-1">
                <li v-for="(error, index) in errors?.email" :key="index">
                    {{ error }}
                </li>
            </ul>
        </div>
        <div>
            <label
                for="password"
                class="block text-sm/6 font-medium text-gray-900"
                >Şifre:</label
            >
            <input
                type="password"
                v-model="password"
                id="password"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                required
            />
            <ul v-if="errors?.password" class="text-red-500 text-sm mt-1">
                <li v-for="(error, index) in errors?.password" :key="index">
                    {{ error }}
                </li>
            </ul>
        </div>
        <div class="mb-6">
            <label
                for="password_confirmation"
                class="block text-sm/6 font-medium text-gray-900"
                >Şifreyi Onayla:</label
            >
            <input
                type="password"
                v-model="password_confirmation"
                id="password_confirmation"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                required
            />
            <ul
                v-if="errors?.password_confirmation"
                class="text-red-500 text-sm mt-1"
            >
                <li
                    v-for="(error, index) in authStores.errors
                        .password_confirmation"
                    :key="index"
                >
                    {{ error }}
                </li>
            </ul>
        </div>

        <div>
            <button
                type="submit"
                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Kayıt Ol
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
        const router = useRouter();

        const firstname = ref("");
        const lastname = ref("");
        const email = ref("");
        const username = ref("");
        const password = ref("");
        const password_confirmation = ref("");
        const errors = ref({});

        const register = async () => {
            const userData = {
                firstname: firstname.value,
                lastname: lastname.value,
                email: email.value,
                username: username.value,
                password: password.value,
                password_confirmation: password_confirmation.value,
            };

            await authStore.register(userData);

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
            firstname,
            lastname,
            email,
            username,
            password,
            password_confirmation,
            register,
            errors,
        };
    },
};
</script>
