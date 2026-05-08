<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 via-white to-gold-50">
    <!-- Header -->
    <div class="bg-white border-b border-navy-100 shadow-sm">
      <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-navy-900">Calendrier & Disponibilités</h1>
            <p class="text-navy-600 mt-1">Vérifiez la disponibilité des appartements par période</p>
          </div>
          <div class="flex items-center gap-3">
            <button
              @click="refreshData"
              :disabled="loading"
              class="px-4 py-2 bg-white border border-navy-200 text-navy-700 rounded-lg hover:bg-navy-50 transition-colors flex items-center gap-2 disabled:opacity-50"
            >
              <svg class="w-5 h-5" :class="{ 'animate-spin': loading }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Actualiser
            </button>
          </div>
        </div>

        <!-- Date Range Selector -->
        <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
          <div class="flex flex-col md:flex-row items-start md:items-end gap-4">
            <div class="flex-1 w-full">
              <label class="block text-sm font-semibold text-navy-700 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Période de recherche
              </label>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                  <label class="block text-xs text-navy-600 mb-1">Date d'arrivée</label>
                  <input
                    v-model="dateRange.checkIn"
                    type="date"
                    class="w-full px-4 py-2 border border-navy-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    :min="today"
                  />
                </div>
                <div>
                  <label class="block text-xs text-navy-600 mb-1">Date de départ</label>
                  <input
                    v-model="dateRange.checkOut"
                    type="date"
                    class="w-full px-4 py-2 border border-navy-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    :min="dateRange.checkIn || today"
                  />
                </div>
              </div>
            </div>

            <!-- Quick Date Buttons -->
            <div class="flex flex-wrap gap-2">
              <button
                @click="setQuickDate('today')"
                class="px-3 py-2 text-sm bg-white border border-navy-200 text-navy-700 rounded-lg hover:bg-navy-50 transition-colors"
              >
                Aujourd'hui
              </button>
              <button
                @click="setQuickDate('weekend')"
                class="px-3 py-2 text-sm bg-white border border-navy-200 text-navy-700 rounded-lg hover:bg-navy-50 transition-colors"
              >
                Ce weekend
              </button>
              <button
                @click="setQuickDate('week')"
                class="px-3 py-2 text-sm bg-white border border-navy-200 text-navy-700 rounded-lg hover:bg-navy-50 transition-colors"
              >
                Cette semaine
              </button>
              <button
                @click="setQuickDate('month')"
                class="px-3 py-2 text-sm bg-white border border-navy-200 text-navy-700 rounded-lg hover:bg-navy-50 transition-colors"
              >
                Ce mois
              </button>
              <button
                @click="clearDates"
                class="px-3 py-2 text-sm bg-red-50 border border-red-200 text-red-700 rounded-lg hover:bg-red-100 transition-colors"
              >
                Réinitialiser
              </button>
            </div>
          </div>

          <!-- Date Range Info -->
          <div v-if="dateRange.checkIn && dateRange.checkOut" class="mt-4 flex items-center gap-2 text-sm">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-navy-700 font-medium">
              Recherche pour {{ calculateNights }} nuit(s) du {{ formatDateFr(dateRange.checkIn) }} au {{ formatDateFr(dateRange.checkOut) }}
            </span>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
          <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-blue-100 text-sm font-medium">Total Appartements</p>
                <p class="text-3xl font-bold mt-1">{{ apartments.length }}</p>
              </div>
              <div class="bg-white/20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
            </div>
          </div>

          <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-green-100 text-sm font-medium">
                  {{ hasDateRange ? 'Disponibles (période)' : 'Disponibles' }}
                </p>
                <p class="text-3xl font-bold mt-1">{{ availableCount }}</p>
              </div>
              <div class="bg-white/20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
          </div>

          <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-orange-100 text-sm font-medium">
                  {{ hasDateRange ? 'Occupés (période)' : 'Réservations Actives' }}
                </p>
                <p class="text-3xl font-bold mt-1">{{ occupiedCount }}</p>
              </div>
              <div class="bg-white/20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
          </div>

          <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-purple-100 text-sm font-medium">Taux d'Occupation</p>
                <p class="text-3xl font-bold mt-1">{{ occupancyRate }}%</p>
              </div>
              <div class="bg-white/20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="flex justify-center items-center py-20">
      <div class="text-center">
        <div class="inline-block animate-spin rounded-full h-16 w-16 border-b-4 border-gold-500"></div>
        <p class="mt-4 text-navy-600 font-medium">Chargement des données...</p>
      </div>
    </div>

    <!-- Content -->
    <div v-else class="max-w-7xl mx-auto px-6 py-8 space-y-6">
      <!-- Filters & Legend -->
      <div class="bg-white rounded-xl shadow-sm border border-navy-100 p-6">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-navy-900">Filtres & Légende</h3>
          <button
            v-if="selectedStatus !== 'all'"
            @click="selectedStatus = 'all'"
            class="text-sm text-gold-600 hover:text-gold-700 font-medium"
          >
            Réinitialiser
          </button>
        </div>

        <!-- Status Filter -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-navy-700 mb-2">Filtrer par statut</label>
          <div class="flex flex-wrap gap-2">
            <button
              @click="selectedStatus = 'all'"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                selectedStatus === 'all'
                  ? 'bg-navy-600 text-white shadow-md'
                  : 'bg-navy-50 text-navy-700 hover:bg-navy-100'
              ]"
            >
              Tous
            </button>
            <button
              @click="selectedStatus = 'available'"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                selectedStatus === 'available'
                  ? 'bg-green-600 text-white shadow-md'
                  : 'bg-green-50 text-green-700 hover:bg-green-100'
              ]"
            >
              Disponibles {{ hasDateRange ? '(période)' : '' }}
            </button>
            <button
              @click="selectedStatus = 'occupied'"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                selectedStatus === 'occupied'
                  ? 'bg-red-600 text-white shadow-md'
                  : 'bg-red-50 text-red-700 hover:bg-red-100'
              ]"
            >
              Occupés {{ hasDateRange ? '(période)' : '' }}
            </button>
            <button
              @click="selectedStatus = 'disabled'"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                selectedStatus === 'disabled'
                  ? 'bg-gray-600 text-white shadow-md'
                  : 'bg-gray-50 text-gray-700 hover:bg-gray-100'
              ]"
            >
              Désactivés
            </button>
          </div>
        </div>

        <!-- Legend -->
        <div class="border-t border-navy-100 pt-4">
          <p class="text-sm font-medium text-navy-700 mb-3">Légende des statuts</p>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="flex items-center gap-2">
              <div class="w-3 h-3 bg-green-500 rounded-full"></div>
              <span class="text-sm text-navy-600">Disponible</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="w-3 h-3 bg-red-500 rounded-full"></div>
              <span class="text-sm text-navy-600">Occupé</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
              <span class="text-sm text-navy-600">Confirmé</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
              <span class="text-sm text-navy-600">En attente</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Apartments Grid View -->
      <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <div v-for="apartment in filteredApartments" :key="apartment.id" class="bg-white rounded-xl shadow-md border border-navy-100 overflow-hidden hover:shadow-xl transition-all hover:-translate-y-1">
          <!-- Apartment Header -->
          <div class="bg-gradient-to-r from-navy-600 to-navy-700 p-4">
            <div class="flex items-start justify-between gap-3">
              <div class="flex items-start gap-3 flex-1 min-w-0">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-2 flex-shrink-0">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <h3 class="text-lg font-bold text-white truncate">{{ apartment.name }}</h3>
                  <div class="flex flex-col gap-1 mt-1 text-navy-100 text-xs">
                    <span class="flex items-center gap-1">
                      <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                      </svg>
                      {{ apartment.type }}
                    </span>
                    <span class="flex items-center gap-1">
                      <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                      {{ apartment.capacity }} pers.
                    </span>
                    <span class="flex items-center gap-1 font-semibold">
                      <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      {{ apartment.price_per_night }}€/nuit
                    </span>
                  </div>
                </div>
              </div>
              
              <!-- Availability Badge -->
              <span
                v-if="!apartment.available"
                class="px-2 py-1 bg-gray-500 text-white text-xs font-bold rounded shadow-md flex-shrink-0"
              >
                Désactivé
              </span>
              <span
                v-else-if="isApartmentAvailableForPeriod(apartment.id)"
                class="px-2 py-1 bg-green-500 text-white text-xs font-bold rounded shadow-md flex-shrink-0"
              >
                ✓ Libre
              </span>
              <span
                v-else
                class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded shadow-md flex-shrink-0"
              >
                ✗ Occupé
              </span>
            </div>
          </div>

          <div class="p-4">
            <!-- Period-Filtered Reservations -->
            <div v-if="getFilteredReservations(apartment.id).length > 0" class="space-y-3">
              <div
                v-for="reservation in getFilteredReservations(apartment.id)"
                :key="reservation.id"
                :class="[
                  'p-3 rounded-lg border-2 transition-all',
                  reservation.status === 'confirmed' ? 'bg-blue-50 border-blue-300' :
                  reservation.status === 'pending' ? 'bg-yellow-50 border-yellow-300' :
                  reservation.status === 'occupied' ? 'bg-indigo-50 border-indigo-300' :
                  'bg-gray-50 border-gray-300'
                ]"
              >
                <!-- Date Range -->
                <div class="flex items-center gap-2 mb-2">
                  <svg class="w-4 h-4 text-navy-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <span class="text-sm font-bold text-navy-900">
                    {{ formatDateFr(reservation.check_in_date) }} → {{ formatDateFr(reservation.check_out_date) }}
                  </span>
                </div>

                <!-- Details -->
                <div class="text-xs text-navy-600 space-y-1 ml-6">
                  <p class="font-medium">
                    {{ calculateNightsBetween(reservation.check_in_date, reservation.check_out_date) }} nuit(s)
                    • {{ reservation.adults }} adulte(s)
                    <span v-if="reservation.children > 0">• {{ reservation.children }} enfant(s)</span>
                  </p>
                  <p class="truncate">
                    <span class="font-semibold">Client:</span>
                    {{ reservation.customer?.first_name }} {{ reservation.customer?.last_name }}
                  </p>
                </div>

                <!-- Status & Price -->
                <div class="flex items-center justify-between mt-3 pt-3 border-t border-navy-100">
                  <span
                    :class="[
                      'px-2 py-1 text-xs font-bold rounded',
                      reservation.status === 'confirmed' ? 'bg-green-500 text-white' :
                      reservation.status === 'pending' ? 'bg-yellow-500 text-white' :
                      reservation.status === 'occupied' ? 'bg-indigo-500 text-white' :
                      'bg-gray-500 text-white'
                    ]"
                  >
                    {{ getStatusLabel(reservation.status) }}
                  </span>
                  <span class="text-lg font-bold text-navy-900">{{ reservation.total_price }}€</span>
                </div>
              </div>
            </div>

            <!-- Available State -->
            <div v-else-if="apartment.available && isApartmentAvailableForPeriod(apartment.id)" class="text-center py-8 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg border-2 border-green-300">
              <div class="bg-green-500 rounded-full p-3 w-16 h-16 mx-auto flex items-center justify-center shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <p class="mt-3 text-sm font-bold text-green-900">Disponible</p>
              <p class="text-xs text-green-700">
                {{ hasDateRange ? 'Libre pour la période sélectionnée' : 'Aucune réservation' }}
              </p>
            </div>

            <!-- Occupied State -->
            <div v-else-if="apartment.available && !isApartmentAvailableForPeriod(apartment.id)" class="text-center py-8 bg-gradient-to-br from-red-50 to-rose-50 rounded-lg border-2 border-red-300">
              <div class="bg-red-500 rounded-full p-3 w-16 h-16 mx-auto flex items-center justify-center shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </div>
              <p class="mt-3 text-sm font-bold text-red-900">Occupé</p>
              <p class="text-xs text-red-700">
                {{ hasDateRange ? 'Réservé pour cette période' : 'Réservations en cours' }}
              </p>
            </div>

            <!-- Disabled State -->
            <div v-else class="text-center py-8 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border-2 border-gray-300">
              <div class="bg-gray-400 rounded-full p-3 w-16 h-16 mx-auto flex items-center justify-center shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
              </div>
              <p class="mt-3 text-sm font-bold text-gray-700">Désactivé</p>
              <p class="text-xs text-gray-600">Non disponible à la réservation</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="filteredApartments.length === 0" class="text-center py-16 bg-white rounded-xl border-2 border-dashed border-navy-200">
        <div class="bg-navy-100 rounded-full p-6 w-24 h-24 mx-auto flex items-center justify-center">
          <svg class="w-12 h-12 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
        </div>
        <h3 class="mt-4 text-lg font-semibold text-navy-900">Aucun appartement trouvé</h3>
        <p class="mt-2 text-sm text-navy-600">
          {{ selectedStatus === 'all' ? 'Commencez par ajouter des appartements' : 'Aucun appartement ne correspond à ce filtre' }}
        </p>
        <button
          v-if="selectedStatus !== 'all'"
          @click="selectedStatus = 'all'"
          class="mt-4 px-6 py-2 bg-gold-500 text-white rounded-lg hover:bg-gold-600 transition-colors font-medium"
        >
          Voir tous les appartements
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from '@/api/axios'

