<template>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex">
            <!-- Vertical Tabs Navigation -->
            <div class="w-64 bg-white shadow-sm border-r border-gray-200">
                <div class="p-6">
                    <!----<h1 class="text-2xl font-bold text-gray-900 mb-6">Gestione Abbonamento</h1>-->
                    
                    <nav class="space-y-2">
                        <button
                            v-for="tab in tabs"
                            :key="tab.id"
                            @click="activeTab = tab.id"
                            :class="[
                                'w-full text-left px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200',
                                activeTab === tab.id
                                    ? 'bg-stone-50 text-stone-700 border-l-4 border-stone-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                            ]"
                        >
                            <div class="flex items-center">
                                <component :is="tab.icon" class="w-5 h-5 mr-3" />
                                {{ tab.name }}
                            </div>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="flex-1 bg-white">
                <div class="p-6">
                    <slot :active-tab="activeTab" :tabs="tabs">
                        <component :is="activeTabComponent" />
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import SelectPlan from './components/SelectPlan.vue';
import Invoices from './components/Invoices.vue';

const activeTab = ref('select-plan');

const tabs = [
    {
        id: 'select-plan',
        name: 'Seleziona Piano',
        component: SelectPlan
    },
    {
        id: 'invoices',
        name: 'Fatture',
        component: Invoices
    }
];

const activeTabComponent = computed(() => {
    const tab = tabs.find(t => t.id === activeTab.value);
    return tab ? tab.component : SelectPlan;
});
</script>
