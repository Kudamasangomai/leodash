<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import SendemLogo from '@/Components/SendemLogo.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />


        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <!-- <form @submit.prevent="submit"> -->
            <!-- <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="block w-full mt-1"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div> -->

            <!-- <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div> -->


            <!-- <div class="flex items-center justify-end mt-4">


                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div> -->
        <!-- </form> -->

        <form @submit.prevent="submit" class="w-full max-w-md p-4 mx-auto md:p-6" >
            <div class="flex items-center justify-center mb-8">
              <a href="javascript:void(0)" class="">

                          <SendemLogo class="h-20 text-gray-500 fill-current w-22" />
              </a>
            </div>

            <div class="space-y-6">
              <div>
                <label class="block mb-2 text-sm font-medium text-slate-900">Email</label>
                <div class="relative flex items-center">
                  <input
                   id="email"
                    type="email"
                  v-model="form.email"
                    required
                    autofocus
                    autocomplete="username" class="w-full py-3 pl-4 pr-10 text-sm transition-all border rounded-md outline-none text-slate-900 bg-slate-100 focus:bg-transparent border-slate-100 focus:border-blue-600" placeholder="Enter email" />
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 682.667 682.667">
                    <defs>
                      <clipPath id="a" clipPathUnits="userSpaceOnUse">
                        <path d="M0 512h512V0H0Z" data-original="#000000"></path>
                      </clipPath>
                    </defs>
                    <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                      <path fill="none" stroke-miterlimit="10" stroke-width="40" d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z" data-original="#000000"></path>
                      <path d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z" data-original="#000000"></path>
                    </g>
                  </svg>
                      <InputError class="mt-2" :message="form.errors.email" />
                </div>
              </div>
              <div>
                <label class="block mb-2 text-sm font-medium text-slate-900">Password</label>
                <div class="relative flex items-center">
                  <input    id="password"  v-model="form.password"      autocomplete="current-password" type="password" required class="w-full py-3 pl-4 pr-10 text-sm transition-all border rounded-md outline-none text-slate-900 bg-slate-100 focus:bg-transparent border-slate-100 focus:border-blue-600" placeholder="Enter password" />
                  <!-- <TextInput
                    id="password"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                /> -->


                  <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                    <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                  </svg>
                     <InputError class="mt-2" :message="form.errors.password" />
                </div>
              </div>
              <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center">
                  <input id="remember-me" name="remember-me" type="checkbox" class="w-4 h-4 text-blue-600 rounded-md shrink-0 focus:ring-blue-500 border-slate-300" />
                  <label for="remember-me" class="block ml-3 text-sm text-slate-900">
                    Remember me
                  </label>
                </div>
                <div class="text-sm">
                  <a href="jajvascript:void(0);" class="font-medium text-blue-600 hover:underline">
                    Forgot password?
                  </a>
                </div>
              </div>
            </div>

            <div class="mt-12">
              <button type="submit" class="w-full shadow-xl py-2 px-4 text-[15px] tracking-wide font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none cursor-pointer">
                Sign in
              </button>
              <p class="mt-6 text-sm text-center text-slate-600">Don't have an account? <a href="javascript:void(0);" class="ml-1 font-medium tracking-wide text-blue-600 hover:underline">Register here</a></p>
            </div>
          </form>
    </GuestLayout>
</template>
