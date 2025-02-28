<template>
    <DashboardLayout :pageTitle="'Gösterge Paneli'">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 lg:grid-cols-3">
            <div class="bg-green-800 shadow-md rounded-lg p-6 block">
                <div class="flex flex-col items-center">
                    <div class="flex-shrink-0">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="white"
                            class="h-12 w-12"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819"
                            />
                        </svg>
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="text-lg leading-6 font-medium text-white">
                            MEKANLARIM
                        </h3>
                        <p class="mt-1 text-2xl font-semibold text-white">
                            {{ venuesCount }}
                        </p>
                    </div>
                </div>
            </div>

            <router-link
                to="categories"
                class="bg-blue-800 shadow-md rounded-lg p-6 block"
            >
                <div class="flex flex-col items-center">
                    <div class="flex-shrink-0">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="white"
                            class="h-12 w-12"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122"
                            />
                        </svg>
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="text-lg leading-6 font-medium text-white">
                            KATEGORİLERİM
                        </h3>
                        <p class="mt-1 text-2xl font-semibold text-white">
                            {{ categoriesCount }}
                        </p>
                    </div>
                </div>
            </router-link>

            <router-link
                to="products"
                class="bg-yellow-600 shadow-md rounded-lg p-6 block"
            >
                <div class="flex flex-col items-center">
                    <div class="flex-shrink-0">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="white"
                            class="h-12 w-12"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"
                            />
                        </svg>
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="text-lg leading-6 font-medium text-white">
                            ÜRÜNLERİM
                        </h3>
                        <p class="mt-1 text-2xl font-semibold text-white">
                            {{ productsCount }}
                        </p>
                    </div>
                </div>
            </router-link>
        </div>

        <div
            class="mt-4 mb-4 hidden shrink-0 sm:flex sm:flex-col sm:items-start"
        ></div>

        <VenueList />
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import VenueList from "@/Lists/VenueList.vue";
import { useAuthStore } from "@/stores/auth";
import { onMounted, ref, watch } from "vue";

const authStore = useAuthStore();
const productsCount = ref(0);
const venuesCount = ref(0);
const categoriesCount = ref(0);

onMounted(() => {
    if (Object.keys(authStore.user).length !== 0) {
        productsCount.value = authStore.user.products_count || 0;
        venuesCount.value = authStore.user.venues_count || 0;
        categoriesCount.value = authStore.user.categories_count || 0;
    }
});

watch(
    () => authStore.user,
    (newUser) => {
        if (newUser) {
            productsCount.value = newUser.products_count || 0;
            venuesCount.value = newUser.venues_count || 0;
            categoriesCount.value = newUser.categories_count || 0;
        }
    },
    { immediate: true }
);
</script>
