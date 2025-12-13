<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { ref, warn } from "vue";
import Deleteicon from "@/Components/Deleteicon.vue";
import Editicon from "@/Components/Editicon.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Spinner from "@/Components/Spinner.vue";

const props = defineProps({
    repairs: Array,
    trucks: Array,
    faults: Array,
    warning: Object,
});

const showFormModal = ref(false);
const confirmDeleteRepair = ref(false);
const repairToDelete = ref(null);
const editingRepair = ref(null);

const form = useForm({
    truck_id: "",
    fault_id: "",
    status: "pending",
    location: "",
});

const deleteForm = useForm({});

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
    showFormModal.value = true;
};

const closeFormModal = () => {
    showFormModal.value = false;
    form.reset();
    editingRepair.value = null;
};

const submitForm = () => {
    if (editingRepair.value) {
        form.put(`/repairs/${editingRepair.value.id}`, {
            onSuccess: () => closeFormModal(),
        });
    } else {
        form.post("/repairs", {
            onSuccess: () => closeFormModal(),
        });
    }
};



const confirmDelete = (repair) => {
    repairToDelete.value = repair;
    confirmDeleteRepair.value = true;
};

const closeDeleteModal = () => {
    confirmDeleteRepair.value = false;
    repairToDelete.value = null;
};

const deleteRepair = () => {
    deleteForm.delete(`/repairs/${repairToDelete.value.id}`, {
        onSuccess: () => closeDeleteModal(),
    });
};

const getStatusBadgeColor = (status) => {
    const colors = {
        pending: "bg-yellow-300 text-yellow-800",
        in_progress: "bg-blue-100 text-blue-800",
        completed: "bg-green-100 text-green-800",
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
</script>

<template>
    <Head title="Repairs" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle>Repairs Management</PageTitle>
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

      
            <span v-if="form.recentlySuccessful" class="flex items-center">
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
                                    Record created Successful
                                </p>
                                <!-- <p class="text-sm">Make sure you know how these changes affect you.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </span>

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
                                    Record Deleted Successful
                                </p>
                                <!-- <p class="text-sm">Make sure you know how these changes affect you.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </span>

              <span
                v-if="warning"
                class="flex items-center"
            >
                <div class="flex justify-center w-full">
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
                             {{ warning}}
                                </p>
                                <!-- <p class="text-sm">Make sure you know how these changes affect you.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </span>

        
            

            <div class="px-2 overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-2 border border-r border-gray-300">Truck</th>
                            <th class="p-2 border border-r border-gray-300">Fault</th>
                            <th class="p-2 border border-r border-gray-300">Status</th>
                            <th class="p-2 border border-r border-gray-300">Location</th>
                            <th class="p-2 border border-r border-gray-300">last Reported At</th>
                            <th class="p-2 border border-r border-gray-300">last Checked At</th>
                            <th class="p-2 border border-r border-gray-300">Created By</th>
                            <th class="p-2 border border-r border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center divide-y divide-gray-200">
                        <tr
                            v-if="repairs && repairs.length"
                            v-for="repair in repairs"
                            :key="repair.id"
                            class="odd:bg-gray-50"
                        >
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                <!-- {{ getTruckName(repair.truck.unitane) }} -->

                                {{ repair.truck.unitname }}
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
                                        'px-3 py-2 rounded text-xs font-semibold',
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
                                {{ repair.user.name }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200 flex gap-2"
                            >
                                <button
                                    @click="openEditModal(repair)"
                                    class="text-blue-600 hover:text-blue-900"
                                >
                                    <Editicon />
                                </button>
                                <button
                                    @click="confirmDelete(repair)"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    <Deleteicon />
                                </button>
                            </td>
                        </tr>
                        <tr v-else>
                            <td
                                colspan="8"
                                class="px-4 py-3 text-center text-gray-500"
                            >
                                Nothing to show
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </MainContent>

        <!-- Form Modal -->
        <Modal :show="showFormModal" @close="closeFormModal">
            <div class="p-6 bg-white">
                <h2 class="mb-4 text-lg font-medium text-gray-900">
                    {{ editingRepair ? "Edit Repair" : "Create New Repair" }}
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
                        <label class="block text-sm font-medium text-gray-700"
                            >Fault</label
                        >
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

                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Fault</label
                        >
                        <textarea
                            v-model="form.fault"
                            required
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        ></textarea>
                        <div
                            v-if="form.errors.fault"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.fault }}
                        </div>
                    </div> -->

                    <div v-if="editingRepair">
                        <label class="block text-sm font-medium text-gray-700"
                            >Location</label
                        >
                        <input
                            v-model="form.location"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.location"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.location }}
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <SecondaryButton @click="closeFormModal"
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
        <Modal :show="confirmDeleteRepair" @close="closeDeleteModal">
            <div class="p-6 bg-white">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this repair record?
                </h2>

                <div class="flex justify-end gap-3 mt-6">
                    <SecondaryButton @click="closeDeleteModal"
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
    </AuthenticatedLayout>
</template>
