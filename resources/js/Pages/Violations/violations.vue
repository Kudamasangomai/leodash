<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm} from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { ref} from "vue";
import Spinner from "@/Components/Spinner.vue";


const props = defineProps({violations: Object,});

const confirmDeleteCalibration = ref(false);
const copytable = ref(false);

const closeModal = () => {
    confirmDeleteCalibration.value = false;
    copytable.value = false;
};

const uploadForm = useForm({
    file: null,
});

function onFileChange(e) {
    const f = e.target.files && e.target.files[0] ? e.target.files[0] : null;
    uploadForm.file = f;
}


function submitUpload() {
    if (!uploadForm.file) {return;}

    // Post to the upload route.
    uploadForm.post("/violations/upload", {
        preserveScroll: true,
        onSuccess: () => {
            uploadForm.reset();
            confirmDeleteCalibration.value = true;
        },
        onError: (errors) => {
            alert(errors.file ?? "Failed To Upload");
           uploadForm.reset();

        },
    });
}


// store clicked eventType
const selectedEventType = ref("");

// Function to open modal
function openModal(eventType) {
    selectedEventType.value = eventType;
    copytable.value = true;
}

// Function to copy table content
function copyTable(eventType) {
    const table = document.getElementById("table-" + eventType);
    if (!table) return;

    // Create a temporary textarea
    const textarea = document.createElement("textarea");
    textarea.value = table.innerText;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy"); // copy to clipboard
    document.body.removeChild(textarea);
    copytable.value = true;
    openModal(eventType);
}
</script>

<template>
    <Head title="Violations" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle> Daily Violations Report</PageTitle>
                <div>
                    <div></div>
                </div>
            </PageHeader>

            <div class="p-6 mb-4 space-y-6 shadow-sm bg-white rounded-md">
                <form
                    @submit.prevent="submitUpload"
                    enctype="multipart/form-data"
                    class="space-y-4"
                >

                 <div class="text-blue-500 font-bold">
                    Download the  Events report as csv then convert to .xls or .xlsx then upload
                </div>
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
            <div
               v-if="group && group.length"
                v-for="(group, eventType) in violations"
                :key="eventType"
                class="mb-8 text-center py-4"
            >
                <h2 class="mb-2 text-lg font-bold">{{ eventType }} Events</h2>

                <div class="mb-2 text-right">
                    <button
                        @click="copyTable(eventType)"
                        class="px-3 py-1 text-white bg-blue-500 rounded hover:bg-blue-600"
                    >
                        Copy Table
                    </button>
                </div>
                <div class="px-2 overflow-x-auto" >
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-2 border">Date</th>
                                <th class="p-2 border">Asset</th>
                                <th class="p-2 border">Driver</th>
                                <th class="p-2 border">Location</th>

                                <th class="p-2 border">Duration</th>
                                <th class="p-2 border">Max Speed</th>
                                <th class="p-2 border">Destination</th>
                                <th class="p-2 border">Coordinates</th>
                                <th class="p-2 border">Event</th>
                            </tr>
                        </thead>
                        <tbody
                            :id="'table-' + eventType"
                            class="divide-y divide-gray-200 whitespace-nowrap"
                        >
                            <tr

                                v-for="row in group"
                                :key="row.id"
                                class="text-center odd:bg-gray-50"
                            >
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ row.date }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ row.asset }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ row.driver }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ row.location }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ row.duration }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ row.max_speed }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ row.destination }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ row.coordinates }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ row.event_type }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div v-else class="py-6 text-center text-xl">
      Violations Table Empty
            </div>
        </MainContent>

        <Modal :show="confirmDeleteCalibration" @close="closeModal">
            <div class="p-4">
                <h2 class="text-lg font-medium text-gray-900">
                    Violation Report Succesfully Generated
                </h2>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeModal"> Ok </SecondaryButton>
                </div>
            </div>
        </Modal>

        <Modal :show="copytable" @close="closeModal">
            <div class="p-4">
                <h2 class="text-lg font-medium text-gray-900">
                    <span class="font-bold">{{ selectedEventType }}</span>
                    Succesfully Copied to Clipboard
                </h2>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeModal"> Ok </SecondaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
