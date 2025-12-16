<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({
    errors: Object,
});

// const show = ref(true);
// const pageProps = usePage().props;

const show = ref(false);
const page = usePage();

// watch(
//     () => pageProps.flash,
//     () => {
//         show.value = true;
//     },
//     { deep: true }
// );

watch(
    () => page.props.flash,
    () => {
        if (page.props.flash?.success || page.props.flash?.warning) {
            show.value = true;

            setTimeout(() => {
                show.value = false;
            }, 5000);
        }
    },
    { deep: true }
);
</script>
<template>
    <!-- SUCCESS -->
    <!-- <div
        v-if="page.props.flash.success && show"
        class="fixed z-50 p-4 text-sm text-white bg-green-500 rounded bottom-2 right-2"
    >
        {{ page.props.flash.success }}
    </div> -->

    <span v-if="page.props.flash.success && show" class="flex items-center">
        <div class="fixed z-50 flex justify-center w-full bottom-2 right-2">
            <div
                class="w-1/2 px-4 py-3 mb-4 text-teal-900 bg-teal-100 border-t-4 border-teal-500 rounded-b shadow-md"
                role="alert"
            >
                <div class="flex">
                    <div class="py-1">
                        <svg
                            class="w-6 h-6 mr-4 text-teal-500 fill-current"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"
                            />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">
                            {{ page.props.flash.success }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </span>

    <!-- WARNING -->

    <span v-if="page.props.flash.warning && show" class="flex items-center">
        <div class="fixed z-50 flex justify-center w-full bottom-2 right-2">
            <div
                class="w-1/2 px-4 py-3 mb-4 text-yellow-900 bg-yellow-100 border-t-4 border-yellow-500 rounded-b shadow-md"
                role="alert"
            >
                <div class="flex">
                    <div class="py-1">
                        <svg
                            class="w-6 h-6 mr-4 text-yellow-500 fill-current"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"
                            />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">
                            {{ page.props.flash.warning }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
