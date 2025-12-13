<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageTitle from "@/Components/PageTitle.vue";

const props = defineProps({
    calibration: Object,
});

const form = useForm({
    truck: props.calibration.truck.unitname,
    date_went_to_roadtest: props.calibration.date_went_to_roadtest,
    road_test_done: props.calibration.road_test_done,
    notes: props.calibration.notes || "",
});

const submit = () => {
    form.put(route("dstcalibrations.update", props.calibration.id));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit Distance Calibration" />
        <MainContent>
            <PageHeader>
                <PageTitle
                    >Update Distance Calibration For
                    {{ calibration.truck.unitname }}</PageTitle
                >

                <div>
                    <div></div>
                </div>
            </PageHeader>

            <div class="max-w-2xl px-2">
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <InputLabel for="trucks" value="Asset Name" />
                        <TextInput
                            id="trucks"
                            v-model="form.truck"
                            type="text"
                            class="block w-full mt-1"
                            placeholder="e.g. TRUCK-001, TRUCK-002, TRUCK-003"
                            required
                        />
                        <InputError :message="form.errors.truck" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel
                            for="date_went_to_roadtest"
                            value="Road Test Date"
                        />
                        <TextInput
                            id="date_went_to_roadtest"
                            v-model="form.date_went_to_roadtest"
                            type="datetime-local"
                            class="block w-full mt-1"
                        />
                        <InputError
                            :message="form.errors.date_went_to_roadtest"
                            class="mt-2"
                        />
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input
                                v-model="form.road_test_done"
                                type="checkbox"
                                class="mr-2"
                            />
                            <span>Road Test Done</span>
                        </label>
                        <InputError
                            :message="form.errors.road_test_done"
                            class="mt-2"
                        />
                    </div>

                    <div>
                        <InputLabel for="notes" value="Notes" />
                        <textarea
                            id="notes"
                            v-model="form.notes"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md"
                            rows="4"
                        />
                        <InputError :message="form.errors.notes" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <PrimaryButton :disabled="form.processing"
                            >Update</PrimaryButton
                        >
                        <Link
                            prefetch="mount"
                            cache-for="5m"
                            :href="route('dstcalibrations.index')"
                            class="text-gray-600"
                            >Cancel</Link
                        >
                    </div>
                </form>
            </div>
        </MainContent>
    </AuthenticatedLayout>
</template>
