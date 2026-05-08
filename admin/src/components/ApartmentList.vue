<template>
  <div class="animate-fade-in">
    <!-- Header with Create Button -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Appartements</h1>
        <p class="page-subtitle">Gérer votre catalogue d'appartements</p>
      </div>
      <button
        @click="$emit('create')"
        class="btn btn-primary"
      >
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nouvel appartement
      </button>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Search -->
          <div>
            <label class="input-label">Rechercher</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
              </div>
              <input
                v-model="filters.search"
                type="text"
                placeholder="Nom de l'appartement..."
                class="input pl-10"
                @input="debouncedSearch"
              />
            </div>
          </div>

          <!-- Type Filter -->
          <div>
            <label class="input-label">Type</label>
            <select
              v-model="filters.type"
              class="input"
              @change="applyFilters"
            >
              <option value="">Tous les types</option>
              <option value="studio">Studio</option>
              <option value="t2">T2</option>
              <option value="t3">T3</option>
            </select>
          </div>

          <!-- Availability Filter -->
          <div>
            <label class="input-label">Disponibilité</label>
            <select
              v-model="filters.is_available"
              class="input"
              @change="applyFilters"
            >
              <option value="">Tous</option>
              <option value="true">Disponible</option>
              <option value="false">Indisponible</option>
            </select>
          </div>

          <!-- Price Range -->
          <div>
            <label class="input-label">Fourchette de prix (€)</label>
            <div class="flex gap-2">
              <input
                v-model.number="filters.min_price"
                type="number"
                placeholder="Min"
                class="input"
                @change="applyFilters"
              />
              <input
                v-model.number="filters.max_price"
                type="number"
                placeholder="Max"
                class="input"
                @change="applyFilters"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Apartments Grid / Table -->
    <div class="card overflow-hidden">
      <!-- Loading State -->
      <div v-if="loading" class="p-12 text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
        <p class="mt-3 text-navy-400 text-sm">Chargement des appartements...</p>
      </div>

      <!-- Empty State -->
      <div v-else-if="apartments.length === 0" class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-navy-50 mb-4">
          <svg class="w-8 h-8 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 21h19.5M3.75 3v18m4.5-18v18m4.5-18v18m4.5-18v18M5.25 9h.008v.008H5.25V9zm0 3h.008v.008H5.25V12zm0 3h.008v.008H5.25V15zm4.5-6h.008v.008H9.75V9zm0 3h.008v.008H9.75V12zm0 3h.008v.008H9.75V15zm4.5-6h.008v.008h-.008V9zm0 3h.008v.008h-.008V12zm0 3h.008v.008h-.008V15z" />
          </svg>
        </div>
        <p class="text-navy-700 font-medium mb-1">Aucun appartement trouvé</p>
        <p class="text-navy-400 text-sm">Ajustez vos filtres ou créez un nouvel appartement.</p>
        <button @click="$emit('create')" class="btn btn-primary mt-4">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Créer un appartement
        </button>
      </div>

      <!-- Table -->
      <div v-else class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="table-header">
            <tr>
              <th>Image</th>
              <th>Nom</th>
              <th>Type</th>
              <th>Capacité</th>
              <th>Prix / Nuit</th>
              <th>Statut</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="apartment in apartments" :key="apartment.id" class="table-row group">
              <td>
                <img
                  v-if="apartment.images && apartment.images.length > 0"
                  :src="apartment.images[0].thumbnail_url || apartment.images[0].image_url"
                  :alt="apartment.images[0].alt_text || apartment.name"
                  class="h-14 w-20 object-cover rounded-lg ring-1 ring-navy-100"
                />
                <div v-else class="h-14 w-20 bg-navy-50 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-navy-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                  </svg>
                </div>
              </td>
              <td>
                <div class="font-medium text-navy-900">{{ apartment.name }}</div>
                <div v-if="apartment.is_featured" class="flex items-center gap-1.5 mt-1">
                  <svg class="w-3.5 h-3.5 text-gold-500" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" />
                  </svg>
                  <span class="text-xs text-gold-600 font-medium">En vedette</span>
                </div>
              </td>
              <td>
                <span class="badge badge-info">{{ apartment.type.toUpperCase() }}</span>
              </td>
              <td>
                <div class="flex items-center gap-1.5">
                  <svg class="w-4 h-4 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                  </svg>
                  <span>{{ apartment.capacity }} {{ apartment.capacity === 1 ? 'pers.' : 'pers.' }}</span>
                </div>
              </td>
              <td>
                <span class="font-semibold text-navy-900">{{ formatCurrency(apartment.pricePerNight) }}</span>
              </td>
              <td>
                <span
                  class="badge"
                  :class="apartment.available ? 'badge-success' : 'badge-danger'"
                >
                  <span class="w-1.5 h-1.5 rounded-full" :class="apartment.available ? 'bg-emerald-500' : 'bg-red-500'"></span>
                  {{ apartment.available ? 'Disponible' : 'Indisponible' }}
                </span>
              </td>
              <td class="text-right">
                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                  <button
                    @click="$emit('edit', apartment)"
                    class="btn btn-ghost btn-sm"
                    title="Modifier"
                  >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Modifier
                  </button>
                  <button
                    @click="confirmDelete(apartment)"
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
      </div>

      <!-- Pagination -->
      <div v-if="meta.total > 0" class="px-6 py-4 flex items-center justify-between border-t border-gray-100">
        <div class="text-xs text-navy-400">
          {{ ((meta.current_page - 1) * meta.per_page) + 1 }} à
          {{ Math.min(meta.current_page * meta.per_page, meta.total) }} sur
          {{ meta.total }} résultats
        </div>
        <div class="flex gap-1">
          <button
            @click="changePage(meta.current_page - 1)"
            :disabled="meta.current_page === 1"
            class="btn btn-outline btn-sm"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
          </button>
          <button
            v-for="page in visiblePages"
            :key="page"
            @click="changePage(page)"
            :class="[
              'btn btn-sm',
              page === meta.current_page
                ? 'btn-primary'
                : 'btn-outline'
            ]"
          >{{ page }}</button>
          <button
            @click="changePage(meta.current_page + 1)"
            :disabled="meta.current_page === meta.last_page"
            class="btn btn-outline btn-sm"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      v-if="showDeleteModal"
      class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm flex items-center justify-center z-50"
      @click.self="showDeleteModal = false"
    >
      <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 shadow-xl animate-slide-down">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-bold text-navy-900">Confirmer la suppression</h3>
            <p class="text-sm text-navy-400">Cette action est irréversible</p>
          </div>
        </div>
        <p class="text-sm text-navy-600 mb-6">
          Êtes-vous sûr de vouloir supprimer « <strong>{{ apartmentToDelete?.name }}</strong> » ? 
          Toutes les données associées seront perdues.
        </p>
        <div class="flex justify-end gap-3">
          <button
            @click="showDeleteModal = false"
            class="btn btn-outline"
          >
            Annuler
          </button>
          <button
            @click="deleteApartment"
            :disabled="deleting"
            class="btn btn-danger"
          >
            <svg v-if="deleting" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ deleting ? 'Suppression...' : 'Supprimer' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import apiClient from '../api/axios'

