<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Editicon from "@/Components/Editicon.vue";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    trucks: Array,
});

// add loading state and sync function
const loading = ref(false);
const showFormModal = ref(false);
const editingTruck = ref(null);

function syncTrucks() {
    if (loading.value) return;
    loading.value = true;
    router.visit("/trucks/fetch", {
        method: "get",
        preserveState: true,
        onFinish: () => {
            loading.value = false;
        },
    });
}

const form = useForm({
    unitname: "",
    status: "",
});

const openEditModal = (truck) => {
    editingTruck.value = truck;
    form.unitname = truck.unitname;
    form.status = truck.status;
    showFormModal.value = true;
};

const submitForm = () => {
    if (editingTruck.value) {
        form.put(`/trucks/${editingTruck.value.id}`, {
            onSuccess: () => closeFormModal(),
            onError: (errors) => {
                console.log("Errors:", errors);
            },
        });
    }
};

const closeFormModal = () => {
    showFormModal.value = false;
    form.reset();
    editingTruck.value = null;
};
// let  num =  1;
</script>

<template>
    <Head title="Trucks" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle>Trucks</PageTitle>
                <div>
                    <div>
                        <PrimaryButton :disabled="loading" @click="syncTrucks">
                            <svg
                                class="w-5 h-5 mr-2 -ml-1"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>

                            <i v-if="!loading" class="mr-2 bx bx-chat"></i>
                            <svg
                                v-else
                                class="w-5 h-5 mr-2 text-white animate-spin"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                ></path>
                            </svg>
                            {{ loading ? "Syncing..." : "Fetch Trucks" }}
                        </PrimaryButton>
                    </div>
                </div>
            </PageHeader>

            <div class="p-6 overflow-x-auto">
              
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-300 whitespace-nowrap">
                            <tr class="border-b border-gray-200">

                                <th
                                    class="px-4 py-3 text-left text-[14px] font-medium text-slate-600 border-r border-gray-200"
                                >
                                    Asset Name
                                </th>

                                <th
                                    class="px-4 py-3 text-left text-[14px] font-medium text-slate-600 border-r border-gray-200"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[14px] font-medium text-slate-600 border-r border-gray-200"
                                >
                                    Last reported At
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[14px] font-medium text-slate-600 border-r border-gray-200"
                                >
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody
                            class="divide-y divide-gray-200 whitespace-nowrap"
                        >
                            <tr
                                class="odd:bg-gray-50"
                                v-for="truck in trucks.data"
                                :key="truck.id"
                            >

                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ truck.unitname }}
                                </td>

                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{
                                        truck.status === 1
                                            ? "Active"
                                            : "Inactive"
                                    }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ truck.last_reported_at }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-600 border-r border-gray-200"
                                >
                                    <button @click="openEditModal(truck)">
                                        <Editicon />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="m-4 mt-6 md:flex">
                    <p class="flex-1 text-sm text-slate-600">
                        Showing 1 to 5 of 100 entries
                    </p>

                <div class="flex gap-2 mt-4 justify-end">
                    <Link
                        v-for="link in trucks.links"
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
            </div>
        </MainContent>
        <Modal :show="showFormModal" @close="closeFormModal">
            <div class="p-6 bg-white">
                <h2 class="mb-4 text-lg font-medium text-gray-900">
                    {{ editingTruck ? "Edit Truck" : "Create New Repair" }}
                </h2>

                <form @submit.prevent="submitForm" class="space-y-4">
                    <div v-if="editingTruck">
                        <label class="block text-sm font-medium text-gray-700"
                            >Asset Name</label
                        >
                        <input
                            v-model="form.unitname"
                            type="text"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        />
                        <div
                            v-if="form.errors.unitname"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.unitname }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Status</label
                        >
                        <select
                            v-model="form.status"
                            required
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm"
                        >
                            <option value="">Select a Fault</option>
                            <option :value="1">Active</option>
                            <option :value="0">Inactive</option>
                        </select>
                        <div
                            v-if="form.errors.status"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.status }}
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
                            {{ editingTruck ? "Update" : "Create" }}
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
    </AuthenticatedLayout>
</template>
