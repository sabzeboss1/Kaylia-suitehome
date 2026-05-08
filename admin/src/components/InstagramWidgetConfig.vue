<template>
  <div class="card p-6">
    <div class="mb-6">
      <h3 class="text-lg font-semibold text-navy-900 mb-2">Widget Instagram</h3>
      <p class="text-sm text-navy-500">
        Intégrez un widget Instagram tiers (Elfsight, SnapWidget, etc.) ou utilisez les images par défaut
      </p>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="text-center py-8">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
      <p class="mt-3 text-navy-400 text-sm">Chargement...</p>
    </div>

    <!-- Form -->
    <form v-else @submit.prevent="saveWidget" class="space-y-6">
      <!-- Enable Widget Toggle -->
      <div class="flex items-center justify-between p-4 bg-navy-50 rounded-lg">
        <div>
          <label class="text-sm font-medium text-navy-900">Activer le widget Instagram</label>
          <p class="text-xs text-navy-500 mt-1">
            Si désactivé, les images par défaut seront affichées
          </p>
        </div>
        <button
          type="button"
          @click="form.enabled = !form.enabled"
          class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-gold-500 focus:ring-offset-2"
          :class="form.enabled ? 'bg-gold-500' : 'bg-gray-200'"
        >
          <span
            class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
            :class="form.enabled ? 'translate-x-6' : 'translate-x-1'"
          />
        </button>
      </div>

      <!-- Instagram Username -->
      <div>
        <label class="block text-sm font-medium text-navy-900 mb-2">
          Nom d'utilisateur Instagram
        </label>
        <input
          v-model="form.username"
          type="text"
          placeholder="kayliasuitehome"
          class="w-full px-4 py-2 border border-navy-200 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent"
        />
        <p class="mt-1 text-xs text-navy-500">
          Affiché dans le titre de la section
        </p>
      </div>

      <!-- Widget Code -->
      <div>
        <label class="block text-sm font-medium text-navy-900 mb-2">
          Code du widget (shortcode ou script)
        </label>
        <textarea
          v-model="form.widget_code"
          rows="8"
          placeholder='<!-- Collez ici le code fourni par votre service tiers -->
Exemples:
- Elfsight: <script src="https://apps.elfsight.com/..."></script>
- SnapWidget: <script src="https://snapwidget.com/..."></script>
- Autre: Tout code HTML/JavaScript valide'
          class="w-full px-4 py-3 border border-navy-200 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent font-mono text-sm"
          :disabled="!form.enabled"
        ></textarea>
        <p class="mt-1 text-xs text-navy-500">
          Collez le code fourni par votre service de widget Instagram (Elfsight, SnapWidget, etc.)
        </p>
      </div>

      <!-- Help Section -->
      <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg">
        <h4 class="text-sm font-semibold text-blue-900 mb-2">Services recommandés :</h4>
        <ul class="space-y-2 text-xs text-blue-700">
          <li class="flex items-start gap-2">
            <span class="text-blue-500 mt-0.5">•</span>
            <div>
              <strong>Elfsight:</strong> 
              <a href="https://elfsight.com/instagram-feed-instashow/" target="_blank" class="underline hover:text-blue-900">
                elfsight.com/instagram-feed
              </a>
              - Widget Instagram gratuit et personnalisable
            </div>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-blue-500 mt-0.5">•</span>
            <div>
              <strong>SnapWidget:</strong> 
              <a href="https://snapwidget.com/" target="_blank" class="underline hover:text-blue-900">
                snapwidget.com
              </a>
              - Widgets Instagram simples et élégants
            </div>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-blue-500 mt-0.5">•</span>
            <div>
              <strong>Juicer:</strong> 
              <a href="https://www.juicer.io/" target="_blank" class="underline hover:text-blue-900">
                juicer.io
              </a>
              - Agrégateur de réseaux sociaux
            </div>
          </li>
        </ul>
      </div>

      <!-- Preview Section -->
      <div v-if="form.enabled && form.widget_code" class="border-t border-navy-100 pt-6">
        <h4 class="text-sm font-semibold text-navy-900 mb-3">Aperçu du code :</h4>
        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
          <pre class="text-xs text-gray-700 overflow-x-auto">{{ form.widget_code }}</pre>
        </div>
        <p class="mt-2 text-xs text-navy-500">
          ⚠️ Le widget sera affiché sur le site une fois sauvegardé
        </p>
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-between pt-4 border-t border-navy-100">
        <button
          v-if="form.enabled && form.widget_code"
          type="button"
          @click="clearWidget"
          class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors"
        >
          Effacer le widget
        </button>
        <div v-else></div>

        <div class="flex items-center gap-3">
          <button
            type="button"
            @click="loadWidget"
            class="px-4 py-2 text-sm font-medium text-navy-600 hover:bg-navy-50 rounded-lg transition-colors"
          >
            Annuler
          </button>
          <button
            type="submit"
            :disabled="saving"
            class="px-6 py-2 bg-gold-500 text-white rounded-lg hover:bg-gold-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-sm font-medium flex items-center gap-2"
          >
            <svg v-if="saving" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>{{ saving ? 'Enregistrement...' : 'Enregistrer' }}</span>
          </button>
        </div>
      </div>

      <!-- Success Message -->
      <div v-if="showSuccess" class="p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700 flex items-center gap-2">
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        Configuration enregistrée avec succès!
      </div>

      <!-- Error Message -->
      <div v-if="error" class="p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
        {{ error }}
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from '@/api/axios'

const loading = ref(false)
const saving = ref(false)
const showSuccess = ref(false)
const error = ref<string | null>(null)

const form = ref({
  enabled: false,
  widget_code: '',
  username: 'kayliasuitehome'
})

const loadWidget = async () => {
  loading.value = true
  error.value = null

  try {
    const response = await axios.get('/settings/instagram/widget')
    
    if (response.data.success) {
      form.value = {
        enabled: response.data.data.enabled || false,
        widget_code: response.data.data.widget_code || '',
        username: response.data.data.username || 'kayliasuitehome'
      }
    }
  } catch (err: any) {
    console.error('Failed to load Instagram widget:', err)
    error.value = err.response?.data?.error?.message || 'Erreur lors du chargement'
  } finally {
    loading.value = false
  }
}

const saveWidget = async () => {
  saving.value = true
  error.value = null
  showSuccess.value = false

  try {
    const response = await axios.put('/settings/instagram/widget', form.value)
    
    if (response.data.success) {
      showSuccess.value = true
      setTimeout(() => {
        showSuccess.value = false
      }, 3000)
    }
  } catch (err: any) {
    console.error('Failed to save Instagram widget:', err)
    error.value = err.response?.data?.error?.message || 'Erreur lors de l\'enregistrement'
  } finally {
    saving.value = false
  }
}

const clearWidget = () => {
  if (confirm('Êtes-vous sûr de vouloir effacer le widget Instagram ?')) {
    form.value.widget_code = ''
  }
}

onMounted(() => {
  loadWidget()
})
</script>
