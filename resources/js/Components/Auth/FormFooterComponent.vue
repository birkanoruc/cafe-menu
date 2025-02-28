<template>
    <footer>
        <p class="mt-10 text-center text-sm/6 text-gray-500">
            {{ pText + " " }}
            <router-link
                :to="{ name: routeName }"
                class="font-semibold text-indigo-600 hover:text-indigo-500"
                >{{ buttonText }}</router-link
            >
        </p>
    </footer>
</template>

<script>
export default {
    name: "RegisterFooterComponent",
    props: {
        pText: {
            type: String,
            default: "Default Component Text",
        },
        buttonText: {
            type: String,
            default: "Default Button Text",
        },
        routeName: {
            type: String,
            default: "/",
        },
    },
};
</script>
