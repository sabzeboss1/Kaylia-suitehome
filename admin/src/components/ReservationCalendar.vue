<template>
  <div class="space-y-6">
    <!-- Calendar Controls -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <!-- Month Navigation -->
        <div class="flex items-center space-x-4">
          <button
            @click="previousMonth"
            class="p-2 rounded-lg hover:bg-gray-100 transition-colors"
          >
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <h2 class="text-xl font-semibold text-gray-800">
            {{ currentMonthName }} {{ currentYear }}
          </h2>
          <button
            @click="nextMonth"
            class="p-2 rounded-lg hover:bg-gray-100 transition-colors"
          >
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
          <button
            @click="goToToday"
            class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          >
            Today
          </button>
        </div>

        <!-- Apartment Filter -->
        <div class="w-full md:w-64">
          <select
            v-model="selectedApartmentId"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            @change="fetchReservations"
          >
            <option value="">All Apartments</option>
            <option v-for="apt in apartments" :key="apt.id" :value="apt.id">
              {{ apt.name }}
            </option>
          </select>
        </div>
      </div>

      <!-- Legend -->
      <div class="mt-4 flex flex-wrap gap-4 text-sm">
        <div class="flex items-center">
          <div class="w-4 h-4 bg-yellow-200 border border-yellow-400 rounded mr-2"></div>
          <span class="text-gray-600">Pending</span>
        </div>
        <div class="flex items-center">
          <div class="w-4 h-4 bg-green-200 border border-green-400 rounded mr-2"></div>
          <span class="text-gray-600">Confirmed</span>
        </div>
        <div class="flex items-center">
          <div class="w-4 h-4 bg-blue-200 border border-blue-400 rounded mr-2"></div>
          <span class="text-gray-600">Completed</span>
        </div>
        <div class="flex items-center">
          <div class="w-4 h-4 bg-red-200 border border-red-400 rounded mr-2"></div>
          <span class="text-gray-600">Cancelled</span>
        </div>
      </div>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div v-if="loading" class="p-8 text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <p class="mt-2 text-gray-600">Loading calendar...</p>
      </div>

      <div v-else class="p-6">
        <!-- Day Headers -->
        <div class="grid grid-cols-7 gap-2 mb-2">
          <div
            v-for="day in dayNames"
            :key="day"
            class="text-center text-sm font-semibold text-gray-600 py-2"
          >
            {{ day }}
          </div>
        </div>

        <!-- Calendar Days -->
        <div class="grid grid-cols-7 gap-2">
          <div
            v-for="(day, index) in calendarDays"
            :key="index"
            :class="[
              'min-h-24 p-2 border rounded-lg transition-colors',
              day.isCurrentMonth ? 'bg-white' : 'bg-gray-50',
              day.isToday ? 'border-blue-500 border-2' : 'border-gray-200',
              day.reservations.length > 0 ? 'cursor-pointer hover:bg-gray-50' : ''
            ]"
            @click="day.reservations.length > 0 && showDayReservations(day)"
          >
            <div class="text-sm font-medium" :class="day.isCurrentMonth ? 'text-gray-900' : 'text-gray-400'">
              {{ day.date.getDate() }}
            </div>
            
            <!-- Reservation Indicators -->
            <div class="mt-1 space-y-1">
              <div
                v-for="reservation in day.reservations.slice(0, 3)"
                :key="reservation.id"
                :class="getReservationClass(reservation.status)"
                class="text-xs px-1 py-0.5 rounded truncate"
                :title="`${reservation.customer.first_name} ${reservation.customer.last_name} - ${reservation.apartment.name}`"
              >
                {{ reservation.apartment.name }}
              </div>
              <div
                v-if="day.reservations.length > 3"
                class="text-xs text-gray-500 px-1"
              >
                +{{ day.reservations.length - 3 }} more
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Day Reservations Modal -->
    <div
      v-if="showDayModal"
      class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
      @click="showDayModal = false"
    >
      <div
        class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white"
        @click.stop
      >
        <div class="flex justify-between items-start mb-4">
          <h3 class="text-lg font-semibold text-gray-900">
            Reservations for {{ selectedDay ? formatDate(selectedDay.date) : '' }}
          </h3>
          <button
            @click="showDayModal = false"
            class="text-gray-400 hover:text-gray-600"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="space-y-3 max-h-96 overflow-y-auto">
          <div
            v-for="reservation in selectedDay?.reservations || []"
            :key="reservation.id"
            class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
            @click="viewReservationDetails(reservation.id)"
          >
            <div class="flex justify-between items-start">
              <div>
                <div class="font-medium text-gray-900">
                  {{ reservation.customer.first_name }} {{ reservation.customer.last_name }}
                </div>
                <div class="text-sm text-gray-600">{{ reservation.apartment.name }}</div>
                <div class="text-sm text-gray-500 mt-1">
                  {{ formatDate(reservation.check_in_date) }} - {{ formatDate(reservation.check_out_date) }}
                </div>
              </div>
              <div class="flex flex-col items-end space-y-1">
                <span :class="getStatusClass(reservation.status)">
                  {{ reservation.status }}
                </span>
                <span class="text-sm font-medium text-gray-900">
                  €{{ reservation.total_price }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import apiClient from '../api/axios'

const emit = defineEmits(['view-reservation'])

const currentDate = ref(new Date())
const reservations = ref([])
const apartments = ref([])
const selectedApartmentId = ref('')
const loading = ref(false)
const showDayModal = ref(false)
const selectedDay = ref(null)

const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']

const currentYear = computed(() => currentDate.value.getFullYear())
const currentMonth = computed(() => currentDate.value.getMonth())

const currentMonthName = computed(() => {
  return currentDate.value.toLocaleDateString('en-US', { month: 'long' })
})

const calendarDays = computed(() => {
  const year = currentYear.value
  const month = currentMonth.value
  
  const firstDay = new Date(year, month, 1)
  const lastDay = new Date(year, month + 1, 0)
  const daysInMonth = lastDay.getDate()
  
  const startingDayOfWeek = firstDay.getDay()
  const days = []
  
  // Previous month days
  const prevMonthLastDay = new Date(year, month, 0).getDate()
  for (let i = startingDayOfWeek - 1; i >= 0; i--) {
    const date = new Date(year, month - 1, prevMonthLastDay - i)
    days.push({
      date,
      isCurrentMonth: false,
      isToday: false,
      reservations: getReservationsForDate(date)
    })
  }
  
  // Current month days
  const today = new Date()
  today.setHours(0, 0, 0, 0)
  
  for (let day = 1; day <= daysInMonth; day++) {
    const date = new Date(year, month, day)
    days.push({
      date,
      isCurrentMonth: true,
      isToday: date.getTime() === today.getTime(),
      reservations: getReservationsForDate(date)
    })
  }
  
  // Next month days
  const remainingDays = 42 - days.length // 6 rows * 7 days
  for (let day = 1; day <= remainingDays; day++) {
    const date = new Date(year, month + 1, day)
    days.push({
      date,
      isCurrentMonth: false,
      isToday: false,
      reservations: getReservationsForDate(date)
    })
  }
  
  return days
})

const getReservationsForDate = (date) => {
  const dateStr = date.toISOString().split('T')[0]
  return reservations.value.filter(reservation => {
    const checkIn = new Date(reservation.check_in_date)
    const checkOut = new Date(reservation.check_out_date)
    checkIn.setHours(0, 0, 0, 0)
    checkOut.setHours(0, 0, 0, 0)
    date.setHours(0, 0, 0, 0)
    
    return date >= checkIn && date < checkOut
  })
}

const fetchReservations = async () => {
  loading.value = true

  try {
    const startDate = new Date(currentYear.value, currentMonth.value, 1)
    const endDate = new Date(currentYear.value, currentMonth.value + 1, 0)
    
    const params = {
      date_from: startDate.toISOString().split('T')[0],
      date_to: endDate.toISOString().split('T')[0],
      per_page: 1000 // Get all reservations for the month
    }
    
    if (selectedApartmentId.value) {
      params.apartment_id = selectedApartmentId.value
    }

    const response = await apiClient.get('/reservations', { params })
    reservations.value = response.data.data
  } catch (err) {
    console.error('Failed to load reservations:', err)
  } finally {
    loading.value = false
  }
}

const fetchApartments = async () => {
  try {
    const response = await apiClient.get('/apartments')
    apartments.value = response.data.data
  } catch (err) {
    console.error('Failed to load apartments:', err)
  }
}

const previousMonth = () => {
  currentDate.value = new Date(currentYear.value, currentMonth.value - 1, 1)
  fetchReservations()
}

const nextMonth = () => {
  currentDate.value = new Date(currentYear.value, currentMonth.value + 1, 1)
  fetchReservations()
}

const goToToday = () => {
  currentDate.value = new Date()
  fetchReservations()
}

const showDayReservations = (day) => {
  selectedDay.value = day
  showDayModal.value = true
}

const viewReservationDetails = (reservationId) => {
  showDayModal.value = false
  emit('view-reservation', reservationId)
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
}

const getReservationClass = (status) => {
  const classes = {
    pending: 'bg-yellow-200 text-yellow-800 border border-yellow-400',
    confirmed: 'bg-green-200 text-green-800 border border-green-400',
    cancelled: 'bg-red-200 text-red-800 border border-red-400',
    completed: 'bg-blue-200 text-blue-800 border border-blue-400'
  }
  return classes[status] || 'bg-gray-200 text-gray-800 border border-gray-400'
}

const getStatusClass = (status) => {
  const classes = {
    pending: 'px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800',
    confirmed: 'px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800',
    cancelled: 'px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800',
    completed: 'px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800'
  }
  return classes[status] || 'px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800'
}

onMounted(() => {
  fetchReservations()
  fetchApartments()
})
</script>
