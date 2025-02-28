import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/Stores/auth";
import Dashboard from "@/Pages/Dashboard.vue";
import Categories from "@/Pages/Categories.vue";
import Products from "@/Pages/Products.vue";
import Venues from "@/Pages/Venues.vue";
import Profile from "@/Pages/Auth/Profile.vue";
import Login from "@/Pages/Auth/Login.vue";
import Register from "@/Pages/Auth/Register.vue";
import ForgotPassword from "@/Pages/Auth/ForgotPassword.vue";

const routes = [
    {
        path: "/",
        redirect: "/admin/login",
    },
    {
        path: "/admin",
        children: [
            {
                path: "login",
                name: "login",
                component: Login,
                meta: { requiresAuth: false },
            },
            {
                path: "register",
                name: "register",
                component: Register,
                meta: { requiresAuth: false },
            },
            {
                path: "forgot-password",
                name: "forgot-password",
                component: ForgotPassword,
                meta: { requiresAuth: false },
            },
        ],
    },
    {
        path: "/admin",
        children: [
            {
                path: "dashboard",
                name: "dashboard",
                component: Dashboard,
                meta: { requiresAuth: true },
            },
            {
                path: "venues/:id",
                name: "venues",
                component: Venues,
                meta: { requiresAuth: true },
            },
            // {
            //     path: "categories",
            //     name: "categories",
            //     component: Categories,
            //     meta: { requiresAuth: true },
            // },
            // {
            //     path: "products",
            //     name: "products",
            //     component: Products,
            //     meta: { requiresAuth: true },
            // },
            {
                path: "profile",
                name: "profile",
                component: Profile,
                meta: { requiresAuth: true },
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore();

    if (to.meta.requiresAuth && !auth.token) {
        return next("/admin/login");
    }

    if (!to.meta.requiresAuth && auth.token) {
        return next("/admin/dashboard");
    }

    next();
});

export default router;
