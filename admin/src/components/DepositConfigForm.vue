<template>
  <div class="card">
    <div class="card-body">
      <!-- Header -->
      <div class="mb-6">
        <h3 class="text-lg font-semibold text-navy-800 mb-1">Configuration du dépôt de garantie</h3>
        <p class="text-sm text-navy-400">Gérez le système de dépôt pour les réservations</p>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="flex items-center justify-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
      </div>

      <!-- Error -->
      <div v-else-if="error" class="p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
        {{ error }}
      </div>

      <!-- Form -->
      <form v-else @submit.prevent="handleSubmit" class="space-y-6">
        <!-- Enable/Disable -->
        <div class="flex items-center justify-between p-4 bg-navy-50/30 rounded-lg border border-navy-50">
          <div>
            <label class="block text-sm font-medium text-navy-800 mb-1">
              Activer le système de dépôt
            </label>
            <p class="text-xs text-navy-400">
              Exiger un dépôt de garantie pour toutes les réservations
            </p>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input
              type="checkbox"
              v-model="formData.enabled"
              class="sr-only peer"
            />
            <div class="w-11 h-6 bg-navy-200 rounded-full peer-checked:bg-emerald-500 transition-colors"></div>
            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
          </label>
        </div>

        <!-- Percentage -->
        <div>
          <label class="block text-sm font-medium text-navy-800 mb-2">
            Pourcentage du dépôt
          </label>
          <div class="flex items-center gap-4">
            <input
              type="range"
              v-model.number="formData.percentage"
              min="1"
              max="100"
              step="1"
              class="flex-1 h-2 bg-navy-100 rounded-lg appearance-none cursor-pointer accent-gold-500"
              :disabled="!formData.enabled"
            />
            <div class="flex items-center gap-2 min-w-[80px]">
              <input
                type="number"
                v-model.number="formData.percentage"
                min="1"
                max="100"
                class="w-16 px-3 py-2 text-sm border border-navy-100 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500"
                :disabled="!formData.enabled"
              />
              <span class="text-sm font-medium text-navy-700">%</span>
            </div>
          </div>
          <p class="text-xs text-navy-400 mt-2">
            Le client paiera {{ formData.percentage }}% du montant total en dépôt
          </p>
        </div>

        <!-- Example Calculation -->
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
          <p class="text-sm font-semibold text-blue-900 mb-2">Exemple de calcul</p>
          <div class="space-y-1 text-sm text-blue-800">
            <div class="flex justify-between">
              <span>Montant total de la réservation :</span>
              <span class="font-medium">400,00€</span>
            </div>
            <div class="flex justify-between">
              <span>Dépôt de garantie ({{ formData.percentage }}%) :</span>
              <span class="font-bold text-blue-900">{{ calculateExampleDeposit() }}€</span>
            </div>
            <div class="flex justify-between">
              <span>Solde à payer sur place :</span>
              <span class="font-medium">{{ calculateExampleRemaining() }}€</span>
            </div>
          </div>
        </div>

        <!-- Notice Title -->
        <div>
          <label class="block text-sm font-medium text-navy-800 mb-2">
            Titre de la notice
          </label>
          <input
            type="text"
            v-model="formData.notice_title"
            maxlength="255"
            class="w-full px-3 py-2 text-sm border border-navy-100 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500"
            :disabled="!formData.enabled"
            placeholder="Dépôt de garantie requis"
          />
          <p class="text-xs text-navy-400 mt-1">
            Titre affiché dans la modal de confirmation
          </p>
        </div>

        <!-- Notice Message -->
        <div>
          <label class="block text-sm font-medium text-navy-800 mb-2">
            Message explicatif
          </label>
          <textarea
            v-model="formData.notice_message"
            rows="4"
            maxlength="1000"
            class="w-full px-3 py-2 text-sm border border-navy-100 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500"
            :disabled="!formData.enabled"
            placeholder="Pour confirmer votre réservation, un dépôt de garantie est requis..."
          ></textarea>
          <p class="text-xs text-navy-400 mt-1">
            Message affiché au client pour expliquer le système de dépôt
          </p>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-navy-100">
          <button
            type="button"
            @click="handleReset"
            class="px-4 py-2 text-sm font-medium text-navy-700 bg-white border border-navy-200 rounded-lg hover:bg-navy-50 transition-colors"
            :disabled="saving"
          >
            Réinitialiser
          </button>
          <button
            type="submit"
            class="px-6 py-2 text-sm font-medium text-white bg-navy-900 rounded-lg hover:bg-navy-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="saving"
          >
            {{ saving ? 'Enregistrement...' : 'Enregistrer' }}
          </button>
        </div>
      </form>

      <!-- Success Toast -->
      <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="translate-y-2 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-2 opacity-0"
      >
        <div
          v-if="showSuccess"
          class="fixed bottom-4 right-4 bg-navy-900 text-white px-5 py-3 rounded-lg shadow-xl flex items-center gap-2 z-50 text-sm"
        >
          <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
          Configuration enregistrée avec succès
        </div>
      </Transition>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from '../api/axios'

interface DepositConfig {
  enabled: boolean
  percentage: number
  notice_title: string
  notice_message: string
}

const loading = ref(false)
const saving = ref(false)
const error = ref<string | null>(null)
const showSuccess = ref(false)

const formData = ref<DepositConfig>({
  enabled: true,
  percentage: 25,
  notice_title: 'Dépôt de garantie requis',
  notice_message: 'Pour confirmer votre réservation, un dépôt de garantie est requis. Ce montant sera déduit du total à payer lors de votre arrivée. Le solde restant sera à régler sur place.'
})

const originalData = ref<DepositConfig | null>(null)

const fetchConfig = async () => {
  loading.value = true
  error.value = null

  try {
    const response = await axios.get('/deposit/config')
    
    if (response.data.success) {
      formData.value = { ...response.data.data }
      originalData.value = { ...response.data.data }
    }
  } catch (err: any) {
    error.value = err.response?.data?.error?.message || 'Échec du chargement de la configuration'
  } finally {
    loading.value = false
  }
}

const handleSubmit = async () => {
  saving.value = true
  error.value = null

  try {
    const response = await axios.put('/deposit/config', formData.value)
    
    if (response.data.success) {
      originalData.value = { ...formData.value }
      showSuccess.value = true
      setTimeout(() => {
        showSuccess.value = false
      }, 3000)
    }
  } catch (err: any) {
    error.value = err.response?.data?.error?.message || 'Échec de l\'enregistrement'
  } finally {
    saving.value = false
  }
}

const handleReset = () => {
  if (originalData.value) {
    formData.value = { ...originalData.value }
  }
}

const calculateExampleDeposit = (): string => {
  const total = 400
  const deposit = (total * formData.value.percentage) / 100
  return deposit.toFixed(2)
}

const calculateExampleRemaining = (): string => {
  const total = 400
  const deposit = (total * formData.value.percentage) / 100
  const remaining = total - deposit
  return remaining.toFixed(2)
}

onMounted(() => {
  fetchConfig()
})
</script>
