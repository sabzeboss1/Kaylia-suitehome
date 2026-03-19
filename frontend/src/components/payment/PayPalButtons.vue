<template>
  <div class="paypal-buttons-wrapper">
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Paiement PayPal
      </label>
      <div 
        id="paypal-button-container" 
        class="min-h-[150px] flex items-center justify-center"
      >
        <div v-if="isLoading" class="text-center">
          <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-blue"></div>
          <p class="mt-2 text-sm text-gray-600">Chargement PayPal...</p>
        </div>
        <div v-else-if="error" class="text-center text-red-600 text-sm">
          {{ error }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

interface Props {
  clientId: string
  amount: number
  currency?: string
  mode?: 'sandbox' | 'live'
  reservationId: number
}

const props = withDefaults(defineProps<Props>(), {
  currency: 'EUR',
  mode: 'sandbox'
})

const emit = defineEmits<{
  'success': [orderId: string, details: any]
  'error': [error: string]
  'cancel': []
}>()

const isLoading = ref(true)
const error = ref<string | null>(null)
let paypalInstance: any = null

onMounted(async () => {
  try {
    // Check if PayPal SDK is already loaded
    if ((window as any).paypal) {
      initializePayPalButtons()
      return
    }

    // Load PayPal SDK
    await loadPayPalSDK()
    initializePayPalButtons()
  } catch (err: any) {
    console.error('Failed to load PayPal SDK:', err)
    error.value = err.message || 'Failed to load PayPal'
    isLoading.value = false
  }
})

onUnmounted(() => {
  // Cleanup PayPal buttons
  const container = document.getElementById('paypal-button-container')
  if (container) {
    container.innerHTML = ''
  }
})

async function loadPayPalSDK(): Promise<void> {
  return new Promise((resolve, reject) => {
    // Check if script already exists
    const existingScript = document.querySelector('script[src*="paypal.com/sdk/js"]')
    if (existingScript) {
      resolve()
      return
    }

    const script = document.createElement('script')
    script.src = `https://www.paypal.com/sdk/js?client-id=${props.clientId}&currency=${props.currency}`
    script.async = true
    
    script.onload = () => {
      console.log('✅ PayPal SDK loaded')
      resolve()
    }
    
    script.onerror = () => {
      reject(new Error('Failed to load PayPal SDK'))
    }
    
    document.head.appendChild(script)
  })
}

function initializePayPalButtons() {
  const paypal = (window as any).paypal
  
  if (!paypal) {
    error.value = 'PayPal SDK not available'
    isLoading.value = false
    return
  }

  try {
    paypalInstance = paypal.Buttons({
      style: {
        layout: 'vertical',
        color: 'gold',
        shape: 'rect',
        label: 'paypal'
      },
      
      createOrder: (data: any, actions: any) => {
        console.log('💳 Creating PayPal order...')
        return actions.order.create({
          purchase_units: [{
            reference_id: `reservation_${props.reservationId}`,
            description: `Réservation #${props.reservationId}`,
            amount: {
              currency_code: props.currency,
              value: props.amount.toFixed(2)
            }
          }],
          application_context: {
            shipping_preference: 'NO_SHIPPING'
          }
        })
      },
      
      onApprove: async (data: any, actions: any) => {
        console.log('✅ PayPal payment approved:', data.orderID)
        
        try {
          // Capture the order
          const details = await actions.order.capture()
          console.log('✅ PayPal order captured:', details)
          
          emit('success', data.orderID, details)
        } catch (err: any) {
          console.error('❌ Failed to capture PayPal order:', err)
          emit('error', err.message || 'Failed to capture payment')
        }
      },
      
      onCancel: (data: any) => {
        console.log('⚠️ PayPal payment cancelled:', data)
        emit('cancel')
      },
      
      onError: (err: any) => {
        console.error('❌ PayPal error:', err)
        emit('error', err.message || 'PayPal payment failed')
      }
    })

    // Render buttons
    paypalInstance.render('#paypal-button-container')
      .then(() => {
        console.log('✅ PayPal buttons rendered')
        isLoading.value = false
      })
      .catch((err: any) => {
        console.error('❌ Failed to render PayPal buttons:', err)
        error.value = 'Failed to render PayPal buttons'
        isLoading.value = false
      })
  } catch (err: any) {
    console.error('❌ Failed to initialize PayPal buttons:', err)
    error.value = err.message || 'Failed to initialize PayPal'
    isLoading.value = false
  }
}
</script>

<style scoped>
.paypal-buttons-wrapper {
  width: 100%;
}

#paypal-button-container {
  width: 100%;
}
</style>
