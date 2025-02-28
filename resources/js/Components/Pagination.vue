<template>
    <div
        class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
    >
        <div class="flex flex-1 justify-between sm:hidden">
            <a
                v-if="pagination.links && pagination.links.prev"
                :href="pagination.links.prev"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Önceki
            </a>
            <a
                v-if="pagination.links && pagination.links.next"
                :href="pagination.links.next"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Sonraki
            </a>
        </div>

        <div
            class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
        >
            <div>
                <p class="text-sm text-gray-700">
                    Toplam
                    <span class="font-medium">{{ pagination.total }}</span>
                    sonuç arasından
                    <span class="font-medium">{{ pagination.from }}</span>
                    ila
                    <span class="font-medium">{{ pagination.to }}</span>
                    arasındaki kayıtlar.
                </p>
            </div>
            <div>
                <nav
                    class="isolate inline-flex -space-x-px rounded-md shadow-xs"
                    aria-label="Pagination"
                >
                    <a
                        v-if="pagination.links && pagination.links.prev"
                        :href="pagination.links.prev"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                    >
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="size-5" aria-hidden="true" />
                    </a>

                    <a
                        v-for="page in pagination.pages"
                        :key="page"
                        :href="`#`"
                        :aria-current="
                            page === pagination.current_page
                                ? 'page'
                                : undefined
                        "
                        :class="{
                            'relative z-10 inline-flex items-center bg-indigo-600 text-white px-4 py-2 text-sm font-semibold focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600':
                                page === pagination.current_page,
                            'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:outline-offset-0':
                                page !== pagination.current_page,
                        }"
                    >
                        {{ page }}
                    </a>

                    <a
                        v-if="pagination.links && pagination.links.next"
                        :href="pagination.links.next"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                    >
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="size-5" aria-hidden="true" />
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/20/solid";

// computed import
import { defineProps, computed } from "vue";

const props = defineProps({
    pagination: {
        type: Object,
        required: true,
    },
});

const pagination = computed(() => {
    return {
        ...props.pagination,
        from:
            (props.pagination.current_page - 1) * props.pagination.per_page + 1,
        to: Math.min(
            props.pagination.current_page * props.pagination.per_page,
            props.pagination.total
        ),
        pages: Array.from(
            { length: props.pagination.total_pages },
            (_, i) => i + 1
        ),
    };
});
</script>
