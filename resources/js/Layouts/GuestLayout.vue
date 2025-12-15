<script setup>
import SendemLogo from '@/Components/SendemLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0"
    >
        <div class="mb-6 -mt-10">
            <Link href="/">
                <SendemLogo class="h-20 text-gray-500 fill-current w-22" />
            </Link>
        </div>

        <div
            class=" w-full overflow-hidden bg-[#3585DA] px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
