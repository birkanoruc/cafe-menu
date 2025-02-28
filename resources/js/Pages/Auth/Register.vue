<template>
    <AuthLayout pageTitle="Yeni Bir Hesap Oluşturun">
        <RegisterForm />
        <FormFooterComponent
            pText="Zaten bir hesabınız var mı?"
            buttonText="Şimdi giriş yapın"
            routeName="login"
        />
    </AuthLayout>
</template>

<script>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import RegisterForm from "@/Forms/Auth/RegisterForm.vue";
import FormFooterComponent from "@/Components/Auth/FormFooterComponent.vue";

export default {
    components: {
        AuthLayout,
        RegisterForm,
        FormFooterComponent,
    },
};
</script>
