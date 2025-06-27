<!-- resources/js/Pages/Subscriptions/ActiveSubscription.vue -->
<template>
    <div class="p-6 bg-white shadow rounded-xl mt-10">
      <p>Puoi annullare la sottoscrizione in qualsiasi momento. Una volta che la tua sottoscrizione sarà annullata, avrai l'opzione di ripristinarla fino alla fine del tuo  periodo di fatturazione.</p>
      <div class="mt-4">
        <button @click="confirm()" class="bg-neutral-50 border border-stone-500 text-stone px-4 py-2 rounded cursor-pointer">
            annulla abbonamento
        </button>
      </div>
    </div>
    <Confirm :show="showConfirm" 
      :title="'Annulla abbonamento'" 
      :message="'Sei sicuro di voler cancellare il tuo abbonamento? Continuerai ad avere accesso fino alla fine del ciclo di fatturazione.'"
      @close="showConfirm = false"
      @confirm="cancelSubscription"
      ></Confirm>
    
</template>
<script setup>
  import { router } from '@inertiajs/vue3'
  import { ref } from 'vue'
  import Confirm from './Confirm.vue';
  const showConfirm = ref(false)
  const emit = defineEmits(['cancel'])
  
  function cancelSubscription() {
    showConfirm.value = false;
    router.post('/subscription/cancel', {}, {
      onSuccess: () => {
        emit('cancel');
      }
    })
  }

  function confirm() {
    showConfirm.value = true;
  }
</script>