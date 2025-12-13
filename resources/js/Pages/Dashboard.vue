<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import MainContent from "@/Components/MainContent.vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageTitle from "@/Components/PageTitle.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
         <MainContent>
            <!-- <PageHeader>
                <PageTitle>Distance Calibrations</PageTitle>
                
            </PageHeader> -->

            
        <div class="py-2">
          
                        You're logged in!
              
        </div>
        </MainContent>
    </AuthenticatedLayout>
</template>
