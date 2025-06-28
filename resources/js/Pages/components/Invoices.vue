<template>
    <div class="p-6 bg-white shadow rounded-xl mb-10">
        <h2 class="text-lg font-semibold mb-4">Fatture</h2>
        <div class="overflow-x-auto">
            <template  v-if="loading || invoices.length > 0">
             
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-white-50">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Data</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Totale</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Stato</th>
                    <th class="px-6 py-3 text-right font-medium text-gray-500 uppercase tracking-wider"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    <tr v-if="loading" v-for="n in 3" :key="'skeleton-' + n" class="animate-pulse">
                    <!-- skeleton -->
                    <td class="px-6 py-4">
                    <div class="h-4 bg-gray-200 rounded w-24"></div>
                    </td>
                    <td class="px-6 py-4">
                    <div class="h-4 bg-gray-200 rounded w-20"></div>
                    </td>
                    <td class="px-6 py-4">
                    <div class="h-6 bg-gray-200 rounded-full w-16"></div>
                    </td>
                    <td class="px-6 py-4 text-right">
                    <div class="h-8 bg-gray-300 rounded w-24 ml-auto"></div>
                    </td>
                </tr>
                <tr v-else v-for="invoice in invoices" :key="invoice.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-800">{{ formatDate(invoice.date) }}</td>
                    <td class="px-6 py-4 text-gray-800">{{ invoice.total }}</td>
                    <td class="px-6 py-4">
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                        :class="{
                        'bg-green-100 text-green-800': invoice.status === 'paid',
                        'bg-yellow-100 text-yellow-800': invoice.status === 'open',
                        'bg-red-100 text-red-800': invoice.status !== 'paid' && invoice.status !== 'open'
                        }"
                    >
                        {{ invoice.status }}
                    </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                    <a
                        :href="invoice.download_url"
                        class="bg-stone-700 mt-4 text-white px-4 py-2 rounded cursor-pointer"
                    >
                        Scarica PDF
                    </a>
                    </td>
                </tr>
                </tbody>
            </table>
            </template>
            <template v-else>
                <p class="text-gray-500">Nessuna fattura disponibile</p>
            </template>
        </div>
    </div>
  </template>

<script setup>
    import { ref, onMounted } from 'vue'
    import axios from 'axios'

    const invoices = ref([])
    const loading = ref(true)

    const loadInvoices = async () => {
        try {
            const response = await axios.get(route('invoice.list'))
            invoices.value = response.data
        } catch (error) {
            console.error('Errore:', error)
        } finally {
            loading.value = false
        }
    }

    onMounted(() => {
        loadInvoices()
    })

    function formatDate(date) {
        return new Date(date).toLocaleDateString('it-IT')
    }  

</script>