<template>
  <div class="bg-[#d9cfc2] rounded-lg p-6 lg:sticky lg:top-4 space-y-6 max-w-md mx-auto lg:mx-0">
    <!-- DatePicker Component -->
    <DatePicker
      v-model="showDatePicker"
      :start-date="tempCheckIn"
      :end-date="tempCheckOut"
      @update:dates="handleDatePickerUpdate"
    />
    <!-- 1. Vos informations -->
    <div class="bg-[#e8dfd5] rounded-lg p-5 border border-gray-200 shadow-sm">
      <h3 class="text-base font-semibold text-gray-800 mb-4">Vos informations</h3>
      
      <!-- Dates avec bouton d'édition -->
      <div class="mb-4 pb-4 border-b border-gray-300">
        <div class="flex items-center justify-between mb-2">
          <span class="text-xs text-gray-600 uppercase tracking-wide">Dates de séjour</span>
          <button
            @click="showDatePicker = true"
            class="flex items-center gap-1 text-xs text-[#1c5d78] hover:text-[#154a5f] transition"
            title="Modifier les dates"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Modifier</span>
          </button>
        </div>
        <div class="flex items-center justify-between text-sm text-gray-700">
          <span class="font-medium">{{ formatDate(checkIn) }}</span>
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
          <span class="font-medium">{{ formatDate(checkOut) }}</span>
        </div>
        <div class="text-xs text-gray-500 mt-1 text-center">
          {{ nightCount }} nuit{{ nightCount > 1 ? 's' : '' }}
        </div>
      </div>

      <!-- Apartment name -->
      <div class="text-sm font-medium text-gray-800 mb-4">{{ apartmentName }}</div>

      <!-- Guests counters -->
      <div class="space-y-4">
        <!-- Adults -->
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-700">Adultes</span>
          <div class="flex items-center gap-3">
            <button
              @click="decrementAdults"
              :disabled="adults <= 1"
              class="w-8 h-8 bg-[#1c5d78] text-white rounded-full flex items-center justify-center text-lg font-bold hover:bg-[#154a5f] transition disabled:opacity-40 disabled:cursor-not-allowed"
            >
              −
            </button>
            <span class="text-base font-medium text-gray-800 w-6 text-center">{{ adults }}</span>
            <button
              @click="incrementAdults"
              :disabled="adults + children >= maxCapacity"
              class="w-8 h-8 bg-[#1c5d78] text-white rounded-full flex items-center justify-center text-lg font-bold hover:bg-[#154a5f] transition disabled:opacity-40 disabled:cursor-not-allowed"
            >
              +
            </button>
          </div>
        </div>

        <!-- Children -->
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-700">Enfants (0–18 ans)</span>
          <div class="flex items-center gap-3">
            <button
              @click="decrementChildren"
              :disabled="children <= 0"
              class="w-8 h-8 bg-[#1c5d78] text-white rounded-full flex items-center justify-center text-lg font-bold hover:bg-[#154a5f] transition disabled:opacity-40 disabled:cursor-not-allowed"
            >
              −
            </button>
            <span class="text-base font-medium text-gray-800 w-6 text-center">{{ children }}</span>
            <button
              @click="incrementChildren"
              :disabled="adults + children >= maxCapacity"
              class="w-8 h-8 bg-[#1c5d78] text-white rounded-full flex items-center justify-center text-lg font-bold hover:bg-[#154a5f] transition disabled:opacity-40 disabled:cursor-not-allowed"
            >
              +
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- 2. Options confort+ -->
    <div v-if="comfortOptions.length > 0" class="bg-[#e8dfd5] rounded-lg p-5 border border-gray-200 shadow-sm">
      <h3 class="text-base font-semibold text-gray-800 mb-4">Options confort+</h3>
      <div class="space-y-3">
        <div
          v-for="option in comfortOptions"
          :key="option.id"
          class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition cursor-pointer"
          @click="toggleOption(option.id)"
        >
          <img
            :src="option.image"
            :alt="option.name"
            class="w-16 h-16 object-cover rounded flex-shrink-0"
          />
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-800 leading-tight">{{ option.name }}</p>
            <p class="text-sm text-gray-600 mt-1">
              <span class="font-semibold">{{ formatPrice(option.price) }}</span>
              <span v-if="option.priceUnit">{{ option.priceUnit }}</span>
            </p>
          </div>
          <input
            type="checkbox"
            :checked="isOptionSelected(option.id)"
            class="w-5 h-5 flex-shrink-0 accent-[#1c5d78] cursor-pointer"
            @click.stop
          />
        </div>
      </div>
    </div>

    <!-- 3. Vin & confiseries -->
    <div v-if="wineOptions.length > 0" class="bg-[#e8dfd5] rounded-lg p-5 border border-gray-200 shadow-sm">
      <h3 class="text-base font-semibold text-gray-800 mb-4">Vin & confiseries</h3>
      <div class="space-y-3">
        <div
          v-for="option in wineOptions"
          :key="option.id"
          class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition cursor-pointer"
          @click="toggleOption(option.id)"
        >
          <img
            :src="option.image"
            :alt="option.name"
            class="w-16 h-16 object-cover rounded flex-shrink-0"
          />
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-800 leading-tight">{{ option.name }}</p>
            <p class="text-sm font-semibold text-gray-800 mt-1">{{ formatPrice(option.price) }}</p>
          </div>
          <input
            type="checkbox"
            :checked="isOptionSelected(option.id)"
            class="w-5 h-5 flex-shrink-0 accent-[#1c5d78] cursor-pointer"
            @click.stop
          />
        </div>
      </div>
    </div>

    <!-- 4. Tarif -->
    <div class="bg-[#e8dfd5] rounded-lg p-5 border border-gray-200 shadow-sm">
      <h3 class="text-base font-semibold text-gray-800 mb-4">Tarif</h3>
      <div class="space-y-3">
        <div
          v-for="rate in rates"
          :key="rate.id"
          class="p-4 rounded-lg border-2 transition cursor-pointer"
          :class="selectedRate === rate.id ? 'border-[#1c5d78] bg-[#f0ebe3]' : 'border-gray-200 bg-white hover:border-gray-300'"
          @click="selectedRate = rate.id"
        >
          <div class="flex items-start justify-between gap-3 mb-2">
            <div class="flex-1">
              <p class="text-sm font-semibold text-gray-800 mb-1">{{ rate.name }}</p>
              <p class="text-xs text-gray-600 leading-relaxed">{{ rate.description }}</p>
            </div>
            <input
              type="radio"
              :value="rate.id"
              v-model="selectedRate"
              class="w-5 h-5 mt-0.5 flex-shrink-0 accent-[#1c5d78] cursor-pointer"
              @click.stop
            />
          </div>
          <p class="text-base font-bold text-gray-800 mt-2">
            {{ formatPrice(rate.pricePerNight) }}
            <span class="text-sm font-normal text-gray-600">/nuit</span>
          </p>
        </div>
      </div>
    </div>

    <!-- 5. Résumé -->
    <div class="bg-[#e8dfd5] rounded-lg p-5 border border-gray-200 shadow-sm">
      <h3 class="text-base font-semibold text-gray-800 mb-4">Résumé</h3>
      
      <div class="space-y-3 mb-4">
        <div class="flex justify-between items-baseline">
          <div>
            <span class="text-2xl font-bold text-gray-800">{{ formatPrice(pricePerNight) }}</span>
            <span class="text-sm text-gray-600">/nuit</span>
          </div>
          <span class="text-xl font-bold text-gray-800">{{ formatPrice(totalPrice) }}</span>
        </div>
        <div class="text-sm text-gray-600">{{ nightCount }} nuits</div>
      </div>

      <!-- Code promo -->
      <div class="space-y-2 mb-5">
        <label class="text-sm font-medium text-gray-700">Code promo</label>
        <div class="flex gap-2">
          <input
            type="text"
            v-model="promoCodeInput"
            class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1c5d78] transition"
            placeholder="Entrez votre code"
          />
          <button
            @click="applyPromoCode"
            class="px-4 py-2 bg-[#1c5d78] text-white rounded-lg text-sm font-medium hover:bg-[#154a5f] transition"
          >
            Appliquer
          </button>
        </div>
      </div>

      <!-- Suivant button -->
      <button
        @click="handleNext"
        class="w-full py-3 bg-white text-gray-800 rounded-lg text-base font-semibold border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition"
      >
        Suivant
      </button>
    </div>

  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { format } from 'date-fns'
