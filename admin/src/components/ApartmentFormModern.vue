<template>
  <div class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl max-w-6xl w-full max-h-[95vh] overflow-hidden shadow-2xl animate-slide-down">
      <!-- Header with Tabs -->
      <div class="sticky top-0 bg-gradient-navy px-8 py-5 z-10">
        <div class="flex justify-between items-center mb-4">
          <div>
            <h2 class="text-2xl font-bold text-white">
              {{ isEdit ? 'Modifier l\'appartement' : 'Nouvel appartement' }}
            </h2>
            <p class="text-navy-300 text-sm mt-1">
              {{ isEdit ? 'Mettez à jour les informations' : 'Créez un nouvel appartement avec toutes ses informations' }}
            </p>
          </div>
          <button
            @click="$emit('close')"
            class="text-white/60 hover:text-white hover:bg-white/10 rounded-lg p-2 transition-all"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex gap-1 overflow-x-auto">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="currentTab = tab.id"
            :class="[
              'px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap',
              currentTab === tab.id
                ? 'bg-white text-navy-900 shadow-lg'
                : 'text-white/60 hover:text-white hover:bg-white/[0.08]'
            ]"
          >
            {{ tab.label }}
          </button>
        </div>
      </div>

      <!-- Form Content -->
      <form @submit.prevent="handleSubmit" class="overflow-y-auto max-h-[calc(95vh-180px)]">
        <!-- Tab: Basic Info -->
        <div v-show="currentTab === 'basic'" class="p-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="lg:col-span-2">
              <label class="input-label">
                Nom de l'appartement <span class="text-red-400">*</span>
              </label>
              <input
                v-model="form.name"
                type="text"
                required
                placeholder="Ex: Studio Cosy Centre-Ville"
                class="input"
                :class="{ 'border-red-500': errors.name }"
              />
              <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name[0] }}</p>
            </div>

            <!-- Type -->
            <div>
              <label class="input-label">
                Type <span class="text-red-400">*</span>
              </label>
              <select
                v-model="form.type"
                required
                class="input"
              >
                <option value="">Sélectionner un type</option>
                <option value="studio">Studio</option>
                <option value="t2">T2 - 2 pièces</option>
                <option value="t3">T3 - 3 pièces</option>
              </select>
            </div>

            <!-- Capacity -->
            <div>
              <label class="input-label">
                Capacité <span class="text-red-400">*</span>
              </label>
              <input
                v-model.number="form.capacity"
                type="number"
                min="1"
                required
                placeholder="Nombre de personnes"
                class="input"
              />
            </div>

            <!-- Surface Area -->
            <div>
              <label class="input-label">
                Surface (m²) <span class="text-red-400">*</span>
              </label>
              <input
                v-model.number="form.surface_area"
                type="number"
                step="0.01"
                min="0"
                required
                placeholder="Ex: 45.5"
                class="input"
              />
            </div>

            <!-- Floor -->
            <div>
              <label class="input-label">
                Étage <span class="text-red-400">*</span>
              </label>
              <input
                v-model.number="form.floor"
                type="number"
                placeholder="Ex: 2"
                class="input"
              />
            </div>

            <!-- Beds -->
            <div class="lg:col-span-2 grid grid-cols-2 gap-4">
              <div>
                <label class="input-label">
                  Lits King Size
                </label>
                <input
                  v-model.number="form.beds_king_size"
                  type="number"
                  min="0"
                  class="input"
                />
              </div>
              <div>
                <label class="input-label">
                  Lits Simples
                </label>
                <input
                  v-model.number="form.beds_single"
                  type="number"
                  min="0"
                  class="input"
                />
              </div>
            </div>

            <!-- Price -->
            <div>
              <label class="input-label">
                Prix par nuit (€) <span class="text-red-400">*</span>
              </label>
              <input
                v-model.number="form.price_per_night"
                type="number"
                step="0.01"
                min="0"
                required
                placeholder="Ex: 89.00"
                class="input"
              />
            </div>

            <!-- Tax -->
            <div>
              <label class="input-label">
                Taxe de séjour (€)
              </label>
              <input
                v-model.number="form.tax_per_stay"
                type="number"
                step="0.01"
                min="0"
                placeholder="Ex: 2.50"
                class="input"
              />
            </div>

            <!-- Description -->
            <div class="lg:col-span-2">
              <label class="input-label">
                Description
              </label>
              <textarea
                v-model="form.description"
                rows="6"
                placeholder="Décrivez l'appartement en détail..."
                class="input"
              ></textarea>
            </div>

            <!-- Settings -->
            <div class="lg:col-span-2 bg-navy-50/50 rounded-xl p-6 space-y-4 border border-navy-100">
              <h4 class="font-semibold text-navy-800 text-sm">Paramètres</h4>
              <label class="flex items-center justify-between p-3 rounded-lg hover:bg-white cursor-pointer transition-colors">
                <div>
                  <div class="text-sm font-medium text-navy-800">Disponible à la réservation</div>
                  <div class="text-xs text-navy-400">Les clients peuvent réserver cet appartement</div>
                </div>
                <div class="relative">
                  <input type="checkbox" v-model="form.is_available" class="sr-only peer" />
                  <div class="w-10 h-6 bg-navy-200 rounded-full peer-checked:bg-emerald-500 transition-colors"></div>
                  <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                </div>
              </label>
              <label class="flex items-center justify-between p-3 rounded-lg hover:bg-white cursor-pointer transition-colors">
                <div>
                  <div class="text-sm font-medium text-navy-800">Appartement mis en avant</div>
                  <div class="text-xs text-navy-400">Affiché en priorité sur le site</div>
                </div>
                <div class="relative">
                  <input type="checkbox" v-model="form.is_featured" class="sr-only peer" />
                  <div class="w-10 h-6 bg-navy-200 rounded-full peer-checked:bg-gold-500 transition-colors"></div>
                  <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <!-- Tab: Images -->
        <div v-show="currentTab === 'images'" class="p-8">
          <div class="mb-6">
            <h3 class="text-lg font-bold text-navy-900 mb-1">Galerie d'images</h3>
            <p class="text-navy-400 text-sm">Ajoutez des images de qualité pour présenter l'appartement</p>
          </div>

          <!-- Upload Zone -->
          <div
            @drop.prevent="handleDrop"
            @dragover.prevent="dragOver = true"
            @dragleave.prevent="dragOver = false"
            :class="[
              'border-2 border-dashed rounded-xl p-10 text-center transition-all mb-8',
              dragOver ? 'border-gold-500 bg-gold-50 scale-[1.01]' : 'border-navy-200 hover:border-gold-400'
            ]"
          >
            <input
              ref="fileInput"
              type="file"
              accept="image/jpeg,image/png,image/webp"
              multiple
              @change="handleFileSelect"
              class="hidden"
            />
            <div>
              <svg class="w-12 h-12 text-navy-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
              <p class="text-sm font-semibold text-navy-700 mb-1">Glissez-déposez vos images ici</p>
              <p class="text-xs text-navy-400 mb-4">ou</p>
              <button
                type="button"
                @click="$refs.fileInput.click()"
                class="btn btn-primary"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                Parcourir les fichiers
              </button>
              <p class="text-xs text-navy-300 mt-4">JPEG, PNG, WebP • Max 10MB par image</p>
            </div>
          </div>

          <!-- Images Grid -->
          <div v-if="images.length > 0">
            <div class="flex justify-between items-center mb-4">
              <div class="flex items-center gap-4">
                <h4 class="font-semibold text-gray-800">{{ images.length }} image(s)</h4>
                <span v-if="selectedImages.length > 0" class="text-sm text-blue-600 font-medium">
                  {{ selectedImages.length }} sélectionnée(s)
                </span>
              </div>
              <div class="flex items-center gap-2">
                <button
                  v-if="images.length > 0"
                  type="button"
                  @click="toggleSelectAll"
                  class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors"
                >
                  {{ selectedImages.length === images.length ? '❌ Tout désélectionner' : '☑️ Tout sélectionner' }}
                </button>
                <button
                  v-if="selectedImages.length > 0"
                  type="button"
                  @click="deleteSelectedImages"
                  class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-all flex items-center gap-2"
                >
                  <span>🗑️</span>
                  <span>Supprimer ({{ selectedImages.length }})</span>
                </button>
              </div>
            </div>
            
            <p class="text-sm text-gray-500 mb-4">💡 Glissez pour réorganiser • La première image est l'image principale</p>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
              <div
                v-for="(image, index) in images"
                :key="image.id || index"
                draggable="true"
                @dragstart="handleDragStart(index)"
                @dragover.prevent
                @drop="handleImageDrop(index)"
                :class="[
                  'relative group cursor-move border-3 rounded-xl overflow-hidden transition-all hover:shadow-xl',
                  selectedImages.includes(index) ? 'border-blue-500 ring-4 ring-blue-200' : (image.is_primary ? 'border-yellow-400 ring-4 ring-yellow-100' : 'border-gray-200 hover:border-blue-400')
                ]"
              >
                <!-- Checkbox de sélection -->
                <div class="absolute top-3 left-3 z-10">
                  <label class="flex items-center cursor-pointer">
                    <input
                      type="checkbox"
                      :checked="selectedImages.includes(index)"
                      @change="toggleImageSelection(index)"
                      @click.stop
                      class="w-5 h-5 rounded border-2 border-white shadow-lg text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer"
                    />
                  </label>
                </div>

                <img
                  :src="getImageUrl(image.preview || image.thumbnail_url || image.image_url)"
                  :alt="image.alt_text || 'Image appartement'"
                  class="w-full h-48 object-cover"
                  @load="(e) => { console.log('Image loaded successfully:', e.target.src) }"
                  @error="(e) => { console.error('Image load error:', e.target.src, 'Original URL:', image.preview || image.thumbnail_url || image.image_url); e.target.src = '/images/placeholder-apartment.svg' }"
                />
                
                <!-- Primary Badge -->
                <div
                  v-if="image.is_primary"
                  class="absolute top-3 right-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1"
                >
                  <span>⭐</span>
                  <span>PRINCIPALE</span>
                </div>

                <!-- Order Badge -->
                <div 
                  v-else
                  class="absolute top-3 right-3 bg-black/70 text-white text-xs font-bold px-2 py-1 rounded-full"
                >
                  #{{ index + 1 }}
                </div>

                <!-- Actions Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all flex flex-col justify-end p-4">
                  <div class="flex gap-2">
                    <button
                      type="button"
                      @click="setPrimaryImage(index)"
                      v-if="!image.is_primary"
                      class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all"
                    >
                      ⭐ Principale
                    </button>
                    <button
                      type="button"
                      @click="editImageAlt(index)"
                      class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all"
                    >
                      ✏️ Alt
                    </button>
                    <button
                      type="button"
                      @click="removeImage(index)"
                      class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all"
                    >
                      🗑️
                    </button>
                  </div>
                </div>

                <!-- Upload Progress -->
                <div v-if="image.uploading" class="absolute inset-0 bg-black/70 flex items-center justify-center">
                  <div class="text-white text-center">
                    <div class="animate-spin text-4xl mb-2">⏳</div>
                    <div class="text-sm font-medium">Upload en cours...</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div v-else class="text-center py-12">
            <svg class="w-12 h-12 text-navy-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
            <p class="text-sm text-navy-400">Aucune image ajoutée</p>
          </div>
        </div>

        <!-- Tab: Video -->
        <div v-show="currentTab === 'video'" class="p-8">
          <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">🎥 Vidéo de présentation</h3>
            <p class="text-gray-600 text-sm">Ajoutez une vidéo YouTube, Vimeo ou un lien direct pour présenter l'appartement</p>
          </div>

          <div class="space-y-6">
            <!-- Video URL -->
            <div>
              <label class="input-label">
                🔗 URL de la vidéo
              </label>
              <input
                v-model="form.video_url"
                type="url"
                placeholder="https://www.youtube.com/watch?v=... ou https://vimeo.com/..."
                class="input"
              />
              <p class="text-xs text-gray-500 mt-1">
                💡 Formats supportés: YouTube, Vimeo, liens directs MP4/WebM
              </p>
            </div>

            <!-- Video Preview -->
            <div v-if="form.video_url" class="bg-gray-50 rounded-xl p-6">
              <h4 class="font-semibold text-gray-800 mb-4">👁️ Aperçu de la vidéo</h4>
              <div class="aspect-video bg-gray-200 rounded-lg overflow-hidden">
                <!-- YouTube -->
                <iframe
                  v-if="isYouTubeUrl(form.video_url)"
                  :src="getYouTubeEmbedUrl(form.video_url)"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen
                  class="w-full h-full"
                ></iframe>
                
                <!-- Vimeo -->
                <iframe
                  v-else-if="isVimeoUrl(form.video_url)"
                  :src="getVimeoEmbedUrl(form.video_url)"
                  frameborder="0"
                  allow="autoplay; fullscreen; picture-in-picture"
                  allowfullscreen
                  class="w-full h-full"
                ></iframe>
                
                <!-- Direct Video -->
                <video
                  v-else-if="isDirectVideoUrl(form.video_url)"
                  :src="form.video_url"
                  controls
                  class="w-full h-full bg-black"
                >
                  Votre navigateur ne supporte pas la lecture de vidéos.
                </video>
                
                <!-- Invalid Format -->
                <div v-else class="flex items-center justify-center h-full text-gray-500">
                  <div class="text-center">
                    <div class="text-4xl mb-2">⚠️</div>
                    <p class="text-sm">Format de vidéo non reconnu</p>
                    <p class="text-xs mt-1">Vérifiez l'URL de votre vidéo</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Help Section -->
            <div class="bg-blue-50 rounded-xl p-6">
              <h4 class="font-semibold text-blue-900 mb-3">💡 Comment ajouter une vidéo ?</h4>
              <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex items-start gap-2">
                  <span class="font-bold">1️⃣</span>
                  <div>
                    <strong>YouTube :</strong> Copiez l'URL de la vidéo
                    <br>
                    <code class="text-xs bg-blue-100 px-2 py-1 rounded mt-1 inline-block">https://www.youtube.com/watch?v=xxxxx</code>
                  </div>
                </li>
                <li class="flex items-start gap-2">
                  <span class="font-bold">2️⃣</span>
                  <div>
                    <strong>Vimeo :</strong> Copiez l'URL de la vidéo
                    <br>
                    <code class="text-xs bg-blue-100 px-2 py-1 rounded mt-1 inline-block">https://vimeo.com/xxxxx</code>
                  </div>
                </li>
                <li class="flex items-start gap-2">
                  <span class="font-bold">3️⃣</span>
                  <div>
                    <strong>Vidéo directe :</strong> URL d'un fichier vidéo hébergé
                    <br>
                    <code class="text-xs bg-blue-100 px-2 py-1 rounded mt-1 inline-block">https://example.com/video.mp4</code>
                  </div>
                </li>
              </ul>
            </div>

            <!-- Clear Button -->
            <div v-if="form.video_url" class="flex justify-end">
              <button
                type="button"
                @click="form.video_url = ''"
                class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-all flex items-center gap-2"
              >
                <span>🗑️</span>
                <span>Supprimer la vidéo</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Tab: Location -->
        <div v-show="currentTab === 'location'" class="p-8">
          <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">📍 Autour de vous</h3>
            <p class="text-gray-600 text-sm">Ajoutez les points d'intérêt et attractions à proximité de l'appartement</p>
          </div>

          <div class="space-y-6">
            <!-- Attractions List -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3">
                🗺️ Points d'intérêt à proximité
              </label>
              
              <div class="space-y-3 mb-4">
                <div
                  v-for="(attraction, index) in form.nearby_attractions"
                  :key="index"
                  class="flex items-center gap-3 p-4 bg-white border-2 border-gray-200 rounded-xl hover:border-blue-300 transition-all"
                >
                  <span class="text-2xl">📍</span>
                  <input
                    v-model="form.nearby_attractions[index]"
                    type="text"
                    placeholder="Ex: Plage à 500m, Centre-ville à 10 minutes..."
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                  <button
                    type="button"
                    @click="removeAttraction(index)"
                    class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-all"
                  >
                    🗑️
                  </button>
                </div>
              </div>

              <button
                type="button"
                @click="addAttraction"
                class="w-full px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
              >
                <span class="text-xl">➕</span>
                <span>Ajouter un point d'intérêt</span>
              </button>
            </div>

            <!-- Preview -->
            <div v-if="form.nearby_attractions && form.nearby_attractions.length > 0" class="bg-gray-50 rounded-xl p-6">
              <h4 class="font-semibold text-gray-800 mb-4">👁️ Aperçu</h4>
              <div class="bg-white rounded-lg p-4 border border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800 mb-3">Autour de vous</h5>
                <ul class="space-y-2">
                  <li
                    v-for="(attraction, index) in form.nearby_attractions.filter(a => a && a.trim())"
                    :key="index"
                    class="flex items-start gap-2 text-gray-700"
                  >
                    <span class="text-gray-400 mt-1">•</span>
                    <span>{{ attraction }}</span>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Help Section -->
            <div class="bg-green-50 rounded-xl p-6">
              <h4 class="font-semibold text-green-900 mb-3">💡 Conseils pour les points d'intérêt</h4>
              <ul class="space-y-2 text-sm text-green-800">
                <li class="flex items-start gap-2">
                  <span>✓</span>
                  <span>Indiquez la distance : "Plage à 500m", "Centre-ville à 10 minutes à pied"</span>
                </li>
                <li class="flex items-start gap-2">
                  <span>✓</span>
                  <span>Mentionnez les commerces : "Supermarché à 200m", "Boulangerie en face"</span>
                </li>
                <li class="flex items-start gap-2">
                  <span>✓</span>
                  <span>Ajoutez les attractions : "Musée à 5 minutes", "Parc naturel à proximité"</span>
                </li>
                <li class="flex items-start gap-2">
                  <span>✓</span>
                  <span>Précisez les transports : "Arrêt de bus à 100m", "Gare à 15 minutes"</span>
                </li>
              </ul>
            </div>

            <!-- Examples -->
            <div class="bg-blue-50 rounded-xl p-6">
              <h4 class="font-semibold text-blue-900 mb-3">📝 Exemples</h4>
              <div class="space-y-1 text-sm text-blue-800">
                <p>• Plage de sable fin à 500 mètres</p>
                <p>• Centre-ville et commerces à 10 minutes à pied</p>
                <p>• Supermarché Carrefour à 200 mètres</p>
                <p>• Restaurant gastronomique "Le Gourmet" à 5 minutes</p>
                <p>• Arrêt de bus ligne 12 devant la résidence</p>
                <p>• Parc naturel régional à 2km</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab: Equipment -->
        <div v-show="currentTab === 'equipment'" class="p-8">
          <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">🛋️ Équipements & Commodités</h3>
            <p class="text-gray-600 text-sm">Sélectionnez tous les équipements disponibles dans l'appartement</p>
          </div>

          <div v-if="loadingEquipment" class="text-center py-12">
            <div class="animate-spin text-5xl mb-4">⏳</div>
            <p class="text-gray-600">Chargement des équipements...</p>
          </div>
          
          <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            <label
              v-for="equipment in availableEquipment"
              :key="equipment.id"
              :class="[
                'flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all',
                equipmentIds.includes(equipment.id)
                  ? 'border-blue-500 bg-blue-50 shadow-md'
                  : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50'
              ]"
            >
              <input
                type="checkbox"
                :value="equipment.id"
                v-model="equipmentIds"
                class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500"
              />
              <span class="text-sm font-medium text-gray-700">{{ equipment.name }}</span>
            </label>
          </div>
        </div>

        <!-- Tab: SEO -->
        <div v-show="currentTab === 'seo'" class="p-8">
          <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">🚀 Optimisation SEO</h3>
            <p class="text-gray-600 text-sm">Optimisez le référencement de cet appartement sur les moteurs de recherche</p>
          </div>

          <div class="space-y-6">
            <!-- Meta Title -->
            <div>
              <label class="input-label">
                🏷️ Titre SEO (Meta Title)
                <span class="text-gray-500 font-normal ml-2">{{ form.meta_title?.length || 0 }}/70</span>
              </label>
              <input
                v-model="form.meta_title"
                type="text"
                maxlength="70"
                placeholder="Ex: Studio Cosy Centre-Ville - Location Courte Durée"
                class="input"
                :class="{ 'border-yellow-400': form.meta_title?.length > 60 }"
              />
              <p class="text-xs text-gray-500 mt-1">
                💡 Idéal: 50-60 caractères • Inclure le type d'appartement et la localisation
              </p>
            </div>

            <!-- Meta Description -->
            <div>
              <label class="input-label">
                📝 Description SEO (Meta Description)
                <span class="text-gray-500 font-normal ml-2">{{ form.meta_description?.length || 0 }}/160</span>
              </label>
              <textarea
                v-model="form.meta_description"
                rows="3"
                maxlength="160"
                placeholder="Ex: Découvrez notre studio moderne de 25m² en plein centre-ville. Équipé, confortable et idéalement situé pour votre séjour."
                class="input"
                :class="{ 'border-yellow-400': form.meta_description?.length > 150 }"
              ></textarea>
              <p class="text-xs text-gray-500 mt-1">
                💡 Idéal: 120-155 caractères • Résumé attractif avec appel à l'action
              </p>
            </div>

            <!-- Meta Keywords -->
            <div>
              <label class="input-label">
                🔑 Mots-clés SEO
              </label>
              <input
                v-model="form.meta_keywords"
                type="text"
                placeholder="Ex: studio, location courte durée, centre-ville, appartement meublé"
                class="input"
              />
              <p class="text-xs text-gray-500 mt-1">
                💡 Séparez les mots-clés par des virgules • 5-10 mots-clés pertinents
              </p>
            </div>

            <!-- OG Image -->
            <div>
              <label class="input-label">
                🖼️ Image Open Graph (Réseaux sociaux)
              </label>
              <input
                v-model="form.og_image"
                type="text"
                placeholder="URL de l'image (laissez vide pour utiliser l'image principale)"
                class="input"
              />
              <p class="text-xs text-gray-500 mt-1">
                💡 Image affichée lors du partage sur Facebook, Twitter, etc. • Recommandé: 1200x630px
              </p>
            </div>

            <!-- SEO Preview -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h4 class="font-semibold text-gray-800 mb-4">👁️ Aperçu Google</h4>
              <div class="bg-white rounded-lg p-4 border border-gray-200">
                <div class="text-blue-600 text-lg mb-1">
                  {{ form.meta_title || form.name || 'Titre de l\'appartement' }}
                </div>
                <div class="text-green-700 text-sm mb-2">
                  https://votresite.com/appartements/{{ form.slug || 'slug-appartement' }}
                </div>
                <div class="text-gray-600 text-sm">
                  {{ form.meta_description || form.description?.substring(0, 160) || 'Description de l\'appartement...' }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Error/Success Messages -->
        <div v-if="errorMessage || successMessage" class="px-8 pb-4">
          <div v-if="errorMessage" class="p-4 bg-red-50 border-2 border-red-200 rounded-xl flex items-start gap-3">
            <span class="text-2xl">❌</span>
            <div>
              <p class="font-semibold text-red-800">Erreur</p>
              <p class="text-red-700 text-sm">{{ errorMessage }}</p>
            </div>
          </div>
          <div v-if="successMessage" class="p-4 bg-green-50 border-2 border-green-200 rounded-xl flex items-start gap-3">
            <span class="text-2xl">✅</span>
            <div>
              <p class="font-semibold text-green-800">Succès</p>
              <p class="text-green-700 text-sm">{{ successMessage }}</p>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="sticky bottom-0 bg-white border-t border-gray-100 px-8 py-4 flex justify-between items-center">
          <button
            type="button"
            @click="$emit('close')"
            class="btn btn-outline"
          >
            Annuler
          </button>
          <button
            type="submit"
            :disabled="saving"
            class="btn btn-primary btn-lg"
          >
            <svg v-if="saving" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            {{ saving ? 'Enregistrement...' : (isEdit ? 'Mettre à jour' : 'Créer l\'appartement') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed, watch } from 'vue'
import apiClient from '../api/axios'

const props = defineProps({
  apartment: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'saved'])

// Tabs
const tabs = [
  { id: 'basic', label: 'Informations' },
  { id: 'images', label: 'Images' },
  { id: 'video', label: 'Vidéo' },
  { id: 'location', label: 'Localisation' },
  { id: 'equipment', label: 'Équipements' },
  { id: 'seo', label: 'SEO' }
]

const currentTab = ref('basic')
const isEdit = ref(!!props.apartment)
const saving = ref(false)
const loadingEquipment = ref(false)
const dragOver = ref(false)
const draggingImageIndex = ref(null)
const errorMessage = ref('')
const successMessage = ref('')
const errors = ref({})

// Helper to get full image URL
const getImageUrl = (url) => {
  if (!url) {
    console.warn('⚠️ getImageUrl: URL vide ou null')
    return '/images/placeholder-apartment.svg' // Fallback image
  }
  
  // Data URIs (for local previews before upload)
  if (url.startsWith('data:')) {
    return url
  }
  
  // If URL is already absolute
  if (url.startsWith('http')) {
    return url
  }
  
  // For relative URLs starting with /storage, build absolute URL to backend
  // IMPORTANT: Ne pas utiliser axios baseURL car il ajoute /api/
  const backendURL = 'http://localhost:8000'
  const fullUrl = `${backendURL}${url}`
  
  console.log('🖼️ Image URL:', {
    original: url,
    computed: fullUrl
  })
  
  return fullUrl
}

const form = reactive({
  name: '',
  type: '',
  capacity: 1,
  surface_area: 0,
  floor: 0,
  beds_king_size: 0,
  beds_single: 0,
  description: '',
  video_url: '',
  nearby_attractions: [],
  price_per_night: 0,
  tax_per_stay: 0,
  is_available: true,
  is_featured: false,
  // SEO fields
  meta_title: '',
  meta_description: '',
  meta_keywords: '',
  og_image: '',
  structured_data: ''
})

// Use ref for equipment_ids to avoid reactivity issues with arrays
const equipmentIds = ref([])

const availableEquipment = ref([])
const images = ref([])
const selectedImages = ref([]) // Pour la sélection multiple
const fileInput = ref(null)

// Methods
const fetchEquipment = async () => {
  try {
    loadingEquipment.value = true
    const response = await apiClient.get('/equipment')
    availableEquipment.value = response.data.data
  } catch (error) {
    console.error('Error fetching equipment:', error)
  } finally {
    loadingEquipment.value = false
  }
}

const loadApartmentData = () => {
  if (props.apartment) {
    // Map camelCase API response to snake_case form fields
    const fieldMapping = {
      'pricePerNight': 'price_per_night',
      'taxPerStay': 'tax_per_stay',
      'surface': 'surface_area',
      'videoUrl': 'video_url',
      'nearbyAttractions': 'nearby_attractions',
      'metaTitle': 'meta_title',
      'metaDescription': 'meta_description',
      'metaKeywords': 'meta_keywords',
      'ogImage': 'og_image',
      'structuredData': 'structured_data',
      'available': 'is_available',
      'featured': 'is_featured'
    }
    
    // Copy direct fields
    Object.keys(form).forEach(key => {
      if (props.apartment[key] !== undefined) {
        form[key] = props.apartment[key]
      }
    })
    
    // Map camelCase fields to snake_case
    Object.entries(fieldMapping).forEach(([camelKey, snakeKey]) => {
      if (props.apartment[camelKey] !== undefined) {
        form[snakeKey] = props.apartment[camelKey]
      }
    })
    
    // Ensure nearby_attractions is always an array
    if (!Array.isArray(form.nearby_attractions)) {
      form.nearby_attractions = []
    }
    
    // Load equipment IDs - handle both array of objects and array of IDs
    if (props.apartment.equipment && Array.isArray(props.apartment.equipment)) {
      // If equipment is an array of objects with id property
      if (props.apartment.equipment.length > 0 && typeof props.apartment.equipment[0] === 'object') {
        equipmentIds.value = props.apartment.equipment
          .map(e => e.id)
          .filter(id => id !== undefined && id !== null)
          .map(id => parseInt(id, 10))
          .filter(id => !isNaN(id) && id > 0)
      } 
      // If equipment is already an array of IDs
      else {
        equipmentIds.value = props.apartment.equipment
          .filter(id => id !== undefined && id !== null)
          .map(id => parseInt(id, 10))
          .filter(id => !isNaN(id) && id > 0)
      }
      console.log('Loaded equipment IDs:', equipmentIds.value)
    } else {
      equipmentIds.value = []
    }
    
    if (props.apartment.images) {
      images.value = [...props.apartment.images]
    }
  }
}

const handleFileSelect = (event) => {
  const files = Array.from(event.target.files)
  processFiles(files)
}

const handleDrop = (event) => {
  dragOver.value = false
  const files = Array.from(event.dataTransfer.files)
  processFiles(files)
}

const processFiles = async (files) => {
  for (const file of files) {
    if (!file.type.match(/^image\/(jpeg|png|webp)$/)) {
      alert(`${file.name} n'est pas un format d'image valide`)
      continue
    }
    
    if (file.size > 10 * 1024 * 1024) {
      alert(`${file.name} dépasse la limite de 10MB`)
      continue
    }
    
    const reader = new FileReader()
    reader.onload = (e) => {
      const imageData = {
        file,
        preview: e.target.result,
        alt_text: '',
        display_order: images.value.length,
        is_primary: images.value.length === 0,
        uploading: false
      }
      images.value.push(imageData)
    }
    reader.readAsDataURL(file)
  }
}

const handleDragStart = (index) => {
  draggingImageIndex.value = index
}

const handleImageDrop = (dropIndex) => {
  if (draggingImageIndex.value === null) return
  
  const draggedImage = images.value[draggingImageIndex.value]
  images.value.splice(draggingImageIndex.value, 1)
  images.value.splice(dropIndex, 0, draggedImage)
  
  images.value.forEach((img, idx) => {
    img.display_order = idx
  })
  
  draggingImageIndex.value = null
}

const setPrimaryImage = (index) => {
  images.value.forEach((img, idx) => {
    img.is_primary = idx === index
  })
}

const editImageAlt = (index) => {
  const newAlt = prompt('Texte alternatif pour l\'image (SEO):', images.value[index].alt_text || '')
  if (newAlt !== null) {
    images.value[index].alt_text = newAlt
  }
}

const removeImage = async (index) => {
  const image = images.value[index]
  
  if (!confirm('Supprimer cette image ?')) return
  
  if (image.id && isEdit.value) {
    try {
      await apiClient.delete(`/apartments/images/${image.id}`)
    } catch (error) {
      console.error('Error deleting image:', error)
      alert('Échec de la suppression de l\'image')
      return
    }
  }
  
  images.value.splice(index, 1)
  
  // Retirer de la sélection si elle était sélectionnée
  const selectionIndex = selectedImages.value.indexOf(index)
  if (selectionIndex > -1) {
    selectedImages.value.splice(selectionIndex, 1)
  }
  
  // Ajuster les indices de sélection
  selectedImages.value = selectedImages.value.map(i => i > index ? i - 1 : i)
  
  if (image.is_primary && images.value.length > 0) {
    images.value[0].is_primary = true
  }
}

// Gestion de la sélection multiple
const toggleImageSelection = (index) => {
  const selectionIndex = selectedImages.value.indexOf(index)
  if (selectionIndex > -1) {
    selectedImages.value.splice(selectionIndex, 1)
  } else {
    selectedImages.value.push(index)
  }
}

const toggleSelectAll = () => {
  if (selectedImages.value.length === images.value.length) {
    selectedImages.value = []
  } else {
    selectedImages.value = images.value.map((_, index) => index)
  }
}

const deleteSelectedImages = async () => {
  if (selectedImages.value.length === 0) return
  
  const count = selectedImages.value.length
  if (!confirm(`Supprimer ${count} image(s) sélectionnée(s) ?\n\nCette action est irréversible.`)) {
    return
  }
  
  // Trier les indices en ordre décroissant pour éviter les problèmes d'index
  const sortedIndices = [...selectedImages.value].sort((a, b) => b - a)
  
  let deletedCount = 0
  let failedCount = 0
  
  for (const index of sortedIndices) {
    const image = images.value[index]
    
    // Si l'image existe en BDD, la supprimer via l'API
    if (image.id && isEdit.value) {
      try {
        await apiClient.delete(`/apartments/images/${image.id}`)
        deletedCount++
      } catch (error) {
        console.error('Error deleting image:', error)
        failedCount++
        continue
      }
    } else {
      deletedCount++
    }
    
    // Supprimer de la liste locale
    images.value.splice(index, 1)
  }
  
  // Réinitialiser la sélection
  selectedImages.value = []
  
  // Vérifier si on doit définir une nouvelle image principale
  if (images.value.length > 0 && !images.value.some(img => img.is_primary)) {
    images.value[0].is_primary = true
  }
  
  // Afficher un message de résultat
  if (failedCount > 0) {
    alert(`${deletedCount} image(s) supprimée(s)\n${failedCount} échec(s)`)
  } else {
    successMessage.value = `${deletedCount} image(s) supprimée(s) avec succès`
    setTimeout(() => {
      successMessage.value = ''
    }, 3000)
  }
}

const uploadImages = async (apartmentId) => {
  const newImages = images.value.filter(img => img.file)
  
  for (const image of newImages) {
    try {
      image.uploading = true
      
      const formData = new FormData()
      formData.append('image', image.file)
      formData.append('alt_text', image.alt_text || '')
      formData.append('display_order', image.display_order)
      formData.append('is_primary', image.is_primary ? '1' : '0')
      
      await apiClient.post(`/apartments/${apartmentId}/images`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
      
      image.uploading = false
    } catch (error) {
      console.error('Error uploading image:', error)
      image.uploading = false
    }
  }
}

const updateExistingImages = async (apartmentId) => {
  const existingImages = images.value.filter(img => img.id)
  
  for (const image of existingImages) {
    try {
      await apiClient.put(`/apartments/images/${image.id}`, {
        alt_text: image.alt_text,
        display_order: image.display_order,
        is_primary: image.is_primary
      })
    } catch (error) {
      console.error('Error updating image:', error)
    }
  }
}

const handleSubmit = async () => {
  try {
    saving.value = true
    errorMessage.value = ''
    successMessage.value = ''
    errors.value = {}
    
    // Ensure numeric fields have valid values
    // Filter out undefined values from equipment_ids and ensure it's a clean array of integers
    const cleanEquipmentIds = Array.isArray(equipmentIds.value) 
      ? equipmentIds.value
          .filter(id => id !== undefined && id !== null && id !== '')
          .map(id => parseInt(id, 10))
          .filter(id => !isNaN(id) && id > 0)
      : []
    
    const dataToSend = {
      ...form,
      floor: parseInt(form.floor) || 0,
      beds_king_size: parseInt(form.beds_king_size) || 0,
      beds_single: parseInt(form.beds_single) || 0,
      capacity: parseInt(form.capacity) || 1,
      surface_area: parseFloat(form.surface_area) || 0,
      price_per_night: parseFloat(form.price_per_night) || 0,
      tax_per_stay: parseFloat(form.tax_per_stay) || 0,
      equipment_ids: cleanEquipmentIds
    }
    
    const endpoint = isEdit.value
      ? `/apartments/${props.apartment.id}`
      : '/apartments'
    
    const method = isEdit.value ? 'put' : 'post'
    
    console.log('Sending apartment data:', dataToSend)
    console.log('Equipment IDs being sent:', dataToSend.equipment_ids)
    console.log('Equipment IDs type:', Array.isArray(dataToSend.equipment_ids) ? 'array' : typeof dataToSend.equipment_ids)
    const response = await apiClient[method](endpoint, dataToSend)
    console.log('API response:', response)
    
    // Extract apartment ID from Laravel API response structure
    // Response structure: { data: { success: true, data: {...apartment...}, meta: {...} } }
    const apartmentData = response.data?.data || response.data
    const apartmentId = apartmentData?.id || (isEdit.value ? props.apartment.id : null)
    
    console.log('Apartment ID for image upload:', apartmentId)
    
    if (!apartmentId) {
      throw new Error('Could not determine apartment ID for image upload')
    }
    
    await uploadImages(apartmentId)
    
    if (isEdit.value) {
      await updateExistingImages(apartmentId)
    }
    
    // Reload images from API to get the uploaded images with their IDs
    try {
      const imagesResponse = await apiClient.get(`/apartments/${apartmentId}/images`)
      if (imagesResponse.data?.data) {
        // Clear preview URLs as they are no longer valid after reload
        images.value = imagesResponse.data.data.map(img => ({
          ...img,
          preview: null // Clear blob URLs
        }))
        console.log('Reloaded images:', images.value)
      }
    } catch (imageError) {
      console.error('Error reloading images:', imageError)
    }
    
    successMessage.value = `Appartement ${isEdit.value ? 'mis à jour' : 'créé'} avec succès !`
    
    setTimeout(() => {
      emit('saved', apartmentData)
      emit('close')
    }, 1500)
    
  } catch (error) {
    console.error('Error saving apartment:', error)
    console.error('Error response:', error.response?.data)
    
    if (error.response?.data?.error?.details) {
      errors.value = error.response.data.error.details
      errorMessage.value = 'Veuillez corriger les erreurs de validation'
    } else if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
      errorMessage.value = 'Veuillez corriger les erreurs de validation'
    } else {
      errorMessage.value = error.response?.data?.error?.message || error.response?.data?.message || 'Échec de l\'enregistrement'
    }
  } finally {
    saving.value = false
  }
}

// Video helper methods
const isYouTubeUrl = (url) => {
  if (!url) return false
  return url.includes('youtube.com') || url.includes('youtu.be')
}

const isVimeoUrl = (url) => {
  if (!url) return false
  return url.includes('vimeo.com')
}

const isDirectVideoUrl = (url) => {
  if (!url) return false
  return /\.(mp4|webm|ogg)$/i.test(url)
}

const getYouTubeEmbedUrl = (url) => {
  if (!url) return ''
  const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/)
  const videoId = match ? match[1] : ''
  return videoId ? `https://www.youtube.com/embed/${videoId}` : ''
}

const getVimeoEmbedUrl = (url) => {
  if (!url) return ''
  const match = url.match(/vimeo\.com\/(\d+)/)
  const videoId = match ? match[1] : ''
  return videoId ? `https://player.vimeo.com/video/${videoId}` : ''
}

// Nearby attractions methods
const addAttraction = () => {
  form.nearby_attractions.push('')
}

const removeAttraction = (index) => {
  form.nearby_attractions.splice(index, 1)
}

onMounted(() => {
  fetchEquipment()
  loadApartmentData()
})

// Watch equipment_ids to ensure it stays as an array
watch(equipmentIds, (newVal) => {
  console.log('Equipment IDs changed:', newVal, 'Type:', Array.isArray(newVal) ? 'array' : typeof newVal)
  // If it's not an array, convert it back
  if (!Array.isArray(newVal)) {
    console.warn('⚠️ equipment_ids is not an array, converting...')
    equipmentIds.value = Object.values(newVal).filter(v => v !== undefined && v !== null)
  }
}, { deep: true })
</script>
