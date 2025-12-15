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
    v: Object,
    reports:Array
});

const confirmDeleteCalibration = ref(false);


const closeModal = () => {
    confirmDeleteCalibration.value = false;
};

// --- New: upload form logic ---
const uploadForm = useForm({
    file: null,
});

function onFileChange(e) {
    const f = e.target.files && e.target.files[0] ? e.target.files[0] : null;
    uploadForm.file = f;
}

function submitUpload() {
    if (!uploadForm.file) {
        // simple client-side guard; server-side validation still applies
        return;
    }

    // Post to the upload route. Adjust URL if your route differs.
    uploadForm.post("/violations/upload", {
        preserveScroll: true,
        onSuccess: () => {
            uploadForm.reset();
             confirmDeleteCalibration.value = true;
        },
        onError: () => {
            // errors available in uploadForm.errors
        },
    });
}

</script>

<template>
    <Head title="Violations" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle> Violations Report</PageTitle>
                <div>
                    <div></div>
                </div>
            </PageHeader>

            <!-- New: Vue-compatible file upload form (replaces Splade form) -->
            <div class="p-6 mb-4 space-y-6 rounded shadow-sm">
                <form @submit.prevent="submitUpload" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Select Excel File (.xls or .xlsx)
                        </label>
                        <input
                            type="file"
                            accept=".xlsx,.xls,.csv"
                            @change="onFileChange"
                            required
                            class="block w-full p-4 mt-1 text-sm text-gray-700"
                        />
                        <div v-if="uploadForm.errors.file" class="mt-1 text-sm text-red-600">
                            {{ uploadForm.errors.file }}
                        </div>
                    </div>

                    <div class="flex items-center">
                        <PrimaryButton type="submit" :disabled="uploadForm.processing">
                            Upload
                               <span v-if="uploadForm.processing" class="flex items-center">
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
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-2 border">Location</th>
                            <th class="p-2 border">Early Trucks</th>
                            <th class="p-2 border">Trucks E/R</th>
                            <th class="p-2 border">1st Truck</th>
                            <th class="p-2 border">Last Truck</th>
                            <th class="p-2 border">Last 3 Trucks</th>

                        </tr>
                    </thead>
                    <tbody   class="divide-y divide-gray-200 whitespace-nowrap">
                        <tr v-if="violations" v-for="row in violations" :key="row.id"      class="text-center odd:bg-gray-50">
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ row }}
                            </td>
                            <td  class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200">

                            </td>

                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >

                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >

                            </td>

                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >

                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >

                            </td>

                        </tr>
                        <tr v-else>
                            <td>nothign to show</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </MainContent>

        <Modal :show="confirmDeleteCalibration" @close="closeModal">
            <div class="p-4 bg-green-200">
                <h2 class="text-lg font-medium text-gray-900">
                  Violation  Report Succesfully Generated
                </h2>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeModal">
                        Ok
                    </SecondaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