const apartments = ref([])
const reservations = ref([])
const loading = ref(true)
const selectedStatus = ref('all')

// Date range for filtering
const dateRange = ref({
  checkIn: '',
  checkOut: ''
})

const today = computed(() => {
  return new Date().toISOString().split('T')[0]
})

const hasDateRange = computed(() => {
  return dateRange.value.checkIn && dateRange.value.checkOut
})

const calculateNights = computed(() => {
  if (!hasDateRange.value) return 0
  const start = new Date(dateRange.value.checkIn)
  const end = new Date(dateRange.value.checkOut)
  const diffTime = Math.abs(end - start)
  return Math.ceil(diffTime / (1000 * 60 * 60 * 24))
})

// Check if apartment is available for the selected period
const isApartmentAvailableForPeriod = (apartmentId) => {
  if (!hasDateRange.value) {
    // No date range selected - check if has any active reservations
    return getApartmentReservations(apartmentId).length === 0
  }

  // Check for overlapping reservations in the selected period
  const overlapping = reservations.value.filter(r => {
    if (r.apartment_id !== apartmentId) return false
    if (!['pending', 'confirmed', 'occupied'].includes(r.status)) return false

    const resCheckIn = new Date(r.check_in_date)
    const resCheckOut = new Date(r.check_out_date)
    const searchCheckIn = new Date(dateRange.value.checkIn)
    const searchCheckOut = new Date(dateRange.value.checkOut)

    // Two date ranges overlap if:
    // - Reservation starts before search period ends AND
    // - Reservation ends after search period starts
    // This catches ALL overlap scenarios
    return resCheckIn < searchCheckOut && resCheckOut > searchCheckIn
  })

  return overlapping.length === 0
}

