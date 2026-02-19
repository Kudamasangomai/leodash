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

const props = defineProps({
    users: Array,
});

const showFormModal = ref(false);
const confirmDeleteUser = ref(false);
const editinguser = ref(null);
const deleteForm = useForm({});
const userToDelete = ref(null);


const form = useForm({
    name: "",
    email: "",
    work_email: "",
    role: "",
    password: "",
});

const openCreateModal = () => {
    editinguser.value = null;
    form.reset();
    showFormModal.value = true;
};

const openEditModal = (user) => {
    editinguser.value = user;
    (form.name = user.name),
        (form.email = user.email),
          (form.work_email = user.work_email),
        (form.role= user.role),
        (form.password = user.password),
        (showFormModal.value = true);
};

const submitForm = () => {
    if (editinguser.value) {
        form.put(`/users/${editinguser.value.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                closeFormModal(), form.reset("form");
            },
        });
    } else {
        form.post(route("users.store"), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset("form");
                showFormModal.value = false;
            },
        });
    }
};

const confirmDelete = (user) => {
    userToDelete.value = user;
    confirmDeleteUser.value = true;
};


const deleteRepair = () => {
    deleteForm.delete(`/users/${userToDelete.value.id}`, {
        onSuccess: () => closeFormModal(),
    });
};


const closeFormModal = () => {
    showFormModal.value = false;
     editinguser.value = null;
     confirmDeleteUser.value= false;
    form.reset();

};
</script>

<template>
    <Head title="User" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle>Users</PageTitle>
                <div>
                    <PrimaryButton @click="openCreateModal">
                        + New user
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
                                Name
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Email
                            </th>

                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Work Email
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                IS Admin
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
                            v-if="users && users.length"
                            v-for="user in users"
                            :key="users.id"
                            class="odd:bg-gray-50"
                        >
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ user.name }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ user.email }}
                            </td>
                                 <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ user.work_email }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ user.role === 0 ? "NO" : "Yes" }}

                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200 flex gap-2"
                            >
                                <button @click="openEditModal(user)">
                                    <Editicon />
                                </button>
                                <!-- <button @click="confirmDelete(user)">
                                    <Deleteicon />
                                </button> -->
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
                    {{ editinguser ? "Edit User" : "Create New User" }}
                </h2>

                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Name</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.name"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Email</label
                        >
                        <input
                            v-model="form.email"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.email"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.email }}
                        </div>
                    </div>

                      <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Work Email</label
                        >
                        <input
                            v-model="form.work_email"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.work_email"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.work_email }}
                        </div>
                    </div>

                      <div v-if="editinguser">
                        <label class="block text-sm font-medium text-gray-700"
                            >Role</label
                        >
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Password</label
                        >
                        <input
                            v-model="form.password"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.password"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.password }}
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
                            {{ editinguser ? "Update" : "Create" }}
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

        <!-- Delete Confirmation Modal -->
        <Modal :show="confirmDeleteUser" @close="closeFormModal">
            <div class="p-6 bg-white">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this record?
                </h2>

                <div class="flex justify-end gap-3 mt-6">
                    <SecondaryButton @click="closeFormModal"
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
