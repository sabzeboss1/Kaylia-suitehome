<template>
  <div class="animate-fade-in">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Avis clients</h1>
        <p class="page-subtitle">Modérer les avis et notes des clients</p>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="input-label">Statut</label>
            <select v-model="filters.status" class="input" @change="fetchReviews">
              <option value="">Tous</option>
              <option value="pending">En attente</option>
              <option value="approved">Approuvé</option>
              <option value="rejected">Rejeté</option>
            </select>
          </div>
          <div>
            <label class="input-label">Note</label>
            <select v-model="filters.rating" class="input" @change="fetchReviews">
              <option value="">Toutes</option>
              <option value="5">5 étoiles</option>
              <option value="4">4 étoiles</option>
              <option value="3">3 étoiles</option>
              <option value="2">2 étoiles</option>
              <option value="1">1 étoile</option>
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
      <p class="mt-3 text-navy-400 text-sm">Chargement des avis...</p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="card p-6 border-red-200 bg-red-50 text-red-600 text-sm">{{ error }}</div>

    <!-- Reviews Table -->
    <div v-else-if="reviews.length > 0" class="card overflow-hidden">
      <table class="min-w-full">
        <thead class="table-header">
          <tr>
            <th>Client</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Concernant</th>
            <th>Statut</th>
            <th>Date</th>
            <th class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="review in reviews" :key="review.id" class="table-row group">
            <td>
              <span class="font-medium text-navy-900 text-sm">
                {{ review.customer?.first_name }} {{ review.customer?.last_name }}
              </span>
            </td>
            <td>
              <div class="flex items-center gap-1">
                <div class="flex">
                  <svg v-for="n in 5" :key="n" class="w-3.5 h-3.5" :class="n <= review.rating ? 'text-gold-500' : 'text-navy-100'" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" />
                  </svg>
                </div>
                <span class="text-xs text-navy-400 ml-1">{{ review.rating }}/5</span>
              </div>
            </td>
            <td>
              <span class="text-sm text-navy-600 line-clamp-2 max-w-xs block">{{ review.comment }}</span>
            </td>
            <td>
              <span class="text-xs text-navy-400">
                {{ review.reviewable_type === 'App\\Models\\Apartment' ? 'Appartement' : 'Service SPA' }}
              </span>
              <div class="text-xs font-medium text-navy-700">{{ getReviewableTitle(review) }}</div>
            </td>
            <td>
              <span class="badge" :class="getStatusBadgeClass(review.is_approved)">
                <span class="w-1.5 h-1.5 rounded-full" :class="getStatusDotClass(review.is_approved)"></span>
                {{ getStatusText(review.is_approved) }}
              </span>
            </td>
            <td>
              <span class="text-xs text-navy-400">{{ formatDate(review.created_at) }}</span>
            </td>
            <td class="text-right">
              <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button
                  v-if="review.is_approved === null"
                  @click="approveReview(review.id)"
                  class="btn btn-sm text-emerald-600 hover:bg-emerald-50"
                  title="Approuver"
                >
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                </button>
                <button
                  v-if="review.is_approved === null"
                  @click="rejectReview(review.id)"
                  class="btn btn-sm text-amber-600 hover:bg-amber-50"
                  title="Rejeter"
                >
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
                <button
                  @click="deleteReview(review.id)"
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
          {{ pagination.total }} avis
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
    <div v-else class="card p-12 text-center">
      <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-navy-50 mb-4">
        <svg class="w-7 h-7 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
        </svg>
      </div>
      <p class="text-navy-700 font-medium mb-1">Aucun avis trouvé</p>
      <p class="text-navy-400 text-sm">Aucun avis ne correspond à vos filtres.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../api/axios';

const reviews = ref([]);
const loading = ref(false);
const error = ref(null);

const filters = ref({ status: 'pending', rating: '' });

const pagination = ref({ current_page: 1, per_page: 20, total: 0, last_page: 1 });

const fetchReviews = async () => {
  loading.value = true;
  error.value = null;
  try {
    const params = { page: pagination.value.current_page, per_page: pagination.value.per_page };
    if (filters.value.status) {
      if (filters.value.status === 'pending') params.is_approved = 'null';
      else if (filters.value.status === 'approved') params.is_approved = '1';
      else if (filters.value.status === 'rejected') params.is_approved = '0';
    }
    if (filters.value.rating) params.rating = filters.value.rating;
    const response = await axios.get('/reviews', { params });
    reviews.value = response.data.data;
    pagination.value = response.data.meta;
  } catch (err) {
    error.value = err.response?.data?.message || 'Échec du chargement des avis';
  } finally {
    loading.value = false;
  }
};

const resetFilters = () => { filters.value = { status: '', rating: '' }; pagination.value.current_page = 1; fetchReviews(); };
const changePage = (page) => { pagination.value.current_page = page; fetchReviews(); };

const approveReview = async (id) => {
  try { await axios.put(`/reviews/${id}/approve`); fetchReviews(); }
  catch (err) { alert(err.response?.data?.message || 'Échec de l\'approbation'); }
};

const rejectReview = async (id) => {
  try { await axios.put(`/reviews/${id}/reject`); fetchReviews(); }
  catch (err) { alert(err.response?.data?.message || 'Échec du rejet'); }
};

const deleteReview = async (id) => {
  if (!confirm('Supprimer cet avis ?')) return;
  try { await axios.delete(`/reviews/${id}`); fetchReviews(); }
  catch (err) { alert(err.response?.data?.message || 'Échec de la suppression'); }
};

const getStatusBadgeClass = (isApproved) => {
  if (isApproved === null) return 'badge-gold';
  if (isApproved === 1 || isApproved === true) return 'badge-success';
  return 'badge-danger';
};

const getStatusDotClass = (isApproved) => {
  if (isApproved === null) return 'bg-amber-500';
  if (isApproved === 1 || isApproved === true) return 'bg-emerald-500';
  return 'bg-red-500';
};

const getStatusText = (isApproved) => {
  if (isApproved === null) return 'En attente';
  if (isApproved === 1 || isApproved === true) return 'Approuvé';
  return 'Rejeté';
};

const getReviewableTitle = (review) => {
  if (review.reviewable_type === 'App\\Models\\Apartment') return review.apartment?.name || 'Inconnu';
  return review.spa_service?.name || 'Inconnu';
};

const formatDate = (dateString) => new Date(dateString).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });

onMounted(() => { fetchReviews(); });
</script>
