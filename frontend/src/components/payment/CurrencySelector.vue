<template>
  <div class="bg-white rounded-lg p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 24px; line-height: 24px;">
        Sélection de la devise
      </h2>
    </div>
    <div class="bg-[#A8927D]/10 border border-[#A8927D]/30 rounded p-4 mb-4">
      <p class="text-sm text-gray-700" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400; font-size: 16px; line-height: 24px;">
        Vous pouvez payer dans la devise qui vous convient le mieux. Les prix seront automatiquement convertis.
      </p>
    </div>
    <select
      :value="currentCurrency.code"
      @change="handleCurrencyChange"
      class="w-full px-4 py-3 border-2 border-gray-300 rounded text-gray-900 outline-none focus:border-primary-blue transition"
      style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 500; font-size: 16px;"
    >
      <option 
        v-for="currency in availableCurrencies" 
        :key="currency.code" 
        :value="currency.code"
      >
        {{ currency.symbol }} {{ currency.code }}
      </option>
    </select>
  </div>
</template>

<script setup lang="ts">
import { useCurrency } from '@/composables/useCurrency'

const { currentCurrency, setCurrency, availableCurrencies } = useCurrency()

function handleCurrencyChange(event: Event) {
  const target = event.target as HTMLSelectElement
  setCurrency(target.value as any)
}
</script>
