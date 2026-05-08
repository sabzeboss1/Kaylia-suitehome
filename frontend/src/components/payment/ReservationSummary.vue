<template>
  <div class="bg-white rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 24px; line-height: 24px;">
      Les détails de votre réservation
    </h2>

    <div class="space-y-4">
      <!-- Main Reservation -->
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-900 font-medium" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 16px;">
            {{ apartmentName }}
          </p>
          <p class="text-sm text-gray-500" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400; font-size: 14px;">
            du {{ formatDate(checkIn) }} au {{ formatDate(checkOut) }}
          </p>
        </div>
        <span class="text-gray-900 font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
          {{ formatPrice(basePrice) }}
        </span>
      </div>

      <!-- Add-ons -->
      <div v-for="addon in addOns" :key="addon.id" class="flex justify-between items-center">
        <p class="text-gray-700" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400; font-size: 16px;">
          {{ getAddonLabel(addon) }}
        </p>
        <span class="text-gray-900" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
          {{ formatPrice(getAddonTotalPrice(addon)) }}
        </span>
      </div>

      <!-- Promo Code Discount -->
      <div v-if="discount > 0" class="flex justify-between items-center text-green-600">
        <p style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400; font-size: 16px;">
          Code promo
        </p>
        <span style="font-family: 'Poppins', sans-serif; font-weight: 500;">
          -{{ formatPrice(discount) }}
        </span>
      </div>

      <!-- Total -->
      <div class="border-t pt-4 flex justify-between items-center">
        <p class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px;">
          Total
        </p>
        <span class="text-xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 24px;">
          {{ formatPrice(totalPrice) }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { format } from 'date-fns'
import { fr } from 'date-fns/locale'
import { useCurrency } from '@/composables/useCurrency'

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

const { formatPrice } = useCurrency()

function formatDate(date: Date): string {
  return format(date, 'dd/MM/yyyy', { locale: fr })
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
