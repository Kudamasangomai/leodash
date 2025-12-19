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
import Deleteicon from "@/Components/Deleteicon.vue";
import Editicon from "@/Components/Editicon.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    calibrations: Array,
});

const confirmDeleteCalibration = ref(false);
const calibrationToDelete = ref(null);
const deleteform = useForm({});



const confirmCalibrationDelete = (id) => {
    calibrationToDelete.value = id;
    confirmDeleteCalibration.value = true;
};

const DeleteCalibration = () => {
    deleteform.delete(route("dstcalibrations.destroy", calibrationToDelete.value), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmDeleteCalibration.value = false;
};

</script>

<template>
    <Head title="Distance Calibrations" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle>Distance Calibrations</PageTitle>
                <div>
                    <div>
                        <Link
                            href="/dstcalibrations/create"
                            prefetch="mount"
                            cache-for="5m"
                        >
                            <PrimaryButton>
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

                                New Distance Calibration
                            </PrimaryButton>
                        </Link>
                    </div>
                </div>
            </PageHeader>
               <div class="px-2 overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-200 whitespace-nowrap">
                    <tr class="border border-gray-300">
                        <th
                            class="p-2 border font-medium border-r text-[13px]  border-gray-300"
                        >
                            Id
                        </th>
                        <!-- <th
                            class="p-2 border font-medium border-r text-[13px]  border-gray-300"
                        >
                            Asset name
                        </th> -->
                            <th class="p-2 border font-medium border-r text-[13px]  border-gray-300">Asset Name</th>
                        <th
                            class="p-2 border font-medium border-r text-[13px]  border-gray-300"
                        >
                            Date Created
                        </th>
                        <th
                            class="p-2 border font-medium border-r text-[13px]  border-gray-300"
                        >
                            Status(road test done)
                        </th>

                        <th
                            class="p-2 border font-medium border-r text-[13px]  border-gray-300"
                        >
                            Date(road test done)
                        </th>
                        <th
                            class="p-2 border font-medium border-r text-[13px]  border-gray-300"
                        >
                          Created By
                        </th>
                        <th
                            class="p-2 border font-medium border-r text-[13px]  border-gray-300"
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
                                        v-for="cal in calibrations.data" :key="cal.id"
                                    >
                                        <td
                                            class="px-4 py-3 border-r border-gray-200"
                                        >
                                            {{ cal.id }}
                                        </td>
                                        <td
                                            class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                        >
                                            {{ cal.truck.unitname }}
                                        </td>
                                        <td
                                            class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                        >
                                            {{ cal.created_at }}
                                        </td>
                                        <td
                                            class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                        >
                                          {{ cal.road_test_done }}
                                        </td>

                                          <td
                                            class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                        >
                                          <span v-if="cal.date_went_to_roadtest">{{ cal.date_went_to_roadtest }}</span>
                                          <span v-if="cal.notes" class="block text-xs text-gray-500">{{ cal.notes }}</span>
                                        </td>
                                        <td
                                            class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                                        >
                                          {{ cal.user.name }}
                                        </td>
                                        <td
                                            class="px-4 py-3 text-[14px] text-slate-600 border-r border-gray-200"
                                        >

                                            <Link
                                              prefetch="mount"
                                                cache-for="2m"
                                                :href="`/dstcalibrations/${cal.id}/edit`"
                                                class="text-indigo-600 hover:text-indigo-900 me-3"
                                                >Edit</Link
                                            >


                                                <a
                                            href="#"
                                            as="button"
                                            @click="
                                                confirmCalibrationDelete(
                                                    cal.id
                                                )
                                            "
                                        >
                                            <Deleteicon />
                                        </a>
                                        </td>
                                    </tr>
                                </tbody>
            </table>
            </div>
        </MainContent>

      <Modal :show="confirmDeleteCalibration" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete This Distance Calibration
                </h2>

                <!-- <p class="mt-1 text-sm text-gray-600">
                    Once deleted, all of its related data will be permanently
                    deleted.
                </p> -->

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': deleteform.processing }"
                        :disabled="deleteform.processing"
                        @click="DeleteCalibration"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
