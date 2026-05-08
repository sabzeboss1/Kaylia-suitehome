<template>
  <div class="animate-fade-in">
    <div class="page-header">
      <div>
        <h1 class="page-title">Clients</h1>
        <p class="page-subtitle">Gérer les informations et l'historique des clients</p>
      </div>
      <button @click="showCreateModal = true" class="btn btn-primary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Ajouter un client
      </button>
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

    <!-- Create Customer Modal -->
    <div
      v-if="showCreateModal"
      class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm flex items-center justify-center z-50"
      @click.self="closeCreateModal"
    >
      <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto animate-slide-down">
        <div class="p-6">
          <div class="flex justify-between items-start mb-6">
            <div>
              <h2 class="text-lg font-bold text-navy-900">Ajouter un nouveau client</h2>
              <p class="text-sm text-navy-400 mt-1">Créer manuellement un compte client</p>
            </div>
            <button @click="closeCreateModal" class="text-navy-300 hover:text-navy-600 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <!-- Success Message -->
          <div v-if="createSuccess" class="mb-4 flex items-center gap-2 px-4 py-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            <span>Client créé avec succès!</span>
          </div>

          <!-- Error Message -->
          <div v-if="createError" class="mb-4 flex items-center gap-2 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            <span>{{ createError }}</span>
          </div>

          <form @submit.prevent="createCustomer" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="input-label">Prénom <span class="text-red-500">*</span></label>
                <input
                  v-model="newCustomer.first_name"
                  type="text"
                  class="input"
                  placeholder="Jean"
                  required
                />
              </div>
              <div>
                <label class="input-label">Nom <span class="text-red-500">*</span></label>
                <input
                  v-model="newCustomer.last_name"
                  type="text"
                  class="input"
                  placeholder="Dupont"
                  required
                />
              </div>
            </div>

            <div>
              <label class="input-label">Email <span class="text-red-500">*</span></label>
              <input
                v-model="newCustomer.email"
                type="email"
                class="input"
                placeholder="jean.dupont@example.com"
                required
              />
            </div>

            <div>
              <label class="input-label">Téléphone</label>
              <input
                v-model="newCustomer.phone"
                type="tel"
                class="input"
                placeholder="+237 6XX XX XX XX"
              />
            </div>

            <div>
              <label class="input-label">Nationalité</label>
              <input
                v-model="newCustomer.nationality"
                type="text"
                class="input"
                placeholder="Cameroun"
              />
            </div>

            <div class="flex items-center gap-3 p-4 bg-navy-50 rounded-lg">
              <input
                v-model="newCustomer.is_newsletter_subscribed"
                type="checkbox"
                id="newsletter"
                class="w-4 h-4 text-gold-500 border-navy-300 rounded focus:ring-gold-500"
              />
              <label for="newsletter" class="text-sm text-navy-700 cursor-pointer">
                Abonner à la newsletter
              </label>
            </div>

            <div class="mt-6 flex justify-end gap-3">
              <button type="button" @click="closeCreateModal" class="btn btn-outline" :disabled="creating">
                Annuler
              </button>
              <button type="submit" class="btn btn-primary" :disabled="creating">
                <svg v-if="creating" class="w-4 h-4 mr-2 animate-spin" viewBox="0 0 24 24" fill="none">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ creating ? 'Création...' : 'Créer le client' }}
              </button>
            </div>
          </form>
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
const showCreateModal = ref(false);
const creating = ref(false);
const createSuccess = ref(false);
const createError = ref(null);

const newCustomer = ref({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  nationality: '',
  is_newsletter_subscribed: false
});

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

const createCustomer = async () => {
  creating.value = true;
  createError.value = null;
  createSuccess.value = false;

  try {
    await axios.post('/customers', newCustomer.value);
    createSuccess.value = true;
    
    // Reset form
    newCustomer.value = {
      first_name: '',
      last_name: '',
      email: '',
      phone: '',
      nationality: '',
      is_newsletter_subscribed: false
    };

    // Refresh customer list
    await fetchCustomers();

    // Close modal after 1.5 seconds
    setTimeout(() => {
      closeCreateModal();
    }, 1500);
  } catch (err) {
    createError.value = err.response?.data?.message || 'Échec de la création du client';
  } finally {
    creating.value = false;
  }
};

const closeCreateModal = () => {
  showCreateModal.value = false;
  createSuccess.value = false;
  createError.value = null;
  newCustomer.value = {
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    nationality: '',
    is_newsletter_subscribed: false
  };
};

onMounted(() => {
  fetchCustomers();
});
</script>
