<script setup>
import SendemLogo from '@/Components/SendemLogo.vue';
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <!-- <div
        class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0"
    >
        <div class="mb-6 -mt-10">
            <Link href="/">
                <SendemLogo class="h-20 text-gray-500 fill-current w-22" />
            </Link>
        </div>

        <div
            class=" w-full overflow-hidden bg-[#3585DA] px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div> -->

    <div class="flex items-center justify-center p-4 bg-gray-100 lg:h-screen">
      <div class="max-w-6xl bg-white [box-shadow:0_2px_10px_-3px_rgba(6,81,237,0.3)] p-4 lg:p-5 rounded-md">
        <div class="grid items-center md:grid-cols-2 gap-y-8">

   <slot />
          <div class="w-full h-full">
            <div class="relative w-full h-full overflow-hidden rounded-md aspect-square bg-gray-50 before:absolute before:inset-0 before:bg-blue-600/70">
              <img  src="/images/dasht2.jpg" class="object-cover w-full h-full" alt="login img" />

              <div class="absolute inset-0 flex items-center justify-center max-w-sm p-6 m-auto">
                <div>
                  <h1 class="text-4xl font-semibold text-white">Sign in</h1>
                  <p class="text-slate-100 text-[15px] font-medium mt-6 leading-relaxed">Sign in to your account and explore a world of possibilities. Your journey begins here.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
