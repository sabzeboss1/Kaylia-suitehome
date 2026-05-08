<template>
  <div v-if="loading" class="p-8 text-center">
    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
    <p class="mt-2 text-gray-600">Loading reservation details...</p>
  </div>

  <div v-else-if="error" class="p-8 text-center text-red-600">
    {{ error }}
  </div>

  <div v-else-if="reservation" class="space-y-6">
    <!-- Header with Actions -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex justify-between items-start mb-4">
        <div>
          <h2 class="text-2xl font-bold text-gray-800">Reservation #{{ reservation.id }}</h2>
          <p class="text-gray-600 mt-1">Created {{ formatDateTime(reservation.created_at) }}</p>
        </div>
        <div class="flex space-x-2">
          <span :class="getStatusClass(reservation.status)">
            {{ reservation.status }}
          </span>
          <span :class="getPaymentStatusClass(reservation.payment_status)">
            {{ reservation.payment_status }}
          </span>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-wrap gap-2">
        <button
          v-if="reservation.status === 'pending'"
          @click="updateStatus('confirmed')"
          class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
        >
          Confirmer
        </button>
        <button
          v-if="['pending', 'confirmed'].includes(reservation.status)"
          @click="updateStatus('cancelled')"
          class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
        >
          Annuler
        </button>
        <button
          v-if="['confirmed'].includes(reservation.status)"
          @click="markAsOccupied"
          class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
        >
          Marquer Occupé
        </button>
        <button
          v-if="reservation.payment_status === 'pending'"
          @click="markAsPaid"
          class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
        >
          Marquer Payé
        </button>
        <button
          @click="sendConfirmationEmail"
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
        >
          Envoyer Email
        </button>
        <button
          @click="downloadInvoice"
          class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
        >
          Télécharger Facture
        </button>
        <button
          v-if="reservation.payment_status === 'paid'"
          @click="processRefund"
          class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors"
        >
          Rembourser
        </button>
      </div>
    </div>

    <!-- Special Requests (Prominent Display) -->
    <div v-if="reservation.special_requests" class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-yellow-800">Special Requests</h3>
          <div class="mt-2 text-sm text-yellow-700">
            {{ reservation.special_requests }}
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Customer Information -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h3>
        <dl class="space-y-3">
          <div>
            <dt class="text-sm font-medium text-gray-500">Name</dt>
            <dd class="mt-1 text-sm text-gray-900">
              {{ reservation.customer.first_name }} {{ reservation.customer.last_name }}
            </dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Email</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ reservation.customer.email }}</dd>
          </div>
          <div v-if="reservation.customer.phone">
            <dt class="text-sm font-medium text-gray-500">Phone</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ reservation.customer.phone }}</dd>
          </div>
          <div v-if="reservation.customer.nationality">
            <dt class="text-sm font-medium text-gray-500">Nationality</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ reservation.customer.nationality }}</dd>
          </div>
        </dl>
      </div>

      <!-- Apartment Details -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Apartment Details</h3>
        <dl class="space-y-3">
          <div>
            <dt class="text-sm font-medium text-gray-500">Apartment</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ reservation.apartment.name }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Type</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ reservation.apartment.type.toUpperCase() }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Check-in</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(reservation.check_in_date) }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Check-out</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(reservation.check_out_date) }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Guests</dt>
            <dd class="mt-1 text-sm text-gray-900">
              {{ reservation.adults }} adults
              <span v-if="reservation.children > 0">, {{ reservation.children }} children</span>
            </dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Total Nights</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ reservation.total_nights }}</dd>
          </div>
        </dl>
      </div>
    </div>

    <!-- Selected Options -->
    <div v-if="reservation.options && reservation.options.length > 0" class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Selected Options</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Option</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="option in reservation.options" :key="option.id">
              <td class="px-4 py-3 text-sm text-gray-900">{{ option.option.name }}</td>
              <td class="px-4 py-3 text-sm text-gray-900">{{ option.quantity }}</td>
              <td class="px-4 py-3 text-sm text-gray-900">€{{ option.unit_price }}</td>
              <td class="px-4 py-3 text-sm font-medium text-gray-900">€{{ option.total_price }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pricing Breakdown -->
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Pricing Breakdown</h3>
      <dl class="space-y-3">
        <div class="flex justify-between">
          <dt class="text-sm text-gray-600">Base Price ({{ reservation.total_nights }} nights)</dt>
          <dd class="text-sm font-medium text-gray-900">€{{ reservation.base_price }}</dd>
        </div>
        <div v-if="reservation.options_price > 0" class="flex justify-between">
          <dt class="text-sm text-gray-600">Options</dt>
          <dd class="text-sm font-medium text-gray-900">€{{ reservation.options_price }}</dd>
        </div>
        <div v-if="reservation.promo_discount > 0" class="flex justify-between text-green-600">
          <dt class="text-sm">Promo Discount ({{ reservation.promo_code }})</dt>
          <dd class="text-sm font-medium">-€{{ reservation.promo_discount }}</dd>
        </div>
        <div class="flex justify-between pt-3 border-t border-gray-200">
          <dt class="text-base font-semibold text-gray-900">Total</dt>
          <dd class="text-base font-bold text-gray-900">€{{ reservation.total_price }}</dd>
        </div>
        <div class="flex justify-between">
          <dt class="text-sm text-gray-600">Pricing Type</dt>
          <dd class="text-sm text-gray-900">{{ reservation.pricing_type.replace('_', ' ') }}</dd>
        </div>
      </dl>
    </div>

    <!-- Payment History -->
    <div v-if="reservation.payments && reservation.payments.length > 0" class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment History</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transaction ID</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="payment in reservation.payments" :key="payment.id">
              <td class="px-4 py-3 text-sm text-gray-900">{{ formatDateTime(payment.created_at) }}</td>
              <td class="px-4 py-3 text-sm text-gray-900">{{ payment.transaction_id }}</td>
              <td class="px-4 py-3 text-sm text-gray-900">{{ payment.payment_method }}</td>
              <td class="px-4 py-3 text-sm font-medium text-gray-900">
                {{ payment.currency }} {{ payment.amount }}
              </td>
              <td class="px-4 py-3 text-sm">
                <span :class="getPaymentStatusClass(payment.status)">
                  {{ payment.status }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Success Message -->
    <div v-if="successMessage" class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm text-green-700">{{ successMessage }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Confirmation Dialog -->
  <div v-if="showConfirmDialog" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="showConfirmDialog = false">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" @click.stop>
      <div class="mt-3 text-center">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Action</h3>
        <div class="mt-2 px-7 py-3">
          <p class="text-sm text-gray-500">{{ confirmMessage }}</p>
        </div>
        <div class="flex justify-center space-x-4 px-4 py-3">
          <button
            @click="confirmAction"
            class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Confirm
          </button>
          <button
            @click="showConfirmDialog = false"
            class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import apiClient from '../api/axios'

const props = defineProps({
  reservationId: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['updated'])

const reservation = ref(null)
const loading = ref(false)
const error = ref(null)
const successMessage = ref('')
const showConfirmDialog = ref(false)
const confirmMessage = ref('')
const pendingAction = ref(null)

const fetchReservation = async () => {
  loading.value = true
  error.value = null

  try {
    const response = await apiClient.get(`/reservations/${props.reservationId}`)
    reservation.value = response.data.data
  } catch (err) {
    error.value = err.response?.data?.error?.message || 'Failed to load reservation'
  } finally {
    loading.value = false
  }
}

const updateStatus = (newStatus) => {
  confirmMessage.value = `Are you sure you want to ${newStatus} this reservation?`
  pendingAction.value = async () => {
    try {
      await apiClient.put(`/reservations/${props.reservationId}`, {
        status: newStatus
      })
      
      successMessage.value = `Reservation ${newStatus} successfully`
      setTimeout(() => { successMessage.value = '' }, 5000)
      
      await fetchReservation()
      emit('updated')
    } catch (err) {
      error.value = err.response?.data?.error?.message || 'Failed to update status'
    }
  }
  showConfirmDialog.value = true
}

const sendConfirmationEmail = async () => {
  try {
    await apiClient.post(`/reservations/${props.reservationId}/send-confirmation`)
    successMessage.value = 'Confirmation email sent successfully'
    setTimeout(() => { successMessage.value = '' }, 5000)
  } catch (err) {
    error.value = err.response?.data?.error?.message || 'Failed to send email'
  }
}

const downloadInvoice = async () => {
  try {
    const response = await apiClient.get(`/reservations/${props.reservationId}/invoice`, {
      responseType: 'blob'
    })

    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', `invoice-${props.reservationId}.pdf`)
    document.body.appendChild(link)
    link.click()
    link.remove()
  } catch (err) {
    error.value = err.response?.data?.error?.message || 'Failed to download invoice'
  }
}

const processRefund = () => {
  confirmMessage.value = 'Are you sure you want to process a refund for this reservation?'
  pendingAction.value = async () => {
    try {
      await apiClient.post(`/reservations/${props.reservationId}/refund`)
      
      successMessage.value = 'Refund processed successfully'
      setTimeout(() => { successMessage.value = '' }, 5000)
      
      await fetchReservation()
      emit('updated')
    } catch (err) {
      error.value = err.response?.data?.error?.message || 'Failed to process refund'
    }
  }
  showConfirmDialog.value = true
}

const markAsOccupied = () => {
  confirmMessage.value = 'Marquer cet appartement comme occupé pour cette période?'
  pendingAction.value = async () => {
    try {
      await apiClient.put(`/reservations/${props.reservationId}`, {
        status: 'occupied'
      })
      
      successMessage.value = 'Appartement marqué comme occupé'
      setTimeout(() => { successMessage.value = '' }, 5000)
      
      await fetchReservation()
      emit('updated')
    } catch (err) {
      error.value = err.response?.data?.error?.message || 'Failed to mark as occupied'
    }
  }
  showConfirmDialog.value = true
}

const markAsPaid = () => {
  confirmMessage.value = 'Marquer ce paiement comme payé?'
  pendingAction.value = async () => {
    try {
      await apiClient.put(`/reservations/${props.reservationId}`, {
        payment_status: 'paid'
      })
      
      successMessage.value = 'Paiement marqué comme payé'
      setTimeout(() => { successMessage.value = '' }, 5000)
      
      await fetchReservation()
      emit('updated')
    } catch (err) {
      error.value = err.response?.data?.error?.message || 'Failed to mark as paid'
    }
  }
  showConfirmDialog.value = true
}

const confirmAction = async () => {
  showConfirmDialog.value = false
  if (pendingAction.value) {
    await pendingAction.value()
    pendingAction.value = null
  }
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
}

const formatDateTime = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleString('en-US', { 
    year: 'numeric', 
    month: 'short', 
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const getStatusClass = (status) => {
  const classes = {
    pending: 'px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800',
    confirmed: 'px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800',
    cancelled: 'px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800',
    completed: 'px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800',
    occupied: 'px-3 py-1 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800'
  }
  return classes[status] || 'px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800'
}

const getPaymentStatusClass = (status) => {
  const classes = {
    pending: 'px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800',
    paid: 'px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800',
    refunded: 'px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800',
    completed: 'px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800',
    failed: 'px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800'
  }
  return classes[status] || 'px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800'
}

watch(() => props.reservationId, () => {
  if (props.reservationId) {
    fetchReservation()
  }
})

onMounted(() => {
  fetchReservation()
})
</script>
