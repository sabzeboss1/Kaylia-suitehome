<template>
  <div class="hero-gradient border-b-2 border-stone-200">
    <!-- Mobile Layout -->
    <div class="md:hidden px-4 py-6">
      <!-- Info Grid 2x2 -->
      <div class="grid grid-cols-2 gap-3 mb-6">
        <!-- Location -->
        <div class="flex items-center gap-2 bg-white rounded-lg p-3 border border-gray-200">
          <div class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
          <span class="text-xs text-gray-700">Quartier Jouvence, Yaoundé</span>
        </div>

        <!-- Apartments Count -->
        <div class="flex items-center gap-2 bg-white rounded-lg p-3 border border-gray-200">
          <div class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <span class="text-xs text-gray-700">7 appartements</span>
        </div>

        <!-- Capacity -->
        <div class="flex items-center gap-2 bg-white rounded-lg p-3 border border-gray-200">
          <div class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </div>
          <span class="text-xs text-gray-700">1 à 4 personnes</span>
        </div>

        <!-- Apartment Types -->
        <div class="flex items-center gap-2 bg-white rounded-lg p-3 border border-gray-200">
          <div class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
          </div>
          <span class="text-xs text-gray-700">du T1 au T3</span>
        </div>
      </div>

      <!-- Personalize Button -->
      <button 
        @click="showFilters = !showFilters"
        class="w-full bg-[#b8a088] hover:bg-[#a89078] text-white font-medium px-6 py-4 rounded-lg transition-all duration-300 flex items-center justify-between mb-8"
      >
        <span>Personnalisez votre séjour</span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
        </svg>
      </button>

      <!-- Title Section -->
      <div class="text-center">
        <h1 class="text-3xl font-semibold text-gray-900 mb-3">
          <span class="text-3xl">{{ availableCount }}</span>
          <span class="italic text-[#0b6087]"> appartements</span>
          <span> disponibles</span>
        </h1>
        <p class="text-base text-gray-600">
          Retrouvez nos appartements disponibles par rapport à vos dates de séjour.
        </p>
      </div>

      <!-- Filters Panel (collapsible) -->
      <div v-if="showFilters" class="mt-6 space-y-3 animate-fade-in">
        <!-- Guest Count Selector -->
        <div class="relative">
          <select 
            v-model="filters.guests"
            @change="applyFilters"
            class="appearance-none w-full bg-white border-2 border-stone-300 rounded-lg px-4 py-3 pr-10 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors cursor-pointer"
          >
            <option :value="null">Nombre de personne</option>
            <option :value="1">1 personne</option>
            <option :value="2">2 personnes</option>
            <option :value="3">3 personnes</option>
            <option :value="4">4 personnes</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        </div>

        <!-- Room Count Selector -->
        <div class="relative">
          <select 
            v-model="filters.bedrooms"
            @change="applyFilters"
            class="appearance-none w-full bg-white border-2 border-stone-300 rounded-lg px-4 py-3 pr-10 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors cursor-pointer"
          >
            <option :value="null">Nombre de chambre</option>
            <option value="studio">Studio</option>
            <option :value="1">1 chambre</option>
            <option :value="2">2 chambres</option>
            <option :value="3">3 chambres</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        </div>

        <!-- Date Range Picker -->
        <div class="relative">
          <button
            type="button"
            @click="showDatePicker = true"
            class="w-full bg-white border-2 border-stone-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors cursor-pointer text-left flex items-center justify-between" 
          >
            <span class="text-sm">{{ dateRangeDisplay || 'Sélectionner les dates' }}</span>
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Desktop Layout (unchanged) -->
    <div class="hidden md:block max-w-7xl mx-auto px-6 py-16">
      <div class="text-center animate-fade-in-up">
        <h1 class="text-[32px] leading-[24px] font-semibold text-gray-900 mb-4 space-x-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
          <span class="text-[32px]">{{ availableCount }}</span>
          <span class="italic" style="color: #0b6087;">appartements</span>
          <span>disponibles</span>
        </h1>
        <p class="text-[24px] leading-[24px] font-light text-gray-600 max-w-2xl mx-auto whitespace-nowrap" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
          Retrouvez nos appartements disponibles par rapport à vos dates de séjour.
        </p>
      </div>

      <!-- Filter Section -->
      <div class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-4 animate-fade-in-up stagger-1">
        <!-- Guest Count Selector -->
        <div class="relative">
          <select 
            v-model="filters.guests"
            @change="applyFilters"
            class="appearance-none w-full bg-white border-2 border-stone-300 rounded-lg px-6 py-3 pr-10 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors cursor-pointer"
          >
            <option :value="null">Nombre de personne</option>
            <option :value="1">1 personne</option>
            <option :value="2">2 personnes</option>
            <option :value="3">3 personnes</option>
            <option :value="4">4 personnes</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        </div>

        <!-- Room Count Selector -->
        <div class="relative">
          <select 
            v-model="filters.bedrooms"
            @change="applyFilters"
            class="appearance-none w-full bg-white border-2 border-stone-300 rounded-lg px-6 py-3 pr-10 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors cursor-pointer"
          >
            <option :value="null">Nombre de chambre</option>
            <option value="studio">Studio</option>
            <option :value="1">1 chambre</option>
            <option :value="2">2 chambres</option>
            <option :value="3">3 chambres</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        </div>

        <!-- Date Range Picker -->
        <div class="relative">
          <button
            type="button"
            @click="showDatePicker = true"
            class="w-full bg-white border-2 border-stone-300 rounded-lg px-6 py-3 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors cursor-pointer text-left flex items-center justify-between" 
          >
            <span>{{ dateRangeDisplay || 'Sélectionner les dates' }}</span>
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </button>
        </div>

        <!-- Reserve Button -->
        <button 
          @click="handleReserve"
          class="w-full bg-[#0b6087] hover:bg-[#094d6b] text-white font-semibold px-8 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg"
        >
          Réserver
        </button>
      </div>
    </div>
  </div>
  
  <!-- DatePicker Modal -->
  <DatePicker 
    v-model="showDatePicker" 
    :start-date="startDate" 
    :end-date="endDate" 
    @update:dates="handleDateUpdate" 
  />
