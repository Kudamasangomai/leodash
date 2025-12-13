<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';


const props = defineProps({
    truck: Object,
});
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Edit Truck" />
    <div class="p-4">Edit form for truck: {{ truck.unitname }}</div>
  </AuthenticatedLayout>
</template>
