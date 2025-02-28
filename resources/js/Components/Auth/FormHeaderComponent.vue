<template>
    <header>
        <h2 class="text-base/7 font-semibold text-gray-900">
            {{ title }}
        </h2>
        <p class="mt-1 text-sm/6 text-gray-600">
            {{ description }}
        </p>
    </header>
</template>

<script>
export default {
    name: "FormHeaderComponent",
    props: {
        title: {
            type: String,
            default: "Default Component Title",
        },
        description: {
            type: String,
            default: "Default Component Description",
        },
    },
};
</script>
