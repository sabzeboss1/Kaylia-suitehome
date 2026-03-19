<template>
  <div class="bg-white rounded-lg p-6">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-semibold text-gray-900">Vous allez payer</h2>
      <span class="text-2xl font-bold text-gray-900">{{ formatPrice(totalPrice) }}</span>
    </div>

    <div class="bg-gray-50 rounded p-4">
      <h3 class="text-sm font-semibold text-gray-900 mb-2">
        Informations relatives au prix
      </h3>
      <p class="text-xs text-gray-600 leading-relaxed">
        Le prix total inclut les frais de service et les taxes. Le montant final peut
        varier en fonction de votre mode de paiement et de votre pays de résidence. Pour
        plus d'informations, veuillez consulter nos conditions générales de vente.
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  totalPrice: number
}

defineProps<Props>()

function formatPrice(price: number): string {
  return `${price.toFixed(0)}€`
}
</script>
