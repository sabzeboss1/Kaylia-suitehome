<template>
  <div class="bg-white rounded-lg p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-semibold text-gray-900">Sélection de la devise</h2>
      <button class="text-sm text-gray-600 hover:text-gray-900">
        Modifier votre devise
      </button>
    </div>
    <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-4">
      <p class="text-sm text-gray-700">
        Vous pouvez payer dans la devise qui vous convient le mieux.
      </p>
    </div>
    <select
      v-model="selectedCurrency"
      @change="handleCurrencyChange"
      class="w-full px-4 py-3 border-2 border-gray-300 rounded text-gray-900 outline-none focus:border-primary-blue transition"
    >
      <option value="EUR">€ EUR</option>
      <option value="USD">$ USD</option>
      <option value="GBP">£ GBP</option>
    </select>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Props {
  modelValue?: string
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: 'EUR'
})

const emit = defineEmits<{
  'update:modelValue': [value: string]
}>()

const selectedCurrency = ref(props.modelValue)

function handleCurrencyChange() {
  emit('update:modelValue', selectedCurrency.value)
}
</script>
