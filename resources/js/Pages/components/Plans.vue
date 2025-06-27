<template>
       <div class="flex items-center gap-4 mb-6">
        <span :class="billingCycle === 'monthly' ? 'font-semibold text-gray-900' : 'text-gray-500'">Mensile</span>
        
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only peer" v-model="isYearly">
          <div class="w-11 h-6 bg-stone-700 rounded-full peer peer-checked:bg-stone-700 transition"></div>
          <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full transition-transform peer-checked:translate-x-full"></div>
        </label>

        <span :class="billingCycle === 'yearly' ? 'font-semibold text-gray-900' : 'text-gray-500'">Annuale</span>
    </div>
    
    
    <div class="grid grid-rows-1 gap-6">
      <div
        v-for="plan in plans"
        class="border rounded-lg bg-white shadow">
        <div class="p-6">
          <h2 class="text-xl font-semibold mb-2">{{ plan.name }}</h2>
          <p class="text-gray-700 mb-4">{{ plan.description }}</p>
          <ul class="space-y-3 mb-6">
            <li v-for="(feature, index) in plan.features" :key="index" class="flex items-start">
              <svg class="w-5 h-5 text-green-600 mt-1 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-gray-700">{{ feature }}</span>
            </li>
          </ul>
          <p class="text-lg font-bold mb-4">
            <span v-if="billingCycle === 'monthly'">
              {{ plan.monthly_price }}{{ plan.currency }} / mese
            </span>
            <span v-else>
              {{ plan.yearly_price }}{{ plan.currency }} / anno
            </span> 
          </p>
        </div>

        <div class="bg-stone-50 border pt-2 pb-2 pr-2 pl-2 flex justify-end">
          <template v-if="billingCycle === 'monthly'">
            <button v-if="ended || plan.monthly_id != subscription?.stripe_price" @click="confirm(plan.monthly_id)"  class="bg-stone-700 text-white px-4 py-2 rounded cursor-pointer">
              <template v-if="subscription && !ended">cambia piano</template>
              <template v-else>abbonati</template>
            </button>
            <label v-else class="bg-neutral-50 border border-stone-500 text-stone px-4 py-2 rounded">abbonamento corrente</label>
          </template>
          <template v-else>
            <button  v-if="ended || plan.yearly_id != subscription?.stripe_price" @click="confirm(plan.yearly_id)"  class="bg-stone-700 text-white px-4 py-2 rounded cursor-pointer">
              <template v-if="subscription && !ended">cambia piano</template>
              <template v-else>abbonati</template>
            </button>
            <label v-else class="bg-neutral-50 border border-stone-500 text-stone px-4 py-2 rounded">abbonamento corrente</label>
          </template>
          
          
        </div>
      </div>
    </div>
    <div class="mt-2" v-if="subscription">
        <a class="text-stone-500 underline cursor-pointer" @click="back()">Torna indietro</a>
    </div>

    <Confirm :show="showConfirm" 
      :title="'Cambia piano'" 
      :message="'Sei sicuro di voler cambiare il piano di fatturazione.'"
      @close="showConfirm = false"
      @confirm="subscribe"
      ></Confirm>
    
</template>
<script setup>
import { computed, ref } from 'vue'
import axios from '../core/axios'
import Confirm from './Confirm.vue';
const showConfirm = ref(false)
const isYearly = ref(false)
const billingCycle = computed(() => (isYearly.value ? 'yearly' : 'monthly'))
const emit = defineEmits(['back'])
var selected_price = null;

const props = defineProps({
  subscription: Object,
  plans: Array,
  ended: Boolean
})

function back(){
  emit('back')
}

async function confirm(price) {
    selected_price = price;
    if( props.subscription ){
      showConfirm.value = true;
    }else{
      showConfirm.value = false;
      await this.subscribe();
    }
    
}

async function subscribe() {
  showConfirm.value = false;
  try {
    const response = await axios.post('/subscription/subscribe', { price: selected_price })
    window.location.href = response.data.checkout_url
  } catch (error) {
    console.error(error)
  } finally {
  }
}
</script>