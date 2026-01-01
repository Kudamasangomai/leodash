<script setup>
import { ref, onMounted } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import Message from "@/Components/Message.vue";

const showingNavigationDropdown = ref(false);
onMounted(() => {
    document.querySelectorAll(".collapsible-toggle").forEach((toggle) => {
        toggle.addEventListener("click", function () {
            let menu = this.nextElementSibling; // The submenu <ul>
            let arrowIcon = this.querySelector(".arrow");

            if (!menu) return;

            // If menu has a maxHeight set and is not zero — collapse it
            const currentMax = window.getComputedStyle(menu).maxHeight;
            if (currentMax && currentMax !== "0px" && currentMax !== "0") {
                menu.style.maxHeight = "0px";
                if (arrowIcon) arrowIcon.classList.remove("rotate-90");
            } else {
                // expand to its scrollHeight
                menu.style.maxHeight = menu.scrollHeight + "px";
                if (arrowIcon) arrowIcon.classList.add("rotate-90");
            }
        });
    });
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav
                class="fixed z-50 w-full bg-white border-b border-blue-500 shadow-2xl"
            >
                <!-- Primary Navigation Menu -->
                <div class="max-w-full px-4 mx-auto sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex items-center shrink-0">
                                <Link
                                    prefetch="mount"
                                    cache-for="1m"
                                    :href="route('dashboard')"
                                >
                                    <ApplicationLogo
                                        class="block w-auto text-gray-800 fill-current h-9"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    <!-- Dashboard -->
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 text-sm font-normal leading-4 text-black transition duration-150 ease-in-out border border-transparent rounded-md hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="flex items-center -me-2 sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="w-6 h-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="text-base font-normal text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-normal text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <DropdownLink href="/repairs">
                                Repairs
                            </DropdownLink>
                            <DropdownLink href="/dstcalibrations">
                                Calibration
                            </DropdownLink>
                            <DropdownLink href="/faults"> Faults </DropdownLink>
                            <DropdownLink href="/trucks"> Trucks </DropdownLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <nav
                id="sidebar-menu"
                x-description="Mobile menu"
                class="bg-[#446ad7] hidden text-white md:block fixed h-screen shadow-lg top-18 left-0 min-w-[225px] py-6 px-4 z-40 overflow-y-auto"
            >
                <Link href="javascript:void(0)"
                    ><img
                        src="https://readymadeui.com/readymadeui.svg"
                        alt="logo"
                        class="w-36"
                    />
                </Link>

                <ul class="mt-6">
                    <li>
                        <Link
                            prefetch="mount"
                            cache-for="1m"
                            href="/dashboard"
                            class="text-white font-normal hover:text-slate-900 text-[15px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                        >
                       <svg viewBox="0 0 24 24" fill="none" class="w-[20px] h-[20px] mr-2"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.1" d="M14 17.5C14 16.0955 14 15.3933 14.3371 14.8889C14.483 14.6705 14.6705 14.483 14.8889 14.3371C15.3933 14 16.0955 14 17.5 14V14V14C18.9045 14 19.6067 14 20.1111 14.3371C20.3295 14.483 20.517 14.6705 20.6629 14.8889C21 15.3933 21 16.0955 21 17.5V17.5V17.5C21 18.9045 21 19.6067 20.6629 20.1111C20.517 20.3295 20.3295 20.517 20.1111 20.6629C19.6067 21 18.9045 21 17.5 21V21V21C16.0955 21 15.3933 21 14.8889 20.6629C14.6705 20.517 14.483 20.3295 14.3371 20.1111C14 19.6067 14 18.9045 14 17.5V17.5V17.5Z" fill="#ffffff"></path> <path opacity="0.1" d="M3 17.5C3 16.0955 3 15.3933 3.33706 14.8889C3.48298 14.6705 3.67048 14.483 3.88886 14.3371C4.39331 14 5.09554 14 6.5 14V14V14C7.90446 14 8.60669 14 9.11114 14.3371C9.32952 14.483 9.51702 14.6705 9.66294 14.8889C10 15.3933 10 16.0955 10 17.5V17.5V17.5C10 18.9045 10 19.6067 9.66294 20.1111C9.51702 20.3295 9.32952 20.517 9.11114 20.6629C8.60669 21 7.90446 21 6.5 21V21V21C5.09554 21 4.39331 21 3.88886 20.6629C3.67048 20.517 3.48298 20.3295 3.33706 20.1111C3 19.6067 3 18.9045 3 17.5V17.5V17.5Z" fill="#ffffff"></path> <path opacity="0.1" d="M3 6.5C3 5.09554 3 4.39331 3.33706 3.88886C3.48298 3.67048 3.67048 3.48298 3.88886 3.33706C4.39331 3 5.09554 3 6.5 3V3V3C7.90446 3 8.60669 3 9.11114 3.33706C9.32952 3.48298 9.51702 3.67048 9.66294 3.88886C10 4.39331 10 5.09554 10 6.5V6.5V6.5C10 7.90446 10 8.60669 9.66294 9.11114C9.51702 9.32952 9.32952 9.51702 9.11114 9.66294C8.60669 10 7.90446 10 6.5 10V10V10C5.09554 10 4.39331 10 3.88886 9.66294C3.67048 9.51702 3.48298 9.32952 3.33706 9.11114C3 8.60669 3 7.90446 3 6.5V6.5V6.5Z" fill="#ffffff"></path> <path d="M14 17.5C14 16.0955 14 15.3933 14.3371 14.8889C14.483 14.6705 14.6705 14.483 14.8889 14.3371C15.3933 14 16.0955 14 17.5 14V14V14C18.9045 14 19.6067 14 20.1111 14.3371C20.3295 14.483 20.517 14.6705 20.6629 14.8889C21 15.3933 21 16.0955 21 17.5V17.5V17.5C21 18.9045 21 19.6067 20.6629 20.1111C20.517 20.3295 20.3295 20.517 20.1111 20.6629C19.6067 21 18.9045 21 17.5 21V21V21C16.0955 21 15.3933 21 14.8889 20.6629C14.6705 20.517 14.483 20.3295 14.3371 20.1111C14 19.6067 14 18.9045 14 17.5V17.5V17.5Z" stroke="#ffffff" stroke-width="2"></path> <path d="M3 17.5C3 16.0955 3 15.3933 3.33706 14.8889C3.48298 14.6705 3.67048 14.483 3.88886 14.3371C4.39331 14 5.09554 14 6.5 14V14V14C7.90446 14 8.60669 14 9.11114 14.3371C9.32952 14.483 9.51702 14.6705 9.66294 14.8889C10 15.3933 10 16.0955 10 17.5V17.5V17.5C10 18.9045 10 19.6067 9.66294 20.1111C9.51702 20.3295 9.32952 20.517 9.11114 20.6629C8.60669 21 7.90446 21 6.5 21V21V21C5.09554 21 4.39331 21 3.88886 20.6629C3.67048 20.517 3.48298 20.3295 3.33706 20.1111C3 19.6067 3 18.9045 3 17.5V17.5V17.5Z" stroke="#ffffff" stroke-width="2"></path> <path d="M3 6.5C3 5.09554 3 4.39331 3.33706 3.88886C3.48298 3.67048 3.67048 3.48298 3.88886 3.33706C4.39331 3 5.09554 3 6.5 3V3V3C7.90446 3 8.60669 3 9.11114 3.33706C9.32952 3.48298 9.51702 3.67048 9.66294 3.88886C10 4.39331 10 5.09554 10 6.5V6.5V6.5C10 7.90446 10 8.60669 9.66294 9.11114C9.51702 9.32952 9.32952 9.51702 9.11114 9.66294C8.60669 10 7.90446 10 6.5 10V10V10C5.09554 10 4.39331 10 3.88886 9.66294C3.67048 9.51702 3.48298 9.32952 3.33706 9.11114C3 8.60669 3 7.90446 3 6.5V6.5V6.5Z" stroke="#ffffff" stroke-width="2"></path> <path d="M14 6.5H21" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17.5 3V10" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            <span>Dashboard</span>
                        </Link>
                    </li>
                </ul>

                <div class="mt-6">
                    <h6 class="text-white text-[15px] font-semibold px-4">
                        Services
                    </h6>
                    <ul class="space-y-1 mt-3">
                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/repairs"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg

                                    class="w-[20px] h-[20px] mr-2"
                                    fill="#ffffff"
                                    viewBox="0 0 640 512"
                                >
                                    <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path
                                        d="M308.5 135.3c7.1-6.3 9.9-16.2 6.2-25c-2.3-5.3-4.8-10.5-7.6-15.5L304 89.4c-3-5-6.3-9.9-9.8-14.6c-5.7-7.6-15.7-10.1-24.7-7.1l-28.2 9.3c-10.7-8.8-23-16-36.2-20.9L199 27.1c-1.9-9.3-9.1-16.7-18.5-17.8C173.9 8.4 167.2 8 160.4 8h-.7c-6.8 0-13.5 .4-20.1 1.2c-9.4 1.1-16.6 8.6-18.5 17.8L115 56.1c-13.3 5-25.5 12.1-36.2 20.9L50.5 67.8c-9-3-19-.5-24.7 7.1c-3.5 4.7-6.8 9.6-9.9 14.6l-3 5.3c-2.8 5-5.3 10.2-7.6 15.6c-3.7 8.7-.9 18.6 6.2 25l22.2 19.8C32.6 161.9 32 168.9 32 176s.6 14.1 1.7 20.9L11.5 216.7c-7.1 6.3-9.9 16.2-6.2 25c2.3 5.3 4.8 10.5 7.6 15.6l3 5.2c3 5.1 6.3 9.9 9.9 14.6c5.7 7.6 15.7 10.1 24.7 7.1l28.2-9.3c10.7 8.8 23 16 36.2 20.9l6.1 29.1c1.9 9.3 9.1 16.7 18.5 17.8c6.7 .8 13.5 1.2 20.4 1.2s13.7-.4 20.4-1.2c9.4-1.1 16.6-8.6 18.5-17.8l6.1-29.1c13.3-5 25.5-12.1 36.2-20.9l28.2 9.3c9 3 19 .5 24.7-7.1c3.5-4.7 6.8-9.5 9.8-14.6l3.1-5.4c2.8-5 5.3-10.2 7.6-15.5c3.7-8.7 .9-18.6-6.2-25l-22.2-19.8c1.1-6.8 1.7-13.8 1.7-20.9s-.6-14.1-1.7-20.9l22.2-19.8zM112 176a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zM504.7 500.5c6.3 7.1 16.2 9.9 25 6.2c5.3-2.3 10.5-4.8 15.5-7.6l5.4-3.1c5-3 9.9-6.3 14.6-9.8c7.6-5.7 10.1-15.7 7.1-24.7l-9.3-28.2c8.8-10.7 16-23 20.9-36.2l29.1-6.1c9.3-1.9 16.7-9.1 17.8-18.5c.8-6.7 1.2-13.5 1.2-20.4s-.4-13.7-1.2-20.4c-1.1-9.4-8.6-16.6-17.8-18.5L583.9 307c-5-13.3-12.1-25.5-20.9-36.2l9.3-28.2c3-9 .5-19-7.1-24.7c-4.7-3.5-9.6-6.8-14.6-9.9l-5.3-3c-5-2.8-10.2-5.3-15.6-7.6c-8.7-3.7-18.6-.9-25 6.2l-19.8 22.2c-6.8-1.1-13.8-1.7-20.9-1.7s-14.1 .6-20.9 1.7l-19.8-22.2c-6.3-7.1-16.2-9.9-25-6.2c-5.3 2.3-10.5 4.8-15.6 7.6l-5.2 3c-5.1 3-9.9 6.3-14.6 9.9c-7.6 5.7-10.1 15.7-7.1 24.7l9.3 28.2c-8.8 10.7-16 23-20.9 36.2L315.1 313c-9.3 1.9-16.7 9.1-17.8 18.5c-.8 6.7-1.2 13.5-1.2 20.4s.4 13.7 1.2 20.4c1.1 9.4 8.6 16.6 17.8 18.5l29.1 6.1c5 13.3 12.1 25.5 20.9 36.2l-9.3 28.2c-3 9-.5 19 7.1 24.7c4.7 3.5 9.5 6.8 14.6 9.8l5.4 3.1c5 2.8 10.2 5.3 15.5 7.6c8.7 3.7 18.6 .9 25-6.2l19.8-22.2c6.8 1.1 13.8 1.7 20.9 1.7s14.1-.6 20.9-1.7l19.8 22.2zM464 304a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"
                                    />
                                </svg>
                                <span>Repairs</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/dstcalibrations"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    class="w-[20px] h-[20px] mr-3"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 3a9 9 0 100 18 9 9 0 000-18z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 12l4-2"
                                    />
                                </svg>

                                <span>Calibration</span>
                            </Link>
                        </li>
                    </ul>
                </div>

                <div class="mt-6">
                    <h6 class="text-white text-[15px] font-semibold px-4">
                        Reports
                    </h6>
                    <ul class="space-y-1 mt-3">
                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/early-start"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    class="w-[20px] h-[20px] mr-3"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle cx="12" cy="12" r="9" />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 7v5l3 2"
                                    />
                                </svg>

                                <span>Early Start</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/violations"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    class="w-[20px] h-[20px] mr-3"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 3l9 16H3L12 3z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v4m0 4h.01"
                                    />
                                </svg>

                                <span>Violations</span>
                            </Link>
                        </li>

                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/lightvehiclescoring"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    class="w-[20px] h-[20px] mr-3"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4 20V10m6 10V4m6 16v-7"
                                    />
                                </svg>

                                <span>Buses Scoring</span>
                            </Link>
                        </li>
                    </ul>
                </div>

                <div class="mt-6">
                    <h6 class="text-white text-[15px] font-semibold px-4">
                        Assets
                    </h6>
                    <ul class="space-y-1 mt-3">
                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/trucks"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    class="w-[20px] h-[20px] mr-3"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 7h11v8H3zM14 10h4l3 3v2h-7"
                                    />
                                    <circle cx="7" cy="17" r="2" />
                                    <circle cx="17" cy="17" r="2" />
                                </svg>

                                <span>Trucks</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/faults"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    class="w-[20px] h-[20px] mr-3"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14.7 6.3a4 4 0 01-5.4 5.4l-5 5a2 2 0 102.8 2.8l5-5a4 4 0 005.4-5.4z"
                                    />
                                </svg>

                                <span>Faults</span>
                            </Link>
                        </li>
                    </ul>
                </div>

                <div class="mt-6 mb-32">
                    <h6 class="text-white text-[15px] font-semibold px-4">
                        Maintenance
                    </h6>
                    <ul class="space-y-1 mt-3">
                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/faultyunits"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    class="w-[20px] h-[20px] mr-3"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect
                                        x="7"
                                        y="7"
                                        width="10"
                                        height="10"
                                        rx="2"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 1v3m6-3v3m-6 16v3m6-3v3M1 9h3m-3 6h3m16-6h3m-3 6h3"
                                    />
                                </svg>

                                <span>Faulty Units</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/notes"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    class="w-[20px] h-[20px] mr-3"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect
                                        x="6"
                                        y="4"
                                        width="12"
                                        height="16"
                                        rx="2"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 8h6M9 12h6M9 16h4"
                                    />
                                </svg>

                                <span>Reminders / Todos</span>
                            </Link>
                        </li>

                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/notes"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                            <svg viewBox="0 0 24 24"      class="w-[20px] h-[20px] mr-3"  fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cellphone_line</title> <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Device" transform="translate(-192.000000, 0.000000)" fill-rule="nonzero"> <g id="cellphone_line" transform="translate(192.000000, 0.000000)"> <path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fill-rule="nonzero"> </path> <path d="M17,2 C18.0543909,2 18.9181678,2.81587733 18.9945144,3.85073759 L19,4 L19,20 C19,21.0543909 18.18415,21.9181678 17.1492661,21.9945144 L17,22 L7,22 C5.94563773,22 5.08183483,21.18415 5.00548573,20.1492661 L5,20 L5,4 C5,2.94563773 5.81587733,2.08183483 6.85073759,2.00548573 L7,2 L17,2 Z M17,4 L7,4 L7,20 L17,20 L17,4 Z M12.5,16 C12.7454222,16 12.9496,16.1769086 12.9919429,16.4101355 L13,16.5 L13,17.5 C13,17.7454222 12.8230914,17.9496 12.5898645,17.9919429 L12.5,18 L11.5,18 C11.2545778,18 11.0504,17.8230914 11.0080571,17.5898645 L11,17.5 L11,16.5 C11,16.2545778 11.1769086,16.0504 11.4101355,16.0080571 L11.5,16 L12.5,16 Z" id="形状" fill="#ffffff"> </path> </g> </g> </g> </g></svg>
                                <span>Assets Register</span>
                            </Link>
                        </li>
                    </ul>
                </div>

                <div
                    class="fixed bottom-0 left-0 bg-[#446ad7] mt-20 min-w-[219px] border-t border-white rounded-lg px-5 py-2"
                >
                    <ul class="space-y-1 mt-3">
                        <li>
                            <Link
                                prefetch="mount"
                                cache-for="1m"
                                href="/profile"
                                class="text-white font-normal hover:text-slate-900 text-[14px] flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    class="w-[20px] h-[20px] mr-3"
                                    viewBox="0 0 512 512"
                                >
                                    <path
                                        d="M437.02 74.98C388.668 26.63 324.379 0 256 0S123.332 26.629 74.98 74.98C26.63 123.332 0 187.621 0 256s26.629 132.668 74.98 181.02C123.332 485.37 187.621 512 256 512s132.668-26.629 181.02-74.98C485.37 388.668 512 324.379 512 256s-26.629-132.668-74.98-181.02zM111.105 429.297c8.454-72.735 70.989-128.89 144.895-128.89 38.96 0 75.598 15.179 103.156 42.734 23.281 23.285 37.965 53.687 41.742 86.152C361.641 462.172 311.094 482 256 482s-105.637-19.824-144.895-52.703zM256 269.507c-42.871 0-77.754-34.882-77.754-77.753C178.246 148.879 213.13 114 256 114s77.754 34.879 77.754 77.754c0 42.871-34.883 77.754-77.754 77.754zm170.719 134.427a175.9 175.9 0 0 0-46.352-82.004c-18.437-18.438-40.25-32.27-64.039-40.938 28.598-19.394 47.426-52.16 47.426-89.238C363.754 132.34 315.414 84 256 84s-107.754 48.34-107.754 107.754c0 37.098 18.844 69.875 47.465 89.266-21.887 7.976-42.14 20.308-59.566 36.542-25.235 23.5-42.758 53.465-50.883 86.348C50.852 364.242 30 312.512 30 256 30 131.383 131.383 30 256 30s226 101.383 226 226c0 56.523-20.86 108.266-55.281 147.934zm0 0"
                                        data-original="#000000"
                                    />
                                </svg>
                                <span>Profile</span>
                            </Link>
                        </li>
  <!-- <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink> -->
                        <li>
                            <Link

                                :href="route('logout')"
                                method="post"
                                as="button"
                                prefetch="mount"
                                class="text-white font-normal hover:text-slate-900 text-[14px] w-full flex items-center hover:bg-gray-100 rounded px-4 py-2 transition-all"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    class="w-[20px] h-[20px] mr-3"
                                    viewBox="0 0 6.35 6.35"
                                >
                                    <path
                                        d="M3.172.53a.265.266 0 0 0-.262.268v2.127a.265.266 0 0 0 .53 0V.798A.265.266 0 0 0 3.172.53zm1.544.532a.265.266 0 0 0-.026 0 .265.266 0 0 0-.147.47c.459.391.749.973.749 1.626 0 1.18-.944 2.131-2.116 2.131A2.12 2.12 0 0 1 1.06 3.16c0-.65.286-1.228.74-1.62a.265.266 0 1 0-.344-.404A2.667 2.667 0 0 0 .53 3.158a2.66 2.66 0 0 0 2.647 2.663 2.657 2.657 0 0 0 2.645-2.663c0-.812-.363-1.542-.936-2.03a.265.266 0 0 0-.17-.066z"
                                        data-original="#000000"
                                    />
                                </svg>
                                <span>Logout</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>
            <Modal v-if="open">
                <Link :href="route('logout')" method="post" as="button">
                    Yes, log me out
                </Link>
            </Modal>
            <!-- Page Content -->

            <div class="mx-2 md:ml-36">
                <main class="py-20 bg">
                    <Message />
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
