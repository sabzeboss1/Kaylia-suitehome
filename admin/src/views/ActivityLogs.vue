<template>
  <div class="animate-fade-in">
    <div class="page-header">
      <div>
        <h1 class="page-title">Journaux d'activité</h1>
        <p class="page-subtitle">Suivre les actions administratives et événements système</p>
      </div>
      <button @click="exportLogs" class="btn btn-outline">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
        Exporter CSV
      </button>
    </div>

    <div class="card mb-6"><div class="card-body">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="input-label">Utilisateur</label>
          <select v-model="filters.admin_user_id" class="input" @change="fetchLogs">
            <option value="">Tous</option>
            <option v-for="user in adminUsers" :key="user.id" :value="user.id">{{ user.name }}</option>
          </select>
        </div>
        <div>
          <label class="input-label">Action</label>
          <select v-model="filters.action" class="input" @change="fetchLogs">
            <option value="">Toutes</option>
            <option value="create">Création</option>
            <option value="update">Mise à jour</option>
            <option value="delete">Suppression</option>
            <option value="login">Connexion</option>
            <option value="logout">Déconnexion</option>
          </select>
        </div>
        <div>
          <label class="input-label">Type d'entité</label>
          <select v-model="filters.entity_type" class="input" @change="fetchLogs">
            <option value="">Tous</option>
            <option value="Apartment">Appartement</option>
            <option value="Reservation">Réservation</option>
            <option value="Customer">Client</option>
            <option value="SpaService">Service SPA</option>
            <option value="PromoCode">Code Promo</option>
            <option value="Review">Avis</option>
            <option value="AdminUser">Utilisateur</option>
          </select>
        </div>
        <div>
          <label class="input-label">Date</label>
          <input v-model="filters.date" type="date" class="input" @change="fetchLogs" />
        </div>
      </div>
      <div class="mt-3 flex gap-2">
        <div class="relative flex-1">
          <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
          </div>
          <input v-model="filters.search" type="text" placeholder="Rechercher dans la description..." class="input pl-10" @input="debouncedSearch" />
        </div>
        <button @click="resetFilters" class="btn btn-outline btn-sm">Réinitialiser</button>
      </div>
    </div></div>

    <div v-if="loading" class="card p-8 text-center">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
      <p class="mt-3 text-navy-400 text-sm">Chargement des journaux...</p>
    </div>
    <div v-else-if="error" class="card p-6 border-red-200 bg-red-50 text-red-600 text-sm">{{ error }}</div>

    <div v-else class="card overflow-hidden">
      <div v-if="logs.length > 0">
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead class="table-header"><tr>
              <th>Date</th><th>Utilisateur</th><th>Action</th><th>Entité</th><th>Description</th><th>IP</th>
            </tr></thead>
            <tbody>
              <tr v-for="log in logs" :key="log.id" class="table-row">
                <td><span class="text-xs text-navy-400 whitespace-nowrap">{{ formatDateTime(log.created_at) }}</span></td>
                <td><span class="text-sm font-medium text-navy-700">{{ log.admin_user?.name || 'Système' }}</span></td>
                <td>
                  <span class="badge" :class="getActionBadge(log.action)">{{ getActionLabel(log.action) }}</span>
                </td>
                <td>
                  <div class="text-sm text-navy-700">{{ getEntityLabel(log.entity_type) }}</div>
                  <div v-if="log.entity_id" class="text-[10px] text-navy-300 font-mono">#{{ log.entity_id }}</div>
                </td>
                <td><span class="text-xs text-navy-500 line-clamp-2 max-w-xs block">{{ log.description }}</span></td>
                <td><span class="text-xs text-navy-300 font-mono">{{ log.ip_address || '—' }}</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-if="pagination.total > pagination.per_page" class="px-6 py-4 flex items-center justify-between border-t border-gray-100">
          <span class="text-xs text-navy-400">{{ (pagination.current_page - 1) * pagination.per_page + 1 }} à {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} sur {{ pagination.total }}</span>
          <div class="flex gap-1">
            <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="btn btn-outline btn-sm"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg></button>
            <button @click="changePage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="btn btn-outline btn-sm"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg></button>
          </div>
        </div>
      </div>
      <div v-else class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-navy-50 mb-4">
          <svg class="w-7 h-7 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>
        </div>
        <p class="text-navy-700 font-medium mb-1">Aucun journal trouvé</p>
        <p class="text-navy-400 text-sm">Aucun journal ne correspond à vos filtres.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../api/axios';

const logs = ref([]); const adminUsers = ref([]);
const loading = ref(false); const error = ref(null);
const filters = ref({ admin_user_id: '', action: '', entity_type: '', date: '', search: '' });
const pagination = ref({ current_page: 1, per_page: 50, total: 0, last_page: 1 });
let searchTimeout = null;

const fetchAdminUsers = async () => { try { const r = await axios.get('/admin-users'); adminUsers.value = r.data.data; } catch (e) { /* silent */ } };

const fetchLogs = async () => {
  loading.value = true; error.value = null;
  try {
    const params = { page: pagination.value.current_page, per_page: pagination.value.per_page };
    if (filters.value.admin_user_id) params.admin_user_id = filters.value.admin_user_id;
    if (filters.value.action) params.action = filters.value.action;
    if (filters.value.entity_type) params.entity_type = filters.value.entity_type;
    if (filters.value.date) params.date = filters.value.date;
    if (filters.value.search) params.search = filters.value.search;
    const r = await axios.get('/activity-logs', { params });
    logs.value = r.data.data; pagination.value = r.data.meta;
  } catch (e) { error.value = e.response?.data?.message || 'Échec du chargement'; }
  finally { loading.value = false; }
};

const debouncedSearch = () => { clearTimeout(searchTimeout); searchTimeout = setTimeout(() => { pagination.value.current_page = 1; fetchLogs(); }, 500); };
const resetFilters = () => { filters.value = { admin_user_id: '', action: '', entity_type: '', date: '', search: '' }; pagination.value.current_page = 1; fetchLogs(); };
const changePage = (p) => { pagination.value.current_page = p; fetchLogs(); };

const exportLogs = async () => {
  try {
    const params = {};
    Object.entries(filters.value).forEach(([k, v]) => { if (v) params[k] = v; });
    const r = await axios.get('/activity-logs/export', { params, responseType: 'blob' });
    const url = window.URL.createObjectURL(new Blob([r.data], { type: 'text/csv' }));
    const a = document.createElement('a'); a.href = url;
    a.download = `journaux-${new Date().toISOString().split('T')[0]}.csv`;
    a.click(); window.URL.revokeObjectURL(url);
  } catch (e) { alert('Échec de l\'export'); }
};

const getActionBadge = (a) => ({ create: 'badge-success', update: 'badge-info', delete: 'badge-danger', login: 'badge-gold', logout: 'badge-neutral' }[a] || 'badge-neutral');
const getActionLabel = (a) => ({ create: 'Création', update: 'Mise à jour', delete: 'Suppression', login: 'Connexion', logout: 'Déconnexion' }[a] || a);
const getEntityLabel = (t) => ({ Apartment: 'Appartement', Reservation: 'Réservation', Customer: 'Client', SpaService: 'Service SPA', PromoCode: 'Code Promo', Review: 'Avis', AdminUser: 'Utilisateur' }[t] || t);
const formatDateTime = (d) => new Date(d).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' });

onMounted(() => { fetchAdminUsers(); fetchLogs(); });
</script>
