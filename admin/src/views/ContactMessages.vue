<template>
  <div class="animate-fade-in">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Messages de contact</h1>
        <p class="page-subtitle">Gérez les demandes et messages des clients</p>
      </div>
      <button @click="fetchMessages" class="btn btn-outline">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
        </svg>
        Actualiser
      </button>
    </div>

    <!-- Compact Stats -->
    <div class="flex flex-wrap gap-3 mb-6">
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-50 border border-blue-100">
        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
        <span class="text-xs font-medium text-blue-700">Nouveaux</span>
        <span class="text-sm font-bold text-blue-800">{{ stats.new }}</span>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-50 border border-amber-100">
        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
        <span class="text-xs font-medium text-amber-700">Lus</span>
        <span class="text-sm font-bold text-amber-800">{{ stats.read }}</span>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-50 border border-emerald-100">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        <span class="text-xs font-medium text-emerald-700">Répondus</span>
        <span class="text-sm font-bold text-emerald-800">{{ stats.replied }}</span>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-gray-100 shadow-sm">
        <span class="text-xs font-semibold text-navy-400 uppercase">Total</span>
        <span class="text-lg font-bold text-navy-900">{{ stats.total }}</span>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="input-label">Statut</label>
            <select v-model="filters.status" class="input" @change="fetchMessages">
              <option value="">Tous</option>
              <option value="new">Nouveau</option>
              <option value="read">Lu</option>
              <option value="replied">Répondu</option>
              <option value="archived">Archivé</option>
            </select>
          </div>
          <div class="md:col-span-2">
            <label class="input-label">Rechercher</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
              </div>
              <input v-model="filters.search" type="text" placeholder="Nom, email ou message..." class="input pl-10" @input="debouncedSearch" />
            </div>
          </div>
          <div class="flex items-end gap-2">
            <button @click="resetFilters" class="btn btn-outline btn-sm">Réinitialiser</button>
            <span class="text-xs text-navy-400 mb-2">{{ pagination.total }} msg</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="card p-8 text-center">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
      <p class="mt-3 text-navy-400 text-sm">Chargement des messages...</p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="card p-6 border-red-200 bg-red-50 text-red-600 text-sm">{{ error }}</div>

    <!-- Messages Table -->
    <div v-else-if="messages.length > 0" class="card overflow-hidden">
      <table class="min-w-full">
        <thead class="table-header">
          <tr>
            <th>Expéditeur</th>
            <th>Sujet</th>
            <th>Aperçu</th>
            <th>Statut</th>
            <th>Date</th>
            <th class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="message in messages"
            :key="message.id"
            class="table-row group cursor-pointer"
            :class="{ 'bg-blue-50/30': message.status === 'new' }"
            @click="viewMessage(message)"
          >
            <td>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-navy text-white text-xs font-bold flex items-center justify-center flex-shrink-0">
                  {{ getInitials(message.name) }}
                </div>
                <div class="min-w-0">
                  <div class="font-medium text-navy-900 text-sm" :class="{ 'font-bold': message.status === 'new' }">{{ message.name }}</div>
                  <div class="text-xs text-navy-400 truncate">{{ message.email }}</div>
                </div>
              </div>
            </td>
            <td>
              <span class="text-sm text-navy-700 font-medium">{{ message.subject }}</span>
            </td>
            <td>
              <span class="text-xs text-navy-400 line-clamp-1 max-w-xs block">{{ message.message }}</span>
            </td>
            <td>
              <span class="badge" :class="getStatusBadgeClass(message.status)">
                <span class="w-1.5 h-1.5 rounded-full" :class="getStatusDotClass(message.status)"></span>
                {{ getStatusLabel(message.status) }}
              </span>
            </td>
            <td>
              <span class="text-xs text-navy-400">{{ formatDate(message.created_at) }}</span>
            </td>
            <td class="text-right" @click.stop>
              <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button
                  v-if="message.status === 'new'"
                  @click="updateStatus(message.id, 'read')"
                  class="btn btn-sm text-amber-600 hover:bg-amber-50"
                  title="Marquer comme lu"
                >
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </button>
                <button
                  v-if="['new', 'read'].includes(message.status)"
                  @click="updateStatus(message.id, 'replied')"
                  class="btn btn-sm text-emerald-600 hover:bg-emerald-50"
                  title="Marquer comme répondu"
                >
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                </button>
                <button
                  @click="deleteMessage(message.id)"
                  class="btn btn-sm text-red-500 hover:bg-red-50 hover:text-red-700"
                  title="Supprimer"
                >
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination -->
      <div v-if="pagination.total > pagination.per_page" class="px-6 py-4 flex items-center justify-between border-t border-gray-100">
        <div class="text-xs text-navy-400">
          {{ (pagination.current_page - 1) * pagination.per_page + 1 }} à
          {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} sur
          {{ pagination.total }}
        </div>
        <div class="flex gap-1">
          <button
            @click="changePage(pagination.current_page - 1)"
            :disabled="pagination.current_page === 1"
            class="btn btn-outline btn-sm"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
          </button>
          <button
            @click="changePage(pagination.current_page + 1)"
            :disabled="pagination.current_page === pagination.last_page"
            class="btn btn-outline btn-sm"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Empty -->
    <div v-else class="card p-12 text-center">
      <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-navy-50 mb-4">
        <svg class="w-7 h-7 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.98l7.5-4.04a2.25 2.25 0 012.134 0l7.5 4.04a2.25 2.25 0 011.183 1.98V21z" />
        </svg>
      </div>
      <p class="text-navy-700 font-medium mb-1">Aucun message trouvé</p>
      <p class="text-navy-400 text-sm">Aucun message ne correspond à vos filtres.</p>
    </div>

    <!-- Message Detail Modal -->
    <div
      v-if="selectedMessage"
      class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
      @click.self="closeModal"
    >
      <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-hidden shadow-2xl animate-slide-down">
        <!-- Modal Header -->
        <div class="bg-gradient-navy px-6 py-4">
          <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-white/10 text-white text-sm font-bold flex items-center justify-center">
                {{ getInitials(selectedMessage.name) }}
              </div>
              <div>
                <h2 class="text-lg font-bold text-white">{{ selectedMessage.name }}</h2>
                <p class="text-navy-300 text-xs">{{ selectedMessage.email }}</p>
              </div>
            </div>
            <button @click="closeModal" class="text-white/60 hover:text-white hover:bg-white/10 rounded-lg p-1.5 transition-all">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-180px)]">
          <div class="flex items-center justify-between mb-4">
            <span class="badge" :class="getStatusBadgeClass(selectedMessage.status)">
              <span class="w-1.5 h-1.5 rounded-full" :class="getStatusDotClass(selectedMessage.status)"></span>
              {{ getStatusLabel(selectedMessage.status) }}
            </span>
            <span class="text-xs text-navy-400">{{ formatDateLong(selectedMessage.created_at) }}</span>
          </div>

          <div class="mb-4">
            <label class="input-label">Sujet</label>
            <div class="px-3 py-2 bg-navy-50 rounded-lg text-sm font-medium text-navy-800">{{ selectedMessage.subject }}</div>
          </div>

          <div>
            <label class="input-label">Message</label>
            <div class="px-4 py-3 bg-navy-50/50 rounded-lg border border-navy-100 text-sm text-navy-700 whitespace-pre-wrap leading-relaxed">{{ selectedMessage.message }}</div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-100 px-6 py-3 flex justify-between items-center">
          <div class="flex gap-2">
            <button
              v-if="selectedMessage.status === 'new'"
              @click="updateStatus(selectedMessage.id, 'read')"
              class="btn btn-sm bg-amber-50 text-amber-700 hover:bg-amber-100"
            >
              Marquer lu
            </button>
            <button
              v-if="['new', 'read'].includes(selectedMessage.status)"
              @click="updateStatus(selectedMessage.id, 'replied')"
              class="btn btn-sm bg-emerald-50 text-emerald-700 hover:bg-emerald-100"
            >
              Répondu
            </button>
            <button
              @click="updateStatus(selectedMessage.id, 'archived')"
              class="btn btn-sm btn-outline"
            >
              Archiver
            </button>
          </div>
          <button
            @click="deleteMessage(selectedMessage.id)"
            class="btn btn-sm text-red-500 hover:bg-red-50 hover:text-red-700"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
            Supprimer
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from '../api/axios';

