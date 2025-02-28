<template>
    <div class="min-h-full">
        <NavbarComponent />
        <BannerComponent />

        <header class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                    {{ pageTitle }}
                </h1>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <slot></slot>
        </main>
    </div>
</template>

<script>
import NavbarComponent from "@/Components/NavbarComponent.vue";
import BannerComponent from "@/Components/BannerComponent.vue";

import { onMounted, watch } from "vue"; // Burada ref ve onMounted düzgün şekilde import ediliyor
import { useAuthStore } from "@/stores/auth";

export default {
    components: { NavbarComponent, BannerComponent },
    props: {
        pageTitle: {
            type: String,
            default: "Default Page Title",
        },
    },

    setup() {
        const authStore = useAuthStore();

        onMounted(() => {
            if (authStore.token && Object.keys(authStore.user).length === 0) {
                authStore.fetchUser();
            }
        });

        watch(
            () => authStore.user,
            (newUser) => {
                console.log("Güncellenen kullanıcı verisi:", newUser);
            }
        );

        return {
            onMounted,
        };
    },
};
</script>