// Emits
const emit = defineEmits(['create', 'edit', 'deleted'])

// State
const loading = ref(false)
const apartments = ref([])
const meta = ref({
  current_page: 1,
  per_page: 20,
  total: 0,
  last_page: 1
})

const filters = ref({
  search: '',
  type: '',
  is_available: '',
  min_price: null,
  max_price: null
})

const showDeleteModal = ref(false)
const apartmentToDelete = ref(null)
const deleting = ref(false)

// Debounce timer for search
let searchTimeout = null

// Computed
const visiblePages = computed(() => {
  const pages = []
  const current = meta.value.current_page
  const last = meta.value.last_page
  
  let start = Math.max(1, current - 2)
  let end = Math.min(last, start + 4)
  
  if (end - start < 4) {
    start = Math.max(1, end - 4)
  }
  
  for (let i = start; i <= end; i++) {
    pages.push(i)
  }
  
  return pages
})

// Methods
const fetchApartments = async (page = 1) => {
  try {
    loading.value = true
    
    const params = {
      page,
      per_page: meta.value.per_page
    }
    
    if (filters.value.search) params.search = filters.value.search
    if (filters.value.type) params.type = filters.value.type
    if (filters.value.is_available !== '') params.is_available = filters.value.is_available
    if (filters.value.min_price) params.min_price = filters.value.min_price
    if (filters.value.max_price) params.max_price = filters.value.max_price
    
    const response = await apiClient.get('/apartments', { params })
    
    apartments.value = response.data.data
    meta.value = response.data.meta
    
    loading.value = false
  } catch (error) {
    console.error('Error fetching apartments:', error)
    loading.value = false
  }
}

const applyFilters = () => {
  fetchApartments(1)
}

const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    applyFilters()
  }, 500)
}

const changePage = (page) => {
  if (page >= 1 && page <= meta.value.last_page) {
    fetchApartments(page)
  }
}

const confirmDelete = (apartment) => {
  apartmentToDelete.value = apartment
  showDeleteModal.value = true
}

const deleteApartment = async () => {
  try {
    deleting.value = true
    await apiClient.delete(`/apartments/${apartmentToDelete.value.id}`)
    
    showDeleteModal.value = false
    apartmentToDelete.value = null
    deleting.value = false
    
    fetchApartments(meta.value.current_page)
    
    emit('deleted')
  } catch (error) {
    console.error('Error deleting apartment:', error)
    deleting.value = false
    alert('Échec de la suppression. Veuillez réessayer.')
  }
}

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR'
  }).format(amount)
}

// Lifecycle
onMounted(() => {
  fetchApartments()
})

// Expose method for parent to refresh
defineExpose({
  refresh: fetchApartments
})
</script>
