<template setup>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Appearance settings" />

        <SettingsLayout>
            <div class="space-y-6">
                <!---<HeadingSmall title="Appearance settings" description="Update your account's appearance settings" />-->
                <Billing  
                    :subscription="subscription"
                    :plans="plans"
                    :invoices="invoices"
                    :selected_plan="selected_plan"
                    :canResume="canResume"
                    :ended="ended"
                  
                  />
            </div>
        </SettingsLayout>
    </AppLayout>
   
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Billing from './components/Billing.vue';

import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];


const props = defineProps({
  subscription: Object,
  plans: Array,
  invoices: Array,
  selected_plan: Object,
  canResume: Boolean,
  ended: Boolean
})

</script>

