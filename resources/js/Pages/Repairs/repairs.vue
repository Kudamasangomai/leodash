<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { ref, watch } from "vue";
import Deleteicon from "@/Components/Deleteicon.vue";
import Editicon from "@/Components/Editicon.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Spinner from "@/Components/Spinner.vue";
import Closeicon from "@/Components/Closeicon.vue";

const props = defineProps({
    repairs: Object,
    trucks: Array,
    faults: Array,
    users: Array,
});

const showFormModal = ref(false);
const confirmDeleteRepair = ref(false);
const repairToDelete = ref(null);
const editingRepair = ref(null);
const closeRepair = ref(null);
const deleteForm = useForm({});
const showRepairModal = ref(false);
const isModalOpen = ref(false); // controls modal visibility
const selectedRepair = ref(null); // stores repair clicked

const form = useForm({
    truck_id: "",
    fault_id: "",
    status: "pending",
    location: "",
    comments: "",
    donebyid: "",
    repairedondate: "",
});

const openCreateModal = () => {
    editingRepair.value = null;
    form.reset();
    showFormModal.value = true;
};

const openEditModal = (repair) => {
    editingRepair.value = repair;
    form.truck_id = repair.truck_id;
    form.fault_id = repair.fault_id;
    form.status = repair.status;
    form.location = repair.location;
    form.repairedondate = repair.repairedondate;
    showFormModal.value = true;
};

const openRepairModal = (repair) => {
    closeRepair.value = repair;
    form.truck_id = repair.truck_id;
    form.truck = repair.truck.unitname;
    form.comments = repair.comments;
    form.fault = repair.fault.name;
    form.fault_id = repair.fault_id;
    showRepairModal.value = true;
};

