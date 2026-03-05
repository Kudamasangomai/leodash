<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import MainContent from "@/Components/MainContent.vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageTitle from "@/Components/PageTitle.vue";
import Spinner from "@/Components/Spinner.vue";
import DangerButton from "@/Components/DangerButton.vue";
const form = useForm({
    trucks: "",
});

const submit = () => {
    form.trucks = form.trucks.split(",").map((t) => t.trim());
    form.post(route("dstcalibrations.store"));
};
</script>

<template>
    <Head title="New Distance Calibration" />
    <AuthenticatedLayout>
        <MainContent>
            <PageHeader>
                <PageTitle>Create Distance Calibration /s</PageTitle>
                <div>
                    <div>
                        <Link
                            href="/dstcalibrations/create"
                            prefetch="mount"
                            cache-for="5m"
                        >
                        </Link>
                    </div>
                </div>
            </PageHeader>

            <div class="p-6 mx-2 border-2 border-blue-300 sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <InputLabel
                            for="trucks"
                            value="Trucks (comma-separated unitnames)"
                        />
                        <TextInput
                            id="trucks"
                            v-model="form.trucks"
                            type="text"
                            class="block w-full mt-1"
                            placeholder="e.g. LEO300, H14, L16"
                            required
                        />
                        <InputError
                            :message="form.errors.trucks"
                            class="mt-2"
                        />
                    </div>


   <!-- <InputError :message="form.errors['trucks.0']" class="mt-2" /> -->
                    <div class="flex items-center gap-3">
                        <PrimaryButton :disabled="form.processing"
                            >Create
                            <span
                                v-if="form.processing"
                                class="flex items-center"
                            >
                                <Spinner />
                            </span>
                        </PrimaryButton>

                        <Link
                            prefetch="mount"
                            cache-for="5m"
                            :href="route('dstcalibrations.index')"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md"
                            >Cancel</Link
                        >
                    </div>
                </form>
            </div>
        </MainContent>
    </AuthenticatedLayout>
</template>
