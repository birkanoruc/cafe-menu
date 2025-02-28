<template>
    <div class="mt-6 flex items-center justify-start gap-x-6">
        <button
            @click="openModal"
            class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
            Hesabımı Sil
        </button>

        <ModalComponent
            :open="isModalOpen"
            @close="closeModal"
            @confirm="deleteAccount"
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
                            >Hesabı Sil</DialogTitle
                        >
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Hesabınızı silmek istediğinizden emin misiniz?
                                Tüm verileriniz kalıcı olarak silinecektir. Bu
                                işlem geri alınamaz.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </ModalComponent>
    </div>
</template>

<script setup>
import ModalComponent from "@/Components/ModalComponent.vue";
import { DialogTitle } from "@headlessui/vue";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";
import { useAuthStore } from "@/stores/auth";
import { useToast } from "vue-toastification";
import { ref } from "vue";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const toast = useToast();
const router = useRouter(); // Vue Router'ı burada kullanıyoruz
const errors = ref({}); // `errors` reaktif bir değişken olarak tanımlanmalı
const isModalOpen = ref(false);

const deleteAccount = async () => {
    await authStore.deleteAccount(authStore.user.id);

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

    closeModal();
};

const openModal = () => {
    isModalOpen.value = true; // Modalı aç
};

const closeModal = () => {
    isModalOpen.value = false; // Modalı kapat
};
</script>
