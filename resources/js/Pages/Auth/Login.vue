<template>
    <AuthLayout pageTitle="Hesabınıza Giriş Yapın">
        <LoginForm />
        <FormFooterComponent
            pText="Henüz bir hesabınız yok mu?"
            buttonText="Ücretsiz kayıt olun"
            routeName="register"
        />
    </AuthLayout>
</template>

<script>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import LoginForm from "@/Forms/Auth/LoginForm.vue";
import FormFooterComponent from "@/Components/Auth/FormFooterComponent.vue";

export default {
    components: {
        AuthLayout,
        LoginForm,
        FormFooterComponent,
    },
};
</script>