// Get reservations filtered by date range
const getFilteredReservations = (apartmentId) => {
  let filtered = reservations.value.filter(r => r.apartment_id === apartmentId)

  if (hasDateRange.value) {
    // Filter to show only reservations that overlap with selected period
    filtered = filtered.filter(r => {
      const resCheckIn = new Date(r.check_in_date)
      const resCheckOut = new Date(r.check_out_date)
      const searchCheckIn = new Date(dateRange.value.checkIn)
      const searchCheckOut = new Date(dateRange.value.checkOut)

      // Two date ranges overlap if:
      // - Reservation starts before search period ends AND
      // - Reservation ends after search period starts
      return resCheckIn < searchCheckOut && resCheckOut > searchCheckIn
    })
  }

  return filtered.sort((a, b) => new Date(a.check_in_date) - new Date(b.check_in_date))
}

const availableCount = computed(() => {
  return apartments.value.filter(apt => 
    apt.available && isApartmentAvailableForPeriod(apt.id)
  ).length
})

const occupiedCount = computed(() => {
  return apartments.value.filter(apt => 
    apt.available && !isApartmentAvailableForPeriod(apt.id)
  ).length
})

const occupancyRate = computed(() => {
  const activeApartments = apartments.value.filter(apt => apt.available).length
  if (activeApartments === 0) return 0
  return Math.round((occupiedCount.value / activeApartments) * 100)
})