const submitForm = () => {
    if (editingRepair.value) {
        form.put(`/repairs/${editingRepair.value.id}`, {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post("/repairs", {
            onSuccess: () => closeModal(),
        });
    }
};

const CloseRepairForm = () => {
    form.put(`/repairs/closerepair/${closeRepair.value.id}`, {
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    form.reset();
    showFormModal.value = false;
    editingRepair.value = null;
    showRepairModal.value = false;
    confirmDeleteRepair.value = false;
    repairToDelete.value = null;
    isModalOpen.value = false;
    selectedRepair.value = null;
};

const confirmDelete = (repair) => {
    repairToDelete.value = repair;
    confirmDeleteRepair.value = true;
};

const deleteRepair = () => {
    deleteForm.delete(`/repairs/${repairToDelete.value.id}`, {
        onSuccess: () => closeModal(),
    });
};

const getStatusBadgeColor = (status) => {
    const colors = {
        pending: "bg-yellow-400 text-yellow-800",
        in_progress: "bg-blue-100 text-blue-800",
        completed: "bg-green-400 text-green-800",
        on_hold: "bg-red-100 text-red-800",
    };
    return colors[status] || "bg-gray-100 text-gray-800";
};

const isFetching = ref(false);
function triggerFetchLocations() {
    if (isFetching.value) return;
    isFetching.value = true;
    router.visit("/repairs/fetchlocations", {
        method: "get",
        onFinish: () => {
            isFetching.value = false;
        },
        preserveScroll: true,
    });
}

const q = ref("");
watch(q, (value) => {
    router.get("/repairs", value ? { q: value } : {}, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
});

// Function to open modal
function openModal(repair) {
    selectedRepair.value = repair;
    isModalOpen.value = true;
}
</script>

<template>
    <Head title="Repairs" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle>Repairs Managementppp</PageTitle>
                <div>
                    <PrimaryButton
                        @click="triggerFetchLocations"
                        :disabled="isFetching"
                    >
                        <template v-if="isFetching">
                            <span class="flex items-center gap-2">
                                Fetching Locations
                                <Spinner />
                            </span>
                        </template>
                        <template v-else> Fetch Locations </template>
                    </PrimaryButton>
                    <PrimaryButton @click="openCreateModal">
                        + New Repair
                    </PrimaryButton>
                </div>
            </PageHeader>

            <span
                v-if="deleteForm.recentlySuccessful"
                class="flex items-center"
            >
                <div class="flex justify-center w-full">
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
                                    Record Deleted Successfully
                                </p>
                                <!-- <p class="text-sm">Make sure you know how these changes affect you.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </span>

            <div class="py-4 ml-2">
                <label for="table-search" class="sr-only">Search</label>
                <div
                    class="relative flex justify-end w-full mt-1 mr-1 md:w-1/3 md:ml-auto"
                >
                    <input
                        type="text"
                        class="block w-full px-3 border border-gray-300 rounded shadow-sm"
                        placeholder="Search for truck or Fault"
                        v-model="q"
                    />

                    <div
                        class="flex flex-wrap items-center justify-between gap-4"
                    >
                        <PrimaryButton type="button">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="inline w-4 h-4 mr-2 fill-current"
                                viewBox="0 0 67.671 67.671"
                            >
                                <path
                                    d="M52.946 23.348H42.834v6h10.112c3.007 0 5.34 1.536 5.34 2.858v26.606c0 1.322-2.333 2.858-5.34 2.858H14.724c-3.007 0-5.34-1.536-5.34-2.858V32.207c0-1.322 2.333-2.858 5.34-2.858h10.11v-6h-10.11c-6.359 0-11.34 3.891-11.34 8.858v26.606c0 4.968 4.981 8.858 11.34 8.858h38.223c6.358 0 11.34-3.891 11.34-8.858V32.207c-.001-4.968-4.982-8.859-11.341-8.859z"
                                    data-original="#000000"
                                />
                                <path
                                    d="M24.957 14.955a2.99 2.99 0 0 0 2.121-.879l3.756-3.756v30.522a3 3 0 1 0 6 0V10.117l3.959 3.959c.586.586 1.354.879 2.121.879s1.535-.293 2.121-.879a2.998 2.998 0 0 0 0-4.242L36.078.877A2.987 2.987 0 0 0 33.958 0h-.046c-.767 0-1.534.291-2.12.877l-8.957 8.957a2.998 2.998 0 0 0 2.122 5.121z"
                                    data-original="#000000"
                                />
                            </svg>
                            Export
                        </PrimaryButton>
                    </div>
                </div>
            </div>
            <div class="px-2 overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Date
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Truck
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Fault
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Status
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Location
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Last Reported At
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Last Checked At
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Created By - Repaired By
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center divide-y divide-gray-200">
                        <tr
                            v-if="repairs.data && repairs.data.length"
                            v-for="repair in repairs.data"
                            :key="repair.id"
                            class="odd:bg-gray-50"
                        >
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ repair.created_at }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                <button
                                    @click="openModal(repair)"
                                    class="text-blue-500"
                                >
                                    {{ repair.truck.unitname }}
                                </button>
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ repair.fault.name }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] border-r border-gray-200"
                            >
                                <span
                                    :class="[
                                        'px-3 py-2 rounded text-[14px] font-semibold',
                                        getStatusBadgeColor(repair.status),
                                    ]"
                                >
                                    {{ repair.status }}
                                </span>
                            </td>

                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ repair.location || "N/A" }}
                            </td>
                            <td
                                :class="{
                                    'bg-red-300':
                                        repair.status === 'pending' &&
                                        repair.days_without_report > 1,
                                }"
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ repair.last_reported_at }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ repair.last_check_at || "N/A" }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ repair.user.name }}<br />
                                {{ repair.done_by?.name }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] justify-center text-slate-900 border-r border-gray-200 flex gap-2"
                            >
                                <button @click="openEditModal(repair)">
                                    <Editicon />
                                </button>

                                <button
                                    title="Close"
                                    class="mr-2"
                                    @click="openRepairModal(repair)"
                                >
                                    <Closeicon />
                                </button>
                                <button @click="confirmDelete(repair)">
                                    <Deleteicon />
                                </button>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="8" class="px-4 py-3 text-center">
                                Nothing to show
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex gap-2 mt-4 justify-end">
                    <Link
                        v-for="link in repairs.links"
                        :key="link.label"
                        :href="link.url ?? ''"
                        v-html="link.label"
                        class="px-3 py-1 border rounded border-gray-200"
                        :class="{
                            'bg-blue-500 text-white': link.active,
                            'text-gray-400': !link.url,
                        }"
                        preserve-scroll
                    />
                </div>
            </div>
        </MainContent>

        <!-- Form Modal -->
        <Modal :show="showFormModal" @close="closeModal">
            <div class="p-6 bg-white">
                <h2 class="mb-4 text-lg font-medium text-gray-900">
                    {{ editingRepair ? "Edit Repair" : "Create New Repair" }}
                </h2>

                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Truck</label>
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
                        <label class="block text-sm font-medium">Fault</label>
                        <select
                            v-model="form.fault_id"
                            required
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        >
                            <option value="">Select a Fault</option>
                            <option
                                v-for="fault in faults"
                                :key="fault.id"
                                :value="fault.id"
                            >
                                {{ fault.name }}
                            </option>
                        </select>
                        <div
                            v-if="form.errors.fault_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.fault_id }}
                        </div>
                    </div>

                    <div v-if="editinguser">
                        <label class="block text-sm font-medium">Role</label>
                        <select
                            v-model="form.role"
                            id="inputState"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        >
                            <option value="1">Admin</option>
                            <option value="0">User</option>
                        </select>
                        <div
                            v-if="form.errors.role"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.role }}
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
                            {{ editingRepair ? "Update" : "Create" }}
                            <span
                                v-if="isFetching || form.processing"
                                class="flex items-center gap-2"
                            >
                                <Spinner />
                            </span>
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Delete Confirmation Modal -->
        <Modal :show="confirmDeleteRepair" @close="closeModal">
            <div class="p-6 bg-white">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this repair record?
                </h2>

                <div class="flex justify-end gap-3 mt-6">
                    <SecondaryButton @click="closeModal"
                        >Cancel</SecondaryButton
                    >
                    <DangerButton
                        @click="deleteRepair"
                        :disabled="deleteForm.processing"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>

        <!-- Close repair modal-->
        <Modal :show="showRepairModal" @close="closeModal">
            <div class="p-6 bg-white">
                <h2 class="mb-4 text-lg font-medium text-gray-900">
                    Close Repair
                </h2>

                <h6>Truck - {{ form.truck }}</h6>
                <h6>Fault - {{ form.fault }}</h6>
                <form @submit.prevent="CloseRepairForm" class="space-y-4">
                    <label class="block text-sm font-medium"
                        >Job Done / comment</label
                    >
                    <input
                        v-model="form.comments"
                        type="text"
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                    />
                    <div
                        v-if="form.errors.comments"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.comments }}
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Fault</label>
                        <select
                            v-model="form.donebyid"
                            required
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        >
                            <option value="">Done By</option>
                            <option
                                v-for="user in users"
                                :key="user.id"
                                :value="user.id"
                            >
                                {{ user.name }}
                            </option>
                        </select>
                        <div
                            v-if="form.errors.fault_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.user_id }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium"
                            >Repaired On</label
                        >
                        <input
                            v-model="form.repairedondate"
                            type="date"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />

                        <div
                            v-if="form.errors.repairedondate"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.repairedondate }}
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
                            Close
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

        <Modal :show="isModalOpen" @close="closeModal">
            <!-- Modal Overlay -->
            <div>
                <!-- Modal Content -->
                <div class="bg-white rounded-2xl shadow-xl p-6 w-full">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-xl font-bold">Repair Details</h2>

                        <span
                            class="px-3 py-1 font-medium rounded-full"
                            :class="{
                                'bg-green-100 text-green-700':
                                    selectedRepair.status === 'completed',
                                'bg-yellow-100 text-yellow-700':
                                    selectedRepair.status === 'pending',
                                'bg-red-100 text-red-700':
                                    selectedRepair.status === 'failed',
                            }"
                        >
                            {{ selectedRepair.status }}
                        </span>
                    </div>

                    <!-- Info Grid -->
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="">Truck</span>
                            <span class="font-medium">
                                {{ selectedRepair.truck.unitname }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="">Fault</span>
                            <span class="font-medium">
                                {{ selectedRepair.fault.name }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="">Last Reported At</span>
                            <span class="font-medium">
                                {{ selectedRepair.last_reported_at }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="">Done By</span>
                            <span class="font-medium">
                                {{ selectedRepair.done_by?.name ?? "N/A" }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="">Done On</span>
                            <span class="font-medium">
                                {{ selectedRepair.repairedondate ?? "N/A" }}
                            </span>
                        </div>

                        <!-- Description -->
                        <div class="pt-3 border-t">
                            <p class="mb-1">Job Description</p>
                            <p class="bg-gray-200 rounded-lg p-3">
                                {{
                                    selectedRepair.comments ??
                                    "No description provided"
                                }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-6 flex justify-end">
                        <button
                            @click="closeModal"
                            class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
