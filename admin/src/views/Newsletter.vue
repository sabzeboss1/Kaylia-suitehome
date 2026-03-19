<template>
  <div class="animate-fade-in">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Newsletter</h1>
        <p class="page-subtitle">Gérer les abonnements email</p>
      </div>
      <button @click="exportSubscribers" class="btn btn-outline">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        Exporter CSV
      </button>
    </div>

    <!-- Compact Stats -->
    <div class="flex flex-wrap gap-3 mb-6">
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-50 border border-emerald-100">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        <span class="text-xs font-medium text-emerald-700">Actifs</span>
        <span class="text-sm font-bold text-emerald-800">{{ stats.active }}</span>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-50 border border-red-100">
        <span class="w-2 h-2 rounded-full bg-red-500"></span>
        <span class="text-xs font-medium text-red-700">Désabonnés</span>
        <span class="text-sm font-bold text-red-800">{{ stats.inactive }}</span>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-gray-100 shadow-sm">
        <span class="text-xs font-semibold text-navy-400 uppercase">Total</span>
        <span class="text-lg font-bold text-navy-900">{{ stats.total }}</span>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="input-label">Statut</label>
            <select v-model="filters.status" class="input" @change="fetchSubscribers">
              <option value="">Tous</option>
              <option value="active">Actif</option>
              <option value="inactive">Désabonné</option>
            </select>
          </div>
          <div>
            <label class="input-label">Rechercher</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
              </div>
              <input v-model="filters.search" type="text" placeholder="Rechercher par email..." class="input pl-10" @input="debouncedSearch" />
            </div>
          </div>
          <div class="flex items-end">
            <button @click="resetFilters" class="btn btn-outline btn-sm">Réinitialiser</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="card p-8 text-center">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
      <p class="mt-3 text-navy-400 text-sm">Chargement des abonnés...</p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="card p-6 border-red-200 bg-red-50 text-red-600 text-sm">{{ error }}</div>

    <!-- Table -->
    <div v-else class="card overflow-hidden">
      <div v-if="subscribers.length > 0">
        <table class="min-w-full">
          <thead class="table-header">
            <tr>
              <th>Email</th>
              <th>Statut</th>
              <th>Date d'inscription</th>
              <th>Date de désabonnement</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="subscriber in subscribers" :key="subscriber.id" class="table-row">
              <td>
                <span class="text-sm font-medium text-navy-900">{{ subscriber.email }}</span>
              </td>
              <td>
                <span class="badge" :class="subscriber.is_active ? 'badge-success' : 'badge-danger'">
                  <span class="w-1.5 h-1.5 rounded-full" :class="subscriber.is_active ? 'bg-emerald-500' : 'bg-red-500'"></span>
                  {{ subscriber.is_active ? 'Actif' : 'Désabonné' }}
                </span>
              </td>
              <td>
                <span class="text-sm text-navy-500">{{ formatDate(subscriber.subscribed_at) }}</span>
              </td>
              <td>
                <span class="text-sm text-navy-400">{{ subscriber.unsubscribed_at ? formatDate(subscriber.unsubscribed_at) : '—' }}</span>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div v-if="pagination.total > pagination.per_page" class="px-6 py-4 flex items-center justify-between border-t border-gray-100">
          <div class="text-xs text-navy-400">
            {{ (pagination.current_page - 1) * pagination.per_page + 1 }} à
            {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} sur
            {{ pagination.total }} abonnés
          </div>
          <div class="flex gap-1">
            <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="btn btn-outline btn-sm">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            </button>
            <button @click="changePage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="btn btn-outline btn-sm">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Empty -->
      <div v-else class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-navy-50 mb-4">
          <svg class="w-7 h-7 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
          </svg>
        </div>
        <p class="text-navy-700 font-medium mb-1">Aucun abonné trouvé</p>
        <p class="text-navy-400 text-sm">Aucun abonné ne correspond à vos filtres.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../api/axios';

const subscribers = ref([]);
const loading = ref(false);
const error = ref(null);

const stats = ref({ active: 0, inactive: 0, total: 0 });

const filters = ref({ status: '', search: '' });

const pagination = ref({
  current_page: 1,
  per_page: 20,
  total: 0,
  last_page: 1
});

let searchTimeout = null;

const fetchSubscribers = async () => {
  loading.value = true;
  error.value = null;
  try {
    const params = { page: pagination.value.current_page, per_page: pagination.value.per_page };
    if (filters.value.status) params.is_active = filters.value.status === 'active' ? 1 : 0;
    if (filters.value.search) params.search = filters.value.search;
    const response = await axios.get('/newsletter/subscribers', { params });
    subscribers.value = response.data.data;
    pagination.value = response.data.meta;
    if (response.data.stats) stats.value = response.data.stats;
  } catch (err) {
    error.value = err.response?.data?.message || 'Échec du chargement des abonnés';
  } finally {
    loading.value = false;
  }
};

const debouncedSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => { pagination.value.current_page = 1; fetchSubscribers(); }, 500);
};

const resetFilters = () => {
  filters.value = { status: '', search: '' };
  pagination.value.current_page = 1;
  fetchSubscribers();
};

const changePage = (page) => { pagination.value.current_page = page; fetchSubscribers(); };

const exportSubscribers = async () => {
  try {
    const params = {};
    if (filters.value.status) params.is_active = filters.value.status === 'active' ? 1 : 0;
    const response = await axios.post('/newsletter/subscribers/export', params, { responseType: 'blob' });
    const blob = new Blob([response.data], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `newsletter-abonnes-${new Date().toISOString().split('T')[0]}.csv`;
    a.click();
    window.URL.revokeObjectURL(url);
  } catch (err) {
    alert('Échec de l\'export');
  }
};

const formatDate = (dateString) => {
  if (!dateString) return '—';
  return new Date(dateString).toLocaleDateString('fr-FR', { year: 'numeric', month: 'short', day: 'numeric' });
};

onMounted(() => { fetchSubscribers(); });
</script>
