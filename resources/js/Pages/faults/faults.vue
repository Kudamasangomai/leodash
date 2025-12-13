<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Spinner from "@/Components/Spinner.vue";
import MainContent from "@/Components/MainContent.vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageTitle from "@/Components/PageTitle.vue";

const props = defineProps({
    faults: Array,
});

const form = useForm({
    name: "",
});
const isediting = ref(false);

const editname = (fault) => {
    isediting.value = true;
    (form.id = fault.id), (form.name = fault.name);

    window.scrollTo({ top: 0, behavior: "smooth" });
};

const savefault = () => {
    if (form.id) {
        form.put(route("faults.update", form.id), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                isediting.value = false;
            },
        });
    } else {
        form.post(route("faults.store"), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
            },
        });
    }
};
</script>

<template>
    <Head title="Defects" />

    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle>Faults</PageTitle>
                <div>
                    <div></div>
                </div>
            </PageHeader>

            <div class="py-4">
                <div class="mx-auto sm:px-6 lg:px-8">
                    <div class="relative sm:rounded-lg">
                        <div class="py-4">
                            <form
                                @submit.prevent="savefault"
                                id="myform"
                                class="flex flex-row flex-wrap -mx-4 valid-form"
                            >
                                <div
                                    class="flex-shrink w-full max-w-full px-4 mb-4 form-group md:w-1/2"
                                >
                                    <div
                                        v-if="form.errors.name"
                                        class="font-bold text-red-500 text-m"
                                    >
                                        {{ form.errors.name }}
                                    </div>
                                    <label
                                        for="inputEmail4"
                                        class="inline-block mb-2"
                                        >Name</label
                                    >
                                    <input
                                        type="text"
                                        class="flex w-full mt-1 rounded-md"
                                        placeholder="Not Pulling , No brakes etc"
                                        v-model="form.name"
                                    />
                                </div>
                                <div
                                    class="flex flex-row w-full max-w-full px-4 form-group"
                                >
                                    <button
                                        type="submit"
                                        class="inline-block px-4 py-2 leading-5 text-center bg-blue-500 border rounded text-slate-100 hover:bg-blue-600 hover:border-blue-600"
                                    >
                                        {{ isediting ? "Update" : "Save" }}
                                    </button>
                                    <span
                                        v-if="form.processing"
                                        class="flex items-center"
                                    >
                                        <Spinner />
                                    </span>
                                    <button>
                                        <p
                                            v-if="form.recentlySuccessful"
                                            class="ml-4 text-green-600 text-m"
                                        >
                                            {{
                                                isediting
                                                    ? "Fault Updated Successfully"
                                                    : "Fault Saved Successfully"
                                            }}
                                        </p>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="">
                            <div class="mx-auto sm:px-6 lg:px-0">
                                <div class="text-gray-900">
                                    <table
                                        class="min-w-full border border-gray-200"
                                    >
                                        <thead
                                            class="bg-gray-200 whitespace-nowrap"
                                        >
                                            <tr>
                                                <th
                                                    class="px-4 py-3 text-left text-[13px] font-medium text-slate-600 border-r border-gray-300"
                                                >
                                                    Name
                                                </th>

                                                <th
                                                    scope="col"
                                                    class="px-4 py-3 text-left text-[13px] font-medium text-slate-600 border-r border-gray-300"
                                                >
                                                    Created at
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-4 py-3 text-left text-[13px] font-medium text-slate-600 border-r border-gray-300"
                                                >
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 whitespace-nowrap"
                                        >
                                            <tr
                                                v-for="fault in faults"
                                                :key="faults.id"
                                                     class="odd:bg-gray-50"
                                            >
                                                <td
                                                    scope="row"
                                                    class="px-4 py-3 border-r border-gray-200"
                                                >
                                                    {{ fault.name }}
                                                </td>
                                                <td
                                                    scope="row"
                                                    class="px-4 py-3 border-r border-gray-200"
                                                >
                                                    {{ fault.created_at }}
                                                </td>
                                                <td
                                                    class="flex items-center justify-center border-none"
                                                >
                                                    <!-- :href="`/faults/${fault.id}/edit`" -->
                                                    <button
                                                        class="mr-4"
                                                        @click="editname(fault)"
                                                    >
                                                        <svg
                                                            fill="#1F51FF"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            height="1em"
                                                            viewBox="0 0 512 512"
                                                        >
                                                            <path
                                                                d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"
                                                            />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </MainContent>
    </AuthenticatedLayout>
</template>
