<!-- resources/js/Pages/Subscriptions/ActiveSubscription.vue -->
<template>
    <div class="p-6 bg-white shadow rounded-xl mb-10">
        <h2 class="text-lg font-semibold mb-4" v-if="canResume">Ripristina abbonamento</h2>
        <h2 class="text-lg font-semibold" v-else>Abbonamento attivo</h2>
        
        <div v-if="subscription && !canResume">

            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">{{ plan?.name }}</h2>
                <p class="text-gray-700 mb-4">{{ plan?.description }}</p>
                <ul class="space-y-3 mb-6">
                    <li v-for="(feature, index) in plan?.features" :key="index" class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-1 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-gray-700">{{ feature }}</span>
                    </li>
                </ul>
                <p class="text-lg font-bold mb-4">
                    <span v-if="plan?.billing_cycle === 'monthly'">
                    {{ plan?.monthly_price }}{{ plan?.currency }} / mese
                    </span>
                    <span v-else>
                    {{ plan?.yearly_price }}{{ plan?.currency }} / anno
                    </span> 
                
                </p>
            </div>
            <button  @click="changePlan()" class="bg-stone-700 mt-4 text-white px-4 py-2 rounded cursor-pointer">
                cambia piano
            </button>
        </div>
        <div v-else>
            <p>Il tuo abbonamento è stato annullato, ma è ancora attivo fino alla fine del ciclo di fatturazione.
Puoi decidere di ripristinarlo in qualsiasi momento prima della scadenza prevista il <b>{{ formatDate(subscription.ends_at) }}</b>.<br>
Una volta terminato il periodo attuale, potrai scegliere un nuovo piano di abbonamento.</p>
            <button  @click="resume()" class="bg-stone-700 mt-4 text-white px-4 py-2 rounded cursor-pointer">
                ripristina abbinamento
            </button>
        </div>
    </div>
  </template>
  
<script setup>
    import { router } from '@inertiajs/vue3'
    import { computed } from 'vue'
    const emit = defineEmits(['change','resume'])

    const props = defineProps({
        subscription: Object,
        plans: [],
        canResume: Boolean
    })
    
    
    function formatDate(date) {
        return new Date(date).toLocaleDateString('it-IT')
    }

 
    function changePlan(){
        emit('change')
    }

    function resume() {
       router.post('/subscription/resume', {}, {
            onSuccess: () => {
                // Esempio: redirect a un'altra pagina
                emit('resume');
            }
        })
    }

    const plan = computed(() => {
       let p = props.plans.find( item => item.monthly_id == props.subscription.stripe_price ||  item.yearly_id == props.subscription.stripe_price);
       if( p ){
            if(p.monthly_id == props.subscription.stripe_price){
                p.billing_cycle = 'monthly';
            }
       }
       if( !p ){
            const billing_cycle = props.subscription.price.recurring.interval == 'month'?'monthly' : 'yearly';
            const price = props.subscription.price.unit_amount/100;
            p = {
                'name': props.subscription.product.name,
                'description': props.subscription.product.description,
                'billing_cycle': billing_cycle,
                'monthly_price': price,
                'yearly_price': price,
                'currency': props.subscription.price.currency=='eur'?"€":props.subscription.price.currency
            }
            console.log(props.subscription);
       }
       return p;
    })

    
</script>