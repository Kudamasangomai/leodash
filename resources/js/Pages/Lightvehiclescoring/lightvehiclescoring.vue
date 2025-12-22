<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { ref, watch } from "vue";
import Spinner from "@/Components/Spinner.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    report: Array,
    trucks: Array,
});

const confirmDeleteCalibration = ref(false);
const scoringmodal = ref(false);

const busesform = () => {
    scoringmodal.value = true;
};

const closeModal = () => {
    confirmDeleteCalibration.value = false;
    scoringmodal.value = false;
};

const uploadForm = useForm({
    file: null,
    description: "",
});

function onFileChange(e) {
    const f = e.target.files && e.target.files[0] ? e.target.files[0] : null;
    uploadForm.file = f;
}

const fileInput = ref(null);

function resetForm() {
    uploadForm.reset();
    if (fileInput.value) {
        fileInput.value.value = null; // clear the file input visually
    }
}
function submitUpload() {
    if (!uploadForm.file) {
        return;
    }

    uploadForm.post("/lightvehiclescoring/upload", {
        preserveScroll: true,
        onSuccess: () => {
            resetForm(); // call our custom reset
            confirmDeleteCalibration.value = true;
        },
    });
}

const form = useForm({
    truck_id: "",
    start_date: "",
    end_date: "",
});

const submitForm = () => {
    form.post("/lightvehiclescoring/scoringReport", {
        onSuccess: () => closeFormModal(),
    });
};
</script>

