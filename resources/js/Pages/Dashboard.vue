<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import Modal from "@/Components/Modal.vue";
import { ref, warn } from "vue";

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
                            <p class="my-3 text-lg font-bold">LeoDash</p>

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
                                <div
                                    class="splide nav-hidden"
                                    role="group"
                                    aria-label="Splide Basic HTML Example"
                                >
                                    <div class="splide__track"></div>
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
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5 bg-cyan-50 dark:bg-blue-500 shadow-cyan-700/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            Gt not Reporting
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
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5 bg-red-50 dark:bg-blue-500 shadow-red-800/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            No Trip Datat
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
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5 bg-yellow-50 dark:bg-blue-500 shadow-yellow-800/10"
                                >
                                    <div class="relative dark:text-slate-100">
                                        <h2 class="mb-2 text-center">
                                            Using Gps Speed
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
                                    class="relative h-full p-3 overflow-hidden rounded shadow-lg sm:p-5 bg-green-50 dark:bg-blue-500 shadow-green-700/10"
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
                    </div>

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 lg:w-2/3"
                    >
                        <!-- box card -->
                        <div
                            class="h-full p-6 bg-white rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="text-center">Won vs Lost</h2>
                                <canvas
                                    class="max-w-100"
                                    id="BarChart"
                                ></canvas>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 lg:w-1/3"
                    >
                        <!-- box card -->
                        <div
                            class="h-full p-6 bg-white rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="mb-2 text-center">Sales Funnel</h2>
                                <div
                                    class="flex flex-col w-full max-w-sm mx-auto funnel-area"
                                >
                                    <ul>
                                        <li
                                            aria-label="New Lead"
                                            data-microtip-position="top"
                                            role="tooltip"
                                            class="funnel-1 float-left relative my-0.5 mx-0 text-center w-full"
                                        >
                                            <span
                                                class="inline-block h-0 border-solid border-cyan-300"
                                                ><p
                                                    class="text-center text-white"
                                                >
                                                    12.738
                                                </p></span
                                            >
                                        </li>
                                        <li
                                            aria-label="Qualified"
                                            data-microtip-position="top"
                                            role="tooltip"
                                            class="funnel-2 float-left relative my-0.5 mx-0 text-center w-full"
                                        >
                                            <span
                                                class="inline-block h-0 border-solid border-cyan-400"
                                                ><p
                                                    class="text-center text-white"
                                                >
                                                    5.435
                                                </p></span
                                            >
                                        </li>
                                        <li
                                            aria-label="Proposal"
                                            data-microtip-position="top"
                                            role="tooltip"
                                            class="funnel-3 float-left relative my-0.5 mx-0 text-center w-full"
                                        >
                                            <span
                                                class="inline-block h-0 border-solid border-cyan-500"
                                                ><p
                                                    class="text-center text-white"
                                                >
                                                    3.423
                                                </p></span
                                            >
                                        </li>
                                        <li
                                            aria-label="Negotiation"
                                            data-microtip-position="top"
                                            role="tooltip"
                                            class="funnel-4 float-left relative my-0.5 mx-0 text-center w-full"
                                        >
                                            <span
                                                class="inline-block h-0 border-solid border-cyan-600"
                                                ><p
                                                    class="text-center text-white"
                                                >
                                                    2.145
                                                </p></span
                                            >
                                        </li>
                                        <li
                                            aria-label="Won"
                                            data-microtip-position="top"
                                            role="tooltip"
                                            class="funnel-5 float-left relative my-0.5 mx-0 text-center w-full"
                                        >
                                            <span
                                                class="inline-block h-0 border-solid border-cyan-700"
                                                ><p
                                                    class="text-center text-white"
                                                >
                                                    1.340
                                                </p></span
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 sm:w-1/2 md:w-full lg:w-1/3"
                    >
                        <!-- box card -->
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
                        <!-- box card -->
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
                        <!-- box card -->
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
                    </div>

                    <div
                        class="flex-shrink w-full max-w-full px-3 mb-6 md:px-4 lg:w-1/2"
                    >
                        <!-- box card -->
                        <div
                            class="h-full p-6 bg-white rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <table
                                    class="w-full text-sm text-left table-bordered-bottom table-sm"
                                >
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Sales Name</th>
                                            <th>Lead</th>
                                            <th>Won</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div>#1</div>
                                            </td>
                                            <td>
                                                <div
                                                    class="flex flex-row flex-wrap items-center"
                                                >
                                                    <div
                                                        class="flex-shrink w-full max-w-full mb-1 font-bold text-slate-900 dark:text-slate-300"
                                                    >
                                                        <img
                                                            class="inline-block w-8 h-8 max-w-full mr-2 rounded-full shadow border-1 border-cyan-200 bg-slate-300 dark:border-slate-700"
                                                            src="src/img/avatar/avatar3.jpg"
                                                            alt="Avatar"
                                                        />John Thomas
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>139</div>
                                            </td>
                                            <td>
                                                <div>101</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>#2</div>
                                            </td>
                                            <td>
                                                <div
                                                    class="flex flex-row flex-wrap items-center"
                                                >
                                                    <div
                                                        class="flex-shrink w-full max-w-full mb-1 font-bold text-slate-900 dark:text-slate-300"
                                                    >
                                                        <img
                                                            class="inline-block w-8 h-8 max-w-full mr-2 rounded-full shadow border-1 border-cyan-200 bg-slate-300 dark:border-slate-700"
                                                            src="src/img/avatar/avatar4.jpg"
                                                            alt="Avatar"
                                                        />Carlos Garcia
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>122</div>
                                            </td>
                                            <td>
                                                <div>96</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>#3</div>
                                            </td>
                                            <td>
                                                <div
                                                    class="flex flex-row flex-wrap items-center"
                                                >
                                                    <div
                                                        class="flex-shrink w-full max-w-full mb-1 font-bold text-slate-900 dark:text-slate-300"
                                                    >
                                                        <img
                                                            class="inline-block w-8 h-8 max-w-full mr-2 rounded-full shadow border-1 border-cyan-200 bg-slate-300 dark:border-slate-700"
                                                            src="src/img/avatar/avatar5.jpg"
                                                            alt="Avatar"
                                                        />Daniel Esteban
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>123</div>
                                            </td>
                                            <td>
                                                <div>92</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>#4</div>
                                            </td>
                                            <td>
                                                <div
                                                    class="flex flex-row flex-wrap items-center"
                                                >
                                                    <div
                                                        class="flex-shrink w-full max-w-full mb-1 font-bold text-slate-900 dark:text-slate-300"
                                                    >
                                                        <img
                                                            class="inline-block w-8 h-8 max-w-full mr-2 rounded-full shadow border-1 border-cyan-200 bg-slate-300 dark:border-slate-700"
                                                            src="src/img/avatar/avatar6.jpg"
                                                            alt="Avatar"
                                                        />Steven Rey
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>110</div>
                                            </td>
                                            <td>
                                                <div>84</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>#5</div>
                                            </td>
                                            <td>
                                                <div
                                                    class="flex flex-row flex-wrap items-center"
                                                >
                                                    <div
                                                        class="flex-shrink w-full max-w-full mb-1 font-bold text-slate-900 dark:text-slate-300"
                                                    >
                                                        <img
                                                            class="inline-block w-8 h-8 max-w-full mr-2 rounded-full shadow border-1 border-cyan-200 bg-slate-300 dark:border-slate-700"
                                                            src="src/img/avatar/avatar7.jpg"
                                                            alt="Avatar"
                                                        />Roman Davis
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>111</div>
                                            </td>
                                            <td>
                                                <div>79</div>
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
                            class="h-full p-6 bg-white rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10"
                        >
                            <div class="relative">
                                <h2 class="mb-2 text-center">
                                    Todo List / Reminders
                                </h2>
                                <ul
                                    class="mb-6 overflow-y-auto task-check h-72 scrollbars show"
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
                                                >Send Email to Mr
                                                <span class="font-bold"
                                                    >Gabriel</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >18.00 pm</span
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
                                                >Call Mr
                                                <span class="font-bold"
                                                    >Theo Davis</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >16.00 pm</span
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
                                                >Meeting with Mr
                                                <span class="font-bold"
                                                    >Adreas Rose</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >15.00 am</span
                                                >
                                                in Zoom</span
                                            >
                                        </label>
                                    </li>
                                    <li class="relative py-2">
                                        <label class="flex items-center">
                                            <input
                                                type="checkbox"
                                                name="checked-2"
                                                value="1"
                                                class="w-5 h-5 mr-2 border rounded form-checkbox text-cyan-500 dark:bg-slate-700 border-slate-300 dark:border-slate-700 focus:outline-none"
                                                checked=""
                                            />
                                            <span
                                                >Call Mr
                                                <span class="font-bold"
                                                    >Toni Anderson</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >12.00 am</span
                                                ></span
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
                                                >Meeting with Mr
                                                <span class="font-bold"
                                                    >John Doe</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >12.00 am</span
                                                >
                                                in Zoom</span
                                            >
                                        </label>
                                    </li>
                                    <li class="relative py-2">
                                        <label class="flex items-center">
                                            <input
                                                type="checkbox"
                                                name="checked-2"
                                                value="1"
                                                class="w-5 h-5 mr-2 border rounded form-checkbox text-cyan-500 dark:bg-slate-700 border-slate-300 dark:border-slate-700 focus:outline-none"
                                                checked=""
                                            />
                                            <span
                                                >Call Mr
                                                <span class="font-bold"
                                                    >Adreas Rose</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >12.00 am</span
                                                ></span
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
                                                >Meeting with Mr
                                                <span class="font-bold"
                                                    >John Doe</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >12.00 am</span
                                                >
                                                in Zoom</span
                                            >
                                        </label>
                                    </li>
                                    <li class="relative py-2">
                                        <label class="flex items-center">
                                            <input
                                                type="checkbox"
                                                name="checked-2"
                                                value="1"
                                                class="w-5 h-5 mr-2 border rounded form-checkbox text-cyan-500 dark:bg-slate-700 border-slate-300 dark:border-slate-700 focus:outline-none"
                                                checked=""
                                            />
                                            <span
                                                >Call Mrs
                                                <span class="font-bold"
                                                    >Jenifer Tan</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >12.00 am</span
                                                ></span
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
                                                >Meeting with Mr
                                                <span class="font-bold"
                                                    >John Doe</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >12.00 am</span
                                                >
                                                in Zoom</span
                                            >
                                        </label>
                                    </li>
                                    <li class="relative py-2">
                                        <label class="flex items-center">
                                            <input
                                                type="checkbox"
                                                name="checked-2"
                                                value="1"
                                                class="w-5 h-5 mr-2 border rounded form-checkbox text-cyan-500 dark:bg-slate-700 border-slate-300 dark:border-slate-700 focus:outline-none"
                                                checked=""
                                            />
                                            <span
                                                >Call Mr
                                                <span class="font-bold"
                                                    >Adreas</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >12.00 am</span
                                                ></span
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
                                                >Meeting with Mr
                                                <span class="font-bold"
                                                    >John Doe</span
                                                >
                                                at
                                                <span
                                                    class="text-xs text-slate-500"
                                                    >12.00 am</span
                                                >
                                                in Zoom</span
                                            >
                                        </label>
                                    </li>
                                </ul>
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
                <div class="px-2 overflow-y-auto">
                    <table class="min-w-full border border-gray-200">
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
                            >
                                <td>{{ truck.unitname }}</td>
                                <td>{{ truck.last_reported_at ?? "Never" }}</td>
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
                <div class="flex justify-end gap-3 mt-6">
                    <SecondaryButton @click="closeGtmodal"
                        >Close</SecondaryButton
                    >
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
