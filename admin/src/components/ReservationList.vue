<template>
  <div class="space-y-6">
    <!-- Filters and Search -->
    <div class="card card-body">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <!-- Search -->
        <div>
          <label class="input-label">Search</label>
          <input
            v-model="filters.search"
            type="text"
            placeholder="Customer name or ID..."
            class="input"
            @input="debouncedSearch"
          />
        </div>

        <!-- Status Filter -->
        <div>
          <label class="input-label">Status</label>
          <select
            v-model="filters.status"
            class="input"
            @change="fetchReservations"
          >
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
            <option value="completed">Completed</option>
          </select>
        </div>

        <!-- Payment Status Filter -->
        <div>
          <label class="input-label">Payment Status</label>
          <select
            v-model="filters.payment_status"
            class="input"
            @change="fetchReservations"
          >
            <option value="">All Payment Statuses</option>
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>
            <option value="refunded">Refunded</option>
          </select>
        </div>

        <!-- Apartment Filter -->
        <div>
          <label class="input-label">Apartment</label>
          <select
            v-model="filters.apartment_id"
            class="input"
            @change="fetchReservations"
          >
            <option value="">All Apartments</option>
            <option v-for="apt in apartments" :key="apt.id" :value="apt.id">
              {{ apt.name }}
            </option>
          </select>
        </div>
      </div>

      <!-- Date Range Filter -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="input-label">From Date</label>
          <input
            v-model="filters.date_from"
            type="date"
            class="input"
            @change="fetchReservations"
          />
        </div>
        <div>
          <label class="input-label">To Date</label>
          <input
            v-model="filters.date_to"
            type="date"
            class="input"
            @change="fetchReservations"
          />
        </div>
      </div>

      <!-- Export Button -->
      <div class="mt-4 flex justify-end">
        <button
          @click="exportReservations"
          class="btn btn-primary"
          :disabled="loading"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
          Export CSV
        </button>
      </div>
    </div>

    <!-- Reservations Table -->
    <div class="card overflow-hidden">
      <div v-if="loading" class="p-8 text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
        <p class="mt-2 text-navy-400 text-sm">Chargement des réservations...</p>
      </div>

      <div v-else-if="error" class="p-8 text-center text-red-600">
        {{ error }}
      </div>

      <div v-else-if="reservations.length === 0" class="p-8 text-center text-gray-600">
        No reservations found
      </div>

      <div v-else class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="table-header">
            <tr>
              <th>ID</th>
              <th>Client</th>
              <th>Appartement</th>
              <th>Dates</th>
              <th>Prix</th>
              <th>Statut</th>
              <th>Paiement</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="reservation in reservations" :key="reservation.id" class="table-row">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                #{{ reservation.id }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                  {{ reservation.customer.first_name }} {{ reservation.customer.last_name }}
                </div>
                <div class="text-sm text-gray-500">{{ reservation.customer.email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ reservation.apartment.name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                <div>{{ formatDate(reservation.check_in_date) }}</div>
                <div class="text-gray-500">to {{ formatDate(reservation.check_out_date) }}</div>
                <div class="text-xs text-gray-400">{{ reservation.total_nights }} nights</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                €{{ reservation.total_price }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(reservation.status)">
                  {{ reservation.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getPaymentStatusClass(reservation.payment_status)">
                  {{ reservation.payment_status }}
                </span>
              </td>
              <td>
                <button
                  @click="$emit('view-details', reservation.id)"
                  class="btn btn-ghost btn-sm"
                >
                  Voir
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.total > 0" class="px-6 py-4 flex items-center justify-between border-t border-surface-100">
        <div class="text-xs text-navy-400">
          {{ pagination.from }} à {{ pagination.to }} sur {{ pagination.total }} résultats
        </div>
        <div class="flex gap-1">
          <button
            @click="changePage(pagination.current_page - 1)"
            :disabled="pagination.current_page === 1"
            class="btn btn-outline btn-sm"
          >Préc.</button>
          <button
            v-for="page in visiblePages"
            :key="page"
            @click="changePage(page)"
            :class="[
              'btn btn-sm',
              page === pagination.current_page
                ? 'btn-primary'
                : 'btn-outline'
            ]"
          >{{ page }}</button>
          <button
            @click="changePage(pagination.current_page + 1)"
            :disabled="pagination.current_page === pagination.last_page"
            class="btn btn-outline btn-sm"
          >Suiv.</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import apiClient from '../api/axios'

const emit = defineEmits(['view-details'])

const reservations = ref([])
const apartments = ref([])
const loading = ref(false)
const error = ref(null)

const filters = ref({
  search: '',
  status: '',
  payment_status: '',
  apartment_id: '',
  date_from: '',
  date_to: ''
})

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
  from: 0,
  to: 0
})

let searchTimeout = null

const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchReservations()
  }, 500)
}

const fetchReservations = async () => {
  loading.value = true
  error.value = null

  try {
    const params = {
      page: pagination.value.current_page,
      per_page: pagination.value.per_page,
      ...filters.value
    }

    // Remove empty filters
    Object.keys(params).forEach(key => {
      if (params[key] === '' || params[key] === null) {
        delete params[key]
      }
    })

    const response = await apiClient.get('/reservations', { params })
    
    reservations.value = response.data.data
    pagination.value = {
      current_page: response.data.meta.current_page,
      last_page: response.data.meta.last_page,
      per_page: response.data.meta.per_page,
      total: response.data.meta.total,
      from: response.data.meta.from || 0,
      to: response.data.meta.to || 0
    }
  } catch (err) {
    error.value = err.response?.data?.error?.message || 'Failed to load reservations'
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

const changePage = (page) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    pagination.value.current_page = page
    fetchReservations()
  }
}

const visiblePages = computed(() => {
  const pages = []
  const current = pagination.value.current_page
  const last = pagination.value.last_page
  
  let start = Math.max(1, current - 2)
  let end = Math.min(last, current + 2)
  
  for (let i = start; i <= end; i++) {
    pages.push(i)
  }
  
  return pages
})

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
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

const getPaymentStatusClass = (status) => {
  const classes = {
    pending: 'px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800',
    paid: 'px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800',
    refunded: 'px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800'
  }
  return classes[status] || 'px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800'
}

const exportReservations = async () => {
  try {
    const params = { ...filters.value }
    
    // Remove empty filters
    Object.keys(params).forEach(key => {
      if (params[key] === '' || params[key] === null) {
        delete params[key]
      }
    })

    const response = await apiClient.get('/reservations/export', {
      params,
      responseType: 'blob'
    })

    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', `reservations-${new Date().toISOString().split('T')[0]}.csv`)
    document.body.appendChild(link)
    link.click()
    link.remove()
  } catch (err) {
    console.error('Export failed:', err)
    alert('Failed to export reservations')
  }
}

onMounted(() => {
  fetchReservations()
  fetchApartments()
})
</script>
