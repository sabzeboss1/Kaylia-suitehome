<template>
  <div class="animate-fade-in">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Options supplémentaires</h1>
        <p class="page-subtitle">Gérez les options confort, vins et confiseries</p>
      </div>
      <button @click="openCreateModal" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nouvelle option
      </button>
    </div>

    <!-- Compact Stats -->
    <div class="flex flex-wrap gap-3 mb-6">
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-gray-100 shadow-sm">
        <span class="text-xs font-semibold text-navy-400 uppercase">Total</span>
        <span class="text-lg font-bold text-navy-900">{{ stats.total }}</span>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-50 border border-emerald-100">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        <span class="text-xs font-medium text-emerald-700">Ménage</span>
        <span class="text-sm font-bold text-emerald-800">{{ stats.cleaning }}</span>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-purple-50 border border-purple-100">
        <span class="w-2 h-2 rounded-full bg-purple-500"></span>
        <span class="text-xs font-medium text-purple-700">Vins</span>
        <span class="text-sm font-bold text-purple-800">{{ stats.wine }}</span>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-pink-50 border border-pink-100">
        <span class="w-2 h-2 rounded-full bg-pink-500"></span>
        <span class="text-xs font-medium text-pink-700">Confiseries</span>
        <span class="text-sm font-bold text-pink-800">{{ stats.confectionery }}</span>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="input-label">Catégorie</label>
            <select v-model="filters.category" class="input">
              <option value="">Toutes</option>
              <option value="cleaning">Ménage & Confort</option>
              <option value="wine">Vins</option>
              <option value="confectionery">Confiseries</option>
              <option value="other">Autres</option>
            </select>
          </div>
          <div>
            <label class="input-label">Statut</label>
            <select v-model="filters.status" class="input">
              <option value="">Tous</option>
              <option value="active">Actif</option>
              <option value="inactive">Inactif</option>
            </select>
          </div>
          <div>
            <label class="input-label">Recherche</label>
            <input v-model="filters.search" type="text" placeholder="Rechercher..." class="input" />
          </div>
        </div>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="card p-8 text-center">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
      <p class="mt-3 text-navy-400 text-sm">Chargement des options...</p>
    </div>

    <!-- Options Table -->
    <div v-else-if="filteredOptions.length > 0" class="card overflow-hidden">
      <table class="min-w-full">
        <thead class="table-header">
          <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Type</th>
            <th>Statut</th>
            <th class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="option in filteredOptions" :key="option.id" class="table-row group">
            <td>
              <img
                v-if="option.image_url"
                :src="option.image_url"
                :alt="option.name"
                class="h-10 w-10 rounded-lg object-cover ring-1 ring-navy-100"
              />
              <div v-else class="h-10 w-10 rounded-lg bg-navy-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-navy-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                </svg>
              </div>
            </td>
            <td>
              <div class="font-medium text-navy-900">{{ option.name }}</div>
              <div v-if="option.description" class="text-xs text-navy-400 truncate max-w-xs">{{ option.description }}</div>
            </td>
            <td>
              <span
                class="badge"
                :class="{
                  'badge-success': option.category === 'cleaning',
                  'badge-info': option.category === 'wine',
                  'badge-gold': option.category === 'confectionery',
                  'badge-neutral': option.category === 'other'
                }"
              >
                {{ getCategoryLabel(option.category) }}
              </span>
            </td>
            <td>
              <span class="font-semibold text-navy-900">{{ formatPrice(option.price) }}</span>
            </td>
            <td>
              <span class="text-xs text-navy-400">{{ option.price_type === 'per_night' ? '/ nuit' : 'unique' }}</span>
            </td>
            <td>
              <span class="badge" :class="option.is_active ? 'badge-success' : 'badge-danger'">
                <span class="w-1.5 h-1.5 rounded-full" :class="option.is_active ? 'bg-emerald-500' : 'bg-red-500'"></span>
                {{ option.is_active ? 'Actif' : 'Inactif' }}
              </span>
            </td>
            <td class="text-right">
              <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button @click="editOption(option)" class="btn btn-ghost btn-sm" title="Modifier">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                </button>
                <button @click="deleteOption(option.id)" class="btn btn-sm text-red-500 hover:bg-red-50 hover:text-red-700" title="Supprimer">
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

    <!-- Empty State -->
    <div v-else class="card p-12 text-center">
      <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-navy-50 mb-4">
        <svg class="w-7 h-7 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
      </div>
      <p class="text-navy-700 font-medium mb-1">Aucune option trouvée</p>
      <p class="text-navy-400 text-sm mb-4">Ajustez vos filtres ou créez une nouvelle option.</p>
      <button @click="resetFilters" class="btn btn-outline btn-sm">Réinitialiser les filtres</button>
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
                {{ editingOption ? 'Modifier l\'option' : 'Nouvelle option' }}
              </h2>
              <p class="text-navy-300 text-xs mt-0.5">
                {{ editingOption ? 'Mettez à jour les informations' : 'Créez une nouvelle option supplémentaire' }}
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
        <form @submit.prevent="saveOption" class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
          <div class="space-y-4">
            <div>
              <label class="input-label">Nom <span class="text-red-400">*</span></label>
              <input v-model="form.name" type="text" required placeholder="Ex: Ménage de fin de séjour" class="input" />
            </div>

            <div>
              <label class="input-label">Description</label>
              <textarea v-model="form.description" rows="2" placeholder="Description..." class="input"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="input-label">Catégorie <span class="text-red-400">*</span></label>
                <select v-model="form.category" required class="input">
                  <option value="">Sélectionner</option>
                  <option value="cleaning">Ménage & Confort</option>
                  <option value="wine">Vin</option>
                  <option value="confectionery">Confiserie</option>
                  <option value="other">Autre</option>
                </select>
              </div>
              <div>
                <label class="input-label">Type de prix <span class="text-red-400">*</span></label>
                <select v-model="form.price_type" required class="input">
                  <option value="one_time">Unique</option>
                  <option value="per_night">Par nuit</option>
                </select>
              </div>
            </div>

            <div>
              <label class="input-label">Prix (€) <span class="text-red-400">*</span></label>
              <input v-model.number="form.price" type="number" step="0.01" min="0" required placeholder="50.00" class="input" />
              <p class="text-xs text-navy-300 mt-1">Le prix sera stocké en centimes</p>
            </div>

            <div>
              <label class="input-label">URL de l'image</label>
              <input v-model="form.image_url" type="url" placeholder="https://example.com/image.jpg" class="input" />
            </div>

            <div class="bg-navy-50/50 rounded-lg p-3 border border-navy-100">
              <label class="flex items-center justify-between cursor-pointer">
                <div>
                  <div class="text-sm font-medium text-navy-800">Option active</div>
                  <div class="text-xs text-navy-400">Visible par les clients lors de la réservation</div>
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
              {{ saving ? 'Enregistrement...' : (editingOption ? 'Mettre à jour' : 'Créer') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import axios from '../api/axios'

interface ComfortOption {
  id: number
  name: string
  description: string | null
  price: number
  price_type: 'per_night' | 'one_time'
  category: 'cleaning' | 'wine' | 'confectionery' | 'other'
  image_url: string | null
  is_active: boolean
}

const options = ref<ComfortOption[]>([])
const loading = ref(false)
const saving = ref(false)
const showModal = ref(false)
const editingOption = ref<ComfortOption | null>(null)

const filters = ref({
  category: '',
  status: '',
  search: ''
})

const form = ref({
  name: '',
  description: '',
  price: 0,
  price_type: 'one_time' as 'per_night' | 'one_time',
  category: '' as 'cleaning' | 'wine' | 'confectionery' | 'other' | '',
  image_url: '',
  is_active: true
})

const stats = computed(() => ({
  total: options.value.length,
  cleaning: options.value.filter(o => o.category === 'cleaning').length,
  wine: options.value.filter(o => o.category === 'wine').length,
  confectionery: options.value.filter(o => o.category === 'confectionery').length
}))

const filteredOptions = computed(() => {
  return options.value.filter(option => {
    if (filters.value.category && option.category !== filters.value.category) return false
    if (filters.value.status === 'active' && !option.is_active) return false
    if (filters.value.status === 'inactive' && option.is_active) return false
    if (filters.value.search) {
      const search = filters.value.search.toLowerCase()
      return option.name.toLowerCase().includes(search) || option.description?.toLowerCase().includes(search)
    }
    return true
  })
})

function getCategoryLabel(category: string): string {
  const labels: Record<string, string> = {
    cleaning: 'Ménage',
    wine: 'Vin',
    confectionery: 'Confiserie',
    other: 'Autre'
  }
  return labels[category] || category
}

function formatPrice(priceInCents: number): string {
  return `${(priceInCents / 100).toFixed(2)}€`
}

function resetFilters() {
  filters.value = { category: '', status: '', search: '' }
}

function openCreateModal() {
  editingOption.value = null
  form.value = { name: '', description: '', price: 0, price_type: 'one_time', category: '', image_url: '', is_active: true }
  showModal.value = true
}

function editOption(option: ComfortOption) {
  editingOption.value = option
  form.value = {
    name: option.name,
    description: option.description || '',
    price: option.price / 100,
    price_type: option.price_type,
    category: option.category,
    image_url: option.image_url || '',
    is_active: option.is_active
  }
  showModal.value = true
}

function closeModal() {
  showModal.value = false
  editingOption.value = null
}

async function saveOption() {
  saving.value = true
  try {
    const data = { ...form.value, price: Math.round(form.value.price * 100) }
    if (editingOption.value) {
      await axios.put(`/comfort-options/${editingOption.value.id}`, data)
    } else {
      await axios.post('/comfort-options', data)
    }
    await fetchOptions()
    closeModal()
  } catch (error: any) {
    console.error('Failed to save option:', error)
    alert(error.response?.data?.message || 'Erreur lors de l\'enregistrement')
  } finally {
    saving.value = false
  }
}

async function deleteOption(id: number) {
  if (!confirm('Êtes-vous sûr de vouloir supprimer cette option ?')) return
  try {
    await axios.delete(`/comfort-options/${id}`)
    await fetchOptions()
  } catch (error: any) {
    console.error('Failed to delete option:', error)
    alert(error.response?.data?.message || 'Erreur lors de la suppression')
  }
}

async function fetchOptions() {
  loading.value = true
  try {
    const response = await axios.get('/comfort-options')
    options.value = response.data.data
  } catch (error) {
    console.error('Failed to fetch options:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchOptions()
})
</script>
