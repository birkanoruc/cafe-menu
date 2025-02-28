<template>
    <DashboardLayout pageTitle="Kategorilerim">
        <!-- <ul>
            <li v-for="category in categories" :key="category.id">
                {{ category.name }}
            </li>
        </ul> -->
    </DashboardLayout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    components: { DashboardLayout },
    data() {
        return {
            categories: [],
        };
    },
    async created() {
        try {
            const response = await axios.get("/api/categories");
            this.categories = response.data;
        } catch (error) {
            console.error(error);
        }
    },
};
</script>
