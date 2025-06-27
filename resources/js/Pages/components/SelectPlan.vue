<template>
    <!-- Overlay -->
    <div
        v-if="isLoading"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-51 flex items-center justify-center">
        <!-- Spinner -->
        <div class="w-12 h-12 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
    </div>
    <!-- Fine Overlay-->
     <template v-if="!loading">
      <!-- Active subscription widget-->
      <ActiveSubscription v-if="subscription && showPlans == false"  @resume="loadSubscriptionInfo"
              :subscription="subscription" 
              :plans="plans" 
              :canResume="canResume" 
              @change="showPlans = true"
              />  
        <!-- Plans widget-->
        <Plans v-if="plans.length > 0 && showPlans" :plans="plans" @back="showPlans = false"
              :subscription="subscription"
              :ended="ended"/>
       <!-- Cancel subscription widget-->
      <CancelSubscription v-if="subscription && !canResume && !ended" @cancel="loadSubscriptionInfo"/>
    </template>
    <template v-else>
      <!-- skeleton-->
      <div class="p-6 bg-white shadow rounded-xl mb-10 animate-pulse">
        <h2 class="text-lg font-semibold bg-gray-200 h-6 w-1/4 rounded mb-4"></h2>

        <div class="p-6">
          <div class="h-6 bg-gray-200 rounded w-1/3 mb-2"></div>
          <div class="h-4 bg-gray-200 rounded w-2/3 mb-4"></div>

          <ul class="space-y-3 mb-6">
            <li v-for="i in 3" :key="i" class="flex items-start">
              <div class="w-5 h-5 bg-gray-300 rounded-full mt-1 mr-2 flex-shrink-0"></div>
              <div class="h-4 bg-gray-200 rounded w-2/3"></div>
            </li>
          </ul>

          <div class="h-6 bg-gray-300 rounded w-1/3 mb-4"></div>

          <div class="h-10 w-40 bg-gray-400 rounded"></div>
        </div>
      </div>
    </template>
</template>
<script setup>
import Plans from './Plans.vue';
import ActiveSubscription from './ActiveSubscription.vue';
import CancelSubscription from './CancelSubscription.vue';
import { useLoader,setLoader } from '../core/useLoader'
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'


const showPlans = ref(false);
const plans = ref([]);
const subscription = ref({})
const ended = ref(false)
const canResume = ref(false)
const loading = ref(true)

const { isLoading } = useLoader()

const loadData = async () => {
    try {
        await loadSubscriptionInfo();
        await loadPlans();
        if( !subscription.value ){
            showPlans.value = true;
        }
    } catch (error) {
        console.error('Errore:', error)
    } finally {
        loading.value = false
    }
}
const loadSubscriptionInfo = async () => {
    const response = await axios.get(route('subscription.info'))
    subscription.value = response.data.subscription;
    canResume.value = response.data.canResume;
    ended.value = response.data.ended;

};
const loadPlans = async () => {
    const response = await axios.get(route('subscription.plans'))
    plans.value = response.data;
};


onMounted(() => {
    loadData()
})

const props = defineProps({
    title: String,
    subscription: Object,
    plans: Array,
    canResume: Boolean,
    ended: Boolean
})
router.on('start', () => {
  setLoader(true)
})
router.on('finish', () => {
  setLoader(false)
})
</script>