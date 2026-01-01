<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref } from "vue";
import { onMounted, onBeforeUnmount } from "vue";
import Chart from "chart.js/auto";

const props = defineProps({
    inactiveReportingTrucks: Array,
    inactiveReportingCount: Number,
    faultCounts: Array,
    notes: Array,
    faultyunits : Array,
    chartData: Object,
});

const showGtmodal = ref(false);
const activeModalType = ref(null);

const OpenStatsModal = (type) => {
    activeModalType.value = type;
    showGtmodal.value = true;
};

const CloseStatsModal = () => {
    showGtmodal.value = false;
    activeModalType.value = null;
};



onMounted(() => {
    const ctx = document.getElementById("BarChart").getContext("2d");


    new Chart(ctx, {
        data: {
            labels:props.chartData.labels,
            datasets: [
                {
                    type: "bar",
                    label: "  Repairs For the Last 30 days",
                     data: props.chartData.totaldone,
                    backgroundColor: "#446ad7",
                    borderRadius: 10,
                    barPercentage:0.6

                },


            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: false,

                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                    },
                },
                x: {
                    ticks:{
                        autoSkip:false,

                    },
                    grid: {
                        display: false,
                    },
                },
            },
        },
    });
});

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
                                        Todo List / Reminders / Quick Notes
                                    </h2>
                                    <ul
                                        class="p-2 mb-6 overflow-y-auto task-check h-72 scrollbars show"
                                    >
                                        <li
                                            class="relative py-2"
                                            v-for="note in notes"
                                            :key="note.id"
                                        >
                                            <label class="flex items-center">
                                                <input
                                                    disabled
                                                    type="checkbox"
                                                    name="checked-1"
                                                    value="1"
                                                    class="w-4 h-4 mr-2 rounded text-cyan-500 bg-[#446ad7]"
                                                />
                                                <span
                                                    >{{ note.note }}

                                                    <span
                                                        class="text-sm text-slate-600"
                                                        >{{
                                                            note.sidenote
                                                        }}</span
                                                    ></span
                                                >
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <p class="mx-2 my-4 text-right">
                                <Link
                                    prefetch="mount"
                                    cache-for="2m"
                                    href="/notes"
                                    class="p-2 text-white bg-blue-500 rounded-xl"
                                >
                                    View All
                                </Link>
                            </p>
                        </div>
                    </div>
                    <div class="flex-shrink w-full max-w-full lg:w-1/2">
                        <!-- row -->
                        <div class="flex flex-row flex-wrap">
                            <div
                                class="flex-shrink w-1/2 max-w-full px-3 mb-6 cursor-pointer md:px-4"
                            >
                                <!-- box card -->

                                <div
                                    @click="OpenStatsModal('gtnotreporting')"
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5 bg-[#446ad7] shadow-cyan-700/10"
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
                                    <div class="absolute right-1 bottom-1">
                                        <i
                                            class="text-m bx bx-smile text-white w-[18px] h-[18px]"
                                        >
                                            <svg
                                                width="20px"
                                                height="20px"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                stroke="#ffffff"
                                            >
                                                <g
                                                    id="SVGRepo_bgCarrier"
                                                    stroke-width="0"
                                                ></g>
                                                <g
                                                    id="SVGRepo_tracerCarrier"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                ></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="3.5"
                                                        stroke="#ffffff"
                                                    ></circle>
                                                    <path
                                                        d="M20.188 10.9343C20.5762 11.4056 20.7703 11.6412 20.7703 12C20.7703 12.3588 20.5762 12.5944 20.188 13.0657C18.7679 14.7899 15.6357 18 12 18C8.36427 18 5.23206 14.7899 3.81197 13.0657C3.42381 12.5944 3.22973 12.3588 3.22973 12C3.22973 11.6412 3.42381 11.4056 3.81197 10.9343C5.23206 9.21014 8.36427 6 12 6C15.6357 6 18.7679 9.21014 20.188 10.9343Z"
                                                        stroke="#ffffff"
                                                    ></path>
                                                </g></svg
                                        ></i>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex-shrink w-1/2 max-w-full px-3 mb-6 cursor-pointer md:px-4"
                            >
                                <!-- box card -->
                                <div
                                    @click="OpenStatsModal('notripdata')"
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5 bg-[#446ad7] shadow-red-800/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            No Trip Data
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{
                                                faultCounts["Fm No Trip Data"]
                                                    ?.total ?? 0
                                            }}
                                        </h3>
                                    </div>
                                    <div class="absolute right-1 bottom-1">
                                        <i
                                            class="text-m bx bx-smile text-white w-[18px] h-[18px]"
                                        >
                                            <svg
                                                width="20px"
                                                height="20px"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                stroke="#ffffff"
                                            >
                                                <g
                                                    id="SVGRepo_bgCarrier"
                                                    stroke-width="0"
                                                ></g>
                                                <g
                                                    id="SVGRepo_tracerCarrier"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                ></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="3.5"
                                                        stroke="#ffffff"
                                                    ></circle>
                                                    <path
                                                        d="M20.188 10.9343C20.5762 11.4056 20.7703 11.6412 20.7703 12C20.7703 12.3588 20.5762 12.5944 20.188 13.0657C18.7679 14.7899 15.6357 18 12 18C8.36427 18 5.23206 14.7899 3.81197 13.0657C3.42381 12.5944 3.22973 12.3588 3.22973 12C3.22973 11.6412 3.42381 11.4056 3.81197 10.9343C5.23206 9.21014 8.36427 6 12 6C15.6357 6 18.7679 9.21014 20.188 10.9343Z"
                                                        stroke="#ffffff"
                                                    ></path>
                                                </g></svg
                                        ></i>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex-shrink w-1/2 max-w-full px-3 mb-6 cursor-pointer md:px-4"
                                @click="OpenStatsModal('gpsspeed')"

                            >
                                <!-- box card -->
                                <div
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5 bg-[#446ad7] shadow-yellow-800/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            On Gps Speed
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >

                                            {{
                                                faultCounts["Gps Speed"]
                                                    ?.total ?? 0
                                            }}

                                        </h3>
                                    </div>
                                    <div class="absolute right-1 bottom-1">
                                        <i
                                            class="text-m bx bx-smile text-white w-[18px] h-[18px]"
                                        >
                                            <svg
                                                width="20px"
                                                height="20px"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                stroke="#ffffff"
                                            >
                                                <g
                                                    id="SVGRepo_bgCarrier"
                                                    stroke-width="0"
                                                ></g>
                                                <g
                                                    id="SVGRepo_tracerCarrier"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                ></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="3.5"
                                                        stroke="#ffffff"
                                                    ></circle>
                                                    <path
                                                        d="M20.188 10.9343C20.5762 11.4056 20.7703 11.6412 20.7703 12C20.7703 12.3588 20.5762 12.5944 20.188 13.0657C18.7679 14.7899 15.6357 18 12 18C8.36427 18 5.23206 14.7899 3.81197 13.0657C3.42381 12.5944 3.22973 12.3588 3.22973 12C3.22973 11.6412 3.42381 11.4056 3.81197 10.9343C5.23206 9.21014 8.36427 6 12 6C15.6357 6 18.7679 9.21014 20.188 10.9343Z"
                                                        stroke="#ffffff"
                                                    ></path>
                                                </g></svg
                                        ></i>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex-shrink w-1/2 max-w-full px-3 mb-6 cursor-pointer md:px-4"
                                @click="OpenStatsModal('fmnotreporting')"
                            >
                                <!-- box card -->
                                <div
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5 bg-[#446ad7] shadow-green-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            Fm Not Reporting
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{
                                                faultCounts["Fm Not Reporting"]
                                                    ?.total ?? 0
                                            }}
                                        </h3>
                                    </div>
                                    <div class="absolute right-1 bottom-1">
                                        <i
                                            class="text-m bx bx-smile text-white w-[18px] h-[18px]"
                                        >
                                            <svg
                                                width="20px"
                                                height="20px"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                stroke="#ffffff"
                                            >
                                                <g
                                                    id="SVGRepo_bgCarrier"
                                                    stroke-width="0"
                                                ></g>
                                                <g
                                                    id="SVGRepo_tracerCarrier"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                ></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="3.5"
                                                        stroke="#ffffff"
                                                    ></circle>
                                                    <path
                                                        d="M20.188 10.9343C20.5762 11.4056 20.7703 11.6412 20.7703 12C20.7703 12.3588 20.5762 12.5944 20.188 13.0657C18.7679 14.7899 15.6357 18 12 18C8.36427 18 5.23206 14.7899 3.81197 13.0657C3.42381 12.5944 3.22973 12.3588 3.22973 12C3.22973 11.6412 3.42381 11.4056 3.81197 10.9343C5.23206 9.21014 8.36427 6 12 6C15.6357 6 18.7679 9.21014 20.188 10.9343Z"
                                                        stroke="#ffffff"
                                                    ></path>
                                                </g></svg
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row flex-wrap bg">
                            <div   @click="OpenStatsModal('nospeed')"
                                class="flex w-1/2 max-w-full px-3 mb-6 md:px-4"
                            >
                                <!-- box card -->
                                <div
                                    class="relative h-full p-3 w-1/2 overflow-hidden rounded shadow-lg sm:p-5 bg-[#446ad7] shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            No Speed
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{
                                                faultCounts["No Speed"]
                                                    ?.total ?? 0
                                            }}
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
                                <div  @click="OpenStatsModal('norpm')"
                                    class="relative h-full p-3 ml-2 w-1/2 overflow-hidden rounded shadow-lg sm:p-5 bg-[#446ad7] shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">No Rpm</h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >

                                            {{
                                                faultCounts["No Rpm"]?.total ??
                                                0
                                            }}
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
                                <div       @click="OpenStatsModal('nospeedrpm')"
                                    class="relative h-full p-3 w-1/2 overflow-hidden rounded shadow-lg sm:p-5 bg-[#446ad7] shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            No Speed & Rpm
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{
                                                faultCounts["No Rpm and Speed"]
                                                    ?.total ?? 0
                                            }}
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
                                    class="relative h-full p-3 ml-2 w-1/2 overflow-hidden rounded shadow-lg sm:p-5 bg-[#446ad7] shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            Faulty Gps
                                        </h2>
                                        <h3
                                            class="text-4xl font-bold text-center"
                                        >
                                            {{
                                                faultCounts["Faulty Gps"]
                                                    ?.total ?? 0
                                            }}
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
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 md:w-3/4"
                    >
                        <!-- box card -->
                        <div
                            class="h-full p-6 bg-white border border-blue-300 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="mb-4 text-center">
                                    Repairs For the Last 30 days
                                </h2>
                                <canvas
                                    class="max-w-100"
                                    id="BarChart"
                                ></canvas>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 md:w-1/4"
                    >
                        <!-- box card   class="flex-shrink w-full max-w-full px-3 mb-6 overflow-scroll md:px-4 md:w-1/3"-->
                        <div
                            class="h-full p-6 bg-white border border-blue-300 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="mb-2 text-center">
                                    Most fault by Month/ year
                                </h2>
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
                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 lg:w-1/2"
                    >
                        <!-- box card -->
                        <div
                            class="h-full p-6 overflow-x-auto bg-white border border-blue-300 rounded shadow-lg just shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >

                            <h2 class="mb-2 text-center">
                                Faulty Units FM / Gt
                            </h2>

                            <div class="relative mb-2">
                                <table
                                    class="min-w-full overflow-y-auto border border-gray-200"
                                >
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th
                                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                            >
                                                Type
                                            </th>
                                            <th
                                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                            >
                                                Fault
                                            </th>
                                            <th
                                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                            >
                                                Serial no
                                            </th>
                                            <th
                                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                            >
                                                Location
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="text-center divide-y divide-gray-200"
                                    >
                                        <tr class="odd:bg-gray-50" v-for="unit in faultyunits" :key="unit.it">
                                            <td
                                                class="px-4 py-2 border-r border-gray-200"
                                            >
                                             {{ unit.unit_type }}
                                            </td>
                                            <td
                                                class="px-4 py-2 border-r border-gray-200 whitespace-nowrap"
                                            >
                                                 {{ unit.fault }}
                                            </td>
                                            <td
                                                class="px-4 py-2 border-r border-gray-200"
                                            >
                                               {{ unit.serial_number }}
                                            </td>
                                            <td
                                                class="px-4 py-2 border-r border-gray-200 whitespace-nowrap"
                                            >
                                               {{ unit.location }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                             <p class="mx-2 my-2 text-right">
                        <Link href="/faultyunits" prefetch="mount" class="p-2 text-white bg-blue-500 rounded-xl" cache-for="1m">View All</Link>
                           </p>
                        </div>
                    </div>

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 lg:w-1/2"
                    >
                        <!-- box card -->
                        <div
                            class="h-full p-6 bg-white border border-blue-300 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <h2 class="mb-2 text-center">Asset Register</h2>
                            <div class="relative">
                                <table
                                    class="min-w-full overflow-y-auto border border-gray-200"
                                >
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th
                                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                            >
                                                Type/Item
                                            </th>
                                            <th
                                                class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                            >
                                                Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="text-center divide-y divide-gray-200"
                                    >
                                        <tr class="odd:bg-gray-50">
                                            <td
                                                class="px-4 py-2 border-r border-gray-200"
                                            >
                                                Mix4000
                                            </td>
                                            <td
                                                class="px-4 py-2 border-r border-gray-200"
                                            >
                                                5
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-gray-50">
                                            <td
                                                class="px-4 py-2 border-r border-gray-200"
                                            >
                                                Global Track unit
                                            </td>
                                            <td
                                                class="px-4 py-2 border-r border-gray-200"
                                            >
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

        <Modal :show="showGtmodal" @close="CloseStatsModal">
            <div class="p-6 bg-white">
                <div v-if="activeModalType === 'gtnotreporting'">
                    <h2 class="mb-4 text-lg font-medium text-gray-900">
                        Gt Not reporting Trucks
                    </h2>
                    <div class="px-2 overflow-y-auto h-72 scrollbars show">
                        <table
                            class="min-w-full overflow-y-auto border border-gray-200"
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
                                    <td
                                        class="px-4 py-2 border-r border-gray-200"
                                    >
                                        {{ truck.unitname }}
                                    </td>
                                    <td
                                        class="px-4 py-2 border-r border-gray-200"
                                    >
                                        {{ truck.last_reported_at ?? "Never" }}
                                    </td>
                                    <td>
                                        {{
                                            truck.days_without_report !== null
                                                ? truck.days_without_report +
                                                  " "
                                                : "Never reported"
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-else-if="activeModalType === 'notripdata'">
                    <h2 class="mb-4 text-lg font-medium text-gray-900">
                        No Trip Data
                    </h2>
                    <table
                        class="min-w-full overflow-y-auto border border-gray-200"
                    >
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                >
                                    Asset Name
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
                            </tr>
                        </thead>

                        <tbody class="text-center divide-y divide-gray-200">
                            <tr
                                v-for="repair in faultCounts['Fm No Trip Data']
                                    ?.repairs"
                                :key="repair.id"
                                class="odd:bg-gray-50"
                            >
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.truck.unitname }}
                                </td>
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.location }}
                                </td>

                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.last_reported_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else-if="activeModalType === 'gpsspeed'">
                    <h2 class="mb-4 text-lg font-medium text-gray-900">
                        On Gps Speed
                    </h2>
                    <table
                        class="min-w-full overflow-y-auto border border-gray-200"
                    >
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                >
                                    Asset Name
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
                            </tr>
                        </thead>

                        <tbody class="text-center divide-y divide-gray-200">
                            <tr
                                v-for="repair in faultCounts['Gps Speed']
                                    ?.repairs"
                                :key="repair.id"
                                class="odd:bg-gray-50"
                            >
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.truck.unitname }}
                                </td>
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.location }}
                                </td>

                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.last_reported_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else-if="activeModalType === 'fmnotreporting'">
                    <h2 class="mb-4 text-lg font-medium text-gray-900">
                    Fm Not Reporting
                    </h2>
                    <table
                        class="min-w-full overflow-y-auto border border-gray-200"
                    >
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                >
                                    Asset Name
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
                            </tr>
                        </thead>

                        <tbody class="text-center divide-y divide-gray-200">
                            <tr
                                v-for="repair in faultCounts['Fm Not Reporting']
                                    ?.repairs"
                                :key="repair.id"
                                class="odd:bg-gray-50"
                            >
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.truck.unitname }}
                                </td>
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.location }}
                                </td>

                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.last_reported_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else-if="activeModalType === 'norpm'">
                    <h2 class="mb-4 text-lg font-medium text-gray-900">
                    No Rpm
                    </h2>
                    <table
                        class="min-w-full overflow-y-auto border border-gray-200"
                    >
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                >
                                    Asset Name
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
                            </tr>
                        </thead>

                        <tbody class="text-center divide-y divide-gray-200">
                            <tr
                                v-for="repair in faultCounts['No Rpm']
                                    ?.repairs"
                                :key="repair.id"
                                class="odd:bg-gray-50"
                            >
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.truck.unitname }}
                                </td>
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.location }}
                                </td>

                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.last_reported_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                 <div v-else-if="activeModalType === 'nospeed'">
                    <h2 class="mb-4 text-lg font-medium text-gray-900">
                    No Rpm
                    </h2>
                    <table
                        class="min-w-full overflow-y-auto border border-gray-200"
                    >
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                >
                                    Asset Name
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
                            </tr>
                        </thead>

                        <tbody class="text-center divide-y divide-gray-200">
                            <tr
                                v-for="repair in faultCounts['No Speed']
                                    ?.repairs"
                                :key="repair.id"
                                class="odd:bg-gray-50"
                            >
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.truck.unitname }}
                                </td>
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.location }}
                                </td>

                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.last_reported_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                  <div v-else-if="activeModalType === 'nospeedrpm'">
                    <h2 class="mb-4 text-lg font-medium text-gray-900">
                    No Rpm
                    </h2>
                    <table
                        class="min-w-full overflow-y-auto border border-gray-200"
                    >
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="p-2 border font-medium border-r text-[13px] border-gray-300"
                                >
                                    Asset Name
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
                            </tr>
                        </thead>

                        <tbody class="text-center divide-y divide-gray-200">
                            <tr
                                v-for="repair in faultCounts['No Rpm and Speed']
                                    ?.repairs"
                                :key="repair.id"
                                class="odd:bg-gray-50"
                            >
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.truck.unitname }}
                                </td>
                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.location }}
                                </td>

                                <td class="px-4 py-2 border-r border-gray-200">
                                    {{ repair.last_reported_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <SecondaryButton @click="CloseStatsModal"
                        >Close</SecondaryButton
                    >
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
