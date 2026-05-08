<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Widget d'Avis Clients</h3>
    
    <!-- Enable/Disable Widget -->
    <div class="mb-6">
      <label class="flex items-center cursor-pointer">
        <input
          v-model="config.enabled"
          type="checkbox"
          class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
        />
        <span class="ml-2 text-sm font-medium text-gray-700">Activer le widget d'avis sur la page d'accueil</span>
      </label>
      <p class="mt-1 text-sm text-gray-500">Afficher la section avis entre les services et la localisation</p>
    </div>

    <!-- Widget Provider Selection -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-2">Fournisseur de widget</label>
      <select
        v-model="config.provider"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
      >
        <option value="elfsight">Elfsight</option>
        <option value="trustpilot">Trustpilot</option>
        <option value="google">Google Reviews</option>
        <option value="booking">Booking.com</option>
        <option value="custom">Code personnalisé</option>
      </select>
      <p class="mt-1 text-xs text-gray-500">
        Sélectionnez le service que vous utilisez pour afficher vos avis
      </p>
    </div>

    <!-- Widget Embed Code -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Code d'intégration du widget
      </label>
      <textarea
        v-model="config.embedCode"
        rows="8"
        class="w-full px-3 py-2 text-sm font-mono border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
        placeholder="<script src='https://apps.elfsight.com/p/platform.js' defer></script>
<div class='elfsight-app-...'></div>"
      ></textarea>
      <p class="mt-1 text-xs text-gray-500">
        Collez le code d'intégration fourni par votre service d'avis
      </p>
    </div>

    <!-- Instructions based on provider -->
    <div v-if="config.provider" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
      <h4 class="text-sm font-semibold text-blue-900 mb-2">
        📝 Instructions pour {{ providerName }}
      </h4>
      <div class="text-xs text-blue-800 space-y-2">
        <template v-if="config.provider === 'elfsight'">
          <p><strong>1.</strong> Visitez <a href="https://elfsight.com/google-reviews-widget/" target="_blank" class="underline">Elfsight Google Reviews Widget</a></p>
          <p><strong>2.</strong> Créez votre widget et personnalisez-le</p>
          <p><strong>3.</strong> Copiez le code d'installation fourni</p>
          <p><strong>4.</strong> Collez-le dans le champ ci-dessus</p>
        </template>
        <template v-else-if="config.provider === 'trustpilot'">
          <p><strong>1.</strong> Connectez-vous à votre <a href="https://businessapp.b2b.trustpilot.com/" target="_blank" class="underline">compte Trustpilot</a></p>
          <p><strong>2.</strong> Allez dans "Marketing" > "TrustBox"</p>
          <p><strong>3.</strong> Choisissez un modèle et copiez le code</p>
          <p><strong>4.</strong> Collez-le dans le champ ci-dessus</p>
        </template>
        <template v-else-if="config.provider === 'google'">
          <p><strong>1.</strong> Utilisez un service comme Elfsight ou EmbedSocial</p>
          <p><strong>2.</strong> Connectez votre profil Google Business</p>
          <p><strong>3.</strong> Générez le widget et copiez le code</p>
          <p><strong>4.</strong> Collez-le dans le champ ci-dessus</p>
        </template>
        <template v-else-if="config.provider === 'booking'">
          <p><strong>1.</strong> Connectez-vous à votre <a href="https://admin.booking.com/" target="_blank" class="underline">extranet Booking.com</a></p>
          <p><strong>2.</strong> Allez dans "Marketing" > "Guest Review Score"</p>
          <p><strong>3.</strong> Copiez le code du badge</p>
          <p><strong>4.</strong> Collez-le dans le champ ci-dessus</p>
        </template>
        <template v-else>
          <p>Collez n'importe quel code HTML/JavaScript de widget d'avis</p>
        </template>
      </div>
    </div>

    <!-- Preview Warning -->
    <div v-if="config.embedCode" class="mb-6 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
      <p class="text-xs text-yellow-800">
        ⚠️ Le widget s'affichera sur la page d'accueil du site. Assurez-vous que le code est correct avant d'enregistrer.
      </p>
    </div>

    <!-- Save Button -->
    <div class="flex items-center justify-end gap-3 pt-4 border-t">
      <button
        v-if="hasChanges"
        @click="resetChanges"
        type="button"
        class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition"
      >
        Annuler
      </button>
      <button
        @click="saveConfig"
        :disabled="saving"
        type="button"
        class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
      >
        {{ saving ? 'Enregistrement...' : 'Enregistrer' }}
      </button>
    </div>

    <!-- Success Message -->
    <div v-if="showSuccess" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-md">
      <p class="text-sm text-green-800">✓ Configuration enregistrée avec succès</p>
    </div>

    <!-- Error Message -->
    <div v-if="error" class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
      <p class="text-sm text-red-800">{{ error }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import axios from '../api/axios'

interface ReviewsConfig {
  enabled: boolean
  provider: string
  embedCode: string
}

const config = ref<ReviewsConfig>({
  enabled: false,
  provider: 'elfsight',
  embedCode: ''
})

const originalConfig = ref<string>('')
const saving = ref(false)
const showSuccess = ref(false)
const error = ref('')

const hasChanges = computed(() => {
  return JSON.stringify(config.value) !== originalConfig.value
})

const providerName = computed(() => {
  const names: Record<string, string> = {
    elfsight: 'Elfsight',
    trustpilot: 'Trustpilot',
    google: 'Google Reviews',
    booking: 'Booking.com',
    custom: 'Code personnalisé'
  }
  return names[config.value.provider] || 'Widget'
})

const loadConfig = async () => {
  try {
    const response = await axios.get('/api/settings')
    const settings = response.data.data

    // Convert array to object if needed
    const settingsObj = Array.isArray(settings) 
      ? settings.reduce((acc, item) => {
          acc[item.setting_key] = item.setting_value
          return acc
        }, {})
      : settings

    config.value.enabled = settingsObj.reviews_widget_enabled === '1' || settingsObj.reviews_widget_enabled === true
    config.value.provider = settingsObj.reviews_widget_provider || 'elfsight'
    config.value.embedCode = settingsObj.reviews_widget_embed_code || ''

    originalConfig.value = JSON.stringify(config.value)
  } catch (err: any) {
    error.value = 'Erreur lors du chargement de la configuration'
    console.error('Error loading config:', err)
  }
}

const saveConfig = async () => {
  saving.value = true
  error.value = ''
  showSuccess.value = false

  try {
    const settings = {
      reviews_widget_enabled: config.value.enabled ? '1' : '0',
      reviews_widget_provider: config.value.provider,
      reviews_widget_embed_code: config.value.embedCode
    }

    await axios.put('/api/settings/bulk', { settings })

    originalConfig.value = JSON.stringify(config.value)
    showSuccess.value = true

    setTimeout(() => {
      showSuccess.value = false
    }, 3000)
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Erreur lors de l\'enregistrement'
    console.error('Error saving config:', err)
  } finally {
    saving.value = false
  }
}

const resetChanges = () => {
  config.value = JSON.parse(originalConfig.value)
}

onMounted(() => {
  loadConfig()
})
</script>
