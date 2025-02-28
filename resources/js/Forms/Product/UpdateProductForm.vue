<template>
    <form @submit.prevent="update">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div
                    class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                >
                    <div class="sm:col-span-6">
                        <label
                            for="categories"
                            class="block text-sm font-medium text-gray-900"
                        >
                            Kategoriler
                        </label>
                        <div class="mt-2 space-y-4">
                            <div
                                v-for="category in categories"
                                :key="category.id"
                                class="flex items-center"
                            >
                                <input
                                    type="checkbox"
                                    :id="`category-${category.id}`"
                                    :value="category.id"
                                    v-model="product.category_ids"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                />
                                <label
                                    :for="`category-${category.id}`"
                                    class="ml-2 text-sm text-gray-900"
                                >
                                    {{ category.name }}
                                </label>
                            </div>
                        </div>
                        <ul
                            v-if="errors.category_ids"
                            class="text-red-500 text-sm mt-1"
                        >
                            <li
                                v-for="(error, index) in errors.category_ids"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <div class="sm:col-span-6">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-900"
                        >
                            Ürünün Adı
                        </label>
                        <div class="mt-2">
                            <input
                                type="text"
                                v-model="product.name"
                                name="name"
                                id="name"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            />
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label
                            for="price"
                            class="block text-sm font-medium text-gray-900"
                        >
                            Ürünün Fiyatı
                        </label>
                        <div class="mt-2">
                            <input
                                type="number"
                                step="0.01"
                                v-model="product.price"
                                name="price"
                                id="price"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            />
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label
                            for="discount_price"
                            class="block text-sm font-medium text-gray-900"
                        >
                            Ürünün İndirimli Fiyatı
                        </label>
                        <div class="mt-2">
                            <input
                                type="number"
                                step="0.01"
                                v-model="product.discount_price"
                                name="discount_price"
                                id="discount_price"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            />
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-900"
                        >
                            Ürünün Açıklaması
                        </label>
                        <div class="mt-2">
                            <textarea
                                v-model="product.description"
                                name="description"
                                id="description"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            ></textarea>
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label
                            for="featured_image"
                            class="block text-sm font-medium text-gray-900"
                        >
                            Öne Çıkan Görsel
                        </label>
                        <div class="mt-2">
                            <input
                                type="file"
                                @change="handleFileUpload"
                                accept="image/*"
                                name="featured_image"
                                id="featured_image"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button
                type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Güncelle
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    venueId: {
        type: [Number, String],
        required: true,
    },
});

// Kategorileri çekme
const categories = ref({});
import { useCategoryStore } from "@/stores/category";
const categoryStore = useCategoryStore();

onMounted(async () => {
    await categoryStore.fetchCategories(props.venueId);
    categories.value = categoryStore.categories;
});

// Güncellenecek ürün bilgileri
const product = ref({ ...props.product });

watch(
    () => props.product,
    (newProduct) => {
        product.value = { ...newProduct };
    },
    { deep: true }
);

import { useProductStore } from "@/stores/product";
const productStore = useProductStore();

import { useToast } from "vue-toastification";
const toast = useToast();
const errors = ref({});

const featuredImage = ref(null);
const handleFileUpload = (event) => {
    featuredImage.value = event.target.files[0];
};

const update = async () => {
    const formData = new FormData();

    for (const key in product.value) {
        if (product.value[key] !== undefined && product.value[key] !== null) {
            if (Array.isArray(product.value[key])) {
                product.value[key].forEach((val) =>
                    formData.append(`${key}[]`, val)
                );
            } else {
                formData.append(key, product.value[key]);
            }
        }
    }

    if (featuredImage.value) {
        formData.append("featured_image", featuredImage.value);
    }

    formData.append("venue_id", props.venueId);
    formData.append("_method", "PUT");

    await productStore.updateProduct(product.value.id, formData);

    if (productStore.success) {
        errors.value = {};
        toast.success(productStore.message);
    } else {
        errors.value = productStore.errors;
        toast.error(productStore.message);
    }
};
</script>
