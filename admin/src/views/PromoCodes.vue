<template>
  <div class="animate-fade-in">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Codes promo</h1>
        <p class="page-subtitle">Gérer les codes de réduction et promotions</p>
      </div>
      <button @click="openCreateModal" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nouveau code
      </button>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="input-label">Statut</label>
            <select v-model="filters.active" class="input" @change="fetchPromoCodes">
              <option value="">Tous</option>
              <option value="1">Actif</option>
              <option value="0">Inactif</option>
            </select>
          </div>
          <div>
            <label class="input-label">Type de réduction</label>
            <select v-model="filters.discount_type" class="input" @change="fetchPromoCodes">
              <option value="">Tous</option>
              <option value="percentage">Pourcentage</option>
              <option value="fixed_amount">Montant fixe</option>
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
      <p class="mt-3 text-navy-400 text-sm">Chargement des codes promo...</p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="card p-6 border-red-200 bg-red-50 text-red-600 text-sm">{{ error }}</div>

    <!-- Promo Codes Table -->
    <div v-else class="card overflow-hidden">
      <div v-if="promoCodes.length > 0">
        <table class="min-w-full">
          <thead class="table-header">
            <tr>
              <th>Code</th>
              <th>Réduction</th>
              <th>Validité</th>
              <th>Utilisation</th>
              <th>Statut</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="code in promoCodes" :key="code.id" class="table-row group">
              <td>
                <div class="font-mono font-bold text-navy-900 text-sm">{{ code.code }}</div>
                <div v-if="code.description" class="text-xs text-navy-400 truncate max-w-xs">{{ code.description }}</div>
              </td>
              <td>
                <span class="font-semibold text-navy-900">
                  {{ code.discount_type === 'percentage' ? `${code.discount_value}%` : `${code.discount_value}€` }}
                </span>
                <div class="text-xs text-navy-400">{{ code.discount_type === 'percentage' ? 'Pourcentage' : 'Montant fixe' }}</div>
              </td>
              <td>
                <div class="text-xs text-navy-600">{{ formatDate(code.valid_from) }}</div>
                <div class="text-xs text-navy-400">→ {{ formatDate(code.valid_until) }}</div>
              </td>
              <td>
                <div class="flex items-center gap-1.5">
                  <span class="text-sm font-medium text-navy-700">{{ code.used_count }}</span>
                  <span class="text-xs text-navy-300">/ {{ code.max_uses || '∞' }}</span>
                </div>
              </td>
              <td>
                <span class="badge" :class="isCodeActive(code) ? 'badge-success' : 'badge-neutral'">
                  <span class="w-1.5 h-1.5 rounded-full" :class="isCodeActive(code) ? 'bg-emerald-500' : 'bg-gray-400'"></span>
                  {{ isCodeActive(code) ? 'Actif' : 'Inactif' }}
                </span>
              </td>
              <td class="text-right">
                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                  <button @click="editPromoCode(code)" class="btn btn-ghost btn-sm" title="Modifier">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                  </button>
                  <button @click="deletePromoCode(code.id)" class="btn btn-sm text-red-500 hover:bg-red-50 hover:text-red-700" title="Supprimer">
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
          </svg>
        </div>
        <p class="text-navy-700 font-medium mb-1">Aucun code promo</p>
        <p class="text-navy-400 text-sm mb-4">Créez votre premier code promo.</p>
        <button @click="openCreateModal" class="btn btn-primary btn-sm">Nouveau code</button>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click.self="closeModal">
      <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-hidden shadow-2xl animate-slide-down">
        <div class="bg-gradient-navy px-6 py-4">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-lg font-bold text-white">{{ editingCode ? 'Modifier le code' : 'Nouveau code promo' }}</h2>
              <p class="text-navy-300 text-xs mt-0.5">{{ editingCode ? 'Mettre à jour les informations' : 'Créer un nouveau code de réduction' }}</p>
            </div>
            <button @click="closeModal" class="text-white/60 hover:text-white hover:bg-white/10 rounded-lg p-1.5 transition-all">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
        </div>

        <form @submit.prevent="savePromoCode" class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
          <div class="space-y-4">
            <div>
              <label class="input-label">Code <span class="text-red-400">*</span></label>
              <input v-model="form.code" type="text" required class="input uppercase" placeholder="ETE2024" />
            </div>
            <div>
              <label class="input-label">Description</label>
              <textarea v-model="form.description" rows="2" class="input" placeholder="Description..."></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="input-label">Type <span class="text-red-400">*</span></label>
                <select v-model="form.discount_type" required class="input">
                  <option value="percentage">Pourcentage</option>
                  <option value="fixed_amount">Montant fixe</option>
                </select>
              </div>
              <div>
                <label class="input-label">Valeur {{ form.discount_type === 'percentage' ? '(%)' : '(€)' }} <span class="text-red-400">*</span></label>
                <input v-model.number="form.discount_value" type="number" required min="0" :max="form.discount_type === 'percentage' ? 100 : undefined" step="0.01" class="input" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="input-label">Valide du <span class="text-red-400">*</span></label>
                <input v-model="form.valid_from" type="date" required class="input" />
              </div>
              <div>
                <label class="input-label">Valide jusqu'au <span class="text-red-400">*</span></label>
                <input v-model="form.valid_until" type="date" required class="input" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="input-label">Utilisations max</label>
                <input v-model.number="form.max_uses" type="number" min="1" class="input" placeholder="Illimité" />
              </div>
              <div>
                <label class="input-label">Nuits minimum</label>
                <input v-model.number="form.min_nights" type="number" min="1" class="input" placeholder="Aucun minimum" />
              </div>
            </div>
            <div class="bg-navy-50/50 rounded-lg p-3 border border-navy-100">
              <label class="flex items-center justify-between cursor-pointer">
                <div>
                  <div class="text-sm font-medium text-navy-800">Code actif</div>
                  <div class="text-xs text-navy-400">Utilisable par les clients</div>
                </div>
                <div class="relative">
                  <input type="checkbox" v-model="form.is_active" class="sr-only peer" />
                  <div class="w-10 h-6 bg-navy-200 rounded-full peer-checked:bg-emerald-500 transition-colors"></div>
                  <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                </div>
              </label>
            </div>
          </div>
          <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
            <button type="button" @click="closeModal" class="btn btn-outline flex-1">Annuler</button>
            <button type="submit" :disabled="saving" class="btn btn-primary flex-1">
              <svg v-if="saving" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
              {{ saving ? 'Enregistrement...' : (editingCode ? 'Mettre à jour' : 'Créer') }}
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

