<template>
  <div class="animate-fade-in">
    <!-- Page Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Vue d'ensemble de votre activité</p>
      </div>
      <div class="flex items-center gap-3">
        <span class="text-xs text-navy-400">
          Dernière mise à jour : {{ lastUpdated }}
        </span>
        <button @click="fetchDashboardData" class="btn btn-outline btn-sm" :disabled="loading">
          <svg class="w-4 h-4" :class="{ 'animate-spin': loading }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
          </svg>
          Actualiser
        </button>
      </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
      <div class="stat-card bg-gradient-to-br from-navy-900 to-navy-800">
        <div class="relative z-10">
          <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
              <svg class="w-5 h-5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
              </svg>
            </div>
            <span class="badge badge-gold text-[10px]">Aujourd'hui</span>
          </div>
          <p class="text-white/60 text-sm">Réservations du jour</p>
          <p class="text-3xl font-bold text-white mt-1">
            {{ loading ? '—' : stats.today_reservations }}
          </p>
        </div>
      </div>

      <div class="stat-card bg-gradient-to-br from-navy-800 to-navy-700">
        <div class="relative z-10">
          <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
              <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
              </svg>
            </div>
            <span class="badge badge-success text-[10px]">Ce mois</span>
          </div>
          <p class="text-white/60 text-sm">Revenu mensuel</p>
          <p class="text-3xl font-bold text-white mt-1">
            {{ loading ? '—' : formatCurrency(stats.monthly_revenue) }}
          </p>
        </div>
      </div>

      <div class="stat-card bg-gradient-to-br from-navy-800 to-navy-700">
        <div class="relative z-10">
          <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
              <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
              </svg>
            </div>
          </div>
          <p class="text-white/60 text-sm">Taux d'occupation</p>
          <p class="text-3xl font-bold text-white mt-1">
            {{ loading ? '—' : stats.occupancy_rate + '%' }}
          </p>
        </div>
      </div>

      <div class="stat-card bg-gradient-to-br from-navy-900 to-navy-800">
        <div class="relative z-10">
          <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
              <svg class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>
            </div>
            <span class="badge badge-info text-[10px]">Nouveau</span>
          </div>
          <p class="text-white/60 text-sm">Nouveaux clients</p>
          <p class="text-3xl font-bold text-white mt-1">
            {{ loading ? '—' : stats.new_customers }}
          </p>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8">
      <div class="card">
        <div class="card-header flex items-center justify-between">
          <h2 class="text-base font-semibold text-navy-800">Tendance des réservations</h2>
          <span class="text-xs text-navy-400">30 derniers jours</span>
        </div>
        <div class="card-body">
          <canvas ref="reservationTrendChart"></canvas>
        </div>
      </div>

      <div class="card">
        <div class="card-header flex items-center justify-between">
          <h2 class="text-base font-semibold text-navy-800">Tendance des revenus</h2>
          <span class="text-xs text-navy-400">12 derniers mois</span>
        </div>
        <div class="card-body">
          <canvas ref="revenueTrendChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Most Reserved Apartments -->
    <div class="card mb-8">
      <div class="card-header">
        <h2 class="text-base font-semibold text-navy-800">Appartements les plus réservés</h2>
      </div>
      <div v-if="loading" class="card-body text-navy-400 text-sm">Chargement...</div>
      <div v-else-if="mostReservedApartments.length === 0" class="card-body">
        <div class="text-center py-8">
          <svg class="w-12 h-12 text-navy-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 21h19.5M3.75 3v18m4.5-18v18m4.5-18v18m4.5-18v18" />
          </svg>
          <p class="text-sm text-navy-400">Aucune donnée disponible</p>
        </div>
      </div>
      <div v-else class="table-container border-0">
        <table class="min-w-full">
          <thead class="table-header">
            <tr>
              <th>#</th>
              <th>Appartement</th>
              <th>Type</th>
              <th>Prix/Nuit</th>
              <th>Réservations</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(apartment, index) in mostReservedApartments" :key="apartment.apartment_id" class="table-row">
              <td class="font-semibold text-navy-900">{{ index + 1 }}</td>
              <td class="font-medium text-navy-900">{{ apartment.apartment_name }}</td>
              <td>
                <span class="badge badge-info">{{ apartment.apartment_type }}</span>
              </td>
              <td class="font-medium">{{ formatCurrency(apartment.price_per_night) }}</td>
              <td>
                <span class="font-bold text-navy-900">{{ apartment.reservation_count }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8">
      <!-- Recent Reservations -->
      <div class="card">
        <div class="card-header flex items-center justify-between">
          <h2 class="text-base font-semibold text-navy-800">Réservations récentes</h2>
          <router-link to="/reservations" class="text-xs text-gold-600 hover:text-gold-700 font-medium">Tout voir →</router-link>
        </div>
        <div v-if="loading" class="card-body text-navy-400 text-sm">Chargement...</div>
        <div v-else-if="recentReservations.length === 0" class="card-body text-center py-8">
          <p class="text-sm text-navy-400">Aucune réservation récente</p>
        </div>
        <div v-else class="divide-y divide-surface-100">
          <div v-for="reservation in recentReservations" :key="reservation.id" 
               class="px-6 py-4 flex items-start justify-between hover:bg-surface-50/50 transition-colors">
            <div class="flex items-start gap-3">
              <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0"
                   :class="getStatusDotClass(reservation.status)"></div>
              <div>
                <p class="text-sm font-medium text-navy-800">{{ reservation.customer.name }}</p>
                <p class="text-xs text-navy-400 mt-0.5">{{ reservation.apartment.name }}</p>
                <p class="text-xs text-navy-300 mt-1">
                  {{ formatDate(reservation.check_in_date) }} → {{ formatDate(reservation.check_out_date) }}
                </p>
              </div>
            </div>
            <div class="text-right flex-shrink-0">
              <span class="badge text-[10px]"
                    :class="getStatusBadgeClass(reservation.status)">
                {{ getStatusLabel(reservation.status) }}
              </span>
              <p class="text-sm font-semibold text-navy-800 mt-1">{{ formatCurrency(reservation.total_price) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Contact Messages -->
      <div class="card">
        <div class="card-header flex items-center justify-between">
          <div class="flex items-center gap-2">
            <h2 class="text-base font-semibold text-navy-800">Messages récents</h2>
            <span v-if="contactMessages.unread_count > 0" 
                  class="badge badge-danger text-[10px]">
              {{ contactMessages.unread_count }} non lus
            </span>
          </div>
          <router-link to="/contact-messages" class="text-xs text-gold-600 hover:text-gold-700 font-medium">Tout voir →</router-link>
        </div>
        <div v-if="loading" class="card-body text-navy-400 text-sm">Chargement...</div>
        <div v-else-if="contactMessages.messages.length === 0" class="card-body text-center py-8">
          <p class="text-sm text-navy-400">Aucun message</p>
        </div>
        <div v-else class="divide-y divide-surface-100">
          <div v-for="message in contactMessages.messages.slice(0, 5)" :key="message.id" 
               class="px-6 py-4 hover:bg-surface-50/50 transition-colors">
            <div class="flex items-start justify-between">
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <p class="text-sm font-medium text-navy-800">{{ message.name }}</p>
                  <div v-if="message.status === 'new'" class="w-1.5 h-1.5 rounded-full bg-red-500"></div>
                </div>
                <p class="text-xs text-navy-500 mt-0.5 font-medium">{{ message.subject }}</p>
                <p class="text-xs text-navy-300 mt-1 truncate">{{ message.message }}</p>
              </div>
              <span class="badge text-[10px] flex-shrink-0 ml-3"
                    :class="message.status === 'new' ? 'badge-danger' : 'badge-neutral'">
                {{ message.status === 'new' ? 'Nouveau' : 'Lu' }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Reviews -->
    <div class="card">
      <div class="card-header flex items-center justify-between">
        <div class="flex items-center gap-2">
          <h2 class="text-base font-semibold text-navy-800">Avis en attente</h2>
          <span v-if="pendingReviews.pending_count > 0" 
                class="badge badge-warning text-[10px]">
            {{ pendingReviews.pending_count }} en attente
          </span>
        </div>
        <router-link to="/reviews" class="text-xs text-gold-600 hover:text-gold-700 font-medium">Tout voir →</router-link>
      </div>
      <div v-if="loading" class="card-body text-navy-400 text-sm">Chargement...</div>
      <div v-else-if="pendingReviews.reviews.length === 0" class="card-body text-center py-8">
        <p class="text-sm text-navy-400">Aucun avis en attente</p>
      </div>
      <div v-else class="divide-y divide-surface-100">
        <div v-for="review in pendingReviews.reviews.slice(0, 5)" :key="review.id" 
             class="px-6 py-4 hover:bg-surface-50/50 transition-colors">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center gap-2">
                <p class="text-sm font-medium text-navy-800">{{ review.customer.name }}</p>
                <div class="flex items-center gap-0.5">
                  <svg v-for="n in 5" :key="n" class="w-3.5 h-3.5" 
                       :class="n <= Math.floor(review.rating) ? 'text-gold-500' : 'text-navy-200'"
                       viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" />
                  </svg>
                  <span class="text-xs text-navy-400 ml-1">({{ review.rating }})</span>
                </div>
              </div>
              <p class="text-xs text-navy-500 mt-0.5">{{ review.reviewable_type }}: {{ review.reviewable_name }}</p>
              <p class="text-xs text-navy-300 mt-1">{{ review.comment }}</p>
            </div>
            <span class="text-xs text-navy-300 flex-shrink-0 ml-3">{{ formatDate(review.created_at) }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Chart, registerables } from 'chart.js'
import axios from '../api/axios'

Chart.register(...registerables)

// State
const loading = ref(true)
const lastUpdated = ref('')
const stats = ref({
  today_reservations: 0,
  monthly_revenue: 0,
  occupancy_rate: 0,
  new_customers: 0
})
const mostReservedApartments = ref([])
const recentReservations = ref([])
const contactMessages = ref({
  unread_count: 0,
  messages: []
})
const pendingReviews = ref({
  pending_count: 0,
  reviews: []
})

// Chart refs
const reservationTrendChart = ref(null)
const revenueTrendChart = ref(null)
let reservationChart = null
let revenueChart = null

// Auto-refresh interval
let refreshInterval = null

// Fetch all dashboard data
const fetchDashboardData = async () => {
  try {
    loading.value = true
    
    const [
      statsRes,
      reservationTrendRes,
      revenueTrendRes,
      mostReservedRes,
      recentReservationsRes,
      contactMessagesRes,
      pendingReviewsRes
    ] = await Promise.all([
      axios.get('/dashboard/stats'),
      axios.get('/dashboard/reservations-trend'),
      axios.get('/dashboard/revenue-trend'),
      axios.get('/dashboard/most-reserved-apartments'),
      axios.get('/dashboard/recent-reservations'),
      axios.get('/dashboard/recent-contact-messages'),
      axios.get('/dashboard/pending-reviews')
    ])

    stats.value = statsRes.data.data
    mostReservedApartments.value = mostReservedRes.data.data
    recentReservations.value = recentReservationsRes.data.data
    contactMessages.value = contactMessagesRes.data.data
    pendingReviews.value = pendingReviewsRes.data.data

    updateReservationTrendChart(reservationTrendRes.data.data)
    updateRevenueTrendChart(revenueTrendRes.data.data)

    lastUpdated.value = new Date().toLocaleTimeString('fr-FR')
    
    loading.value = false
  } catch (error) {
    console.error('Error fetching dashboard data:', error)
    loading.value = false
  }
}

// Chart theme colors
const chartColors = {
  primary: { border: 'rgb(197, 164, 126)', bg: 'rgba(197, 164, 126, 0.1)' },
  secondary: { border: 'rgb(26, 31, 54)', bg: 'rgba(26, 31, 54, 0.8)' },
  grid: 'rgba(26, 31, 54, 0.06)',
  text: 'rgb(107, 114, 128)'
}

// Update reservation trend chart
const updateReservationTrendChart = (data) => {
  const ctx = reservationTrendChart.value?.getContext('2d')
  if (!ctx) return

  if (reservationChart) reservationChart.destroy()

  reservationChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: data.map(item => new Date(item.date).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' })),
      datasets: [{
        label: 'Réservations',
        data: data.map(item => item.count),
        borderColor: chartColors.primary.border,
        backgroundColor: chartColors.primary.bg,
        tension: 0.4,
        fill: true,
        borderWidth: 2,
        pointRadius: 0,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: chartColors.primary.border,
        pointHoverBorderColor: '#fff',
        pointHoverBorderWidth: 2,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      interaction: { intersect: false, mode: 'index' },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1a1f36',
          titleColor: '#fff',
          bodyColor: 'rgba(255,255,255,0.8)',
          borderColor: 'rgba(197, 164, 126, 0.3)',
          borderWidth: 1,
          cornerRadius: 8,
          padding: 12,
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1, color: chartColors.text, font: { size: 11 } },
          grid: { color: chartColors.grid },
          border: { display: false }
        },
        x: {
          ticks: { color: chartColors.text, font: { size: 11 }, maxRotation: 0 },
          grid: { display: false },
          border: { display: false }
        }
      }
    }
  })
}

// Update revenue trend chart
const updateRevenueTrendChart = (data) => {
  const ctx = revenueTrendChart.value?.getContext('2d')
  if (!ctx) return

  if (revenueChart) revenueChart.destroy()

  revenueChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: data.map(item => item.month_name),
      datasets: [{
        label: 'Revenus',
        data: data.map(item => item.total),
        backgroundColor: chartColors.secondary.bg,
        borderColor: 'transparent',
        borderWidth: 0,
        borderRadius: 6,
        borderSkipped: false
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      interaction: { intersect: false, mode: 'index' },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1a1f36',
          titleColor: '#fff',
          bodyColor: 'rgba(255,255,255,0.8)',
          borderColor: 'rgba(197, 164, 126, 0.3)',
          borderWidth: 1,
          cornerRadius: 8,
          padding: 12,
          callbacks: {
            label: function(context) {
              return formatCurrency(context.raw)
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: chartColors.text,
            font: { size: 11 },
            callback: function(value) { return formatCurrency(value) }
          },
          grid: { color: chartColors.grid },
          border: { display: false }
        },
        x: {
          ticks: { color: chartColors.text, font: { size: 11 } },
          grid: { display: false },
          border: { display: false }
        }
      }
    }
  })
}

// Format currency
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    maximumFractionDigits: 0
  }).format(amount)
}

// Format date
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

// Status helpers
const getStatusDotClass = (status) => {
  const classes = {
    pending: 'bg-amber-400',
    confirmed: 'bg-emerald-400',
    cancelled: 'bg-red-400',
    completed: 'bg-blue-400'
  }
  return classes[status] || 'bg-gray-400'
}

const getStatusBadgeClass = (status) => {
  const classes = {
    pending: 'badge-warning',
    confirmed: 'badge-success',
    cancelled: 'badge-danger',
    completed: 'badge-info'
  }
  return classes[status] || 'badge-neutral'
}

const getStatusLabel = (status) => {
  const labels = {
    pending: 'En attente',
    confirmed: 'Confirmé',
    cancelled: 'Annulé',
    completed: 'Terminé'
  }
  return labels[status] || status
}

// Lifecycle hooks
onMounted(() => {
  fetchDashboardData()
  refreshInterval = setInterval(() => {
    fetchDashboardData()
  }, 300000)
})

onUnmounted(() => {
  if (reservationChart) reservationChart.destroy()
  if (revenueChart) revenueChart.destroy()
  if (refreshInterval) clearInterval(refreshInterval)
})
</script>