import { fr } from 'date-fns/locale'
import DatePicker from '@/components/common/DatePicker.vue'

interface AddOn {
  id: number
  name: string
  price: number
  priceUnit?: string
  image: string
  category: 'comfort' | 'wine'
}

interface Rate {
  id: number
  name: string
  description: string
  pricePerNight: number
}

interface Props {
  apartmentName: string
  checkIn: Date
  checkOut: Date
  maxCapacity: number
  comfortOptions?: AddOn[]
  wineOptions?: AddOn[]
  rates: Rate[]
  basePrice: number
}

const props = withDefaults(defineProps<Props>(), {
  comfortOptions: () => [],
  wineOptions: () => []
})

const emit = defineEmits<{
  next: []
  'update:guests': [value: { adults: number; children: number }]
  'update:selectedOptions': [value: number[]]
  'update:selectedRate': [value: number]
  'apply-promo': [code: string]
  'update:dates': [value: { checkIn: Date; checkOut: Date }]
}>()

const adults = ref(2)
const children = ref(0)
const selectedOptions = ref<number[]>([])
const selectedRate = ref(props.rates[0]?.id || 1)
const promoCodeInput = ref('')
const showDatePicker = ref(false)
const tempCheckIn = ref<Date>(props.checkIn)
const tempCheckOut = ref<Date>(props.checkOut)

