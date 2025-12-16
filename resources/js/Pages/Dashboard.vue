<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <MainContent>
       
        <div class="mx-auto p-0 md:p-2">
          <!-- row -->
          <div class="flex flex-wrap flex-row">
            <div class="flex-shrink max-w-full px-3 md:px-4 w-full">
              <div class="flex flex-row items-center justify-between mb-2">
                <p class="text-lg font-bold my-3">LeoDash</p>

                <!-- Range time -->

              </div>
            </div>
          </div>

          <!-- row -->
          <div class="flex flex-wrap flex-row">
              <div class="flex-shrink max-w-full px-3 md:px-4 w-full lg:w-1/2 mb-6">
              <!-- box card -->
              <div class="bg-blue-600 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10 h-full">
                <div class="relative px-2">
                  <div class="splide nav-hidden" role="group" aria-label="Splide Basic HTML Example">
                    <div class="splide__track">

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex-shrink max-w-full w-full lg:w-1/2">
              <!-- row -->
              <div class="flex flex-wrap flex-row">
                <div class="flex-shrink max-w-full px-3 md:px-4 w-1/2 mb-6">
                  <!-- box card -->
                  <div class="relative p-3 sm:p-5 bg-cyan-50 dark:bg-cyan-900 rounded shadow-lg shadow-cyan-700/10 h-full overflow-hidden">
                    <div class="relative dark:text-slate-100">
                      <h2 class="text-center mb-2">Won</h2>
                      <h3 class="text-4xl font-bold text-center">1340</h3>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-20">
                      <i class="text-6xl bx bx-smile text-cyan-500"></i>
                    </div>
                  </div>
                </div>

                <div class="flex-shrink max-w-full px-3 md:px-4 w-1/2 mb-6">
                  <!-- box card -->
                  <div class="relative p-3 sm:p-5 bg-red-50 dark:bg-red-900 rounded shadow-lg shadow-red-800/10 h-full overflow-hidden">
                    <div class="relative dark:text-slate-100">
                      <h2 class="text-center mb-2">Lost</h2>
                      <h3 class="text-4xl font-bold text-center">640</h3>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-20">
                      <i class="text-6xl bx bx-sad text-red-500"></i>
                    </div>
                  </div>
                </div>

                <div class="flex-shrink max-w-full px-3 md:px-4 w-1/2 mb-6">
                  <!-- box card -->
                  <div class="relative p-3 sm:p-5 bg-yellow-50 dark:bg-yellow-900 rounded shadow-lg shadow-yellow-800/10 h-full overflow-hidden">
                    <div class="relative dark:text-slate-100">
                      <h2 class="text-center mb-2">Conversion Rate</h2>
                      <h3 class="text-4xl font-bold text-center">78%</h3>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-20">
                      <i class="text-6xl bx bx-filter-alt text-yellow-500"></i>
                    </div>
                  </div>
                </div>

                <div class="flex-shrink max-w-full px-3 md:px-4 w-1/2 mb-6">
                  <!-- box card -->
                  <div class="relative p-3 sm:p-5 bg-green-50 dark:bg-green-900 rounded shadow-lg shadow-green-700/10 h-full overflow-hidden">
                    <div class="relative dark:text-slate-100">
                      <h2 class="text-center mb-2">Average Contract</h2>
                      <h3 class="text-4xl font-bold text-center">$1640</h3>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-20">
                      <i class="text-6xl bx bx-dollar-circle text-green-500"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="flex-shrink max-w-full px-3 md:px-4 w-full lg:w-2/3 mb-6">
              <!-- box card -->
              <div class="p-6 bg-white dark:bg-slate-900 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10 h-full">
                <div class="relative">
                  <h2 class="text-center">Won vs Lost</h2>
                  <canvas class="max-w-100" id="BarChart"></canvas>
                </div>
              </div>
            </div>

            <div class="flex-shrink max-w-full px-3 md:px-4 w-full lg:w-1/3 mb-6">
              <!-- box card -->
              <div class="p-6 bg-white dark:bg-slate-900 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10 h-full">
                <div class="relative">
                  <h2 class="text-center mb-2">Sales Funnel</h2>
                  <div class="funnel-area w-full max-w-sm mx-auto flex flex-col">
                    <ul>
                      <li aria-label="New Lead" data-microtip-position="top" role="tooltip" class="funnel-1 float-left relative my-0.5 mx-0 text-center w-full">
                        <span class="h-0 inline-block border-solid border-cyan-300"><p class="text-white text-center">12.738</p></span>
                      </li>
                      <li aria-label="Qualified" data-microtip-position="top" role="tooltip"  class="funnel-2 float-left relative my-0.5 mx-0 text-center w-full">
                        <span class="h-0 inline-block border-solid border-cyan-400"><p class="text-white text-center">5.435</p></span>
                      </li>
                      <li aria-label="Proposal" data-microtip-position="top" role="tooltip"  class="funnel-3 float-left relative my-0.5 mx-0 text-center w-full">
                        <span class="h-0 inline-block border-solid border-cyan-500"><p class="text-white text-center">3.423</p></span>
                      </li>
                      <li aria-label="Negotiation" data-microtip-position="top" role="tooltip"  class="funnel-4 float-left relative my-0.5 mx-0 text-center w-full">
                        <span class="h-0 inline-block border-solid border-cyan-600"><p class="text-white text-center">2.145</p></span>
                      </li>
                      <li aria-label="Won" data-microtip-position="top" role="tooltip"  class="funnel-5 float-left relative my-0.5 mx-0 text-center w-full">
                        <span class="h-0 inline-block border-solid border-cyan-700"><p class="text-white text-center">1.340</p></span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex-shrink max-w-full px-3 md:px-4 w-full sm:w-1/2 md:w-full lg:w-1/3 mb-6">
              <!-- box card -->
              <div class="p-6 bg-white dark:bg-slate-900 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10 h-full">
                <div class="relative">
                  <h2 class="text-center mb-2">Sales Activity</h2>
                  <canvas class="max-w-100" id="SalesActifity"></canvas>
                </div>
              </div>
            </div>

            <div class="flex-shrink max-w-full px-3 md:px-4 w-full sm:w-1/2 md:w-full lg:w-1/3 mb-6">
              <!-- box card -->
              <div class="p-6 bg-white dark:bg-slate-900 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10 h-full">
                <div class="relative">
                  <h2 class="text-center mb-2">Lead Sources</h2>
                  <canvas class="max-w-100" id="LeadSources"></canvas>
                </div>
              </div>
            </div>

            <div class="flex-shrink max-w-full px-3 md:px-4 w-full lg:w-1/3 mb-6">
              <!-- box card -->
              <div class="p-6 bg-white dark:bg-slate-900 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10 h-full">
                <div class="relative">
                  <h2 class="text-center mb-2">Top Deals</h2>
                  <table class="table-bordered-bottom table-sm w-full text-left text-sm">
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

            <div class="flex-shrink max-w-full px-3 md:px-4 w-full lg:w-1/2 mb-6">
              <!-- box card -->
              <div class="p-6 bg-white dark:bg-slate-900 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10 h-full">
                <div class="relative">
                  <table class="table-bordered-bottom table-sm w-full text-left text-sm">
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
                          <div class="flex flex-wrap flex-row items-center">
                            <div class="font-bold text-slate-900 dark:text-slate-300 flex-shrink max-w-full w-full mb-1">
                              <img class="inline-block rounded-full shadow w-8 h-8 mr-2 max-w-full border-1 border-cyan-200 bg-slate-300 dark:bg-slate-900 dark:border-slate-700" src="src/img/avatar/avatar3.jpg" alt="Avatar">John Thomas
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
                          <div class="flex flex-wrap flex-row items-center">
                            <div class="font-bold text-slate-900 dark:text-slate-300 flex-shrink max-w-full w-full mb-1">
                              <img class="inline-block rounded-full shadow w-8 h-8 mr-2 max-w-full border-1 border-cyan-200 bg-slate-300 dark:bg-slate-900 dark:border-slate-700" src="src/img/avatar/avatar4.jpg" alt="Avatar">Carlos Garcia
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
                          <div class="flex flex-wrap flex-row items-center">
                            <div class="font-bold text-slate-900 dark:text-slate-300 flex-shrink max-w-full w-full mb-1">
                              <img class="inline-block rounded-full shadow w-8 h-8 mr-2 max-w-full border-1 border-cyan-200 bg-slate-300 dark:bg-slate-900 dark:border-slate-700" src="src/img/avatar/avatar5.jpg" alt="Avatar">Daniel Esteban
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
                          <div class="flex flex-wrap flex-row items-center">
                            <div class="font-bold text-slate-900 dark:text-slate-300 flex-shrink max-w-full w-full mb-1">
                              <img class="inline-block rounded-full shadow w-8 h-8 mr-2 max-w-full border-1 border-cyan-200 bg-slate-300 dark:bg-slate-900 dark:border-slate-700" src="src/img/avatar/avatar6.jpg" alt="Avatar">Steven Rey
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
                          <div class="flex flex-wrap flex-row items-center">
                            <div class="font-bold text-slate-900 dark:text-slate-300 flex-shrink max-w-full w-full mb-1">
                              <img class="inline-block rounded-full shadow w-8 h-8 mr-2 max-w-full border-1 border-cyan-200 bg-slate-300 dark:bg-slate-900 dark:border-slate-700" src="src/img/avatar/avatar7.jpg" alt="Avatar">Roman Davis
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

            <div class="flex-shrink max-w-full px-3 md:px-4 w-full lg:w-1/2 mb-6">
              <!-- box card -->
              <div class="p-6 bg-white dark:bg-slate-900 rounded shadow-lg shadow-cyan-100/10 dark:shadow-cyan-700/10 h-full">
                <div class="relative">
                  <h2 class="text-center mb-2">Todo List</h2>
                  <ul class="task-check h-72 overflow-y-auto scrollbars show mb-6">
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-1" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none">
                        <span>Send Email to Mr <span class="font-bold">Gabriel</span> at <span class="text-slate-500 text-xs">18.00 pm</span></span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-1" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none">
                        <span>Call Mr <span class="font-bold">Theo Davis</span> at <span class="text-slate-500 text-xs">16.00 pm</span></span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-1" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none">
                        <span>Meeting with Mr <span class="font-bold">Adreas Rose</span> at <span class="text-slate-500 text-xs">15.00 am</span> in Zoom</span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-2" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none" checked="">
                        <span>Call Mr <span class="font-bold">Toni Anderson</span> at <span class="text-slate-500 text-xs">12.00 am</span></span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-3" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none" checked="">
                        <span>Meeting with Mr <span class="font-bold">John Doe</span> at <span class="text-slate-500 text-xs">12.00 am</span> in Zoom</span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-2" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none" checked="">
                        <span>Call Mr <span class="font-bold">Adreas Rose</span> at <span class="text-slate-500 text-xs">12.00 am</span></span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-3" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none" checked="">
                        <span>Meeting with Mr <span class="font-bold">John Doe</span> at <span class="text-slate-500 text-xs">12.00 am</span> in Zoom</span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-2" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none" checked="">
                        <span>Call Mrs <span class="font-bold">Jenifer Tan</span> at <span class="text-slate-500 text-xs">12.00 am</span></span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-3" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none" checked="">
                        <span>Meeting with Mr <span class="font-bold">John Doe</span> at <span class="text-slate-500 text-xs">12.00 am</span> in Zoom</span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-2" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none" checked="">
                        <span>Call Mr <span class="font-bold">Adreas</span> at <span class="text-slate-500 text-xs">12.00 am</span></span>
                      </label>
                    </li>
                    <li class="relative py-2">
                      <label class="flex items-center">
                        <input type="checkbox" name="checked-3" value="1" class="form-checkbox mr-2 h-5 w-5 text-cyan-500 dark:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded focus:outline-none" checked="">
                        <span>Meeting with Mr <span class="font-bold">John Doe</span> at <span class="text-slate-500 text-xs">12.00 am</span> in Zoom</span>
                      </label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        </MainContent>
    </AuthenticatedLayout>
</template>
