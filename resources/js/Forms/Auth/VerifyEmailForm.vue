<template>
    <div class="mt-6 flex items-center justify-start gap-x-6">
        <button
            @click="openModal"
            class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
            E-Posta Doğrulama Bağlantısı Gönder
        </button>

        <ModalComponent
            :open="isModalOpen"
            @close="closeModal"
            @confirm="sendVerifyEmail"
        >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10"
                    >
                        <ExclamationTriangleIcon
                            class="size-6 text-red-600"
                            aria-hidden="true"
                        />
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <DialogTitle
                            as="h3"
                            class="text-base font-semibold text-gray-900"
                            >E-Posta Doğrulama Bağlantısı Gönder</DialogTitle
                        >
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Onaylamanız durumunda hesabınızın e-posta
                                adresini doğrulamak için size bir bağlantı
                                göndereceğiz.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </ModalComponent>
    </div>
</template>

<script>
import ModalComponent from "@/Components/ModalComponent.vue";
import { DialogTitle } from "@headlessui/vue";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";
import { useAuthStore } from "@/stores/auth";
import { useToast } from "vue-toastification";
import { ref } from "vue";

export default {
    components: { ModalComponent, ExclamationTriangleIcon, DialogTitle },

    setup() {
        const authStore = useAuthStore();
        const toast = useToast();
        const errors = ref({}); // `errors` reaktif bir değişken olarak tanımlanmalı
        const isModalOpen = ref(false);

        const sendVerifyEmail = async () => {
            await authStore.sendVerifyEmail(authStore.user.email);

            if (authStore.success) {
                errors.value = {};

                toast.success(authStore.message);
            } else {
                errors.value = authStore.errors;

                toast.error(authStore.message);
            }

            closeModal();
        };

        const openModal = () => {
            isModalOpen.value = true; // Modalı aç
        };

        const closeModal = () => {
            isModalOpen.value = false; // Modalı kapat
        };

        return {
            sendVerifyEmail,
            errors,
            isModalOpen,
            openModal,
            closeModal,
        };
    },
};
</script>