const messages = ref([]);
const loading = ref(false);
const error = ref(null);
const selectedMessage = ref(null);

const filters = ref({ status: '', search: '' });

const pagination = ref({
  current_page: 1,
  per_page: 20,
  total: 0,
  last_page: 1
});

const stats = computed(() => {
  const all = messages.value;
  return {
    new: all.filter(m => m.status === 'new').length,
    read: all.filter(m => m.status === 'read').length,
    replied: all.filter(m => m.status === 'replied').length,
    total: pagination.value.total
  };
});

let searchTimeout = null;

const fetchMessages = async () => {
  loading.value = true;
  error.value = null;
  try {
    const params = { page: pagination.value.current_page, per_page: pagination.value.per_page };
    if (filters.value.status) params.status = filters.value.status;
    if (filters.value.search) params.search = filters.value.search;
    const response = await axios.get('/contact/messages', { params });
    messages.value = response.data.data;
    pagination.value = response.data.meta;
  } catch (err) {
    error.value = err.response?.data?.message || 'Échec du chargement des messages';
  } finally {
    loading.value = false;
  }
};

const debouncedSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    pagination.value.current_page = 1;
    fetchMessages();
  }, 500);
};

const resetFilters = () => {
  filters.value = { status: '', search: '' };
  pagination.value.current_page = 1;
  fetchMessages();
};

