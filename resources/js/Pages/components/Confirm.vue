<template>
    <div v-if="show" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center">
      <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">{{ title }}</h2>
        <p class="text-gray-600 mb-6">
          {{ message }}
        </p>
        <div class="flex justify-end space-x-3">
          <button
            @click="close"
            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition cursor-pointer"
          >
            Annulla
          </button>
          <button
            @click="confirm"
            class="px-4 py-2 bg-stone-700 text-white rounded hover:bg-stone-700 transition cursor-pointer"
          >
            Conferma
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  const emit = defineEmits(['confirm', 'close'])
  defineProps({ show: Boolean, message: String, title: String })
  
  const confirm = () => emit('confirm')
  const close = () => emit('close')
  </script>