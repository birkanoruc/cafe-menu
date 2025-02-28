<template>
    <form @submit.prevent="update">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div
                    class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                >
                    <div class="sm:col-span-3">
                        <label
                            for="firstname"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Adınız</label
                        >
                        <div class="mt-2">
                            <input
                                type="text"
                                v-model="firstname"
                                name="firstname"
                                id="firstname"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                        </div>
                        <ul
                            v-if="errors.firstname"
                            class="text-red-500 text-sm mt-1"
                        >
                            <li
                                v-for="(error, index) in errors.firstname"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <div class="sm:col-span-3">
                        <label
                            for="lastname"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Soyadınız</label
                        >
                        <div class="mt-2">
                            <input
                                type="text"
                                v-model="lastname"
                                name="lastname"
                                id="lastname"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                        </div>
                        <ul
                            v-if="errors.lastname"
                            class="text-red-500 text-sm mt-1"
                        >
                            <li
                                v-for="(error, index) in errors.lastname"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900">
                İptal
            </button>
            <button
                type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Kaydet
            </button>
        </div>
    </form>
</template>

<script setup>
import { useAuthStore } from "@/stores/auth";
import { ref } from "vue"; // Reactive data için ref kullanıyoruz
import { useToast } from "vue-toastification";

const authStore = useAuthStore();
const toast = useToast();

const firstname = ref(authStore.user.firstname || "");
const lastname = ref(authStore.user.lastname || "");
const errors = ref({});

const update = async () => {
    const data = {
        firstname: firstname.value,
        lastname: lastname.value,
    };

    await authStore.updateProfileInformation(data);

    if (authStore.success) {
        errors.value = {};

        toast.success(authStore.message);
    } else {
        errors.value = authStore.errors;

        toast.error(authStore.message);
    }
};
</script>
