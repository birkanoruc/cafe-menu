<template>
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <img
                            class="size-8"
                            src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                            alt="Menü Yönetimi"
                        />
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <router-link
                                :to="{ name: 'dashboard' }"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                                active-class="bg-gray-900 text-white"
                                >Gösterge Paneli</router-link
                            >
                            <!-- <router-link
                                :to="{ name: 'venues' }"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                                active-class="bg-gray-900 text-white"
                                >Mekanlarım</router-link
                            > -->
                            <!-- <router-link
                                :to="{ name: 'categories' }"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                                active-class="bg-gray-900 text-white"
                                >Kategorilerim</router-link
                            >
                            <router-link
                                :to="{ name: 'products' }"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                                active-class="bg-gray-900 text-white"
                                >Ürünlerim</router-link
                            > -->
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button
                                    @click="toggleProfileMenu"
                                    type="button"
                                    class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                                    id="user-menu-button"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                >
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only"
                                        >Kullanıcı Menüsü</span
                                    >
                                    <img
                                        class="size-8 rounded-full"
                                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt=""
                                    />
                                </button>
                            </div>

                            <div
                                v-if="isProfileMenuOpen"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="user-menu-button"
                                tabindex="-1"
                            >
                                <router-link
                                    :to="{ name: 'profile' }"
                                    class="block px-4 py-2 text-sm text-gray-700"
                                    active-class="bg-gray-100 outline-hidden"
                                    role="menuitem"
                                    tabindex="-1"
                                    id="user-menu-item-0"
                                    >Profil Bilgilerim</router-link
                                >
                                <button
                                    @click="logout"
                                    class="block px-4 py-2 text-sm text-gray-700"
                                    active-class="bg-gray-100 outline-hidden"
                                    role="menuitem"
                                    tabindex="-1"
                                    id="user-menu-item-2"
                                >
                                    Oturumu Kapat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <!-- Mobile menu button -->
                    <button
                        type="button"
                        @click="toggleMobileMenu"
                        class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                        aria-controls="mobile-menu"
                        aria-expanded="false"
                    >
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <!-- Menu open: "hidden", Menu closed: "block" -->
                        <svg
                            class="block size-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            aria-hidden="true"
                            data-slot="icon"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                            />
                        </svg>
                        <!-- Menu open: "block", Menu closed: "hidden" -->
                        <svg
                            class="hidden size-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            aria-hidden="true"
                            data-slot="icon"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="md:hidden" id="mobile-menu" v-if="isMobileMenuOpen">
            <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                <router-link
                    :to="{ name: 'dashboard' }"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                    active-class="bg-gray-900 text-white"
                    aria-current="page"
                    >Gösterge Paneli</router-link
                >
                <!-- <router-link
                    :to="{ name: 'venues' }"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                    active-class="bg-gray-900 text-white"
                    >Mekanlarım</router-link
                > -->
                <router-link
                    :to="{ name: 'categories' }"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                    active-class="bg-gray-900 text-white"
                    >Kategorilerim</router-link
                >
                <router-link
                    :to="{ name: 'products' }"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                    active-class="bg-gray-900 text-white"
                    >Ürünlerim</router-link
                >
            </div>
            <div class="border-t border-gray-700 pt-4 pb-3">
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img
                            class="size-10 rounded-full"
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt=""
                        />
                    </div>
                    <div class="ml-3">
                        <div class="text-base/5 font-medium text-white">
                            Tom Cook
                        </div>
                        <div class="text-sm font-medium text-gray-400">
                            tom@example.com
                        </div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <router-link
                        :to="{ name: 'profile' }"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white"
                        >Profil Bilgilerim</router-link
                    >
                    <button
                        @click="logout"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white"
                    >
                        Oturumu Kapat
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { useAuthStore } from "@/stores/auth";
import { useToast } from "vue-toastification";
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
    name: "NavbarComponent",
    data() {
        return {
            isProfileMenuOpen: false,
            isMobileMenuOpen: false,
        };
    },
    methods: {
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen;
        },

        toggleMobileMenu() {
            this.isMobileMenuOpen = !this.isMobileMenuOpen;
        },
    },
    setup() {
        const authStore = useAuthStore();
        const toast = useToast();
        const router = useRouter(); // Vue Router'ı burada kullanıyoruz
        const errors = ref({}); // `errors` reaktif bir değişken olarak tanımlanmalı

        const logout = async () => {
            await authStore.logout();

            if (authStore.success) {
                errors.value = {};

                toast.success(authStore.message);

                setTimeout(() => {
                    router.push({ name: "login" });
                }, 2000);
            } else {
                errors.value = authStore.errors;

                toast.error(authStore.message);
            }
        };

        return {
            logout,
            errors,
        };
    },
};
</script>
