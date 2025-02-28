<template>
    <button
        @click="openPanel"
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    >
        Yeni Mekan Oluştur
    </button>

    <PanelComponent title="Mekan Ekle" :open="isPanelOpen" @close="closePanel">
        <CreateVenueForm />
    </PanelComponent>

    <hr class="mt-4 mb-4" />

    <ul role="list" class="divide-y divide-gray-100">
        <li
            v-for="venue in venues"
            :key="venue.id"
            class="flex justify-between gap-x-6 py-5"
        >
            <div class="flex min-w-0 gap-x-4">
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
                </div>
            </div>
            <div
                class="hidden shrink-0 sm:flex sm:flex-row sm:items-end sm:space-x-2"
            >
                <router-link
                    :to="{ name: 'venues', params: { id: venue.id } }"
                    class="rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pruple-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >Menüyü Düzenle</router-link
                >

                <button
                    @click="openModal(venue.id)"
                    class="mt-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Mekanı Sil
                </button>
            </div>
        </li>
    </ul>

    <Pagination :pagination="pagination" />

    <ModalComponent
        :open="isModalOpen"
        @close="closeModal"
        @confirm="deleteVenue()"
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
                        >Mekanı Sil</DialogTitle
                    >
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Onaylamanız durumunda mekan silinecektir. Bu işlem
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

// Pagination Component
import Pagination from "@/components/Pagination.vue";

// Venue Store Import
import { useVenueStore } from "@/stores/venue";
const venueStore = useVenueStore();
const venues = ref([]);
const pagination = ref({});

// Toast Notifications
import { useToast } from "vue-toastification";
const toast = useToast();

// Modal Component
import ModalComponent from "@/Components/ModalComponent.vue";
import { DialogTitle } from "@headlessui/vue";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";

const isModalOpen = ref(false);

const openModal = (venueId) => {
    isModalOpen.value = true; // Modalı aç
    selectedVenueId.value = venueId; // Modal açıldığında id'yi kaydediyoruz
};

const closeModal = () => {
    isModalOpen.value = false; // Modalı kapat
    selectedVenueId.value = null; // Modal açıldığında id'yi siliyoruz
};

// Delete Venue
const errors = ref({});
const selectedVenueId = ref(null); // Venue ID'yi burada tutuyoruz

const deleteVenue = async () => {
    const venueId = selectedVenueId.value; // Seçilen venue ID'yi al

    if (!venueId) return; // ID yoksa çık

    await venueStore.deleteVenue(venueId); // API'den mekanı sil

    if (venueStore.success) {
        errors.value = {};

        venues.value = venueStore.venues;

        toast.success(venueStore.message);
    } else {
        errors.value = venueStore.errors;

        toast.error(venueStore.message);
    }

    closeModal();
};

// Venue'lerin yüklenmesi
onMounted(async () => {
    await venueStore.fetchVenues();
    venues.value = venueStore.venues;
    pagination.value = venueStore.pagination;
});

// Değişikliklerin takibi
watchEffect(() => {
    venues.value = venueStore.venues;
});

// Panel Component
import CreateVenueForm from "@/Forms/Venue/CreateVenueForm.vue";
import PanelComponent from "@/Components/PanelComponent.vue";
const isPanelOpen = ref(false);

const openPanel = () => {
    isPanelOpen.value = true; // Modalı aç
};

const closePanel = () => {
    isPanelOpen.value = false; // Modalı kapat
};
</script>
