import { defineStore } from "pinia";
import api from "@/Plugins/axios";

export const useCategoryStore = defineStore("category", {
    state: () => ({
        categories: [],
        category: {},
        success: false,
        errors: {},
        message: null,
    }),

    actions: {
        async deleteCategory(categoryId) {
            this.clearErrors();

            try {
                const { data } = await api.delete(`/categories/${categoryId}`);
                this.removeCategory(categoryId);

                this.setMessage(
                    data.message || "Kategori silme işlemi başarılı!"
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

        async createCategory(categoryData) {
            this.clearErrors();

            try {
                const { data } = await api.post("/categories", categoryData);

                this.pushCategories(data.category);

                this.setMessage(
                    data.message || "Kategori ekleme işlemi başarılı!"
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

        async updateCategory(categoryId, updatedCategory) {
            this.clearErrors();

            try {
                const { data } = await api.post(
                    `/categories/${categoryId}`,
                    updatedCategory
                );

                this.setCategory(data.category);

                this.updateCategory(data.category);

                this.setMessage(
                    data.message || "Kategori güncelleme işlemi başarılı!"
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

        async fetchCategories(venueId) {
            this.clearErrors();

            try {
                const { data } = await api.get(`/venues/${venueId}/categories`);

                this.setCategories(data.categories);

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

        async fetchCategory(categoryId) {
            this.clearErrors();

            try {
                const { data } = await api.get(`/categories/${categoryId}`);

                this.setCategory(data);

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

        setCategories(categories) {
            this.categories = categories || [];
            console.log("Kategori verileri ayarlandı.", categories);
        },

        clearCategories() {
            this.categories = [];
            console.log("Kategori verileri temizlendi.");
        },

        setCategory(category) {
            this.category = category || {};
            console.log("Kategori bilgileri ayarlandı.", category);
        },

        clearCategory() {
            this.category = [];
            console.log("Kategori bilgileri temizlendi.");
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

        pushCategories(category) {
            this.categories = [...this.categories, category];
            console.log("Kategorilere yeni bir veri eklendi.", category);
        },

        removeCategory(categoryId) {
            this.categories = this.categories.filter(
                (category) => category.id !== categoryId
            );
            console.log("Kategorilerden bir veri çıkartıldı.", categoryId);
        },

        updateCategory(updatedCategory) {
            this.categories = this.categories.map((category) =>
                category.id === updatedCategory.id ? updatedCategory : category
            );
            console.log("Kategori güncellendi.", updatedCategory);
        },
    },
});
