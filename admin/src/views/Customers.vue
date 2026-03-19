<template>
  <div class="animate-fade-in">
    <div class="page-header">
      <div>
        <h1 class="page-title">Clients</h1>
        <p class="page-subtitle">Gérer les informations et l'historique des clients</p>
      </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-6">
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="input-label">Rechercher</label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Nom, email ou téléphone..."
              class="input"
              @input="debouncedSearch"
            />
          </div>
          <div>
            <label class="input-label">Statut Newsletter</label>
            <select
              v-model="filters.newsletter"
              class="input"
              @change="fetchCustomers"
            >
              <option value="">Tous</option>
              <option value="subscribed">Abonné</option>
              <option value="unsubscribed">Non abonné</option>
            </select>
          </div>
          <div class="flex items-end">
            <button @click="resetFilters" class="btn btn-outline">
              Réinitialiser
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Customers Table -->
    <div class="card overflow-hidden">
      <div v-if="loading" class="p-8 text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
        <p class="mt-2 text-navy-400 text-sm">Chargement des clients...</p>
      </div>

      <div v-else-if="error" class="p-8 text-center text-red-500 text-sm">
        {{ error }}
      </div>

      <div v-else>
        <table class="min-w-full">
          <thead class="table-header">
            <tr>
              <th>Client</th>
              <th>Contact</th>
              <th>Nationalité</th>
              <th>Newsletter</th>
              <th>Inscrit le</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="customer in customers" :key="customer.id" class="table-row">
              <td class="font-medium text-navy-900">
                {{ customer.first_name }} {{ customer.last_name }}
              </td>
              <td>
                <div class="text-sm text-navy-800">{{ customer.email }}</div>
                <div class="text-xs text-navy-400">{{ customer.phone || 'N/A' }}</div>
              </td>
              <td>{{ customer.nationality || 'N/A' }}</td>
              <td>
                <span class="badge" :class="customer.is_newsletter_subscribed ? 'badge-success' : 'badge-neutral'">
                  {{ customer.is_newsletter_subscribed ? 'Abonné' : 'Non abonné' }}
                </span>
              </td>
              <td class="text-navy-400">{{ formatDate(customer.created_at) }}</td>
              <td class="text-right">
                <button @click="viewCustomer(customer)" class="btn btn-ghost btn-sm mr-1">Voir</button>
                <button @click="exportCustomerData(customer.id)" class="btn btn-outline btn-sm">Exporter</button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 flex items-center justify-between border-t border-surface-100">
          <div class="text-xs text-navy-400">
            {{ (pagination.current_page - 1) * pagination.per_page + 1 }} à
            {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} sur
            {{ pagination.total }} clients
          </div>
          <div class="flex gap-2">
            <button
              @click="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="btn btn-outline btn-sm"
            >Précédent</button>
            <button
              @click="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="btn btn-outline btn-sm"
            >Suivant</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Customer Detail Modal -->
    <div
      v-if="selectedCustomer"
      class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm flex items-center justify-center z-50"
      @click.self="selectedCustomer = null"
    >
      <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto animate-slide-down">
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <h2 class="text-lg font-bold text-navy-900">Détails du client</h2>
            <button @click="selectedCustomer = null" class="text-navy-300 hover:text-navy-600 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Name</label>
              <p class="mt-1 text-sm text-gray-900">
                {{ selectedCustomer.first_name }} {{ selectedCustomer.last_name }}
              </p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <p class="mt-1 text-sm text-gray-900">{{ selectedCustomer.email }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Phone</label>
              <p class="mt-1 text-sm text-gray-900">{{ selectedCustomer.phone || 'N/A' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Nationality</label>
              <p class="mt-1 text-sm text-gray-900">{{ selectedCustomer.nationality || 'N/A' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Newsletter</label>
              <p class="mt-1 text-sm text-gray-900">
                {{ selectedCustomer.is_newsletter_subscribed ? 'Subscribed' : 'Not Subscribed' }}
              </p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Member Since</label>
              <p class="mt-1 text-sm text-gray-900">{{ formatDate(selectedCustomer.created_at) }}</p>
            </div>
          </div>

          <div class="mt-6 flex justify-end gap-3">
            <button @click="selectedCustomer = null" class="btn btn-outline">Fermer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../api/axios';

const customers = ref([]);
const loading = ref(false);
const error = ref(null);
const selectedCustomer = ref(null);

const filters = ref({
  search: '',
  newsletter: ''
});

const pagination = ref({
  current_page: 1,
  per_page: 20,
  total: 0,
  last_page: 1
});

let searchTimeout = null;

const fetchCustomers = async () => {
  loading.value = true;
  error.value = null;

  try {
    const params = {
      page: pagination.value.current_page,
      per_page: pagination.value.per_page
    };

    if (filters.value.search) {
      params.search = filters.value.search;
    }

    if (filters.value.newsletter) {
      params.newsletter = filters.value.newsletter === 'subscribed' ? 1 : 0;
    }

    const response = await axios.get('/customers', { params });
    customers.value = response.data.data;
    pagination.value = response.data.meta;
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to load customers';
  } finally {
    loading.value = false;
  }
};

const debouncedSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    pagination.value.current_page = 1;
    fetchCustomers();
  }, 500);
};

const resetFilters = () => {
  filters.value = {
    search: '',
    newsletter: ''
  };
  pagination.value.current_page = 1;
  fetchCustomers();
};

const changePage = (page) => {
  pagination.value.current_page = page;
  fetchCustomers();
};

const viewCustomer = (customer) => {
  selectedCustomer.value = customer;
};

const exportCustomerData = async (customerId) => {
  try {
    const response = await axios.post(`/customers/${customerId}/export`);
    const blob = new Blob([JSON.stringify(response.data, null, 2)], { type: 'application/json' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `customer-${customerId}-data.json`;
    a.click();
    window.URL.revokeObjectURL(url);
  } catch (err) {
    alert('Failed to export customer data');
  }
};

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

onMounted(() => {
  fetchCustomers();
});
</script>
