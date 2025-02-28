<template>
    <DashboardLayout pageTitle="Profil Bilgilerim">
        <section class="rounded-xl shadow-xl p-6">
            <FormHeaderComponent
                title="Profil Bilgileri Güncelleme"
                description="Hesap bilgilerinizde değişiklik yapmak istediğinizde bu bölümü kullanabilirsiniz."
            />
            <ProfileInformationForm />
        </section>

        <section class="rounded-xl shadow-xl p-6 mt-4">
            <FormHeaderComponent
                title="Şifre Güncelleme"
                description="Hesabınızın şifresinde değişiklik yapmak istediğinizde bu bölümü kullanabilirsiniz."
            />
            <UpdatePasswordForm />
        </section>

        <section class="rounded-xl shadow-xl p-6 mt-4">
            <FormHeaderComponent
                title="E-Posta Doğrulama"
                description="Hesabınızın e-posta adresini doğrulamak istediğinizde bu bölümü kullanabilirsiniz."
            />
            <VerifyEmailForm />
        </section>

        <section class="rounded-xl shadow-xl p-6 mt-4">
            <FormHeaderComponent
                title="Hesap Silme"
                description="Hesabınızı silmek istediğinizde bu bölümü kullanabilirsiniz."
            />
            <DeleteAccountForm />
        </section>
    </DashboardLayout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import ProfileInformationForm from "@/Forms/Auth/ProfileInformationForm.vue";
import UpdatePasswordForm from "@/Forms/Auth/UpdatePasswordForm.vue";
import VerifyEmailForm from "@/Forms/Auth/VerifyEmailForm.vue";
import DeleteAccountForm from "@/Forms/Auth/DeleteAccountForm.vue";
import FormHeaderComponent from "@/Components/Auth/FormHeaderComponent.vue";

export default {
    components: {
        DashboardLayout,
        ProfileInformationForm,
        UpdatePasswordForm,
        FormHeaderComponent,
        VerifyEmailForm,
        DeleteAccountForm,
    },
};
</script>
