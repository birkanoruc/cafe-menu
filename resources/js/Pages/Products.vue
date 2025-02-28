<template>
    <DashboardLayout pageTitle="Ürünlerim">
        <ul>
            <li v-for="product in products" :key="product.id">
                <h2>{{ product.name }}</h2>
                <p>Price: {{ product.price }}</p>
                <p v-if="product.discount_price">
                    Discount Price: {{ product.discount_price }}
                </p>
                <p>{{ product.description }}</p>
                <img :src="product.featured_image" alt="Product Image" />
            </li>
        </ul>
    </DashboardLayout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    components: { DashboardLayout },
    data() {
        return {
            products: [],
        };
    },
    async created() {
        try {
            const response = await axios.get("/api/products");
            this.products = response.data;
        } catch (error) {
            console.error("Error fetching products:", error);
        }
    },
};
</script>