const filteredApartments = computed(() => {
  if (selectedStatus.value === 'all') return apartments.value
  
  return apartments.value.filter(apt => {
    if (selectedStatus.value === 'available') {
      return apt.available && isApartmentAvailableForPeriod(apt.id)
    }
    if (selectedStatus.value === 'occupied') {
      return apt.available && !isApartmentAvailableForPeriod(apt.id)
    }
    if (selectedStatus.value === 'disabled') {
      return !apt.available
    }
    return true
  })
})

const fetchData = async () => {
  try {
    loading.value = true
    
    const [apartmentsResponse, reservationsResponse] = await Promise.all([
      axios.get('/apartments'),
      axios.get('/reservations', {
        params: {
          status: 'pending,confirmed,occupied',
          per_page: 1000
        }
      })
    ])
    
    apartments.value = apartmentsResponse.data.data || []
    reservations.value = reservationsResponse.data.data || []
    
  } catch (error) {
    console.error('Error fetching data:', error)
  } finally {
    loading.value = false
  }
}

const refreshData = () => {
  fetchData()
}

const getApartmentReservations = (apartmentId) => {
  return reservations.value
    .filter(r => r.apartment_id === apartmentId && ['pending', 'confirmed', 'occupied'].includes(r.status))
    .sort((a, b) => new Date(a.check_in_date) - new Date(b.check_in_date))
}

