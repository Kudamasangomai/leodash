<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = usePage().props.value;
const calibration = props.calibration || {};
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Distance Calibration" />

    <div class="max-w-2xl bg-white p-6 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-4">Distance Calibration #{{ calibration.id }}</h2>

      <div class="space-y-3">
        <div>
          <span class="font-semibold">Trucks:</span>
          {{ Array.isArray(calibration.trucks) ? calibration.trucks.join(', ') : calibration.trucks }}
        </div>

        <div>
          <span class="font-semibold">Created By:</span>
          {{ calibration.creator?.name || 'N/A' }}
        </div>

        <div>
          <span class="font-semibold">Date Created:</span>
          {{ new Date(calibration.date_created).toLocaleString() }}
        </div>

        <div v-if="calibration.date_went_to_roadtest">
          <span class="font-semibold">Date Went to Road Test:</span>
          {{ new Date(calibration.date_went_to_roadtest).toLocaleString() }}
        </div>

        <div>
          <span class="font-semibold">Road Test Done:</span>
          {{ calibration.road_test_done ? 'Yes' : 'No' }}
        </div>

        <div v-if="calibration.notes">
          <span class="font-semibold">Notes:</span>
          {{ calibration.notes }}
        </div>
      </div>

      <div class="mt-4 flex gap-2">
        <Link :href="`/distance-calibrations/${calibration.id}/edit`" class="bg-blue-600 text-white px-3 py-1 rounded">Edit</Link>
        <Link :href="route('distance-calibrations.index')" class="bg-gray-600 text-white px-3 py-1 rounded">Back</Link>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
