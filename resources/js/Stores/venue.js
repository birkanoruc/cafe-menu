import { defineStore } from "pinia";
import api from "@/Plugins/axios";

export const useVenueStore = defineStore("venue", {
    state: () => ({
        venues: [],
        venue: {},
        pagination: {},
        venueCategories: [],
        venueProducts: [],
        success: false,
        errors: {},
        message: null,
    }),

    actions: {
        async deleteVenue(venueId) {
            this.clearErrors();

            try {
                const { data } = await api.delete(`/venues/${venueId}`);
                this.removeVenue(venueId);

                this.setMessage(data.message || "Mekan silme işlemi başarılı!");

                this.setSuccess(true);
            } catch (error) {
                const errorData = error.response?.data || {};

                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );

                this.setErrors(errorData.errors);

                this.setSuccess(false);
            }
        },

        async createVenue(venueData) {
            this.clearErrors();

            try {
                const { data } = await api.post("/venues", venueData);

                this.pushVenues(data.venue);

                this.setMessage(
                    data.message || "Mekan ekleme işlemi başarılı!"
                );

                this.setSuccess(true);
            } catch (error) {
                const errorData = error.response?.data || {};

                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );

                this.setErrors(errorData.errors);

                this.setSuccess(false);
            }
        },

        async updateVenue(venueId, updatedVenue) {
            this.clearErrors();

            try {
                const { data } = await api.post(
                    `/venues/${venueId}`,
                    updatedVenue
                );

                this.setVenue(data.venue);

                this.setMessage(
                    data.message || "Mekan güncelleme işlemi başarılı!"
                );

                this.setSuccess(true);
            } catch (error) {
                const errorData = error.response?.data || {};

                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );

                this.setErrors(errorData.errors);

                this.setSuccess(false);
            }
        },

        async fetchVenues() {
            this.clearErrors();

            try {
                const { data } = await api.get("/venues");

                this.setVenues(data.venues);
                this.setPagination(data.pagination);

                this.setSuccess(true);
            } catch (error) {
                const errorData = error.response?.data || {};

                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );

                this.setErrors(errorData.errors);

                this.setSuccess(false);
            }
        },

        async fetchVenue(id) {
            this.clearErrors();

            try {
                const { data } = await api.get(`/venues/${id}`);

                this.setVenue(data);

                this.setSuccess(true);
            } catch (error) {
                const errorData = error.response?.data || {};

                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );

                this.setErrors(errorData.errors);

                this.setSuccess(false);
            }
        },

        async fetchVenueCategories(id) {
            this.error = null;

            try {
                const { data } = await api.get(`/venues/${id}/categories`);

                this.setVenueCategories(data);

                this.setSuccess(true);
            } catch (error) {
                const errorData = error.response?.data || {};

                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );

                this.setErrors(errorData.errors);

                this.setSuccess(false);
            }
        },

        async fetchVenueProducts(id) {
            this.error = null;

            try {
                const { data } = await api.get(`/venues/${id}/products`);

                this.setVenueProducts(data);

                this.setSuccess(true);
            } catch (error) {
                const errorData = error.response?.data || {};

                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );

                this.setErrors(errorData.errors);

                this.setSuccess(false);
            }
        },

        setVenues(venues) {
            this.venues = venues || [];
            console.log("Mekan verileri ayarlandı.", venues);
        },

        setPagination(pagination) {
            this.pagination = pagination || {};
            console.log("Sayfalama bilgileri ayarlandı.", pagination);
        },

        clearVenues() {
            this.venues = [];
            console.log("Mekan verileri temizlendi.");
        },

        setVenue(venue) {
            this.venue = venue || {};
            console.log("Mekan bilgileri ayarlandı.", venue);
        },

        clearVenue() {
            this.venue = [];
            console.log("Mekan bilgileri temizlendi.");
        },

        setVenueCategories(categories) {
            this.venueCategories = categories || [];
            console.log("Mekan kategorileri ayarlandı.", categories);
        },

        clearVenueCategories() {
            this.venueCategories = [];
            console.log("Mekan kategorileri temizlendi.");
        },

        setVenueProducts(products) {
            this.venueProducts = products || [];
            console.log("Mekan ürünleri ayarlandı.", products);
        },

        clearVenueProducts() {
            this.venueProducts = [];
            console.log("Mekan ürünleri temizlendi.");
        },

        setSuccess(success) {
            this.success = success;
            console.log("Başarı durumu ayarlandı.");
        },

        setErrors(errors) {
            this.errors = errors || {};
            console.log("Hata verileri ayarlandı.");
        },

        clearErrors() {
            this.errors = {};
            console.log("Hata verileri temizlendi.");
            this.clearMessage();
        },

        setMessage(message) {
            this.message = message;
            console.log("Mesaj verisi ayarlandı.");
        },

        clearMessage() {
            this.message = null;
            console.log("Mesaj verisi temizlendi.");
        },

        pushVenues(venue) {
            this.venues = [...this.venues, venue]; // Yeni venue ekleniyor
            console.log("Mekanlara yeni bir veri eklendi.", venue);
        },

        removeVenue(venueId) {
            this.venues = this.venues.filter((venue) => venue.id !== venueId);
            console.log("Mekanlardan bir veri çıkartıldı.", venueId);
        },
    },
});
