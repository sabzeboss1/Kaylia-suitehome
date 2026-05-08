<template>
  <Transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div
      v-if="modelValue"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
      @click.self="handleClose"
    >
      <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div
          v-if="modelValue"
          class="bg-white rounded-lg shadow-xl max-w-lg w-full overflow-hidden"
        >
          <!-- Header -->
          <div class="bg-gradient-to-r from-[#0B6087] to-[#094d6b] px-6 py-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                  <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <h3 class="text-xl font-semibold text-white">{{ title }}</h3>
              </div>
              <button
                @click="handleClose"
                class="text-white/80 hover:text-white transition-colors"
              >
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Content -->
          <div class="px-6 py-6 space-y-4">
            <!-- Message -->
            <p class="text-gray-700 leading-relaxed">{{ message }}</p>

            <!-- Deposit Breakdown -->
            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Montant total de la réservation</span>
                <span class="text-sm font-medium text-gray-900">{{ formatPrice(totalAmount) }}</span>
              </div>
              
              <div class="border-t border-gray-200"></div>
              
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">
                  Dépôt de garantie ({{ depositPercentage }}%)
                </span>
                <span class="text-lg font-bold text-[#0B6087]">{{ formatPrice(depositAmount) }}</span>
              </div>
              
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Solde à payer sur place</span>
                <span class="text-sm font-medium text-gray-900">{{ formatPrice(remainingAmount) }}</span>
              </div>
            </div>

            <!-- Important Notice -->
            <div class="bg-[#A8927D]/10 border border-[#A8927D]/30 rounded-lg p-4">
              <div class="flex gap-3">
                <svg class="w-5 h-5 text-[#0B6087] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-gray-800">
                  <p class="font-semibold mb-1">Important</p>
                  <p>Le dépôt de garantie sera déduit du montant total. Vous ne paierez que le solde restant lors de votre arrivée.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="bg-gray-50 px-6 py-4 flex items-center justify-between gap-3">
            <button
              @click="handleClose"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
            >
              Retour
            </button>
            <button
              @click="handleConfirm"
              class="px-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-[#0B6087] to-[#094d6b] rounded-lg hover:from-[#094d6b] hover:to-[#073a4f] transition-all shadow-lg flex items-center gap-2"
            >
              <span>Continuer vers le paiement</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
              </svg>
            </button>
          </div>
        </div>
      </Transition>
    </div>
  </Transition>
</template>

<script setup lang="ts">
interface Props {
  modelValue: boolean
  title?: string
  message?: string
  totalAmount: number
  depositAmount: number
  remainingAmount: number
  depositPercentage: number
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Dépôt de garantie requis',
  message: 'Pour confirmer votre réservation, un dépôt de garantie est requis. Ce montant sera déduit du total à payer lors de votre arrivée.'
})

const emit = defineEmits<{
  'update:modelValue': [value: boolean]
  confirm: []
  close: []
}>()

function handleClose() {
  emit('update:modelValue', false)
  emit('close')
}

function handleConfirm() {
  emit('update:modelValue', false)
  emit('confirm')
}

function formatPrice(amount: number): string {
  return `${amount.toFixed(2)}€`
}
</script>