const promoCodes = ref([]);
const loading = ref(false);
const error = ref(null);
const showModal = ref(false);
const editingCode = ref(null);
const saving = ref(false);

const filters = ref({ active: '', discount_type: '' });
const pagination = ref({ current_page: 1, per_page: 20, total: 0, last_page: 1 });

const form = ref({
  code: '', description: '', discount_type: 'percentage', discount_value: 0,
  valid_from: '', valid_until: '', max_uses: null, min_nights: null, is_active: true
});

const fetchPromoCodes = async () => {
  loading.value = true; error.value = null;
  try {
    const params = { page: pagination.value.current_page, per_page: pagination.value.per_page };
    if (filters.value.active !== '') params.is_active = filters.value.active;
    if (filters.value.discount_type) params.discount_type = filters.value.discount_type;
    const response = await axios.get('/promo-codes', { params });
    promoCodes.value = response.data.data;
    pagination.value = response.data.meta;
  } catch (err) {
    error.value = err.response?.data?.message || 'Échec du chargement';
  } finally { loading.value = false; }
};

const resetFilters = () => { filters.value = { active: '', discount_type: '' }; pagination.value.current_page = 1; fetchPromoCodes(); };
const changePage = (page) => { pagination.value.current_page = page; fetchPromoCodes(); };

const openCreateModal = () => {
  editingCode.value = null;
  form.value = { code: '', description: '', discount_type: 'percentage', discount_value: 0, valid_from: '', valid_until: '', max_uses: null, min_nights: null, is_active: true };
  showModal.value = true;
};

const editPromoCode = (code) => { editingCode.value = code; form.value = { ...code }; showModal.value = true; };
const closeModal = () => { showModal.value = false; editingCode.value = null; };

const savePromoCode = async () => {
  saving.value = true;
  try {
    if (editingCode.value) await axios.put(`/promo-codes/${editingCode.value.id}`, form.value);
    else await axios.post('/promo-codes', form.value);
    closeModal(); fetchPromoCodes();
  } catch (err) { alert(err.response?.data?.message || 'Erreur'); }
  finally { saving.value = false; }
};

const deletePromoCode = async (id) => {
  if (!confirm('Supprimer ce code promo ?')) return;
  try { await axios.delete(`/promo-codes/${id}`); fetchPromoCodes(); }
  catch (err) { alert(err.response?.data?.message || 'Erreur'); }
};

const isCodeActive = (code) => {
  if (!code.is_active) return false;
  const now = new Date();
  return now >= new Date(code.valid_from) && now <= new Date(code.valid_until);
};

const formatDate = (dateString) => new Date(dateString).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });

onMounted(() => { fetchPromoCodes(); });
</script>