<template>
    <Head title="Shunts n Buses" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle>Light Vehicle Scoring</PageTitle>
                <div>
                    <div></div>
                </div>
            </PageHeader>

            <!-- New: Vue-compatible file upload form (replaces Splade form) -->
            <div class="p-6 mb-4 space-y-6 rounded shadow-sm">
                <form
                    @submit.prevent="submitUpload"
                    enctype="multipart/form-data"
                    class="space-y-4"
                >
                    <div>
                        <label class="block text-sm font-medium">
                            Select Excel File (.xls or .xlsx)
                        </label>
                        <input
                            type="file"
                            accept=".xlsx,.xls"
                            ref="fileInput"
                            @change="uploadForm.file = $event.target.files[0]"
                            required
                            class="block w-full p-4 mt-1 text-sm"
                        />
                        <div
                            v-if="uploadForm.errors.file"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ uploadForm.errors.file }}
                        </div>
                    </div>

                    <div class="flex items-center">
                        <PrimaryButton
                            type="submit"
                            :disabled="uploadForm.processing"
                        >
                            Upload
                            <span
                                v-if="uploadForm.processing"
                                class="flex items-center"
                            >
                                <Spinner />
                            </span>
                        </PrimaryButton>
                        <SecondaryButton
                            type="button"
                            class="ms-3"
                            @click="uploadForm.reset('file')"
                        >
                            Cancel
                        </SecondaryButton>
                    </div>
                </form>
            </div>
            <!-- end new -->

            <div class="px-2 overflow-x-auto">
                <div class="mb-2 text-right">
                    <button
                        @click="busesform()"
                        class="hidden px-3 py-1 text-white bg-blue-500 rounded hover:bg-blue-600"
                    >
                        Generate
                    </button>
                </div>
                <table class="min-w-full text-center border border-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-2 border border-r border-gray-300">
                                Truck
                                <tr>
                                    <td class="text-gray-200">-</td>
                                </tr>
                            </th>
                            <th class="p-2 border border-r border-gray-300">
                                Total Distance
                                <tr>
                                    <td class="text-gray-200">-</td>
                                </tr>
                            </th>
                            <th class="p-2 border border-r border-gray-300">
                                Total Duration
                                <tr>
                                    <td class="text-gray-200">-</td>
                                </tr>
                            </th>
                            <th class="p-2 border border-r border-gray-300">
                                Overspeeding
                                <table class="min-w-full bg-white rounded">
                                    <tr class="bg-gray-200 w">
                                        <th class="px-2 py-1">Score</th>
                                        <th class="px-2 py-1">Occ</th>

                                        <th class="px-2 py-1">Max</th>
                                    </tr>
                                </table>
                            </th>
                            <th class="p-2 border border-r border-gray-300">
                                Over Reving
                                <table class="min-w-full bg-white rounded">
                                    <tr class="bg-gray-200 w">
                                        <th class="px-2 py-1">Score</th>
                                        <th class="px-2 py-1">Max</th>
                                    </tr>
                                </table>
                            </th>
                            <th class="p-2 border border-r border-gray-300">
                                Harsh Acceleration

                                <table class="min-w-full bg-white rounded">
                                    <tr class="bg-gray-200 w">
                                        <th class="px-2 py-1">Max</th>
                                        <th class="px-2 py-1">Score</th>
                                    </tr>
                                </table>
                            </th>
                            <th class="p-2 border border-r border-gray-300">
                                Harsh Braking
                                <table class="min-w-full bg-white rounded">
                                    <tr class="bg-gray-200 w">
                                        <th class="px-2 py-1">Max</th>

                                        <th class="px-2 py-1">Score</th>
                                    </tr>
                                </table>
                            </th>
                            <th class="p-2 border border-r border-gray-300">
                                Exessive idle
                                <table class="min-w-full bg-white rounded">
                                    <tr class="bg-gray-200 w">
                                        <th class="px-2 py-1">Occ</th>
                                        <th class="px-2 py-1">Dur</th>
                                    </tr>
                                </table>
                            </th>
                            <th class="p-2 border border-r border-gray-300">
                                GreenBand %
                                <table class="min-w-full bg-white rounded">
                                    <tr class="bg-gray-200 w">
                                        <th class="px-2 py-1">Score</th>
                                        <th class="px-2 py-1">Dur</th>
                                    </tr>
                                </table>
                            </th>
                            <th class="p-2 border border-r border-gray-300">
                                Overall Score
                                <tr>
                                    <td class="text-gray-200">-</td>
                                </tr>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 whitespace-nowrap">
                        <tr
                            v-for="row in report"
                            :key="row.asset_name"
                            class="text-[14px] text-slate-900 border border-gray-200"
                        >
                            <td class="px-4 py-3 border-r border-gray-200">
                                {{ row.asset_name }}
                            </td>
                            <td class="border-r border-gray-200">
                                {{ row.total_distance }}
                            </td>
                            <td class="border-r border-gray-200">
                                {{ row.total_duration_time }}
                            </td>
                            <td class="border-r border-gray-200">
                                <table class="min-w-full rounded">
                                    <tr>
                                        <td class="px-2 py-1">
                                            {{ row.overspeed_score }}
                                        </td>
                                        <td class="px-2 py-1">
                                            {{ row.overspeed_occ }}
                                        </td>
                                        <td class="px-2 py-1 whitespace-wrap">
                                            {{ row.overspeed_max }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-r border-gray-200">
                                <table class="min-w-full rounded">
                                    <tr>
                                        <td class="px-2 py-1">
                                            {{ row.overrev_score }}
                                        </td>
                                        <td class="px-2 py-1">
                                            {{ row.overrev_max }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-r border-gray-200">
                                <table class="min-w-full rounded">
                                    <tr>
                                        <td class="px-2 py-1">
                                            {{ row.harsh_acc_max }}
                                        </td>

                                        <td class="px-2 py-1 whitespace-wrap">
                                            {{ row.harsh_acc_score }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-r border-gray-200">
                                <table class="min-w-full rounded">
                                    <tr>
                                        <td class="px-2 py-1">
                                            {{ row.harsh_brake_max }}
                                        </td>

                                        <td class="px-2 py-1 whitespace-wrap">
                                            {{ row.harsh_brake_score }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-r border-gray-200">
                                <table class="min-w-full rounded">
                                    <tr>
                                        <td class="px-2 py-1">
                                            {{ row.idle_occ }}
                                        </td>
                                        <td class="px-2 py-1">
                                            {{ row.idle_duration_time }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-r border-gray-200">
                                <table class="min-w-full rounded">
                                    <tr>
                                        <td class="px-2 py-1">
                                            {{ row.greenband_percentage }}
                                        </td>
                                        <td class="px-2 py-1 whitespace-wrap">
                                            {{ row.greenband_duration_time }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>{{ row.overall_score }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </MainContent>

        <Modal :show="scoringmodal" @close="closeModal">
            <div class="p-4">
                <h2 class="text-lg font-medium text-gray-900">
                    Select truck and date range / Leave blank to generate all
                    Assets
                </h2>

                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Truck</label
                        >
                        <select
                            v-model="form.truck_id"
                            required
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        >
                            <option value="">Select a truck</option>
                            <option
                                v-for="truck in trucks"
                                :key="truck.id"
                                :value="truck.id"
                            >
                                {{ truck.unitname }}
                            </option>
                        </select>
                        <div
                            v-if="form.errors.truck_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.truck_id }}
                        </div>
                    </div>

                    <div>
                        <label
                            class="block my-4 text-sm font-medium text-gray-700"
                            >start time</label
                        >
                        <input
                            v-model="form.start_date"
                            type="datetime-local"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.start_date"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.start_date }}
                        </div>

                        <label
                            class="block my-4 text-sm font-medium text-gray-700"
                            >End time</label
                        >
                        <input
                            v-model="form.end_date"
                            type="datetime-local"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.end_date"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.end_date }}
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <SecondaryButton @click="closeModal"
                            >Cancel</SecondaryButton
                        >
                        <PrimaryButton
                            type="submit"
                            :disabled="form.processing"
                        >
                            Create
                            <span
                                v-if="form.processing"
                                class="flex items-center gap-2"
                            >
                                <Spinner />
                            </span>
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
