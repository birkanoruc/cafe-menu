<template>
    <div
        class="flex min-h-screen flex-1 flex-col justify-center px-6 py-12 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img
                class="mx-auto h-10 w-auto"
                src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                alt="Kafe Menülerim"
            />
            <h1
                class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900"
            >
                {{ pageTitle }}
            </h1>
        </div>

        <main class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <slot></slot>
        </main>
    </div>
</template>

<script>
export default {
    props: {
        pageTitle: {
            type: String,
            default: "Default Page Title",
        },
    },
};
</script>
