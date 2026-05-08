<template>
  <div class="space-y-6">
    <div v-if="error" class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
      <p class="text-sm text-red-700">{{ error }}</p>
    </div>

    <form @submit.prevent="submitReservation" class="space-y-6">
      <!-- Apartment Selection -->
      <div>
        <label class="input-label">Appartement *</label>
        <select v-model="form.apartment_id" class="input" required>
          <option value="">Sélectionner un appartement</option>
          <option v-for="apt in apartments" :key="apt.id" :value="apt.id">
            {{ apt.name }} - €{{ apt.price_per_night }}/nuit
          </option>
        </select>
      </div>

      <!-- Dates -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="input-label">Date d'arrivée *</label>
          <input
            v-model="form.check_in_date"
            type="date"
            class="input"
            required
            :min="today"
          />
        </div>
        <div>
          <label class="input-label">Date de départ *</label>
          <input
            v-model="form.check_out_date"
            type="date"
            class="input"
            required
            :min="form.check_in_date || today"
          />
        </div>
      </div>

      <!-- Customer Information -->
      <div class="border-t pt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations Client</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="input-label">Prénom *</label>
            <input
              v-model="form.customer.first_name"
              type="text"
              class="input"
              required
            />
          </div>
          <div>
            <label class="input-label">Nom *</label>
            <input
              v-model="form.customer.last_name"
              type="text"
              class="input"
              required
            />
          </div>
          <div>
            <label class="input-label">Email *</label>
            <input
              v-model="form.customer.email"
              type="email"
              class="input"
              required
            />
          </div>
          <div>
            <label class="input-label">Téléphone</label>
            <input
              v-model="form.customer.phone"
              type="tel"
              class="input"
            />
          </div>
          <div>
            <label class="input-label">Nationalité</label>
            <input
              v-model="form.customer.nationality"
              type="text"
              class="input"
            />
          </div>
        </div>
      </div>

      <!-- Guests -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="input-label">Nombre d'adultes *</label>
          <input
            v-model.number="form.adults"
            type="number"
            min="1"
            class="input"
            required
          />
        </div>
        <div>
          <label class="input-label">Nombre d'enfants</label>
          <input
            v-model.number="form.children"
            type="number"
            min="0"
            class="input"
          />
        </div>
      </div>

      <!-- Pricing Type -->
      <div>
        <label class="input-label">Type de tarif *</label>
        <select v-model="form.pricing_type" class="input" required>
          <option value="flexible">Flexible (paiement en ligne)</option>
          <option value="on_site_payment">Paiement sur place</option>
        </select>
        <p class="text-xs text-gray-500 mt-1">
          Le statut de paiement sera "En attente" par défaut
        </p>
      </div>

      <!-- Special Requests -->
      <div>
        <label class="input-label">Demandes spéciales / Notes</label>
        <textarea
          v-model="form.special_requests"
          rows="3"
          class="input"
          placeholder="Notes administratives ou demandes du client..."
        ></textarea>
      </div>

      <!-- Submit Buttons -->
      <div class="flex justify-end gap-3 pt-6 border-t">
        <button
          type="button"
          @click="$emit('cancel')"
          class="btn btn-outline"
          :disabled="submitting"
        >
          Annuler
        </button>
        <button
          type="submit"
          class="btn btn-primary"
          :disabled="submitting"
        >
          <span v-if="submitting">Création en cours...</span>
          <span v-else>Créer la réservation</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import apiClient from '../api/axios'

const emit = defineEmits(['created', 'cancel'])

const apartments = ref([])
const error = ref(null)
const submitting = ref(false)

const today = computed(() => {
  return new Date().toISOString().split('T')[0]
})

const form = ref({
  apartment_id: '',
  check_in_date: '',
  check_out_date: '',
  adults: 2,
  children: 0,
  customer: {
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    nationality: ''
  },
  pricing_type: 'flexible',
  special_requests: ''
})

const fetchApartments = async () => {
  try {
    const response = await apiClient.get('/apartments')
    apartments.value = response.data.data
  } catch (err) {
    error.value = 'Impossible de charger les appartements'
  }
}

const submitReservation = async () => {
  error.value = null
  submitting.value = true

  try {
    // Prepare data - match backend expectations
    const data = {
      apartment_id: parseInt(form.value.apartment_id),
      check_in_date: form.value.check_in_date,
      check_out_date: form.value.check_out_date,
      adults: parseInt(form.value.adults),
      children: parseInt(form.value.children) || 0,
      customer: {
        first_name: form.value.customer.first_name.trim(),
        last_name: form.value.customer.last_name.trim(),
        email: form.value.customer.email.trim(),
        is_newsletter_subscribed: false
      },
      comfort_options: [], // Empty array if no options selected
      pricing_type: form.value.pricing_type
    }

    // Add optional customer fields only if they have values
    if (form.value.customer.phone && form.value.customer.phone.trim()) {
      data.customer.phone = form.value.customer.phone.trim()
    }
    if (form.value.customer.nationality && form.value.customer.nationality.trim()) {
      data.customer.nationality = form.value.customer.nationality.trim()
    }

    // Add special requests only if provided
    if (form.value.special_requests && form.value.special_requests.trim()) {
      data.special_requests = form.value.special_requests.trim()
    }

    console.log('Submitting reservation data:', data)

    const response = await apiClient.post('/reservations', data)
    
    emit('created', response.data.data)
  } catch (err) {
    console.error('Reservation creation error:', err.response?.data)
    
    // Display detailed validation errors if available
    if (err.response?.data?.error?.details) {
      const details = err.response.data.error.details
      const errorMessages = Object.entries(details)
        .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
        .join('\n')
      error.value = `Erreurs de validation:\n${errorMessages}`
    } else {
      error.value = err.response?.data?.error?.message || err.response?.data?.message || 'Erreur lors de la création de la réservation'
    }
  } finally {
    submitting.value = false
  }
}

onMounted(() => {
  fetchApartments()
})
</script>