const formatDateFr = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  })
}

const calculateNightsBetween = (checkIn, checkOut) => {
  const start = new Date(checkIn)
  const end = new Date(checkOut)
  const diffTime = Math.abs(end - start)
  return Math.ceil(diffTime / (1000 * 60 * 60 * 24))
}

const getStatusLabel = (status) => {
  const labels = {
    pending: 'En attente',
    confirmed: 'Confirmée',
    cancelled: 'Annulée',
    completed: 'Terminée',
    occupied: 'Occupé'
  }
  return labels[status] || status
}

// Quick date selection functions
const setQuickDate = (type) => {
  const now = new Date()
  
  switch (type) {
    case 'today':
      dateRange.value.checkIn = now.toISOString().split('T')[0]
      const tomorrow = new Date(now)
      tomorrow.setDate(tomorrow.getDate() + 1)
      dateRange.value.checkOut = tomorrow.toISOString().split('T')[0]
      break
      
    case 'weekend':
      // Next weekend (Saturday to Sunday)
      const daysUntilSaturday = (6 - now.getDay() + 7) % 7 || 7
      const saturday = new Date(now)
      saturday.setDate(saturday.getDate() + daysUntilSaturday)
      const sunday = new Date(saturday)
      sunday.setDate(sunday.getDate() + 1)
      dateRange.value.checkIn = saturday.toISOString().split('T')[0]
      dateRange.value.checkOut = sunday.toISOString().split('T')[0]
      break
      
    case 'week':
      dateRange.value.checkIn = now.toISOString().split('T')[0]
      const nextWeek = new Date(now)
      nextWeek.setDate(nextWeek.getDate() + 7)
      dateRange.value.checkOut = nextWeek.toISOString().split('T')[0]
      break
      
    case 'month':
      dateRange.value.checkIn = now.toISOString().split('T')[0]
      const nextMonth = new Date(now)
      nextMonth.setMonth(nextMonth.getMonth() + 1)
      dateRange.value.checkOut = nextMonth.toISOString().split('T')[0]
      break
  }
}

const clearDates = () => {
  dateRange.value.checkIn = ''
  dateRange.value.checkOut = ''
}

onMounted(() => {
  fetchData()
})
</script>
