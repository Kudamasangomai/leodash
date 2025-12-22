<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import Modal from "@/Components/Modal.vue";
import { ref, warn } from "vue";
import DashboardStats from "@/Components/DashboardStats.vue";

const props = defineProps({
    inactiveReportingTrucks: Array,
    inactiveReportingCount: Number,
});

const showGtmodal = ref(false);

const openGtmodaldiv = () => {
    showGtmodal.value = true;
};

const closeGtmodal = () => {
    showGtmodal.value = false;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <MainContent>
            <div class="p-0 mx-auto md:p-2">
                <!-- row -->
                <div class="flex flex-row flex-wrap">
                    <div class="flex-shrink w-full max-w-full px-3 md:px-4">
                        <div
                            class="flex flex-row items-center justify-between mb-2"
                        >
                            <!-- <p class="my-3 text-lg font-bold">LeoDash</p> -->

                            <!-- Range time -->
                        </div>
                    </div>
                </div>

                <!-- row -->
                <div class="flex flex-row flex-wrap">
                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 lg:w-1/2"
                    >
                        <!-- box card -->
                        <div
                            class="h-full bg-white border border-blue-300 border-solid rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative px-2">
                                <div class="relative">
                                    <h2 class="my-4 text-center">
                                        Todo List / Reminders
                                    </h2>
                                    <ul
                                        class="mb-6 overflow-y-auto task-check h-72 scrollbars show p-2"
                                    >
                                        <li class="relative py-2">
                                            <label class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    name="checked-1"
                                                    value="1"
                                                    class="w-5 h-5 mr-2 border rounded form-checkbox text-cyan-500 dark:bg-slate-700 border-slate-300 dark:border-slate-700 focus:outline-none"
                                                />
                                                <span
                                                    >All 30 Telenor Sim cards to
                                                    be inserted in truck with
                                                    mix 3617 or mix 4000

                                                    <span
                                                        class="text-xs text-slate-500"
                                                        >30% progress</span
                                                    ></span
                                                >
                                            </label>
                                        </li>
                                        <li class="relative py-2">
                                            <label class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    name="checked-1"
                                                    value="1"
                                                    class="w-5 h-5 mr-2 border rounded form-checkbox text-cyan-500 dark:bg-slate-700 border-slate-300 dark:border-slate-700 focus:outline-none"
                                                />
                                                <span
                                                    >All Truck  using gps speed should be put on Vss

                                                    <span
                                                        class="text-xs text-slate-500"
                                                        >WIP</span
                                                    ></span
                                                >
                                            </label>
                                        </li>
                                        <li class="relative py-2">
                                            <label class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    name="checked-1"
                                                    value="1"
                                                    class="w-5 h-5 mr-2 border rounded form-checkbox text-cyan-500 dark:bg-slate-700 border-slate-300 dark:border-slate-700 focus:outline-none"
                                                />
                                                <span
                                                    >Comms Cloud intallations


                                                    <span
                                                        class="text-xs text-slate-500"
                                                        >4 left</span
                                                    >
                                                </span
                                                >
                                            </label>
                                        </li>


                                        <li class="relative py-2">
                                            <label class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    name="checked-3"
                                                    value="1"
                                                    class="w-5 h-5 mr-2 border rounded form-checkbox text-cyan-500 dark:bg-slate-700 border-slate-300 dark:border-slate-700 focus:outline-none"
                                                    checked=""
                                                />
                                                <span
                                                    >Sendem LeoPack Meeting

                                                    on
                                                    <span
                                                        class="text-xs text-slate-500"
                                                        >7 january 2026</span
                                                    >
                                                    On Site</span
                                                >
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink w-full max-w-full lg:w-1/2">
                        <!-- row -->
                        <div class="flex flex-row flex-wrap">
                            <div
                                class="flex-shrink w-1/2 max-w-full px-3 mb-6 md:px-4"
                            >
                                <!-- box card -->
                                <div
                                    @click="openGtmodaldiv()"
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5  bg-[#446ad7] shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            Gt Not Reporting
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{ inactiveReportingCount }}
                                        </h3>
                                    </div>
                                    <div
                                        class="absolute -right-4 -bottom-4 opacity-20"
                                    >
                                        <i
                                            class="text-6xl bx bx-smile text-cyan-500"
                                        ></i>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex-shrink w-1/2 max-w-full px-3 mb-6 md:px-4"
                            >
                                <!-- box card -->
                                <div
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5  bg-[#446ad7] shadow-red-800/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            No Trip Data
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            7
                                        </h3>
                                    </div>
                                    <div
                                        class="absolute -right-4 -bottom-4 opacity-20"
                                    >
                                        <i
                                            class="text-6xl text-red-500 bx bx-sad"
                                        ></i>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex-shrink w-1/2 max-w-full px-3 mb-6 md:px-4"
                            >
                                <!-- box card -->
                                <div
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5  bg-[#446ad7] shadow-yellow-800/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            On Gps Speed
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            15
                                        </h3>
                                    </div>
                                    <div
                                        class="absolute -right-4 -bottom-4 opacity-20"
                                    >
                                        <i
                                            class="text-6xl text-yellow-500 bx bx-filter-alt"
                                        ></i>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex-shrink w-1/2 max-w-full px-3 mb-6 md:px-4"
                            >
                                <!-- box card -->
                                <div
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5  bg-[#446ad7] shadow-green-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            Fm not Reprting
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            8
                                        </h3>
                                    </div>
                                    <div
                                        class="absolute -right-4 -bottom-4 opacity-20"
                                    >
                                        <i
                                            class="text-6xl text-green-500 bx bx-dollar-circle"
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row flex-wrap bg">
                            <div
                                class="flex w-1/2 max-w-full px-3 mb-6 md:px-4"
                            >
                                <!-- box card -->
                                <div
                                    class="relative h-full p-3 w-1/2 overflow-hidden rounded shadow-lg sm:p-5  bg-[#446ad7] shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            No Speed
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{ inactiveReportingCount }}
                                        </h3>
                                    </div>
                                    <div
                                        class="absolute -right-4 -bottom-4 opacity-20"
                                    >
                                        <i
                                            class="text-6xl bx bx-smile text-cyan-500"
                                        ></i>
                                    </div>
                                </div>
                                <div
                                    class="relative h-full p-3 ml-2 w-1/2 overflow-hidden rounded shadow-lg sm:p-5  bg-[#446ad7] shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            No Rpm
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{ inactiveReportingCount }}
                                        </h3>
                                    </div>
                                    <div
                                        class="absolute -right-4 -bottom-4 opacity-20"
                                    >
                                        <i
                                            class="text-6xl bx bx-smile text-cyan-500"
                                        ></i>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex w-1/2 max-w-full px-3 mb-6 md:px-4"
                            >
                                <!-- box card -->
                                <div
                                    class="relative h-full p-3 w-1/2 overflow-hidden rounded shadow-lg sm:p-5  bg-[#446ad7] shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            No Speed & rpm
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{ inactiveReportingCount }}
                                        </h3>
                                    </div>
                                    <div
                                        class="absolute -right-4 -bottom-4 opacity-20"
                                    >
                                        <i
                                            class="text-6xl bx bx-smile text-cyan-500"
                                        ></i>
                                    </div>
                                </div>
                                <div
                                    class="relative h-full p-3 ml-2 w-1/2 overflow-hidden rounded shadow-lg sm:p-5  bg-[#446ad7] shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            Faulty Gps
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{ inactiveReportingCount }}
                                        </h3>
                                    </div>
                                    <div
                                        class="absolute -right-4 -bottom-4 opacity-20"
                                    >
                                        <i
                                            class="text-6xl bx bx-smile text-cyan-500"
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div
                        class="flex-shrink  w-full  max-w-full px-3 mb-6 md:px-4 md:w-3/4 "
                    >
                        <!-- box card -->
                        <div
                            class="h-full p-6 bg-white border-blue-300 border rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="text-center">Repairs For the Month</h2>
                                <canvas
                                    class="max-w-100"
                                    id="BarChart"
                                ></canvas>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex-shrink  w-full max-w-full  px-3 mb-6 md:px-4 md:w-1/4"
                    >
                        <!-- box card   class="flex-shrink w-full max-w-full px-3 mb-6 overflow-scroll md:px-4 md:w-1/3"-->
                        <div
                            class="h-full p-6 bg-white border-blue-300 border rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="mb-2 text-center">Most fault by Month/ year</h2>
                                <div
                                    class="flex flex-col w-full max-w-sm mx-auto funnel-area"
                                >
                                        <table
                                    class="w-full text-sm text-left table-bordered-bottom table-sm"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-left">Fault</th>
                                            <th class="text-left">Times</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div>Gt not reporting</div>
                                            </td>
                                            <td>
                                                <div>5</div>
                                            </td>
                                        </tr>



                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 sm:w-1/2 md:w-full lg:w-1/3"
                    >

                        <div
                            class="h-full p-6 bg-white rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="mb-2 text-center">Sales Activity</h2>
                                <canvas
                                    class="max-w-100"
                                    id="SalesActifity"
                                ></canvas>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 sm:w-1/2 md:w-full lg:w-1/3"
                    >

                        <div
                            class="h-full p-6 bg-white rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="mb-2 text-center">Lead Sources</h2>
                                <canvas
                                    class="max-w-100"
                                    id="LeadSources"
                                ></canvas>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 lg:w-1/3"
                    >

                        <div
                            class="h-full p-6 bg-white rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="mb-2 text-center">Top Deals</h2>
                                <table
                                    class="w-full text-sm text-left table-bordered-bottom table-sm"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-left">Client</th>
                                            <th class="text-left">Deal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div>WMA Company</div>
                                            </td>
                                            <td>
                                                <div>7929$</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>Fruits Inc</div>
                                            </td>
                                            <td>
                                                <div>5629$</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>Wofttee LLC</div>
                                            </td>
                                            <td>
                                                <div>5329$</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>Beozta Inc</div>
                                            </td>
                                            <td>
                                                <div>4529$</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>Mr Danieal</div>
                                            </td>
                                            <td>
                                                <div>3229$</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 lg:w-1/2 "
                    >
                        <!-- box card -->
                        <div
                            class="h-full p-6 bg-white rounded border-blue-300 border shadow-lg overflow-x-auto shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                             <h2 class="mb-2 text-center">
                                   Faulty Units FM & Gt
                                </h2>
                            <div class="relative">
                                <table
                               class="min-w-full border border-gray-200 overflow-y-auto"
                                >
                                             <thead class="bg-gray-200">
                                        <tr>
                                            <th   class="p-2 border font-medium border-r text-[13px] border-gray-300">Type</th>
                                            <th   class="p-2 border font-medium border-r text-[13px] border-gray-300">Fault</th>
                                            <th   class="p-2 border font-medium border-r text-[13px] border-gray-300">Serial no</th>
                                            <th   class="p-2 border font-medium border-r text-[13px] border-gray-300">Location</th>
                                        </tr>
                                    </thead>
                                       <tbody class="text-center divide-y divide-gray-200">
                                        <tr class="odd:bg-gray-50">
                                            <td class="px-4 py-2 border-r border-gray-200">
                                                Mix4000
                                            </td>
                                         <td class="px-4 py-2 border-r border-gray-200 whitespace-nowrap">

                                                      Not Powering

                                            </td>
                                            <td class="px-4 py-2 border-r border-gray-200">
                                                393939040039473
                                            </td>
                                            <td class="px-4 py-2 border-r border-gray-200 whitespace-nowrap">
                                                leo Sendem
                                            </td>
                                        </tr>
      <tr>
                                            <td class="px-4 py-2 border-r border-gray-200">
                                                Mix4000
                                            </td>
                                              <td class="px-4 py-2 border-r border-gray-200">

                                                      Not Powering

                                            </td>
                                            <td class="px-4 py-2 border-r border-gray-200">
                                                393939040039473
                                            </td>
                                            <td class="px-4 py-2 border-r border-gray-200">
                                                leo Sendem
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 lg:w-1/2"
                    >
                        <!-- box card -->
                   <div
                            class="h-full p-6 bg-white rounded shadow-lg border-blue-300 border shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                             <h2 class="mb-2 text-center">
                                   Asset Register
                                </h2>
                            <div class="relative">
                                <table
                               class="min-w-full border border-gray-200 overflow-y-auto"
                                >
                                             <thead class="bg-gray-200">
                                        <tr>
                                            <th   class="p-2 border font-medium border-r text-[13px] border-gray-300">Type/Item</th>
                                            <th   class="p-2 border font-medium border-r text-[13px] border-gray-300">Total</th>

                                        </tr>
                                    </thead>
                                       <tbody class="text-center divide-y divide-gray-200">
                                        <tr class="odd:bg-gray-50">
                                            <td class="px-4 py-2 border-r border-gray-200">
                                                Mix4000
                                            </td>
                                         <td class="px-4 py-2 border-r border-gray-200">

                                          5

                                            </td>

                                        </tr>
                                             <tr class="odd:bg-gray-50">
                                            <td class="px-4 py-2 border-r border-gray-200">
                                           Global Track unit
                                            </td>
                                         <td class="px-4 py-2 border-r border-gray-200">

                                          5

                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </MainContent>

        <Modal :show="showGtmodal" @close="closeGtmodal">
            <div class="p-6 bg-white">
                <h2 class="mb-4 text-lg font-medium text-gray-900">
                    Gt Not reporting Trucks
                </h2>
                <div class="px-2 overflow-y-auto h-72 scrollbars show">
                    <table
                        class="min-w-full border border-gray-200 overflow-y-auto"
                    >
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                >
                                    Truck
                                </th>

                                <th
                                    class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                >
                                    last Reported At
                                </th>
                                <th
                                    class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                >
                                    Days Ago
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center divide-y divide-gray-200">
                            <tr
                                v-for="truck in inactiveReportingTrucks"
                                :key="truck.id"
                                class="odd:bg-gray-50"
                            >
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ truck.unitname }}
                                </td>
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ truck.last_reported_at ?? "Never" }}
                                </td>
                                <td>
                                    {{
                                        truck.days_without_report !== null
                                            ? truck.days_without_report + " "
                                            : "Never reported"
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <SecondaryButton @click="closeGtmodal"
                        >Close</SecondaryButton
                    >
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
