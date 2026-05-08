<template>
  <div class="animate-fade-in">
    <div class="page-header">
      <div>
        <h1 class="page-title">Réservations</h1>
        <p class="page-subtitle">Gérer toutes les réservations</p>
      </div>
      
      <div class="flex items-center gap-3">
        <!-- Add Manual Reservation Button -->
        <button
          @click="showManualReservationModal = true"
          class="btn btn-primary"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Nouvelle Réservation
        </button>
        
        <!-- View Toggle -->
        <div class="flex items-center gap-2 bg-surface-100 rounded-lg p-1">
          <button
            @click="currentView = 'list'"
            :class="[
              'btn btn-sm',
              currentView === 'list'
                ? 'bg-white text-navy-900 shadow-sm'
                : 'text-navy-400 hover:text-navy-700'
            ]"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
            Liste
          </button>
          <button
            @click="currentView = 'calendar'"
            :class="[
              'btn btn-sm',
              currentView === 'calendar'
                ? 'bg-white text-navy-900 shadow-sm'
                : 'text-navy-400 hover:text-navy-700'
            ]"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            Calendrier
          </button>
        </div>
      </div>
    </div>

    <!-- List View -->
    <div v-if="currentView === 'list'">
      <ReservationList @view-details="viewReservationDetails" />
    </div>

    <!-- Calendar View -->
    <div v-if="currentView === 'calendar'">
      <ReservationCalendar @view-reservation="viewReservationDetails" />
    </div>

    <!-- Reservation Detail Modal -->
    <div
      v-if="showDetailModal"
      class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm overflow-y-auto h-full w-full z-50"
      @click="closeDetailModal"
    >
      <div
        class="relative top-10 mx-auto p-6 w-full max-w-6xl mb-10 animate-slide-down"
        @click.stop
      >
        <div class="card">
          <div class="card-header flex justify-between items-center">
            <h2 class="text-lg font-bold text-navy-900">Détails de la réservation</h2>
            <button
              @click="closeDetailModal"
              class="text-navy-300 hover:text-navy-600 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="card-body">
            <ReservationDetail
              v-if="selectedReservationId"
              :reservation-id="selectedReservationId"
              @updated="handleReservationUpdated"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- Manual Reservation Modal -->
    <div
      v-if="showManualReservationModal"
      class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm overflow-y-auto h-full w-full z-50"
      @click="closeManualReservationModal"
    >
      <div
        class="relative top-10 mx-auto p-6 w-full max-w-4xl mb-10 animate-slide-down"
        @click.stop
      >
        <div class="card">
          <div class="card-header flex justify-between items-center">
            <h2 class="text-lg font-bold text-navy-900">Créer une réservation manuelle</h2>
            <button
              @click="closeManualReservationModal"
              class="text-navy-300 hover:text-navy-600 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="card-body">
            <ManualReservationForm
              @created="handleManualReservationCreated"
              @cancel="closeManualReservationModal"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import ReservationList from '../components/ReservationList.vue'
import ReservationCalendar from '../components/ReservationCalendar.vue'
import ReservationDetail from '../components/ReservationDetail.vue'
import ManualReservationForm from '../components/ManualReservationForm.vue'

const currentView = ref('list')
const showDetailModal = ref(false)
const showManualReservationModal = ref(false)
const selectedReservationId = ref(null)
const reservationListRef = ref(null)

const viewReservationDetails = (reservationId) => {
  selectedReservationId.value = reservationId
  showDetailModal.value = true
}

const closeDetailModal = () => {
  showDetailModal.value = false
  selectedReservationId.value = null
}

const closeManualReservationModal = () => {
  showManualReservationModal.value = false
}

const handleReservationUpdated = () => {
  // Refresh the list/calendar view
  window.location.reload()
}

const handleManualReservationCreated = (reservation) => {
  showManualReservationModal.value = false
  // Show success message and refresh
  alert(`Réservation #${reservation.id} créée avec succès!`)
  window.location.reload()
}
</script>
