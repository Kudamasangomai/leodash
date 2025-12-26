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
import { usePage } from "@inertiajs/vue3";
import Closeicon from "@/Components/Closeicon.vue";


const props = defineProps({
    notes: Array,
});

const showFormModal = ref(false);
const confirmDeleteRepair = ref(false);
const noteToDelete = ref(null);
const editingNote = ref(null);
const closeRepair = ref(null);
const deleteForm = useForm({});
const showRepairModal = ref(false);

const form = useForm({
    note: "",
    sidenote: "",

});

const openCreateModal = () => {
    editingNote.value = null;
    form.reset();
    showFormModal.value = true;
};

const openEditModal = (note) => {
    editingNote.value = note;
    form.note = note.note;
    form.sidenote = note.sidenote;
    // form.status = note.status;
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
    if (editingNote.value) {
        form.put(`/notes/${editingNote.value.id}`, {
            onSuccess: () => closeFormModal(),
        });
    } else {
        form.post("/notes", {
            onSuccess: () => closeFormModal(),
        });
    }
};



const closeFormModal = () => {
    showFormModal.value = false;
    form.reset();
    editingNote.value = null;
};



const confirmDelete = (repair) => {
    noteToDelete.value = repair;
    confirmDeleteRepair.value = true;
};

const closeDeleteModal = () => {
    confirmDeleteRepair.value = false;
    noteToDelete.value = null;
};

const deleteNote = () => {
    deleteForm.delete(`/notes/${noteToDelete.value.id}`, {
        onSuccess: () => closeDeleteModal(),
    });
};

// const getStatusBadgeColor = (status) => {
//     const colors = {
//         pending: "bg-yellow-300 text-yellow-800",
//         in_progress: "bg-blue-100 text-blue-800",
//         completed: "bg-green-300 text-green-800",
//         on_hold: "bg-red-100 text-red-800",
//     };
//     return colors[status] || "bg-gray-100 text-gray-800";
// };


</script>

<template>
    <Head title="Notes" />
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
                               Notes
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                               Side Note
                            </th>
                            <!-- <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Status
                            </th> -->




                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center divide-y divide-gray-200">
                        <tr
                            v-if="notes && notes.length"
                            v-for="note in notes"
                            :key="note.id"
                            class="odd:bg-gray-50"
                        >
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ note.created_at }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ note.note}}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ note.sidenote }}
                            </td>
                            <!-- <td
                                class="px-4 py-3 text-[14px] border-r border-gray-200"
                            >
                                <span
                                    :class="[
                                        'px-3 py-2 rounded text-xs font-semibold',
                                        getStatusBadgeColor(note.status),
                                    ]"
                                >
                                    {{ note.status }}
                                </span>
                            </td> -->



                            <td
                                class="px-4 py-3 text-[14px] justify-center text-slate-900 border-r border-gray-200 flex gap-2"
                            >
                                <button @click="openEditModal(note)">
                                    <Editicon />
                                </button>

                             
                                <button @click="confirmDelete(note)">
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
                    {{ editingNote ? "Edit Note" : "Create New Note" }}
                </h2>

                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Note</label
                        >
                      <input
                            v-model="form.note"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.note"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.note }}
                        </div>
                    </div>



                    <div >
                        <label class="block text-sm font-medium text-gray-700"
                            >Side note</label
                        >
                        <input
                            v-model="form.sidenote"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.sidenote"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.sidenote }}
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
                            {{ editingNote ? "Update" : "Create" }}
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
