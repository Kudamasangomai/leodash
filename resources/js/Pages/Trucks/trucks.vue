<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm, router } from "@inertiajs/vue3";
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
    form.status  =  truck.status
    showFormModal.value = true;
};

const submitForm = () => {
    if (editingTruck.value) {
        form.put(`/trucks/${editingTruck.value.id}`, {
            onSuccess: () => closeFormModal(),
            onError: (errors) => {
                console.log('Errors:', errors);
            }
        });
    }
};

const closeFormModal = () => {
    showFormModal.value = false;
    form.reset();
    editingTruck.value = null;
};
let  num =  1;
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
                <div
                    class="flex flex-wrap items-center justify-between gap-4 mb-4"
                >
                    <!-- <button

                                    type="button"
                                    class="flex items-center px-4 py-2 overflow-hidden font-medium bg-white border border-gray-300 rounded-md cursor-pointer text-slate-900 hover:bg-gray-50"
                                >
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
                                </button> -->
                    <!-- <div
                                    class="flex items-center w-full max-w-xs px-4 py-2 overflow-hidden bg-white border border-gray-300 rounded-md"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 192.904 192.904"
                                        class="w-4 h-4 mr-2 fill-gray-600"
                                    >
                                        <path
                                            d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z"
                                        ></path>
                                    </svg>
                                    <input
                                        type="email"
                                        placeholder="Search apps..."
                                        class="w-full text-sm bg-transparent outline-none text-slate-600"
                                    />
                                </div> -->
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-300 whitespace-nowrap">
                            <tr class="border-b border-gray-200">
                                <th
                                    class="px-4 py-3 text-left text-[14px] font-medium text-slate-600 border-r border-gray-200"
                                >
                                    Id
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[14px] font-medium text-slate-600 border-r border-gray-200"
                                >
                                    Asset Name
                                </th>
                                <!-- <th
                                    class="px-4 py-3 text-left text-[14px] font-medium text-slate-600 border-r border-gray-200"
                                >
                                    Plate
                                </th> -->
                                 <th
                                    class="px-4 py-3 text-left text-[14px] font-medium text-slate-600 border-r border-gray-200"
                                >
                                  Last reported At
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[14px] font-medium text-slate-600 border-r border-gray-200"
                                >
                                    Status
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
                                v-for="truck in trucks"
                                :key="truck.id"
                            >
                                <td class="px-4 py-3 border-r border-gray-200">
                                    <!-- {{ truck.id }} -->
                                    {{ num++ }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ truck.unitname }}
                                </td>
                                <!-- <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ truck.license_plate }}
                                </td> -->
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ truck.status  === 1 ? 'Active' : 'Inactive' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                >
                                    {{ truck.last_reported_at }}
                                </td>
                                <td
                                    class="px-4 py-3 text-[14px] text-slate-600 border-r border-gray-200"
                                >
                                 <button
                                    @click="openEditModal(truck)"

                                >
                                    <Editicon />
                                </button>



                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="m-4 mt-6 md:flex">
                    <p class="flex-1 text-sm text-slate-600">
                        Showind 1 to 5 of 100 entries
                    </p>
                    <div class="flex items-center max-md:mt-4">
                        <p class="text-sm text-slate-600">Display</p>
                        <select
                            class="h-8 px-1 mx-4 text-sm border border-gray-300 rounded-md outline-none text-slate-900"
                        >
                            <option>10</option>
                            <option>20</option>
                            <option>50</option>
                            <option>100</option>
                        </select>

                        <ul class="flex justify-center space-x-3">
                            <li
                                class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-md shrink-0"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 fill-gray-400"
                                    viewBox="0 0 55.753 55.753"
                                >
                                    <path
                                        d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z"
                                        data-original="#000000"
                                    />
                                </svg>
                            </li>
                            <li
                                class="flex items-center justify-center shrink-0 bg-blue-500 border hover:border-blue-500 border-blue-500 cursor-pointer text-sm font-medium text-white px-[13px] h-8 rounded-md"
                            >
                                1
                            </li>
                            <li
                                class="flex items-center justify-center shrink-0 border border-gray-300 hover:border-blue-500 cursor-pointer text-sm font-medium text-slate-900 px-[13px] h-8 rounded-md"
                            >
                                2
                            </li>
                            <li
                                class="flex items-center justify-center shrink-0 border border-gray-300 hover:border-blue-500 cursor-pointer text-sm font-medium text-slate-900 px-[13px] h-8 rounded-md"
                            >
                                3
                            </li>
                            <li
                                class="flex items-center justify-center shrink-0 border border-gray-300 hover:border-blue-500 cursor-pointer text-sm font-medium text-slate-900 px-[13px] h-8 rounded-md"
                            >
                                4
                            </li>
                            <li
                                class="flex items-center justify-center w-8 h-8 border border-gray-300 rounded-md cursor-pointer shrink-0 hover:border-blue-500"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 rotate-180 fill-gray-400"
                                    viewBox="0 0 55.753 55.753"
                                >
                                    <path
                                        d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z"
                                        data-original="#000000"
                                    />
                                </svg>
                            </li>
                        </ul>
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
