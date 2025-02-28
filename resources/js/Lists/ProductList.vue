<template>
    <button
        @click="openPanel('create')"
        class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    >
        Yeni Ürün Oluştur
    </button>

    <PanelComponent
        title="Ürün Yönetimi"
        :open="isPanelOpen"
        @close="closePanel"
    >
        <CreateProductForm v-if="panelMode === 'create'" :venueId="venueId" />

        <UpdateProductForm
            v-else-if="panelMode === 'update'"
            :product="selectedProduct"
            :venueId="venueId"
        />
    </PanelComponent>

    <hr class="mt-4 mb-4" />

    <ul role="list" class="divide-y divide-gray-100">
        <li
            v-for="product in products"
            :key="product.id"
            class="flex justify-between gap-x-6 py-5"
        >
            <div class="flex min-w-0 gap-x-4">
                <img
                    class="size-12 flex-none rounded-full bg-gray-50"
                    :src="product.featured_image_url"
                    alt="product.name"
                />
                <div class="min-w-0 flex-auto">
                    <p class="text-sm/6 font-semibold text-gray-900">
                        {{ product.name }}, {{ product.description }},
                        {{ product.price }}, {{ product.discount_price }}
                    </p>
                </div>
                -
                <div
                    class="min-w-0 flex-auto"
                    v-for="category in product.categories"
                    :key="category.id"
                >
                    <p class="text-sm/6 font-semibold text-gray-900">
                        {{ category.name }}
                    </p>
                </div>
            </div>
            <div
                class="hidden shrink-0 sm:flex sm:flex-row sm:items-end sm:space-x-2"
            >
                <button
                    @click="openPanel('update', product)"
                    class="rounded-md bg-purple-600 px-2 py-1 text-xs font-medium text-white shadow-xs hover:bg-purple-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Düzenle
                </button>
                <button
                    @click="openModal(product.id)"
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
        @confirm="deleteProduct()"
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
                        >Ürün Sil</DialogTitle
                    >
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Onaylamanız durumunda ürün silinecektir. Bu işlem
                            geri alınamaz!
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
import { useProductStore } from "@/stores/product";
const productStore = useProductStore();
const products = ref([]);

// Toast Notifications
import { useToast } from "vue-toastification";
const toast = useToast();

// Modal Component
import ModalComponent from "@/Components/ModalComponent.vue";
import { DialogTitle } from "@headlessui/vue";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";

const isModalOpen = ref(false);
const selectedProductId = ref(null);

const openModal = (productId) => {
    isModalOpen.value = true; // Modalı aç
    selectedProductId.value = productId; // Modal açıldığında id'yi kaydediyoruz
};

const closeModal = () => {
    isModalOpen.value = false; // Modalı kapat
    selectedProductId.value = null; // Modal açıldığında id'yi siliyoruz
};

// Panel Component
import CreateProductForm from "@/Forms/Product/CreateProductForm.vue";
import UpdateProductForm from "@/Forms/Product/UpdateProductForm.vue";
import PanelComponent from "@/Components/PanelComponent.vue";
const isPanelOpen = ref(false);
const panelMode = ref("create");
const selectedProduct = ref(null);
const openPanel = (mode, product = null) => {
    panelMode.value = mode;
    isPanelOpen.value = true;

    if (mode === "update" && product) {
        selectedProduct.value = product;
    } else {
        selectedProduct.value = null;
    }
};

const closePanel = () => {
    isPanelOpen.value = false; // Modalı kapat
};

// Delete Category
const errors = ref({});

const deleteProduct = async () => {
    const productId = selectedProductId.value;

    if (!productId) return; // ID yoksa çık

    await productStore.deleteProduct(productId); // API'den mekanı sil

    if (productStore.success) {
        errors.value = {};

        products.value = productStore.products;

        toast.success(productStore.message);
    } else {
        errors.value = productStore.errors;

        toast.error(productStore.message);
    }

    closeModal();
};

import { useRoute } from "vue-router";
const route = useRoute();
const venueId = route.params.id; // Parametreden Venue ID Alınır

// products'lerin yüklenmesi
onMounted(async () => {
    await productStore.fetchProducts(venueId);

    products.value = productStore.products;
});

// Değişikliklerin takibi
watchEffect(() => {
    products.value = productStore.products;
});
</script>
