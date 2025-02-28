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
                            >Mekanın Adı</label
                        >
                        <div class="mt-2">
                            <input
                                type="text"
                                v-model="venue.name"
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
                            for="phone"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Mekanın Telefon Numarası</label
                        >
                        <div class="mt-2">
                            <input
                                type="text"
                                v-model="venue.phone"
                                name="phone"
                                id="phone"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                        </div>
                        <ul
                            v-if="errors.phone"
                            class="text-red-500 text-sm mt-1"
                        >
                            <li
                                v-for="(error, index) in errors.phone"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <div class="sm:col-span-6">
                        <label
                            for="address"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Mekanın Adres Bilgisi</label
                        >
                        <div class="mt-2">
                            <textarea
                                v-model="venue.address"
                                name="address"
                                id="address"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 shadow-md outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            >
                            </textarea>
                        </div>
                        <ul
                            v-if="errors.address"
                            class="text-red-500 text-sm mt-1"
                        >
                            <li
                                v-for="(error, index) in errors.address"
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

import { useVenueStore } from "@/stores/venue";
const venueStore = useVenueStore();

import { useToast } from "vue-toastification";
const toast = useToast();

const venue = ref({});
const errors = ref({});

const featuredImage = ref(null);
const handleFileUpload = (event) => {
    featuredImage.value = event.target.files[0];
};

const create = async () => {
    const formData = new FormData();

    // Form verilerini ekleyelim
    for (const key in venue.value) {
        if (venue.value[key] !== undefined && venue.value[key] !== null) {
            formData.append(key, venue.value[key]);
        }
    }

    // Öne çıkan görseli ekleyelim
    if (featuredImage.value) {
        formData.append("featured_image", featuredImage.value);
    }

    await venueStore.createVenue(formData);

    if (venueStore.success) {
        errors.value = {};

        toast.success(venueStore.message);

        venue.value = {};
    } else {
        errors.value = venueStore.errors;

        toast.error(venueStore.message);
    }
};
</script>
