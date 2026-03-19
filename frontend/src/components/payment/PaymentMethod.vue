<template>
  <div class="bg-white rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-6">Mode de paiement</h2>

    <div class="space-y-4">
      <!-- Credit Card -->
      <label
        class="flex items-center justify-between p-4 border-2 rounded cursor-pointer hover:border-primary-blue transition"
        :class="
          selectedMethod === 'card' ? 'border-primary-blue' : 'border-gray-300'
        "
      >
        <div class="flex items-center gap-3">
          <input
            type="radio"
            name="payment"
            value="card"
            v-model="selectedMethod"
            @change="handleMethodChange"
            class="w-5 h-5"
          />
          <span class="text-gray-900">Carte de crédit ou de débit</span>
        </div>
        <svg class="w-10 h-6" viewBox="0 0 40 24" fill="none">
          <rect width="40" height="24" rx="4" fill="#1A1F71" />
          <rect x="8" y="8" width="24" height="8" rx="2" fill="white" />
        </svg>
      </label>

      <!-- SEPA -->
      <label
        class="flex items-center justify-between p-4 border-2 rounded cursor-pointer hover:border-primary-blue transition"
        :class="
          selectedMethod === 'sepa' ? 'border-primary-blue' : 'border-gray-300'
        "
      >
        <div class="flex flex-col">
          <div class="flex items-center gap-3 mb-1">
            <input
              type="radio"
              name="payment"
              value="sepa"
              v-model="selectedMethod"
              @change="handleMethodChange"
              class="w-5 h-5"
            />
            <span class="text-gray-900">Prélèvement SEPA</span>
          </div>
          <span class="text-sm text-gray-500 ml-8"
            >Compte bancaire en EUR requis</span
          >
        </div>
        <img
          src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 80 30'%3E%3Ctext x='10' y='20' font-family='Arial' font-size='16' font-weight='bold' fill='%230066CC'%3ESEPA%3C/text%3E%3C/svg%3E"
          alt="SEPA"
          class="h-8"
        />
      </label>

      <!-- PayPal -->
      <label
        class="flex items-center justify-between p-4 border-2 rounded cursor-pointer hover:border-primary-blue transition"
        :class="
          selectedMethod === 'paypal'
            ? 'border-primary-blue'
            : 'border-gray-300'
        "
      >
        <div class="flex items-center gap-3">
          <input
            type="radio"
            name="payment"
            value="paypal"
            v-model="selectedMethod"
            @change="handleMethodChange"
            class="w-5 h-5"
          />
          <span class="text-gray-900">PAYPAL</span>
        </div>
        <svg class="h-6" viewBox="0 0 100 32" fill="none">
          <text
            x="0"
            y="24"
            font-family="Arial"
            font-size="20"
            font-weight="bold"
            fill="#003087"
          >
            Pay
          </text>
          <text
            x="35"
            y="24"
            font-family="Arial"
            font-size="20"
            font-weight="bold"
            fill="#009CDE"
          >
            Pal
          </text>
        </svg>
      </label>

      <!-- Apple Pay -->
      <label
        class="flex items-center justify-between p-4 border-2 rounded cursor-pointer hover:border-primary-blue transition"
        :class="
          selectedMethod === 'applepay'
            ? 'border-primary-blue'
            : 'border-gray-300'
        "
      >
        <div class="flex items-center gap-3">
          <input
            type="radio"
            name="payment"
            value="applepay"
            v-model="selectedMethod"
            @change="handleMethodChange"
            class="w-5 h-5"
          />
          <span class="text-gray-900">Apple Pay</span>
        </div>
        <svg class="h-8" viewBox="0 0 50 32" fill="black">
          <path
            d="M8.5 10c-.8 0-1.4.3-1.9.8-.5.5-.8 1.2-.8 2 0 .8.3 1.5.8 2 .5.5 1.1.8 1.9.8.7 0 1.4-.3 1.9-.8.5-.5.8-1.2.8-2 0-.8-.3-1.5-.8-2-.5-.5-1.2-.8-1.9-.8zm5.5 0c-.8 0-1.4.3-1.9.8-.5.5-.8 1.2-.8 2 0 .8.3 1.5.8 2 .5.5 1.1.8 1.9.8.7 0 1.4-.3 1.9-.8.5-.5.8-1.2.8-2 0-.8-.3-1.5-.8-2-.5-.5-1.2-.8-1.9-.8z"
          />
        </svg>
      </label>
    </div>

    <!-- Pay Button (hidden for card payment as Stripe handles it) -->
    <button
      v-if="props.showPayButton"
      @click="handlePayment"
      :disabled="!selectedMethod || props.isProcessing"
      class="w-full font-semibold py-4 rounded mt-6 transition flex items-center justify-center gap-2"
      :class="
        selectedMethod && !props.isProcessing
          ? 'bg-gray-300 hover:bg-gray-400 text-gray-700'
          : 'bg-gray-200 text-gray-500 cursor-not-allowed'
      "
    >
      <svg v-if="props.isProcessing" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      <span>{{ props.isProcessing ? 'Traitement en cours...' : `Payer ${formatPrice(totalAmount)}` }}</span>
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

type PaymentMethodType = 'card' | 'sepa' | 'paypal' | 'applepay'

interface Props {
  totalAmount: number
  modelValue?: PaymentMethodType
  isProcessing?: boolean
  showPayButton?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: 'card',
  isProcessing: false,
  showPayButton: true
})

const emit = defineEmits<{
  'update:modelValue': [value: PaymentMethodType]
  pay: [method: PaymentMethodType]
}>()

const selectedMethod = ref<PaymentMethodType>(props.modelValue)

function handleMethodChange() {
  emit('update:modelValue', selectedMethod.value)
}

function handlePayment() {
  if (selectedMethod.value) {
    emit('pay', selectedMethod.value)
  }
}

function formatPrice(price: number): string {
  return `${price.toFixed(0)}€`
}
</script>
