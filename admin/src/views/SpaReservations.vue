<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">SPA Reservations</h1>
      <p class="text-gray-600">Manage wellness service bookings</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select
            v-model="filters.status"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            @change="fetchReservations"
          >
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
          <select
            v-model="filters.service_id"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            @change="fetchReservations"
          >
            <option value="">All Services</option>
            <option v-for="service in services" :key="service.id" :value="service.id">
              {{ service.name }}
            </option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
          <input
            v-model="filters.from_date"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            @change="fetchReservations"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
          <input
            v-model="filters.to_date"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            @change="fetchReservations"
          />
        </div>
      </div>
      <div class="mt-4">
        <button
          @click="resetFilters"
          class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
        >
          Reset Filters
        </button>
      </div>
    </div>

    <!-- Reservations Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div v-if="loading" class="p-8 text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <p class="mt-2 text-gray-600">Loading reservations...</p>
      </div>

      <div v-else-if="error" class="p-8 text-center text-red-600">
        {{ error }}
      </div>

      <div v-else>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                ID
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Service
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Customer
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Date & Time
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Persons
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Price
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="reservation in reservations" :key="reservation.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                #{{ reservation.id }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ reservation.service?.name || 'N/A' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                  {{ reservation.customer?.first_name }} {{ reservation.customer?.last_name }}
                </div>
                <div class="text-sm text-gray-500">{{ reservation.customer?.email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ formatDate(reservation.reservation_date) }}</div>
                <div class="text-sm text-gray-500">{{ reservation.reservation_time }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ reservation.number_of_persons }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                €{{ reservation.total_price }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  :class="[
                    'px-2 py-1 text-xs font-semibold rounded-full',
                    getStatusClass(reservation.status)
                  ]"
                >
                  {{ reservation.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button
                  @click="viewReservation(reservation)"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  View
                </button>
                <button
                  v-if="reservation.status === 'pending'"
                  @click="updateStatus(reservation.id, 'confirmed')"
                  class="text-green-600 hover:text-green-900 mr-3"
                >
                  Confirm
                </button>
                <button
                  v-if="['pending', 'confirmed'].includes(reservation.status)"
                  @click="updateStatus(reservation.id, 'cancelled')"
                  class="text-red-600 hover:text-red-900"
                >
                  Cancel
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
          <div class="text-sm text-gray-700">
            Showing {{ (pagination.current_page - 1) * pagination.per_page + 1 }} to
            {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} of
            {{ pagination.total }} reservations
          </div>
          <div class="flex gap-2">
            <button
              @click="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="px-3 py-1 border border-gray-300 rounded-md disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-100"
            >
              Previous
            </button>
            <button
              @click="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="px-3 py-1 border border-gray-300 rounded-md disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-100"
            >
              Next
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Reservation Detail Modal -->
    <div
      v-if="selectedReservation"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      @click.self="selectedReservation = null"
    >
      <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <h2 class="text-xl font-bold text-gray-900">Reservation #{{ selectedReservation.id }}</h2>
            <button @click="selectedReservation = null" class="text-gray-400 hover:text-gray-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Service</label>
              <p class="mt-1 text-sm text-gray-900">{{ selectedReservation.service?.name }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Customer</label>
              <p class="mt-1 text-sm text-gray-900">
                {{ selectedReservation.customer?.first_name }} {{ selectedReservation.customer?.last_name }}
              </p>
              <p class="text-sm text-gray-500">{{ selectedReservation.customer?.email }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <p class="mt-1 text-sm text-gray-900">{{ formatDate(selectedReservation.reservation_date) }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Time</label>
                <p class="mt-1 text-sm text-gray-900">{{ selectedReservation.reservation_time }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Number of Persons</label>
                <p class="mt-1 text-sm text-gray-900">{{ selectedReservation.number_of_persons }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Total Price</label>
                <p class="mt-1 text-sm text-gray-900">€{{ selectedReservation.total_price }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <p class="mt-1 text-sm text-gray-900 capitalize">{{ selectedReservation.status }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                <p class="mt-1 text-sm text-gray-900 capitalize">{{ selectedReservation.payment_status }}</p>
              </div>
            </div>
            <div v-if="selectedReservation.special_requests">
              <label class="block text-sm font-medium text-gray-700">Special Requests</label>
              <p class="mt-1 text-sm text-gray-900">{{ selectedReservation.special_requests }}</p>
            </div>
          </div>

          <div class="mt-6 flex justify-end gap-3">
            <button
              @click="selectedReservation = null"
              class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../api/axios';

const reservations = ref([]);
const services = ref([]);
const loading = ref(false);
const error = ref(null);
const selectedReservation = ref(null);

const filters = ref({
  status: '',
  service_id: '',
  from_date: '',
  to_date: ''
});

const pagination = ref({
  current_page: 1,
  per_page: 20,
  total: 0,
  last_page: 1
});

const fetchServices = async () => {
  try {
    const response = await axios.get('/spa/services');
    services.value = response.data.data;
  } catch (err) {
    console.error('Failed to load services:', err);
  }
};

const fetchReservations = async () => {
  loading.value = true;
  error.value = null;

  try {
    const params = {
      page: pagination.value.current_page,
      per_page: pagination.value.per_page
    };

    if (filters.value.status) params.status = filters.value.status;
    if (filters.value.service_id) params.service_id = filters.value.service_id;
    if (filters.value.from_date) params.from_date = filters.value.from_date;
    if (filters.value.to_date) params.to_date = filters.value.to_date;

    const response = await axios.get('/spa/reservations', { params });
    reservations.value = response.data.data;
    pagination.value = response.data.meta;
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to load reservations';
  } finally {
    loading.value = false;
  }
};

const resetFilters = () => {
  filters.value = {
    status: '',
    service_id: '',
    from_date: '',
    to_date: ''
  };
  pagination.value.current_page = 1;
  fetchReservations();
};

const changePage = (page) => {
  pagination.value.current_page = page;
  fetchReservations();
};

const viewReservation = (reservation) => {
  selectedReservation.value = reservation;
};

const updateStatus = async (id, status) => {
  try {
    await axios.put(`/spa/reservations/${id}`, { status });
    fetchReservations();
  } catch (err) {
    alert(err.response?.data?.message || 'Failed to update status');
  }
};

const getStatusClass = (status) => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    confirmed: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
    completed: 'bg-blue-100 text-blue-800'
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

onMounted(() => {
  fetchServices();
  fetchReservations();
});
</script>