const changePage = (page) => {
  pagination.value.current_page = page;
  fetchMessages();
};

const viewMessage = async (message) => {
  selectedMessage.value = message;
  if (message.status === 'new') {
    await updateStatus(message.id, 'read', false);
  }
};

const closeModal = () => { selectedMessage.value = null; };

const updateStatus = async (id, status, closeAfter = true) => {
  try {
    await axios.put(`/contact/messages/${id}`, { status });
    if (closeAfter) closeModal();
    fetchMessages();
  } catch (err) {
    alert(err.response?.data?.message || 'Échec de la mise à jour du statut');
  }
};

const deleteMessage = async (id) => {
  if (!confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) return;
  try {
    await axios.delete(`/contact/messages/${id}`);
    closeModal();
    fetchMessages();
  } catch (err) {
    alert(err.response?.data?.message || 'Échec de la suppression');
  }
};

const getStatusBadgeClass = (status) => {
  return { new: 'badge-info', read: 'badge-gold', replied: 'badge-success', archived: 'badge-neutral' }[status] || 'badge-neutral';
};

const getStatusDotClass = (status) => {
  return { new: 'bg-blue-500', read: 'bg-amber-500', replied: 'bg-emerald-500', archived: 'bg-gray-400' }[status] || 'bg-gray-400';
};

const getStatusLabel = (status) => {
  return { new: 'Nouveau', read: 'Lu', replied: 'Répondu', archived: 'Archivé' }[status] || status;
};

const getInitials = (name) => name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const now = new Date();
  const days = Math.floor((now - date) / (1000 * 60 * 60 * 24));
  if (days === 0) return 'Aujourd\'hui';
  if (days === 1) return 'Hier';
  if (days < 7) return `Il y a ${days}j`;
  return date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
};

const formatDateLong = (dateString) => {
  return new Date(dateString).toLocaleDateString('fr-FR', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
  });
};

onMounted(() => { fetchMessages(); });
</script>
