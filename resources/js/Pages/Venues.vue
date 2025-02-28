<template>
    <DashboardLayout pageTitle="Mekanlarım">
        <div class="flex min-w-0 gap-x-4" v-if="venue">
            <img
                class="size-12 flex-none rounded-full bg-gray-50"
                :src="venue.featured_image_url"
                alt="venue.name"
            />
            <div class="min-w-0 flex-auto">
                <p class="text-sm/6 font-semibold text-gray-900">
                    {{ venue.name }}
                </p>
                <p class="mt-1 truncate text-xs/5 text-gray-500">
                    {{ venue.phone }}, {{ venue.address }}
                </p>
                <button
                    class="text-sm font-semibold text-blue-600"
                    @click="openModal"
                >
                    Düzenle
                </button>
            </div>
        </div>

        <PanelComponent
            title="Mekanı Düzenle"
            :open="isOpen"
            @close="closeModal"
        >
            <UpdateVenueForm />
        </PanelComponent>

        <hr class="mt-4 mb-4" />

        <div class="grid grid-cols-5 gap-4">
            <div class="col-span-2">
                <CategoryList />
            </div>

            <div class="col-span-3">
                <ProductList />
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "@/layouts/DashboardLayout.vue";
import UpdateVenueForm from "@/forms/venue/UpdateVenueForm.vue";
import CategoryList from "@/Lists/CategoryList.vue";
import ProductList from "@/Lists/ProductList.vue";
import { onMounted, ref, watchEffect } from "vue";
import { useRoute } from "vue-router";
import { useVenueStore } from "@/Stores/venue";

const route = useRoute();
const venueStore = useVenueStore();

const venue = ref({});
const categories = ref({});
const products = ref({});

onMounted(async () => {
    await venueStore.fetchVenue(route.params.id);
    venue.value = venueStore.venue;

    await venueStore.fetchVenueCategories(route.params.id);
    categories.value = venueStore.categories;

    await venueStore.fetchVenueProducts(route.params.id);
    products.value = venueStore.products;
});

watchEffect(() => {
    venue.value = venueStore.venue;
    categories.value = venueStore.categories;
    products.value = venueStore.products;
});

import PanelComponent from "@/Components/PanelComponent.vue";
const isOpen = ref(false);

const openModal = () => {
    isOpen.value = true; // Modalı aç
};

const closeModal = () => {
    isOpen.value = false; // Modalı kapat
};
</script>
