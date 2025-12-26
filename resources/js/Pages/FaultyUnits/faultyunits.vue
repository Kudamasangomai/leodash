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
    faultyunits: Array,
});

const showFormModal = ref(false);
const confirmDeleteFaultyUnit = ref(false);
const FaultyunitToDelete = ref(null);
const editingFaultyunit = ref(null);
const deleteForm = useForm({});


const form = useForm({
    fault: "",
    serial_number: "",
    location: "",
    comment: "",
    unit_type: "",
});

const openCreateModal = () => {
    editingFaultyunit.value = null;
    form.reset();
    showFormModal.value = true;
};

const openEditModal = (unit) => {
    editingFaultyunit.value = unit;
    form.unit_type = unit.unit_type;
    form.fault = unit.fault;
    form.serial_number = unit.serial_number;
    form.location = unit.location;
    form.comment = unit.comment;
    showFormModal.value = true;
};

const submitForm = () => {
    if (editingFaultyunit.value) {
        form.put(`/faultyunits/${editingFaultyunit.value.id}`, {
            onSuccess: () => closeFormModal(),
        });
    } else {
        form.post("/faultyunits", {
            onSuccess: () => closeFormModal(),
        });
    }
};

const closeFormModal = () => {
    showFormModal.value = false;
    form.reset();
    editingFaultyunit.value = null;
};

const confirmDelete = (repair) => {
    FaultyunitToDelete.value = repair;
    confirmDeleteFaultyUnit.value = true;
};

const closeDeleteModal = () => {
    confirmDeleteFaultyUnit.value = false;
    FaultyunitToDelete.value = null;
};

const deleteNote = () => {
    deleteForm.delete(`/faultyunits/${FaultyunitToDelete.value.id}`, {
        onSuccess: () => closeDeleteModal(),
    });
};
</script>

<template>
    <Head title="Faulty Units" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle>Quick Notes / Reminders / Todo list</PageTitle>
                <div>
                    <PrimaryButton @click="openCreateModal">
                        + New Note
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
                                unit type
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Fault
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Serial Number
                            </th>

                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Location
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
                            v-if="faultyunits && faultyunits.length"
                            v-for="unit in faultyunits"
                            :key="unit.id"
                            class="odd:bg-gray-50"
                        >
                         <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ unit.created_at }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ unit.unit_type }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ unit.fault }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ unit.serial_number }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] border-r border-gray-200"
                            >
                                {{ unit.location }}
                            </td>

                            <td
                                class="px-4 py-3 text-[14px] justify-center text-slate-900 border-r border-gray-200 flex gap-2"
                            >
                                <button @click="openEditModal(unit)">
                                    <Editicon />
                                </button>

                                <button @click="confirmDelete(unit)">
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
                    {{
                        editingFaultyunit
                            ? "Edit Faulty Unit Record"
                            : "Create Faulty Unit Record"
                    }}
                </h2>
<div class="overflow-y-auto h-72 scrollbars show">
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Unit Type</label
                        >
                        <input
                            v-model="form.unit_type"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.unit_type"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.unit_type }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Fault / Defects</label
                        >
                        <input
                            v-model="form.fault"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.fault"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.fault }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Serial No</label
                        >
                        <input
                            v-model="form.serial_number"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.serial_number"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.serial_number }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Comment</label
                        >
                        <input
                            v-model="form.comment"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.comment"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.comment }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Location</label
                        >

                        <select
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                            v-model="form.location"
                        >
                            <option selected disabled value="">
                                Choose Type
                            </option>
                            <option value="LeoSendemOffice">
                                Leo Sendem Office
                            </option>
                            <option value="LeopackOffice">
                                Leopack Office
                            </option>
                            <option value="MixOffice">Mix Office</option>
                            <option value="GTOffice">Gt Office</option>
                        </select>

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
                            {{ editingFaultyunit ? "Update" : "Create" }}
                            <span
                                v-if="form.processing"
                                class="flex items-center gap-2"
                            >
                                <Spinner />
                            </span>
                        </PrimaryButton>
                    </div>
                </form></div>
            </div>
        </Modal>

        <!-- Delete Confirmation Modal -->
        <Modal :show="confirmDeleteFaultyUnit" @close="closeDeleteModal">
            <div class="p-6 bg-white">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this record?
                </h2>

                <div class="flex justify-end gap-3 mt-6">
                    <SecondaryButton @click="closeDeleteModal"
                        >Cancel</SecondaryButton
                    >
                    <DangerButton
                        @click="deleteNote"
                        :disabled="deleteForm.processing"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