</template>

<script setup lang="ts">
import { ref, computed, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useApartmentsStore } from '@/stores/apartments'
import DatePicker from '@/components/common/DatePicker.vue'

interface FilterParams {
  guests: number | null
  bedrooms: number | string | null
  checkIn: string | null
  checkOut: string | null
}

interface SearchResult {
  apartments: any[]
  total: number
  currentPage: number
  lastPage: number
  filtersApplied: Record<string, any>
}

interface SearchParams {
  checkIn?: string
  checkOut?: string
  guests?: number
  minPrice?: number
  maxPrice?: number
  type?: 'studio' | 't2' | 't3'
}

// Props
const props = defineProps<{
  searchResults?: SearchResult | null
  searchParams?: SearchParams
}>()

const route = useRoute()
const apartmentsStore = useApartmentsStore()

// Filter state
const filters = ref<FilterParams>({
  guests: null,
  bedrooms: null,
  checkIn: null,
  checkOut: null
})

const showDatePicker = ref(false)
const showFilters = ref(false)
const startDate = ref<Date | null>(null)
const endDate = ref<Date | null>(null)

// Computed properties
const availableCount = computed(() => {
  // Use search results if available, otherwise use store
  if (props.searchResults) {
    return props.searchResults.total
  }
  return apartmentsStore.filteredApartments.length
})

const dateRangeDisplay = computed(() => {
  if (startDate.value && endDate.value) {
    const start = startDate.value.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' })
    const end = endDate.value.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' })
    return `${start} - ${end}`
  }
  return ''
})

// Methods
const handleDateUpdate = (start: Date | null, end: Date | null) => {
  startDate.value = start
  endDate.value = end
  
  if (start && end) {
    const checkInStr = start.toISOString().split('T')[0]
    const checkOutStr = end.toISOString().split('T')[0]
    filters.value.checkIn = checkInStr || null
    filters.value.checkOut = checkOutStr || null
  } else {
    filters.value.checkIn = null
    filters.value.checkOut = null
  }
  
  applyFilters()
  showDatePicker.value = false
}

const applyFilters = () => {
  apartmentsStore.setFilters(filters.value)
}

const handleReserve = () => {
  // Navigate to booking page or trigger booking flow
  console.log('Reserve clicked with filters:', filters.value)
}

// Watch for filter changes and apply them
watch(filters, () => {
  applyFilters()
}, { deep: true })

// Initialize filters from query params on mount
onMounted(() => {
  // Set guests from query params
  if (route.query.guests) {
    filters.value.guests = parseInt(route.query.guests as string)
  }
  
  // Set dates from query params
  const checkInQuery = route.query.checkIn
  const checkOutQuery = route.query.checkOut
  
  if (checkInQuery && checkOutQuery && typeof checkInQuery === 'string' && typeof checkOutQuery === 'string') {
    const checkInDate = new Date(checkInQuery)
    const checkOutDate = new Date(checkOutQuery)
    
    startDate.value = checkInDate
    endDate.value = checkOutDate
    filters.value.checkIn = checkInQuery
    filters.value.checkOut = checkOutQuery
  }
  
  // Apply filters if any were set
  if (filters.value.guests || filters.value.checkIn || filters.value.checkOut) {
    applyFilters()
  }
})
</script>

<style scoped>
.hero-gradient {
  background: linear-gradient(to bottom, #f9fafb 0%, #ffffff 100%);
}

.animate-fade-in-up {
  animation: fadeInUp 0.6s ease-out;
}

.stagger-1 {
  animation-delay: 0.2s;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.font-display {
  font-family: 'Cormorant Garamond', serif;
}
</style>
