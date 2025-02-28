<template>
    <button
        @click="openPanel('create')"
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    >
        Yeni Kategori Oluştur
    </button>

    <PanelComponent
        title="Kategori Yönetimi"
        :open="isPanelOpen"
        @close="closePanel"
    >
        <CreateCategoryForm v-if="panelMode === 'create'" :venueId="venueId" />
        <UpdateCategoryForm
            v-else-if="panelMode === 'update'"
            :category="selectedCategory"
        />
    </PanelComponent>

    <hr class="mt-4 mb-4" />

    <ul role="list" class="divide-y divide-gray-100">
        <li
            v-for="category in categories"
            :key="category.id"
            class="flex justify-between gap-x-6 py-5"
        >
            <div class="flex min-w-0 gap-x-4">
                <img
                    class="size-12 flex-none rounded-full bg-gray-50"
                    :src="category.featured_image_url"
                    alt="category.name"
                />
                <div class="min-w-0 flex-auto">
                    <p class="text-sm/6 font-semibold text-gray-900">
                        {{ category.name }}
                    </p>
                </div>
            </div>
            <div
                class="hidden shrink-0 sm:flex sm:flex-row sm:items-end sm:space-x-2"
            >
                <button
                    @click="openPanel('update', category)"
                    class="rounded-md bg-purple-600 px-2 py-1 text-xs font-medium text-white shadow-xs hover:bg-purple-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Düzenle
                </button>
                <button
                    @click="openModal(category.id)"
                    class="rounded-md bg-red-600 px-2 py-1 text-xs font-medium text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Sil
                </button>
            </div>
        </li>
    </ul>

    <ModalComponent
        :open="isModalOpen"
        @close="closeModal"
        @confirm="deleteCategory()"
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
                        >Kategori Sil</DialogTitle
                    >
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Onaylamanız durumunda kategori silinecektir. Bu
                            işlem geri alınamaz!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </ModalComponent>
</template>

<script setup>
import { onMounted, ref, watchEffect } from "vue";

// Category Store Import
import { useCategoryStore } from "@/stores/category";
const categoryStore = useCategoryStore();
const categories = ref([]);

// Toast Notifications
import { useToast } from "vue-toastification";
const toast = useToast();

// Modal Component
import ModalComponent from "@/Components/ModalComponent.vue";
import { DialogTitle } from "@headlessui/vue";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";

const isModalOpen = ref(false);
const selectedCategoryId = ref(null);

const openModal = (categoryId) => {
    isModalOpen.value = true; // Modalı aç
    selectedCategoryId.value = categoryId; // Modal açıldığında id'yi kaydediyoruz
};

const closeModal = () => {
    isModalOpen.value = false; // Modalı kapat
    selectedCategoryId.value = null; // Modal açıldığında id'yi siliyoruz
};

// Panel Component
import CreateCategoryForm from "@/Forms/Category/CreateCategoryForm.vue";
import UpdateCategoryForm from "@/Forms/Category/UpdateCategoryForm.vue";
import PanelComponent from "@/Components/PanelComponent.vue";
const isPanelOpen = ref(false);
const panelMode = ref("create"); // "create" veya "update"
const selectedCategory = ref(null); // Güncellenecek kategori
const openPanel = (mode, category = null) => {
    panelMode.value = mode;
    isPanelOpen.value = true;

    if (mode === "update" && category) {
        selectedCategory.value = category;
    } else {
        selectedCategory.value = null;
    }
};

const closePanel = () => {
    isPanelOpen.value = false; // Modalı kapat
};

// Delete Category
const errors = ref({});

const deleteCategory = async () => {
    const categoryId = selectedCategoryId.value;

    if (!categoryId) return; // ID yoksa çık

    await categoryStore.deleteCategory(categoryId); // API'den mekanı sil

    if (categoryStore.success) {
        errors.value = {};

        categories.value = categoryStore.categories;

        toast.success(categoryStore.message);
    } else {
        errors.value = categoryStore.errors;

        toast.error(categoryStore.message);
    }

    closeModal();
};

import { useRoute } from "vue-router";
const route = useRoute();
const venueId = route.params.id; // Parametreden Venue ID Alınır

// categories'lerin yüklenmesi
onMounted(async () => {
    await categoryStore.fetchCategories(venueId);

    categories.value = categoryStore.categories;
});

// Değişikliklerin takibi
watchEffect(() => {
    categories.value = categoryStore.categories;
});
</script>
