<template>
    <div class="py-10">
        <Billing 
          :title="'Gestione abbonamento'"
          :subscription="subscription"
          :plans="plans"
          :invoices="invoices"
          :selected_plan="selected_plan"
          :canResume="canResume"
        
        />
    </div>
    
</template>

<script setup>
import Billing from './components/Billing.vue';

const props = defineProps({
  subscription: Object,
  plans: Array,
  invoices: Array,
  selected_plan: Object,
  canResume: Boolean
})


</script>
