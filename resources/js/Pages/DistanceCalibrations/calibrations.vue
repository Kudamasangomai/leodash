<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm ,router} from "@inertiajs/vue3";
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
    deleteform.delete(
        route("dstcalibrations.destroy", calibrationToDelete.value),
        {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        }
    );
};

const closeModal = () => {
    confirmDeleteCalibration.value = false;
};

const q = ref("");
watch(q, (value) => {
    router.get("/dstcalibrations", value ? { q: value } : {}, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
});

// onMounted(() => {
//     if (typeof simpleDatatables !== "undefined") {
//         new simpleDatatables.DataTable("#mytable", {
//             searchable: true,
//             fixedHeight: true,
//         });
//     }
// });


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
                            <PrimaryButton type="button" @click="exportExcel">
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
                <table class="min-w-full border border-gray-200" id="mytable">
                    <thead class="bg-gray-200 whitespace-nowrap" id="example">
                        <tr class="border border-gray-300">
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Date Created
                            </th>
                        
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Asset Name
                            </th>

                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Status(road test done)
                            </th>

                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Date(road test done)
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                            >
                                Created By
                            </th>
                            <th
                                class="p-2 border font-medium border-r text-[13px] border-gray-300 hidden-excel"
                            >
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 whitespace-nowrap">
                        <tr
                            class="text-center odd:bg-gray-50"
                            v-for="cal in calibrations.data"
                            :key="cal.id"
                        >
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ cal.created_at }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ cal.truck.unitname }}
                            </td>

                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ cal.road_test_done }}
                            </td>

                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                <span v-if="cal.date_went_to_roadtest">{{
                                    cal.date_went_to_roadtest
                                }}</span>
                                <span
                                    v-if="cal.notes"
                                    class="block text-xs text-gray-500"
                                    >{{ cal.notes }}</span
                                >
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-900 border-r border-gray-200"
                            >
                                {{ cal.user.name }}
                            </td>
                            <td
                                class="px-4 py-3 text-[14px] text-slate-600 border-r border-gray-200"
                            >


                                 <Link prefetch="mount"
                                    cache-for="1m" :href="`/dstcalibrations/${cal.id}/edit`"
                                   class="mr-2"  >
                                    <Editicon />
                                </Link>

                                <a
                                    href="#"
                                    as="button"
                                    @click="confirmCalibrationDelete(cal.id)"
                                >
                                    <Deleteicon />
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                 <div class="flex gap-2 mt-4 justify-end">
                    <Link
                        v-for="link in calibrations.links"
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

        <Modal :show="confirmDeleteCalibration" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete This Distance Calibration
                </h2>



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
