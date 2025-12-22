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
const copytable = ref(false);

const closeModal = () => {
    confirmDeleteCalibration.value = false;
    copytable.value = false;
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
    uploadForm.post("/moving-report/upload", {
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


     // modal visibility


// Function to copy table content
function copyTable() {
 const table = document.getElementById('table-');
    if (!table) return;

    let text = '';
    // Loop through each row
    for (const row of table.rows) {
        const rowText = Array.from(row.cells)
            .map(cell => cell.innerText.trim()) // get text from each cell
            .join('\t'); // tab-separated
        text += rowText + '\n'; // add newline at the end of each row
    }

    // Copy to clipboard
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);

    copytable.value = true;

}
</script>

<template>
    <Head title="Early Start" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle> Early Start Report</PageTitle>
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
                            accept=".xlsx,.xls"
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
                    <div class="mb-2 text-right">
        <button
          @click="copyTable()"
          class="px-3 py-1 text-white bg-blue-500 rounded hover:bg-blue-600"
        >
          Copy Table
        </button>
      </div>
                <table :id="'table-'" class="min-w-full border border-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-2 border">Location</th>
                            <th class="p-2 border">Early Trucks</th>
                            <th class="p-2 border">Trucks E/R</th>
                            <th class="p-2 border">1st Truck</th>
                            <th class="p-2 border">Last Truck</th>
                            <th class="p-2 border">Last 3 Trucks</th>
                            <th class="p-2 border">After 6</th>

                        </tr>
                    </thead>
                    <tbody   class="divide-y divide-gray-200 whitespace-nowrap">
                        <tr v-if="reports" v-for="row in reports" :key="row.id"      class="text-center odd:bg-gray-50">
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ row.location }}
                            </td>
                            <td  class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200">
                                {{ row.total_trucks }}
                            </td>

                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ row.total_trucks }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ row.first_time }}
                            </td>

                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ row.last_time }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                <p v-if="row.last_3 && row.last_3.length">
                                    <span
                                        v-for="(truck, idx) in row.last_3"
                                        :key="idx"
                                        class="inline-block px-2 py-1 mr-1 rounded"
                                    >
                                        {{ truck.asset }} ({{ truck.time }})
                                    </span>
                                </p>
                            </td>

                              <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                             <p v-if="row.last_3_after_6am !== undefined">
        {{ row.last_3_after_6am }}
    </p>
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
                   Early Start Report Succesfully Generated
                </h2>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeModal">
                        Ok
                    </SecondaryButton>
                </div>
            </div>
        </Modal>

           <Modal :show="copytable" @close="closeModal">
            <div class="p-4 ">
                <h2 class="text-lg font-medium text-gray-900">

                   <span class="font-bold">{{ selectedEventType }}</span> Succesfully Copied to Clipboard
                </h2>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeModal"> Ok </SecondaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
