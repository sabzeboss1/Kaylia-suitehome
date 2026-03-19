<template>
  <div class="animate-fade-in">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Gestion du contenu</h1>
        <p class="page-subtitle">Modifier le contenu et les médias du site</p>
      </div>
    </div>

    <!-- Alerts -->
    <div v-if="successMessage" class="mb-4 flex items-center gap-2 px-4 py-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5" /></svg>
      <span>{{ successMessage }}</span>
      <button @click="successMessage = ''" class="ml-auto text-emerald-400 hover:text-emerald-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
    </div>
    <div v-if="errorMessage" class="mb-4 flex items-center gap-2 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
      <span>{{ errorMessage }}</span>
      <button @click="errorMessage = ''" class="ml-auto text-red-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
    </div>

    <!-- Page Selection -->
    <div class="card mb-6">
      <div class="card-body">
        <h2 class="text-sm font-semibold text-navy-700 mb-3">Page à modifier</h2>
        <div class="flex flex-wrap gap-2">
          <button
            v-for="page in availablePages"
            :key="page.slug"
            @click="selectPage(page.slug)"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-all"
            :class="selectedPage === page.slug
              ? 'bg-navy-900 text-white shadow-sm'
              : 'bg-navy-50 text-navy-600 hover:bg-navy-100'"
          >
            {{ page.name }}
          </button>
        </div>
      </div>
    </div>

    <!-- Language Tabs -->
    <div v-if="selectedPage && multiLanguageEnabled" class="flex gap-1 mb-6">
      <button
        v-for="lang in availableLanguages"
        :key="lang.code"
        @click="selectLanguage(lang.code)"
        class="px-4 py-2 rounded-lg text-sm font-medium transition-all"
        :class="selectedLanguage === lang.code
          ? 'bg-gold-500 text-white'
          : 'bg-white text-navy-600 hover:bg-navy-50 border border-navy-100'"
      >
        {{ lang.name }}
      </button>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="card p-8 text-center">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
      <p class="mt-3 text-navy-400 text-sm">Chargement du contenu...</p>
    </div>

    <!-- Content Sections -->
    <div v-if="selectedPage && !loading" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Editor Panel -->
      <div class="space-y-6">
        <div class="card">
          <div class="card-body">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-sm font-semibold text-navy-700">Modifier le contenu</h2>
              <div class="flex gap-2">
                <button @click="revertChanges" :disabled="!hasUnsavedChanges" class="btn btn-outline btn-sm">Annuler</button>
                <button @click="saveChanges" :disabled="!hasUnsavedChanges || saving" class="btn btn-primary btn-sm">
                  <svg v-if="saving" class="w-3.5 h-3.5 animate-spin" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                  {{ saving ? 'Sauvegarde...' : 'Sauvegarder' }}
                </button>
              </div>
            </div>

            <div v-if="sections.length === 0" class="text-navy-400 text-sm">
              Aucune section modifiable trouvée pour cette page.
            </div>

            <div v-else class="space-y-5">
              <div v-for="section in sections" :key="section.section_key" class="border-b border-gray-100 pb-5 last:border-b-0 last:pb-0">
                <div class="flex justify-between items-start mb-2">
                  <label class="input-label">{{ formatSectionKey(section.section_key) }}</label>
                  <span class="text-[10px] text-navy-300">{{ formatDate(section.updated_at) }}</span>
                </div>

                <!-- Text -->
                <input v-if="section.content_type === 'text'" v-model="editedSections[section.section_key]" type="text" class="input" :placeholder="'Entrez ' + formatSectionKey(section.section_key)" />

                <!-- Number -->
                <input v-else-if="section.content_type === 'number'" v-model.number="editedSections[section.section_key]" type="number" step="any" class="input" />

                <!-- Boolean -->
                <div v-else-if="section.content_type === 'boolean'" class="bg-navy-50/50 rounded-lg p-3 border border-navy-100">
                  <label class="flex items-center justify-between cursor-pointer">
                    <span class="text-sm text-navy-700">Activer</span>
                    <div class="relative">
                      <input type="checkbox" v-model="editedSections[section.section_key]" class="sr-only peer" />
                      <div class="w-10 h-6 bg-navy-200 rounded-full peer-checked:bg-emerald-500 transition-colors"></div>
                      <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                    </div>
                  </label>
                </div>

                <!-- Image URL -->
                <div v-else-if="section.content_type === 'image_url'" class="space-y-2">
                  <div v-if="editedSections[section.section_key]" class="relative inline-block">
                    <img :src="getImageUrl(editedSections[section.section_key])" alt="Preview" class="max-w-[200px] rounded-lg border border-navy-100" />
                    <button @click="editedSections[section.section_key] = ''" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-0.5 hover:bg-red-600">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                  </div>
                  <div class="flex gap-2">
                    <input v-model="editedSections[section.section_key]" type="text" class="input flex-1" placeholder="URL de l'image" />
                    <button @click="openMediaLibrary(section.section_key)" class="btn btn-outline btn-sm">Galerie</button>
                    <button @click="uploadImage(section.section_key)" class="btn btn-primary btn-sm">Upload</button>
                  </div>
                </div>

                <!-- Video URL -->
                <div v-else-if="section.content_type === 'video_url'" class="space-y-2">
                  <VideoPreview 
                    v-if="editedSections[section.section_key]" 
                    :url="editedSections[section.section_key]" 
                  />
                  <div class="flex gap-2 items-start">
                    <div class="flex-1">
                      <input 
                        v-model="editedSections[section.section_key]" 
                        type="text" 
                        class="input w-full" 
                        placeholder="URL YouTube, Vimeo ou fichier vidéo" 
                      />
                      <p class="text-xs text-navy-400 mt-1">
                        Formats: YouTube (youtube.com/watch?v=xxx), Vimeo (vimeo.com/xxx), Direct (.mp4, .webm)
                      </p>
                    </div>
                    <button 
                      v-if="editedSections[section.section_key]"
                      @click="editedSections[section.section_key] = ''" 
                      class="btn btn-outline btn-sm text-red-500 hover:bg-red-50"
                    >
                      Effacer
                    </button>
                  </div>
                </div>

                <!-- Media Choice (Image OU Vidéo) -->
                <div v-else-if="section.content_type === 'media_choice'" class="space-y-3">
                  <!-- Type Selector -->
                  <div class="flex gap-2 bg-navy-50 p-1 rounded-lg">
                    <button 
                      @click="setMediaType(section.section_key, 'image')"
                      :class="getMediaType(section.section_key) === 'image' 
                        ? 'bg-white text-navy-900 shadow-sm' 
                        : 'text-navy-600 hover:text-navy-900'"
                      class="flex-1 px-4 py-2 rounded-md text-sm font-medium transition-all flex items-center justify-center gap-2"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      Image
                    </button>
                    <button 
                      @click="setMediaType(section.section_key, 'video')"
                      :class="getMediaType(section.section_key) === 'video' 
                        ? 'bg-white text-navy-900 shadow-sm' 
                        : 'text-navy-600 hover:text-navy-900'"
                      class="flex-1 px-4 py-2 rounded-md text-sm font-medium transition-all flex items-center justify-center gap-2"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                      </svg>
                      Vidéo
                    </button>
                  </div>

                  <!-- Image Input -->
                  <div v-if="getMediaType(section.section_key) === 'image'" class="space-y-2">
                    <img 
                      v-if="getMediaUrl(section.section_key)" 
                      :src="getImageUrl(getMediaUrl(section.section_key))" 
                      alt="Preview" 
                      class="max-w-[300px] rounded-lg border border-navy-100" 
                    />
                    <div class="flex gap-2">
                      <input 
                        v-model="mediaUrls[section.section_key]" 
                        type="text" 
                        class="input flex-1" 
                        placeholder="URL de l'image" 
                        @input="updateMediaChoice(section.section_key)" 
                      />
                      <button 
                        @click="openMediaLibrary(section.section_key)" 
                        class="btn btn-outline btn-sm"
                      >
                        Galerie
                      </button>
                      <button 
                        @click="uploadImage(section.section_key)" 
                        class="btn btn-primary btn-sm"
                      >
                        Upload
                      </button>
                    </div>
                  </div>

                  <!-- Video Input -->
                  <div v-else class="space-y-2">
                    <VideoPreview 
                      v-if="getMediaUrl(section.section_key)" 
                      :url="getMediaUrl(section.section_key)" 
                    />
                    <div class="flex gap-2 items-start">
                      <div class="flex-1">
                        <input 
                          v-model="mediaUrls[section.section_key]" 
                          type="text" 
                          class="input w-full" 
                          placeholder="URL YouTube, Vimeo ou fichier vidéo"
                          @input="updateMediaChoice(section.section_key)" 
                        />
                        <p class="text-xs text-navy-400 mt-1">
                          YouTube: youtube.com/watch?v=xxx | Vimeo: vimeo.com/xxx | Direct: .mp4, .webm
                        </p>
                      </div>
                      <button 
                        @click="uploadVideo(section.section_key)" 
                        class="btn btn-primary btn-sm whitespace-nowrap"
                      >
                        Upload Vidéo
                      </button>
                    </div>
                  </div>
                </div>

                <!-- HTML Editor -->
                <div v-else-if="section.content_type === 'html'" class="space-y-1">
                  <div class="border border-navy-100 rounded-lg overflow-hidden">
                    <div class="bg-navy-50 border-b border-navy-100 px-2 py-1.5 flex gap-1">
                      <button @click="applyFormat(section.section_key, 'bold')" class="px-2 py-1 text-xs bg-white border border-navy-100 rounded hover:bg-navy-50 font-bold">B</button>
                      <button @click="applyFormat(section.section_key, 'italic')" class="px-2 py-1 text-xs bg-white border border-navy-100 rounded hover:bg-navy-50 italic">I</button>
                      <button @click="applyFormat(section.section_key, 'underline')" class="px-2 py-1 text-xs bg-white border border-navy-100 rounded hover:bg-navy-50 underline">U</button>
                      <div class="w-px bg-navy-100 mx-1"></div>
                      <button @click="applyFormat(section.section_key, 'insertUnorderedList')" class="px-2 py-1 text-xs bg-white border border-navy-100 rounded hover:bg-navy-50">≡</button>
                      <button @click="applyFormat(section.section_key, 'insertOrderedList')" class="px-2 py-1 text-xs bg-white border border-navy-100 rounded hover:bg-navy-50">1.</button>
                      <div class="w-px bg-navy-100 mx-1"></div>
                      <button @click="insertLink(section.section_key)" class="px-2 py-1 text-xs bg-white border border-navy-100 rounded hover:bg-navy-50">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" /></svg>
                      </button>
                    </div>
                    <div
                      :ref="'editor-' + section.section_key"
                      contenteditable="true"
                      @input="updateHtmlContent(section.section_key, $event)"
                      class="p-3 min-h-[120px] focus:outline-none text-sm text-navy-700"
                      v-html="editedSections[section.section_key]"
                    ></div>
                  </div>
                </div>

                <!-- JSON -->
                <textarea v-else-if="section.content_type === 'json'" v-model="editedSections[section.section_key]" rows="5" class="input font-mono text-xs" placeholder='{"key": "value"}'></textarea>

                <div v-if="validationErrors[section.section_key]" class="mt-1 text-xs text-red-500">{{ validationErrors[section.section_key] }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Live Preview -->
      <div class="space-y-6">
        <div class="card sticky top-6">
          <div class="card-body">
            <h2 class="text-sm font-semibold text-navy-700 mb-4">Aperçu en direct</h2>
            <div class="border border-navy-100 rounded-lg p-4 bg-navy-50/30 max-h-[600px] overflow-y-auto">
              <div v-if="sections.length === 0" class="text-navy-400 text-sm text-center py-8">Aucun contenu à prévisualiser</div>
              <div v-else class="space-y-4">
                <div v-for="section in sections" :key="section.section_key" class="border-b border-navy-100 pb-4 last:border-b-0">
                  <div class="text-[10px] font-semibold text-navy-300 uppercase tracking-wide mb-1">{{ formatSectionKey(section.section_key) }}</div>

                  <div v-if="['text', 'number'].includes(section.content_type)" class="text-sm text-navy-800">
                    {{ editedSections[section.section_key] || '(vide)' }}
                  </div>

                  <div v-else-if="section.content_type === 'boolean'">
                    <span class="badge" :class="editedSections[section.section_key] ? 'badge-success' : 'badge-danger'">
                      {{ editedSections[section.section_key] ? 'Activé' : 'Désactivé' }}
                    </span>
                  </div>

                  <div v-else-if="section.content_type === 'image_url'">
                    <img v-if="editedSections[section.section_key]" :src="getImageUrl(editedSections[section.section_key])" alt="Preview" class="max-w-full rounded-lg border border-navy-100" />
                    <div v-else class="text-navy-300 text-xs italic">(pas d'image)</div>
                  </div>

                  <div v-else-if="section.content_type === 'video_url'">
                    <VideoPreview 
                      v-if="editedSections[section.section_key]" 
                      :url="editedSections[section.section_key]" 
                    />
                    <div v-else class="text-navy-300 text-xs italic">(pas de vidéo)</div>
                  </div>

                  <div v-else-if="section.content_type === 'media_choice'">
                    <div v-if="getMediaType(section.section_key) === 'image'">
                      <img 
                        v-if="getMediaUrl(section.section_key)" 
                        :src="getImageUrl(getMediaUrl(section.section_key))" 
                        alt="Preview" 
                        class="max-w-full rounded-lg border border-navy-100" 
                      />
                      <div v-else class="text-navy-300 text-xs italic">(pas d'image)</div>
                    </div>
                    <div v-else>
                      <VideoPreview 
                        v-if="getMediaUrl(section.section_key)" 
                        :url="getMediaUrl(section.section_key)" 
                      />
                      <div v-else class="text-navy-300 text-xs italic">(pas de vidéo)</div>
                    </div>
                  </div>

                  <div v-else-if="section.content_type === 'html'" class="prose prose-sm max-w-none text-navy-700" v-html="editedSections[section.section_key]"></div>

                  <pre v-else-if="section.content_type === 'json'" class="text-xs bg-navy-800 text-emerald-400 p-2 rounded overflow-x-auto">{{ formatJson(editedSections[section.section_key]) }}</pre>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Media Library Modal -->
    <div v-if="showMediaLibrary" class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click.self="closeMediaLibrary">
      <div class="bg-white rounded-xl max-w-3xl w-full max-h-[80vh] overflow-hidden shadow-2xl animate-slide-down">
        <div class="bg-gradient-navy px-6 py-4 flex justify-between items-center">
          <h3 class="text-lg font-bold text-white">Bibliothèque média</h3>
          <button @click="closeMediaLibrary" class="text-white/60 hover:text-white hover:bg-white/10 rounded-lg p-1.5 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[60vh]">
          <div v-if="loadingMedia" class="text-center py-8 text-navy-400 text-sm">Chargement...</div>
          <div v-else-if="mediaFiles.length === 0" class="text-center py-8 text-navy-400 text-sm">Aucun fichier média</div>
          <div v-else class="grid grid-cols-3 gap-3">
            <div
              v-for="media in mediaFiles"
              :key="media.id"
              @click="selectMedia(media)"
              class="cursor-pointer border-2 border-navy-100 rounded-lg overflow-hidden hover:border-gold-400 transition-colors"
            >
              <img :src="getMediaThumbnail(media)" :alt="media.alt_text || 'Media'" class="w-full h-28 object-cover" />
              <div class="p-2 bg-navy-50">
                <div class="text-xs text-navy-500 truncate">{{ media.original_filename }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Hidden file input -->
    <input ref="imageUploadInput" type="file" accept="image/jpeg,image/jpg,image/png,image/webp" class="hidden" @change="handleImageUpload" />
    <input ref="videoUploadInput" type="file" accept="video/mp4,video/webm,video/ogg" class="hidden" @change="handleVideoUpload" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from '../api/axios'
import VideoPreview from '../components/VideoPreview.vue'

const loading = ref(false)
const saving = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const selectedPage = ref('')
const selectedLanguage = ref('fr')
const sections = ref([])
const editedSections = ref({})
const originalSections = ref({})
const validationErrors = ref({})
const multiLanguageEnabled = ref(true)
const showMediaLibrary = ref(false)
const loadingMedia = ref(false)
const mediaFiles = ref([])
const currentImageSection = ref('')
const imageUploadInput = ref(null)
const videoUploadInput = ref(null)

// Media choice helpers
const mediaTypes = ref({})
const mediaUrls = ref({})

const availablePages = ref([
  { slug: 'home', name: 'Accueil', description: 'Page principale' },
  { slug: 'apartments', name: 'Appartements', description: 'Liste des appartements' },
  { slug: 'spa', name: 'SPA', description: 'Services SPA' },
  { slug: 'contact', name: 'Contact', description: 'Page contact' },
  { slug: 'about', name: 'À propos', description: 'Page à propos' },
])

const availableLanguages = ref([
  { code: 'fr', name: 'Français' },
  { code: 'en', name: 'English' },
])

const hasUnsavedChanges = computed(() => JSON.stringify(editedSections.value) !== JSON.stringify(originalSections.value))

const selectPage = async (pageSlug) => { selectedPage.value = pageSlug; await loadPageContent() }

const selectLanguage = async (langCode) => {
  if (hasUnsavedChanges.value && !confirm('Vous avez des modifications non sauvegardées. Les abandonner ?')) return
  selectedLanguage.value = langCode
  await loadPageContent()
}

const loadPageContent = async () => {
  if (!selectedPage.value) return
  loading.value = true; errorMessage.value = ''
  try {
    const response = await axios.get(`/content/${selectedPage.value}/editable`, { params: { language: selectedLanguage.value } })
    sections.value = response.data.data
    editedSections.value = {}
    sections.value.forEach(section => {
      if (section.content_type === 'media_choice') {
        try {
          const parsed = typeof section.content_value === 'string' 
            ? JSON.parse(section.content_value) 
            : section.content_value
          mediaTypes.value[section.section_key] = parsed.type || 'image'
          mediaUrls.value[section.section_key] = parsed.url || ''
          editedSections.value[section.section_key] = JSON.stringify(parsed)
        } catch (e) {
          mediaTypes.value[section.section_key] = 'image'
          mediaUrls.value[section.section_key] = ''
          editedSections.value[section.section_key] = JSON.stringify({ type: 'image', url: '' })
        }
      } else {
        editedSections.value[section.section_key] = section.content_type === 'json' && typeof section.content_value === 'object'
          ? JSON.stringify(section.content_value, null, 2)
          : section.content_value
      }
    })
    originalSections.value = JSON.parse(JSON.stringify(editedSections.value))
    validationErrors.value = {}
  } catch (error) {
    errorMessage.value = error.response?.data?.error?.message || 'Échec du chargement du contenu'
  } finally { loading.value = false }
}

const saveChanges = async () => {
  if (!validateAllSections()) { errorMessage.value = 'Corrigez les erreurs avant de sauvegarder'; return }
  saving.value = true; errorMessage.value = ''; successMessage.value = ''
  try {
    const savePromises = sections.value
      .filter(s => editedSections.value[s.section_key] !== originalSections.value[s.section_key])
      .map(s => {
        let val = editedSections.value[s.section_key]
        if (s.content_type === 'json' && typeof val === 'string') { try { val = JSON.parse(val) } catch (e) {} }
        return axios.put(`/content/${selectedPage.value}/${s.section_key}`, { content_value: val, content_type: s.content_type, language: selectedLanguage.value })
      })
    await Promise.all(savePromises)
    originalSections.value = JSON.parse(JSON.stringify(editedSections.value))
    await loadPageContent()
    successMessage.value = 'Contenu sauvegardé !'
    setTimeout(() => { successMessage.value = '' }, 3000)
  } catch (error) {
    errorMessage.value = error.response?.data?.error?.message || 'Échec de la sauvegarde'
  } finally { saving.value = false }
}

const revertChanges = () => {
  if (confirm('Annuler toutes les modifications ?')) {
    editedSections.value = JSON.parse(JSON.stringify(originalSections.value))
    validationErrors.value = {}
  }
}

const validateAllSections = () => {
  validationErrors.value = {}; let valid = true
  sections.value.forEach(s => { const e = validateSection(s); if (e) { validationErrors.value[s.section_key] = e; valid = false } })
  return valid
}

const validateSection = (section) => {
  const val = editedSections.value[section.section_key]
  if (section.required && !val) return 'Ce champ est requis'
  if (section.content_type === 'json' && val && typeof val === 'string') { try { JSON.parse(val) } catch (e) { return 'JSON invalide' } }
  if (section.content_type === 'number' && val && isNaN(val)) return 'Nombre invalide'
  if (section.content_type === 'image_url' && val && !val.match(/^(https?:\/\/|\/)/)) return 'URL ou chemin invalide'
  return null
}

const formatSectionKey = (key) => key.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ')
const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' }) : ''
const formatJson = (v) => { try { return typeof v === 'string' ? JSON.stringify(JSON.parse(v), null, 2) : JSON.stringify(v, null, 2) } catch (e) { return v } }
const getImageUrl = (url) => { 
  if (!url) return ''; 
  if (url.startsWith('http')) return url; 
  // Remove leading slash if present to avoid double slash
  const cleanUrl = url.startsWith('/') ? url.substring(1) : url;
  return import.meta.env.VITE_API_BASE_URL.replace('/api', '') + '/storage/' + cleanUrl;
}

const applyFormat = (k, cmd) => { document.execCommand(cmd, false, null) }
const insertLink = (k) => { const url = prompt('Entrez l\'URL :'); if (url) document.execCommand('createLink', false, url) }
const updateHtmlContent = (k, e) => { editedSections.value[k] = e.target.innerHTML }

const openMediaLibrary = async (k) => { currentImageSection.value = k; showMediaLibrary.value = true; await loadMediaFiles() }
const closeMediaLibrary = () => { showMediaLibrary.value = false; currentImageSection.value = '' }
const loadMediaFiles = async () => {
  loadingMedia.value = true
  try { const r = await axios.get('/api/media', { params: { per_page: 50 } }); mediaFiles.value = r.data.data }
  catch (e) { console.error('Error loading media:', e) }
  finally { loadingMedia.value = false }
}
const selectMedia = (media) => { if (currentImageSection.value) editedSections.value[currentImageSection.value] = media.file_path; closeMediaLibrary() }
const getMediaThumbnail = (media) => getImageUrl(media.thumbnail_600 || media.file_path)

const uploadImage = (k) => { currentImageSection.value = k; imageUploadInput.value?.click() }
const handleImageUpload = async (event) => {
  const file = event.target.files[0]; if (!file) return
  const formData = new FormData(); formData.append('file', file); formData.append('entity_type', 'content'); formData.append('entity_id', 0)
  try {
    const r = await axios.post('/api/media', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
    if (currentImageSection.value) editedSections.value[currentImageSection.value] = r.data.data.file_path
    successMessage.value = 'Image uploadée !'; setTimeout(() => { successMessage.value = '' }, 3000)
  } catch (e) { errorMessage.value = e.response?.data?.error?.message || 'Échec de l\'upload' }
  event.target.value = ''
}

const uploadVideo = (k) => { currentImageSection.value = k; videoUploadInput.value?.click() }
const handleVideoUpload = async (event) => {
  const file = event.target.files[0]; if (!file) return
  const formData = new FormData(); formData.append('file', file); formData.append('entity_type', 'content'); formData.append('entity_id', 0)
  try {
    const r = await axios.post('/api/media', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
    if (currentImageSection.value) {
      const filePath = r.data.data.file_path
      const fullUrl = import.meta.env.VITE_API_BASE_URL.replace('/api', '') + '/storage/' + filePath
      mediaUrls.value[currentImageSection.value] = fullUrl
      updateMediaChoice(currentImageSection.value)
    }
    successMessage.value = 'Vidéo uploadée !'; setTimeout(() => { successMessage.value = '' }, 3000)
  } catch (e) { errorMessage.value = e.response?.data?.error?.message || 'Échec de l\'upload vidéo' }
  event.target.value = ''
}

const getMediaType = (sectionKey) => {
  const value = editedSections.value[sectionKey]
  if (typeof value === 'string') {
    try {
      const parsed = JSON.parse(value)
      return parsed.type || 'image'
    } catch (e) {
      return 'image'
    }
  }
  return mediaTypes.value[sectionKey] || 'image'
}

const getMediaUrl = (sectionKey) => {
  const value = editedSections.value[sectionKey]
  if (typeof value === 'string') {
    try {
      const parsed = JSON.parse(value)
      return parsed.url || ''
    } catch (e) {
      return ''
    }
  }
  return mediaUrls.value[sectionKey] || ''
}

const setMediaType = (sectionKey, type) => {
  mediaTypes.value[sectionKey] = type
  updateMediaChoice(sectionKey)
}

const updateMediaChoice = (sectionKey) => {
  const type = mediaTypes.value[sectionKey] || 'image'
  const url = mediaUrls.value[sectionKey] || ''
  editedSections.value[sectionKey] = JSON.stringify({ type, url })
}

onMounted(() => { if (availablePages.value.length > 0) selectPage(availablePages.value[0].slug) })
</script>

<style scoped>
[contenteditable] { outline: none; }
[contenteditable]:focus { background-color: #ffffff; }
.prose p { margin-bottom: 0.75em; }
.prose ul, .prose ol { margin-left: 1.5em; margin-bottom: 0.75em; }
.prose ul { list-style-type: disc; }
.prose ol { list-style-type: decimal; }
.prose a { color: var(--gold-600); text-decoration: underline; }
.prose strong { font-weight: 600; }
.prose em { font-style: italic; }
</style>
