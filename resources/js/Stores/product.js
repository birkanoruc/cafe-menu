import { defineStore } from "pinia";
import api from "@/Plugins/axios";

export const useProductStore = defineStore("product", {
    state: () => ({
        products: [],
        product: {},
        success: false,
        errors: {},
        message: null,
    }),

    actions: {
        async deleteProduct(productId) {
            this.clearErrors();

            try {
                const { data } = await api.delete(`/products/${productId}`);
                this.removeProduct(productId);

                this.setMessage(data.message || "Ürün silme işlemi başarılı!");

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

        async updateProduct(productId, updateCategory) {
            this.clearErrors();

            try {
                const { data } = await api.post(
                    `/products/${productId}`,
                    updateCategory
                );

                this.setProduct(data.product);

                this.updateProduct(data.product);

                this.setMessage(
                    data.message || "Ürün güncelleme işlemi başarılı!"
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

        async createProduct(productData) {
            this.clearErrors();

            try {
                const { data } = await api.post("/products", productData);

                this.pushCategories(data.product);

                this.setMessage(data.message || "Ürün ekleme işlemi başarılı!");

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

        async fetchProducts(venueId) {
            this.clearErrors();

            try {
                const { data } = await api.get(`/venues/${venueId}/products`);

                this.setCategories(data.products);

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

        async fetchProduct(productId) {
            this.clearErrors();

            try {
                const { data } = await api.get(`/products/${productId}`);

                this.setProduct(data);

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

        setCategories(products) {
            this.products = products || [];
            console.log("Ürün verileri ayarlandı.", products);
        },

        clearCategories() {
            this.products = [];
            console.log("Ürün verileri temizlendi.");
        },

        setProduct(product) {
            this.product = product || {};
            console.log("Ürün bilgileri ayarlandı.", product);
        },

        clearProduct() {
            this.product = [];
            console.log("Ürün bilgileri temizlendi.");
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

        pushCategories(product) {
            this.products = [...this.products, product];
            console.log("Ürünlere yeni bir veri eklendi.", product);
        },

        removeProduct(productId) {
            this.products = this.products.filter(
                (product) => product.id !== productId
            );
            console.log("Ürünlerden bir veri çıkartıldı.", productId);
        },

        updateProduct(updatedProduct) {
            this.products = this.products.map((product) =>
                product.id === updatedProduct.id ? updatedProduct : product
            );
            console.log("Ürün güncellendi.", updatedProduct);
        },
    },
});
