<template>
   <div class="mx-auto ">
     <h1 class="text-2xl font-bold mb-6" v-if="title">{{ title }}</h1>
     
     <!--Select Plan widget-->
     <SelectPlan/>
     
     <!--Invoices widget-->
     <Invoices class="mt-10"/>
 
   </div>
 </template>
 
 <script setup>
import Invoices from './Invoices.vue';
import SelectPlan from './SelectPlan.vue';
const props = defineProps({
    title: String,
})
 
</script>
 