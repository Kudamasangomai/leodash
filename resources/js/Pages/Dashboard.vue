<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <MainContent>
            <div class="py-2">You're logged in!</div>
        </MainContent>
    </AuthenticatedLayout>
</template>