const nightCount = computed(() => {
  const diffTime = Math.abs(props.checkOut.getTime() - props.checkIn.getTime())
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  return diffDays
})

function handleDatePickerUpdate(start: Date | null, end: Date | null) {
  if (start && end) {
    emit('update:dates', {
      checkIn: start,
      checkOut: end
    })
  }
}

const pricePerNight = computed(() => {
  const rate = props.rates.find((r) => r.id === selectedRate.value)
  return rate?.pricePerNight || props.basePrice
})

const optionsTotal = computed(() => {
  return selectedOptions.value.reduce((sum, optionId) => {
    const option = [...props.comfortOptions, ...props.wineOptions].find((o) => o.id === optionId) || null
    if (!option) return sum

    if (option.priceUnit?.includes('/nuit')) {
      return sum + option.price * nightCount.value
    }
    return sum + option.price
  }, 0)
})

const totalPrice = computed(() => {
  return pricePerNight.value * nightCount.value + optionsTotal.value
})

function formatDate(date: Date): string {
  return format(date, 'dd MMM yyyy', { locale: fr })
}

function formatPrice(price: number): string {
  return `${price.toFixed(2)}€`
}

function incrementAdults() {
  if (adults.value + children.value < props.maxCapacity) {
    adults.value++
    emitGuestsUpdate()
  }
}

function decrementAdults() {
  if (adults.value > 1) {
    adults.value--
    emitGuestsUpdate()
  }
}

function incrementChildren() {
  if (adults.value + children.value < props.maxCapacity) {
    children.value++
    emitGuestsUpdate()
  }
}

function decrementChildren() {
  if (children.value > 0) {
    children.value--
    emitGuestsUpdate()
  }
}

function emitGuestsUpdate() {
  emit('update:guests', { adults: adults.value, children: children.value })
}

function isOptionSelected(optionId: number): boolean {
  return selectedOptions.value.includes(optionId)
}

function toggleOption(optionId: number) {
  const index = selectedOptions.value.indexOf(optionId)
  if (index > -1) {
    selectedOptions.value.splice(index, 1)
  } else {
    selectedOptions.value.push(optionId)
  }
  emit('update:selectedOptions', selectedOptions.value)
}

function applyPromoCode() {
  if (promoCodeInput.value.trim()) {
    emit('apply-promo', promoCodeInput.value.trim())
  }
}

function handleNext() {
  emit('next')
}

// Watch for rate changes
watch(selectedRate, (newRate) => {
  emit('update:selectedRate', newRate)
})

// Watch for props changes to update temp dates
watch(() => props.checkIn, (newCheckIn) => {
  tempCheckIn.value = newCheckIn
})

watch(() => props.checkOut, (newCheckOut) => {
  tempCheckOut.value = newCheckOut
})
</script>
