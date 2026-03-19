<template>
  <div class="stripe-card-wrapper">
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Informations de carte
      </label>
      <div 
        id="card-element" 
        class="p-4 border-2 border-gray-300 rounded-lg bg-white focus-within:border-primary-blue transition"
      ></div>
      <div v-if="cardError" class="mt-2 text-sm text-red-600">
        {{ cardError }}
      </div>
    </div>

    <button
      @click="handleSubmit"
      :disabled="!stripe || isProcessing"
      class="w-full bg-primary-blue text-white py-4 rounded-lg font-semibold hover:bg-opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
    >
      <svg v-if="isProcessing" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      <span>{{ isProcessing ? 'Traitement en cours...' : `Payer ${formatPrice(amount)}` }}</span>
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { loadStripe, type Stripe, type StripeElements, type StripeCardElement } from '@stripe/stripe-js'

interface Props {
  clientSecret: string
  amount: number
  publishableKey: string
}

const props = defineProps<Props>()

const emit = defineEmits<{
  'success': [paymentIntent: any]
  'error': [error: string]
}>()

const stripe = ref<Stripe | null>(null)
const elements = ref<StripeElements | null>(null)
const cardElement = ref<StripeCardElement | null>(null)
const cardError = ref<string | null>(null)
const isProcessing = ref(false)

onMounted(async () => {
  try {
    // Load Stripe
    stripe.value = await loadStripe(props.publishableKey)
    
    if (!stripe.value) {
      throw new Error('Failed to load Stripe')
    }

    // Create elements
    elements.value = stripe.value.elements({
      clientSecret: props.clientSecret
    })

    // Create card element
    cardElement.value = elements.value.create('card', {
      style: {
        base: {
          fontSize: '16px',
          color: '#32325d',
          fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
          '::placeholder': {
            color: '#aab7c4'
          }
        },
        invalid: {
          color: '#fa755a',
          iconColor: '#fa755a'
        }
      }
    })

    // Mount card element
    cardElement.value.mount('#card-element')

    // Listen for errors
    cardElement.value.on('change', (event) => {
      if (event.error) {
        cardError.value = event.error.message
      } else {
        cardError.value = null
      }
    })
  } catch (error: any) {
    console.error('Failed to initialize Stripe:', error)
    emit('error', error.message || 'Failed to initialize payment form')
  }
})

onUnmounted(() => {
  if (cardElement.value) {
    cardElement.value.destroy()
  }
})

async function handleSubmit() {
  if (!stripe.value || !cardElement.value || isProcessing.value) {
    return
  }

  isProcessing.value = true
  cardError.value = null

  try {
    // Confirm card payment
    const { error, paymentIntent } = await stripe.value.confirmCardPayment(
      props.clientSecret,
      {
        payment_method: {
          card: cardElement.value
        }
      }
    )

    if (error) {
      cardError.value = error.message || 'Payment failed'
      emit('error', cardError.value || 'Payment failed')
    } else if (paymentIntent && paymentIntent.status === 'succeeded') {
      emit('success', paymentIntent)
    }
  } catch (error: any) {
    cardError.value = error.message || 'An unexpected error occurred'
    emit('error', cardError.value || 'An unexpected error occurred')
  } finally {
    isProcessing.value = false
  }
}

function formatPrice(price: number): string {
  return `${price.toFixed(0)}€`
}
</script>

<style scoped>
.stripe-card-wrapper {
  width: 100%;
}

#card-element {
  min-height: 40px;
}
</style>
