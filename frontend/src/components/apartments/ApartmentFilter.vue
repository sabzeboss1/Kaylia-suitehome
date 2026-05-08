<template>
  <div class="hero-gradient border-b-2 border-stone-200">
    <!-- Mobile Layout -->
    <div class="md:hidden px-4 py-6">
      <!-- Title Section -->
      <div class="text-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-900 mb-3">
          <span class="text-3xl">{{ availableCount }}</span>
          <span class="italic text-[#0b6087]"> appartements</span>
          <span> disponibles</span>
        </h1>
        <p class="text-base text-gray-600">
          Retrouvez nos appartements disponibles par rapport à vos dates de séjour.
        </p>
      </div>

      <!-- Filters Toggle Button -->
      <button 
        @click="showFilters = !showFilters"
        class="w-full bg-[#0b6087] hover:bg-[#094d6b] text-white font-medium px-6 py-3 rounded-lg transition-all duration-300 flex items-center justify-center gap-2 mb-4"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
        </svg>
        <span>{{ showFilters ? 'Masquer les filtres' : 'Afficher les filtres' }}</span>
      </button>

      <!-- Filters Panel (collapsible) -->
      <div v-if="showFilters" class="space-y-3 animate-fade-in">
        <!-- Guest Count Selector -->
        <div class="relative">
          <select 
            v-model="filters.guests"
            @change="applyFilters"
            class="appearance-none w-full bg-white border-2 border-stone-300 rounded-lg px-4 py-3 pr-10 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors cursor-pointer"
          >
            <option :value="null">Nombre de personne</option>
            <option v-for="option in guestOptions" :key="option.value" :value="option.value">
              {{ option.label }}
            </option>
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

    <!-- Desktop Layout -->
    <div class="hidden md:block max-w-7xl mx-auto px-8 py-16">
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
      <div class="mt-12 flex items-stretch overflow-hidden rounded-lg shadow-md animate-fade-in-up stagger-1">
        <!-- Guest Count Selector -->
        <div class="relative flex-1 border-r border-stone-300">
          <select 
            v-model="filters.guests"
            @change="applyFilters"
            class="appearance-none w-full h-full bg-white px-6 py-3 pr-10 text-gray-700 focus:outline-none focus:bg-gray-50 transition-colors cursor-pointer border-0"
          >
            <option :value="null">Nombre de personne</option>
            <option v-for="option in guestOptions" :key="option.value" :value="option.value">
              {{ option.label }}
            </option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        </div>

        <!-- Room Count Selector -->
        <div class="relative flex-1 border-r border-stone-300">
          <select 
            v-model="filters.bedrooms"
            @change="applyFilters"
            class="appearance-none w-full h-full bg-white px-6 py-3 pr-10 text-gray-700 focus:outline-none focus:bg-gray-50 transition-colors cursor-pointer border-0"
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
        <div class="relative flex-1 border-r border-stone-300">
          <button
            type="button"
            @click="showDatePicker = true"
            class="w-full h-full bg-white px-6 py-3 text-gray-700 focus:outline-none focus:bg-gray-50 transition-colors cursor-pointer text-left flex items-center justify-between" 
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
          class="bg-[#0b6087] hover:bg-[#094d6b] text-white font-semibold px-8 py-3 transition-all duration-300 flex items-center justify-center"
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
import { useRoute, useRouter } from 'vue-router'
import { useApartmentsStore } from '@/stores/apartments'
import { useApartments } from '@/composables/useApartments'
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
const router = useRouter()
const apartmentsStore = useApartmentsStore()
const { fetchApartments, apartments } = useApartments()

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
const maxCapacity = ref(6) // Valeur par défaut

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

// Générer dynamiquement les options de nombre de personnes
const guestOptions = computed(() => {
  const options = []
  for (let i = 1; i <= maxCapacity.value; i++) {
    options.push({
      value: i,
      label: i === 1 ? '1 personne' : `${i} personnes`
    })
  }
  return options
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
  
  // Update URL with new search params
  const query: Record<string, string> = {}
  
  if (filters.value.guests) {
    query.guests = filters.value.guests.toString()
  }
  
  if (filters.value.checkIn) {
    query.checkIn = filters.value.checkIn
  }
  
  if (filters.value.checkOut) {
    query.checkOut = filters.value.checkOut
  }
  
  // Navigate to update URL and trigger search
  router.push({
    path: route.path,
    query
  })
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
onMounted(async () => {
  // Récupérer la capacité maximale des appartements
  try {
    await fetchApartments()
    if (apartments.value.length > 0) {
      maxCapacity.value = Math.max(...apartments.value.map(apt => apt.capacity))
    }
  } catch (error) {
    console.error('Erreur lors du chargement des capacités:', error)
  }
  
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
