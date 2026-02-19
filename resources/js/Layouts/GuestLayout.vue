<script setup>
import SendemLogo from "@/Components/SendemLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="flex items-center justify-center p-4 bg-gray-100 lg:h-screen">
        <div
            class="max-w-6xl bg-white  [box-shadow:0_2px_10px_-3px_rgba(6,81,237,0.3)] p-4 lg:p-5 rounded-md"
        >
            <div class="grid items-center md:grid-cols-2 gap-y-8">
                
                <slot />
                <div class="w-full h-full">
                    <div
                        class="relative w-full h-full overflow-hidden rounded-md aspect-square bg-gray-50 before:absolute before:inset-0 before:bg-blue-600/70"
                    >
                        <img
                            src="/images/dasht2.jpg"
                            class="object-cover w-full h-full"
                            alt="login img"
                        />

                        <div
                            class="absolute inset-0 flex items-center justify-center max-w-sm p-6 m-auto"
                        >
                            <div>

                                    <div class="flex items-center justify-center ">   <img
                            src="/images/leologo.png"
                            class="items-center h-20 w-30"
                            alt="login img"
                        /></div>
                           <h1 class="mt-2 text-2xl font-medium text-center text-white">
                                  Committed To Excellence
                                </h1>
                        <div class="py-16 text-transparent"></div>


                                <p
                                    class="text-slate-100 text-[18px] mt-10 leading-relaxed text-justify"
                                >
                            From repairs to routine maintenance , see everything you need at a glance , stay informed , Plan ahead, act fast and never miss a task and keep your fleet perfoming at its best
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
