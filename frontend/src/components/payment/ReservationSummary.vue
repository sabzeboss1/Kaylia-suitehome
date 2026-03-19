<template>
  <div class="bg-white rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-6">
      Les détails de votre réservation
    </h2>

    <div class="space-y-4">
      <!-- Main Reservation -->
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-900 font-medium">{{ apartmentName }}</p>
          <p class="text-sm text-gray-500">
            du {{ formatDate(checkIn) }} au {{ formatDate(checkOut) }}
          </p>
        </div>
        <span class="text-gray-900 font-semibold">{{ formatPrice(basePrice) }}</span>
      </div>

      <!-- Add-ons -->
      <div v-for="addon in addOns" :key="addon.id" class="flex justify-between items-center">
        <p class="text-gray-700">{{ getAddonLabel(addon) }}</p>
        <span class="text-gray-900">{{ formatPrice(getAddonTotalPrice(addon)) }}</span>
      </div>

      <!-- Promo Code Discount -->
      <div v-if="discount > 0" class="flex justify-between items-center text-green-600">
        <p>Code promo</p>
        <span>-{{ formatPrice(discount) }}</span>
      </div>

      <!-- Total -->
      <div class="border-t pt-4 flex justify-between items-center">
        <p class="text-lg font-semibold text-gray-900">Total</p>
        <span class="text-xl font-bold text-gray-900">{{ formatPrice(totalPrice) }}</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { format } from 'date-fns'
import { fr } from 'date-fns/locale'

interface AddOn {
  id: number
  name: string
  price: number
  quantity: number
  price_type?: 'per_night' | 'one_time'
}

interface Props {
  apartmentName: string
  checkIn: Date
  checkOut: Date
  basePrice: number
  addOns?: AddOn[]
  discount?: number
  totalPrice: number
  nightCount?: number
}

const props = withDefaults(defineProps<Props>(), {
  addOns: () => [],
  discount: 0,
  nightCount: 1
})

function formatDate(date: Date): string {
  return format(date, 'dd/MM/yyyy', { locale: fr })
}

function formatPrice(price: number): string {
  return `${price.toFixed(0)}€`
}

function getAddonTotalPrice(addon: AddOn): number {
  if (addon.price_type === 'per_night') {
    return addon.price * addon.quantity * props.nightCount
  }
  return addon.price * addon.quantity
}

function getAddonLabel(addon: AddOn): string {
  if (addon.price_type === 'per_night') {
    return `${addon.name} (${addon.quantity}x × ${props.nightCount} nuits)`
  }
  return addon.name
}
</script>
