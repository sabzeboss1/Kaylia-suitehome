<template>
  <div class="bg-white rounded-lg p-6">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 24px; line-height: 24px;">
        {{ isDeposit ? 'Dépôt à payer' : 'Vous allez payer' }}
      </h2>
      <span class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
        {{ formatPrice(totalPrice) }}
      </span>
    </div>

    <!-- Deposit Info -->
    <div v-if="isDeposit && fullAmount" class="mb-4 p-3 bg-[#A8927D]/10 border border-[#A8927D]/30 rounded-lg">
      <div class="flex items-start gap-2">
        <svg class="w-5 h-5 text-[#0B6087] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="text-sm text-gray-800">
          <p class="font-semibold mb-1">Paiement du dépôt de garantie</p>
          <p>Montant total de la réservation: <span class="font-bold">{{ formatPrice(fullAmount) }}</span></p>
          <p>Solde à payer sur place: <span class="font-bold">{{ formatPrice(fullAmount - totalPrice) }}</span></p>
        </div>
      </div>
    </div>

    <div class="bg-gray-50 rounded p-4">
      <h3 class="text-sm font-semibold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 16px;">
        Informations relatives au prix
      </h3>
      <p class="text-xs text-gray-600 leading-relaxed" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400; font-size: 14px; line-height: 20px;">
        {{ isDeposit 
          ? 'Le dépôt de garantie sera déduit du montant total. Le solde restant sera à régler sur place lors de votre arrivée.' 
          : 'Le prix total inclut les frais de service et les taxes. Le montant final peut varier en fonction de votre mode de paiement et de votre pays de résidence. Pour plus d\'informations, veuillez consulter nos conditions générales de vente.'
        }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useCurrency } from '@/composables/useCurrency'

interface Props {
  totalPrice: number
  isDeposit?: boolean
  fullAmount?: number
}

withDefaults(defineProps<Props>(), {
  isDeposit: false,
  fullAmount: 0
})

const { formatPrice } = useCurrency()
</script>
