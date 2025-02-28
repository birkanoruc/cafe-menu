<template>
    <AuthLayout pageTitle="Şifre Sıfırlama Bağlantısı Gönderin">
        <ForgotPasswordForm />
        <FormFooterComponent
            pText="Henüz bir hesabınız yok mu?"
            buttonText="Ücretsiz kayıt olun"
            routeName="register"
        />
    </AuthLayout>
</template>

<script>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import ForgotPasswordForm from "@/Forms/Auth/ForgotPasswordForm.vue";
import FormFooterComponent from "@/Components/Auth/FormFooterComponent.vue";

export default {
    components: {
        AuthLayout,
        ForgotPasswordForm,
        FormFooterComponent,
    },
};
</script>
