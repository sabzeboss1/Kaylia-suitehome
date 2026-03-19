<template>
  <div class="animate-fade-in">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Services SPA</h1>
        <p class="page-subtitle">Gérer les services bien-être et événements</p>
      </div>
      <button @click="openCreateModal" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nouveau service
      </button>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="input-label">Type de service</label>
            <select v-model="filters.type" class="input" @change="fetchServices">
              <option value="">Tous les types</option>
              <option value="appointment">Rendez-vous</option>
              <option value="event">Événement</option>
            </select>
          </div>
          <div>
            <label class="input-label">Statut</label>
            <select v-model="filters.active" class="input" @change="fetchServices">
              <option value="">Tous</option>
              <option value="1">Actif</option>
              <option value="0">Inactif</option>
            </select>
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
      <p class="mt-3 text-navy-400 text-sm">Chargement des services...</p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="card p-6 border-red-200 bg-red-50 text-red-600 text-sm">{{ error }}</div>

    <!-- Services Table -->
    <div v-else-if="services.length > 0" class="card overflow-hidden">
      <table class="min-w-full">
        <thead class="table-header">
          <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Durée</th>
            <th>Prix</th>
            <th>Capacité</th>
            <th>Privé</th>
            <th>Statut</th>
            <th>Note</th>
            <th class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="service in services" :key="service.id" class="table-row group">
            <td>
              <div class="font-medium text-navy-900">{{ service.name }}</div>
              <div v-if="service.description" class="text-xs text-navy-400 truncate max-w-xs">{{ service.description }}</div>
            </td>
            <td>
              <span class="badge" :class="service.service_type === 'appointment' ? 'badge-info' : 'badge-gold'">
                {{ service.service_type === 'appointment' ? 'Rendez-vous' : 'Événement' }}
              </span>
            </td>
            <td>
              <span class="text-sm text-navy-600">{{ service.duration }} min</span>
            </td>
            <td>
              <span class="font-semibold text-navy-900">{{ service.price }}€</span>
            </td>
            <td>
              <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span class="text-sm">{{ service.max_persons }}</span>
              </div>
            </td>
            <td>
              <span v-if="service.is_private" class="badge badge-neutral">Privé</span>
              <span v-else class="text-xs text-navy-300">Partagé</span>
            </td>
            <td>
              <span class="badge" :class="service.is_active ? 'badge-success' : 'badge-danger'">
                <span class="w-1.5 h-1.5 rounded-full" :class="service.is_active ? 'bg-emerald-500' : 'bg-red-500'"></span>
                {{ service.is_active ? 'Actif' : 'Inactif' }}
              </span>
            </td>
            <td>
              <div v-if="service.rating" class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-gold-500" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" />
                </svg>
                <span class="text-xs font-medium text-navy-700">{{ service.rating }}</span>
                <span class="text-xs text-navy-300">({{ service.review_count }})</span>
              </div>
              <span v-else class="text-xs text-navy-300">—</span>
            </td>
            <td class="text-right">
              <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button @click="editService(service)" class="btn btn-ghost btn-sm" title="Modifier">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                </button>
                <button @click="deleteService(service.id)" class="btn btn-sm text-red-500 hover:bg-red-50 hover:text-red-700" title="Supprimer">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Empty -->
    <div v-else class="card p-12 text-center">
      <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-navy-50 mb-4">
        <svg class="w-7 h-7 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
        </svg>
      </div>
      <p class="text-navy-700 font-medium mb-1">Aucun service trouvé</p>
      <p class="text-navy-400 text-sm mb-4">Créez votre premier service SPA.</p>
      <button @click="openCreateModal" class="btn btn-primary btn-sm">Nouveau service</button>
    </div>

    <!-- Create/Edit Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
      @click.self="closeModal"
    >
      <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-hidden shadow-2xl animate-slide-down">
        <!-- Modal Header -->
        <div class="bg-gradient-navy px-6 py-4">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-lg font-bold text-white">
                {{ editingService ? 'Modifier le service' : 'Nouveau service' }}
              </h2>
              <p class="text-navy-300 text-xs mt-0.5">
                {{ editingService ? 'Mettez à jour les informations' : 'Créez un nouveau service SPA' }}
              </p>
            </div>
            <button @click="closeModal" class="text-white/60 hover:text-white hover:bg-white/10 rounded-lg p-1.5 transition-all">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Modal Content -->
        <form @submit.prevent="saveService" class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
          <div class="space-y-4">
            <div>
              <label class="input-label">Nom <span class="text-red-400">*</span></label>
              <input v-model="form.name" type="text" required placeholder="Ex: Massage relaxant" class="input" />
            </div>

            <div>
              <label class="input-label">Description</label>
              <textarea v-model="form.description" rows="2" placeholder="Description du service..." class="input"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="input-label">Type <span class="text-red-400">*</span></label>
                <select v-model="form.service_type" required class="input">
                  <option value="appointment">Rendez-vous</option>
                  <option value="event">Événement</option>
                </select>
              </div>
              <div>
                <label class="input-label">Durée (min) <span class="text-red-400">*</span></label>
                <input v-model.number="form.duration" type="number" required min="15" step="15" class="input" />
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="input-label">Prix (€) <span class="text-red-400">*</span></label>
                <input v-model.number="form.price" type="number" required min="0" step="0.01" class="input" />
              </div>
              <div>
                <label class="input-label">Capacité max <span class="text-red-400">*</span></label>
                <input v-model.number="form.max_persons" type="number" required min="1" class="input" />
              </div>
            </div>

            <div class="bg-navy-50/50 rounded-lg p-3 border border-navy-100 space-y-3">
              <label class="flex items-center justify-between cursor-pointer">
                <div>
                  <div class="text-sm font-medium text-navy-800">Service privé</div>
                  <div class="text-xs text-navy-400">Réservé à un seul client à la fois</div>
                </div>
                <div class="relative">
                  <input type="checkbox" v-model="form.is_private" class="sr-only peer" />
                  <div class="w-10 h-6 bg-navy-200 rounded-full peer-checked:bg-navy-600 transition-colors"></div>
                  <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                </div>
              </label>
              <label class="flex items-center justify-between cursor-pointer">
                <div>
                  <div class="text-sm font-medium text-navy-800">Service actif</div>
                  <div class="text-xs text-navy-400">Visible et réservable par les clients</div>
                </div>
                <div class="relative">
                  <input type="checkbox" v-model="form.is_active" class="sr-only peer" />
                  <div class="w-10 h-6 bg-navy-200 rounded-full peer-checked:bg-emerald-500 transition-colors"></div>
                  <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                </div>
              </label>
            </div>
          </div>

          <!-- Modal Actions -->
          <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
            <button type="button" @click="closeModal" class="btn btn-outline flex-1">Annuler</button>
            <button type="submit" :disabled="saving" class="btn btn-primary flex-1">
              <svg v-if="saving" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
              {{ saving ? 'Enregistrement...' : (editingService ? 'Mettre à jour' : 'Créer') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../api/axios';

const services = ref([]);
const loading = ref(false);
const error = ref(null);
const showModal = ref(false);
const editingService = ref(null);
const saving = ref(false);

const filters = ref({
  type: '',
  active: ''
});

const form = ref({
  name: '',
  description: '',
  service_type: 'appointment',
  duration: 60,
  price: 0,
  max_persons: 1,
  is_private: false,
  is_active: true
});

const fetchServices = async () => {
  loading.value = true;
  error.value = null;
  try {
    const params = {};
    if (filters.value.type) params.service_type = filters.value.type;
    if (filters.value.active !== '') params.is_active = filters.value.active;
    const response = await axios.get('/spa/services', { params });
    services.value = response.data.data;
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors du chargement des services';
  } finally {
    loading.value = false;
  }
};

const resetFilters = () => {
  filters.value = { type: '', active: '' };
  fetchServices();
};

const openCreateModal = () => {
  editingService.value = null;
  form.value = { name: '', description: '', service_type: 'appointment', duration: 60, price: 0, max_persons: 1, is_private: false, is_active: true };
  showModal.value = true;
};

const editService = (service) => {
  editingService.value = service;
  form.value = { ...service };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  editingService.value = null;
};

const saveService = async () => {
  saving.value = true;
  try {
    if (editingService.value) {
      await axios.put(`/spa/services/${editingService.value.id}`, form.value);
    } else {
      await axios.post('/spa/services', form.value);
    }
    closeModal();
    fetchServices();
  } catch (err) {
    alert(err.response?.data?.message || 'Erreur lors de l\'enregistrement');
  } finally {
    saving.value = false;
  }
};

const deleteService = async (id) => {
  if (!confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) return;
  try {
    await axios.delete(`/spa/services/${id}`);
    fetchServices();
  } catch (err) {
    alert(err.response?.data?.message || 'Erreur lors de la suppression');
  }
};

onMounted(() => {
  fetchServices();
});
</script>
