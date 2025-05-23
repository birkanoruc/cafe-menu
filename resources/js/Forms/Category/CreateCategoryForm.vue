<template>
    <form @submit.prevent="create">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div
                    class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                >
                    <div class="sm:col-span-6">
                        <label
                            for="name"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Kategorinin Adı</label
                        >
                        <div class="mt-2">
                            <input
                                type="text"
                                v-model="category.name"
                                name="name"
                                id="name"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                        </div>
                        <ul
                            v-if="errors.name"
                            class="text-red-500 text-sm mt-1"
                        >
                            <li
                                v-for="(error, index) in errors.name"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <div class="sm:col-span-6">
                        <label
                            for="featured_image"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Öne Çıkan Görsel</label
                        >
                        <div class="mt-2">
                            <input
                                type="file"
                                @change="handleFileUpload"
                                accept="image/*"
                                name="featured_image"
                                id="featured_image"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                        </div>
                        <ul
                            v-if="errors.featured_image"
                            class="text-red-500 text-sm mt-1"
                        >
                            <li
                                v-for="(error, index) in errors.featured_image"
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
import { ref } from "vue";

const props = defineProps({
    venueId: {
        type: [Number, String], // Hem Number hem de String olarak kabul eder
        required: true,
    },
});

import { useCategoryStore } from "@/stores/category";
const categoryStore = useCategoryStore();

import { useToast } from "vue-toastification";
const toast = useToast();

const category = ref({});
const errors = ref({});

const featuredImage = ref(null);
const handleFileUpload = (event) => {
    featuredImage.value = event.target.files[0];
};

const create = async () => {
    const formData = new FormData();

    // Form verilerini ekleyelim
    for (const key in category.value) {
        if (category.value[key] !== undefined && category.value[key] !== null) {
            formData.append(key, category.value[key]);
        }
    }

    // Öne çıkan görseli ekleyelim
    if (featuredImage.value) {
        formData.append("featured_image", featuredImage.value);
    }

    formData.append("venue_id", props.venueId);

    await categoryStore.createCategory(formData);

    if (categoryStore.success) {
        errors.value = {};

        toast.success(categoryStore.message);

        category.value = {};
    } else {
        errors.value = categoryStore.errors;

        toast.error(categoryStore.message);
    }
};
</script>
