import { defineStore } from "pinia";
import api from "@/Plugins/axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: {},
        token: localStorage.getItem("token") || null,
        errors: {},
        message: null,
        success: false,
    }),

    actions: {
        async fetchUser() {
            if (!this.token) return;

            try {
                const { data } = await api.post("/auth/me");

                this.setUser(data);
            } catch (error) {
                this.clearUser();

                const errorData = error.response?.data || {};
                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );
                this.setErrors(errorData.errors);
            }
        },

        async updateProfileInformation(userData) {
            this.clearErrors();

            try {
                const { data } = await api.put(
                    "/auth/update-information",
                    userData
                );

                this.setUser(data.user);

                this.setMessage(
                    data.message || "Profil güncelleme işlemi başarılı!"
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

        async deleteAccount() {
            if (!this.token) return;

            this.clearErrors();

            try {
                await api.delete(`/auth/delete-account/`);

                this.clearUser();

                this.setMessage("Hesabınız silindi!");

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

        async register(userData) {
            this.clearErrors();

            try {
                const { data } = await api.post("/auth/register", userData);

                this.setToken(data.access_token);

                await this.fetchUser();

                this.setMessage(data.message || "Kayıt olma işlemi başarılı!");

                this.setSuccess(true);
            } catch (error) {
                this.clearUser(); // token ve kullanıcı verilerini siler

                const errorData = error.response?.data || {};

                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );

                this.setErrors(errorData.errors);

                this.setSuccess(false);
            }
        },

        async login(credentials) {
            this.clearErrors();
            this.clearUser();

            try {
                const { data } = await api.post("/auth/login", credentials);

                this.setToken(data.access_token);

                await this.fetchUser();

                this.setMessage(data.message || "Oturum açma işlemi başarılı!");

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

        async logout() {
            if (!this.token) return;

            this.clearErrors();

            try {
                const { data } = await api.post("/auth/logout");

                this.clearUser();

                this.setMessage(
                    data.message || "Oturum kapatma işlemi başarılı."
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

        async refreshToken() {
            if (!this.token) return;

            this.clearErrors();
            try {
                const { data } = await api.post("/auth/refresh");

                this.setToken(data.access_token);

                this.setSuccess(true);
            } catch (error) {
                this.clearUser();

                const errorData = error.response?.data || {};

                this.setMessage(
                    errorData.message || "Beklenmeyen bir hata oluştu."
                );

                this.setErrors(errorData.errors);

                this.setSuccess(false);

                throw error; // Interceptor tarafından yakalanması için fırlatıyoruz.
            }
        },

        async forgotPassword(email) {
            this.clearErrors();

            try {
                const { data } = await api.post("/auth/forgot-password", {
                    email,
                });

                this.setMessage(
                    data.message ||
                        "Parola sıfırlama için e-posta gönderme işlemi başarılı!"
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

        async sendVerifyEmail(email) {
            this.clearErrors();

            try {
                const { data } = await api.post("/auth/send-verify-email", {
                    email,
                });

                this.setMessage(
                    data.message ||
                        "Hesabınızı onaylamak için e-posta gönderme işlemi başarılı!"
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

        setUser(user) {
            this.user = user;
            console.log("Kullanıcı verileri ayarlandı.");
        },

        clearUser() {
            this.user = {};
            console.log("Kullanıcı verileri silindi.");
            this.clearToken();
        },

        setToken(token) {
            this.token = token;
            localStorage.setItem("token", token);
            api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
            console.log("Jeton verisi ayarlandı.");
        },

        clearToken() {
            this.token = null;
            localStorage.removeItem("token");
            delete api.defaults.headers.common["Authorization"];
            console.log("Jeton verisi silindi.");
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

        setSuccess(success) {
            this.success = success;
            console.log("Başarı durumu ayarlandı.");
        },
    },
});
