<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-lg max-w-4xl w-full mx-4 my-8 max-h-[90vh] overflow-y-auto">
      <!-- Header -->
      <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">
          {{ isEdit ? 'Edit Apartment' : 'Create Apartment' }}
        </h2>
        <button
          @click="$emit('close')"
          class="text-gray-400 hover:text-gray-600 text-2xl"
        >
          ×
        </button>
      </div>

      <!-- Form -->
      <form @submit.prevent="handleSubmit" class="p-6">
        <!-- Basic Information -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Name -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Name <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.name"
                type="text"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.name }"
              />
              <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</p>
            </div>

            <!-- Type -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Type <span class="text-red-500">*</span>
              </label>
              <select
                v-model="form.type"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.type }"
              >
                <option value="">Select type</option>
                <option value="studio">Studio</option>
                <option value="t2">T2</option>
                <option value="t3">T3</option>
              </select>
              <p v-if="errors.type" class="text-red-500 text-xs mt-1">{{ errors.type[0] }}</p>
            </div>

            <!-- Capacity -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Capacity <span class="text-red-500">*</span>
              </label>
              <input
                v-model.number="form.capacity"
                type="number"
                min="1"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.capacity }"
              />
              <p v-if="errors.capacity" class="text-red-500 text-xs mt-1">{{ errors.capacity[0] }}</p>
            </div>

            <!-- Surface Area -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Surface Area (m²) <span class="text-red-500">*</span>
              </label>
              <input
                v-model.number="form.surface_area"
                type="number"
                step="0.01"
                min="0"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.surface_area }"
              />
              <p v-if="errors.surface_area" class="text-red-500 text-xs mt-1">{{ errors.surface_area[0] }}</p>
            </div>

            <!-- Floor -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Floor <span class="text-red-500">*</span>
              </label>
              <input
                v-model.number="form.floor"
                type="number"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.floor }"
              />
              <p v-if="errors.floor" class="text-red-500 text-xs mt-1">{{ errors.floor[0] }}</p>
            </div>

            <!-- King Size Beds -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                King Size Beds
              </label>
              <input
                v-model.number="form.beds_king_size"
                type="number"
                min="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>

            <!-- Single Beds -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Single Beds
              </label>
              <input
                v-model.number="form.beds_single"
                type="number"
                min="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>

            <!-- Price per Night -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Price per Night (€) <span class="text-red-500">*</span>
              </label>
              <input
                v-model.number="form.price_per_night"
                type="number"
                step="0.01"
                min="0"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.price_per_night }"
              />
              <p v-if="errors.price_per_night" class="text-red-500 text-xs mt-1">{{ errors.price_per_night[0] }}</p>
            </div>

            <!-- Tax per Stay -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Tax per Stay (€)
              </label>
              <input
                v-model.number="form.tax_per_stay"
                type="number"
                step="0.01"
                min="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
          </div>
        </div>

        <!-- Description -->
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Description
          </label>
          <textarea
            v-model="form.description"
            rows="6"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Enter apartment description..."
          ></textarea>
          <p class="text-xs text-gray-500 mt-1">You can use basic HTML formatting</p>
        </div>

        <!-- Equipment -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Equipment & Amenities</h3>
          <div v-if="loadingEquipment" class="text-gray-600">Loading equipment...</div>
          <div v-else class="grid grid-cols-2 md:grid-cols-3 gap-3">
            <label
              v-for="equipment in availableEquipment"
              :key="equipment.id"
              class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer"
            >
              <input
                type="checkbox"
                :value="equipment.id"
                v-model="form.equipment_ids"
                class="rounded text-blue-600 focus:ring-blue-500"
              />
              <span class="text-sm text-gray-700">{{ equipment.name }}</span>
            </label>
          </div>
        </div>

        <!-- Images -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Images</h3>
          
          <!-- Image Upload -->
          <div
            @drop.prevent="handleDrop"
            @dragover.prevent="dragOver = true"
            @dragleave.prevent="dragOver = false"
            :class="[
              'border-2 border-dashed rounded-lg p-6 text-center transition-colors',
              dragOver ? 'border-blue-500 bg-blue-50' : 'border-gray-300'
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
            <div class="text-gray-600">
              <p class="mb-2">Drag and drop images here, or</p>
              <button
                type="button"
                @click="$refs.fileInput.click()"
                class="text-blue-600 hover:text-blue-700 font-medium"
              >
                Browse files
              </button>
              <p class="text-xs text-gray-500 mt-2">JPEG, PNG, WebP (max 10MB each)</p>
            </div>
          </div>

          <!-- Image Preview & Management -->
          <div v-if="images.length > 0" class="mt-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
              <div
                v-for="(image, index) in images"
                :key="image.id || index"
                draggable="true"
                @dragstart="handleDragStart(index)"
                @dragover.prevent
                @drop="handleImageDrop(index)"
                class="relative group cursor-move border-2 border-gray-200 rounded-lg overflow-hidden hover:border-blue-500 transition-colors"
              >
                <img
                  :src="image.preview || image.thumbnail_url || image.image_url"
                  :alt="image.alt_text"
                  class="w-full h-32 object-cover"
                />
                
                <!-- Primary Badge -->
                <div
                  v-if="image.is_primary"
                  class="absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded"
                >
                  Primary
                </div>

                <!-- Actions -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center gap-2">
                  <button
                    type="button"
                    @click="setPrimaryImage(index)"
                    v-if="!image.is_primary"
                    class="opacity-0 group-hover:opacity-100 bg-white text-gray-700 px-2 py-1 rounded text-xs hover:bg-gray-100"
                  >
                    Set Primary
                  </button>
                  <button
                    type="button"
                    @click="removeImage(index)"
                    class="opacity-0 group-hover:opacity-100 bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700"
                  >
                    Remove
                  </button>
                </div>

                <!-- Upload Progress -->
                <div v-if="image.uploading" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                  <div class="text-white text-sm">Uploading...</div>
                </div>
              </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Drag images to reorder. The first image will be the primary image.</p>
          </div>
        </div>

        <!-- Settings -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Settings</h3>
          <div class="space-y-3">
            <!-- Available Toggle -->
            <label class="flex items-center gap-3 cursor-pointer">
              <input
                type="checkbox"
                v-model="form.is_available"
                class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500"
              />
              <div>
                <div class="text-sm font-medium text-gray-700">Available for Booking</div>
                <div class="text-xs text-gray-500">Allow customers to book this apartment</div>
              </div>
            </label>

            <!-- Featured Toggle -->
            <label class="flex items-center gap-3 cursor-pointer">
              <input
                type="checkbox"
                v-model="form.is_featured"
                class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500"
              />
              <div>
                <div class="text-sm font-medium text-gray-700">Featured Apartment</div>
                <div class="text-xs text-gray-500">Display this apartment prominently on the website</div>
              </div>
            </label>
          </div>
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
          <p class="text-red-800 text-sm">{{ errorMessage }}</p>
        </div>

        <!-- Success Message -->
        <div v-if="successMessage" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
          <p class="text-green-800 text-sm">{{ successMessage }}</p>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
          <button
            type="button"
            @click="$emit('close')"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="saving"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ saving ? 'Saving...' : (isEdit ? 'Update Apartment' : 'Create Apartment') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue'
import apiClient from '../api/axios'

// Props
const props = defineProps({
  apartment: {
    type: Object,
    default: null
  }
})

// Emits
const emit = defineEmits(['close', 'saved'])

// State
const isEdit = ref(!!props.apartment)
const saving = ref(false)
const loadingEquipment = ref(false)
const dragOver = ref(false)
const draggingImageIndex = ref(null)
const errorMessage = ref('')
const successMessage = ref('')
const errors = ref({})

const form = reactive({
  name: '',
  type: '',
  capacity: 1,
  surface_area: 0,
  floor: 0,
  beds_king_size: 0,
  beds_single: 0,
  description: '',
  price_per_night: 0,
  tax_per_stay: 0,
  is_available: true,
  is_featured: false,
  equipment_ids: []
})

const availableEquipment = ref([])
const images = ref([])
const fileInput = ref(null)

// Methods
const fetchEquipment = async () => {
  try {
    loadingEquipment.value = true
    const response = await apiClient.get('/equipment')
    availableEquipment.value = response.data.data
    loadingEquipment.value = false
  } catch (error) {
    console.error('Error fetching equipment:', error)
    loadingEquipment.value = false
  }
}

const loadApartmentData = () => {
  if (props.apartment) {
    Object.keys(form).forEach(key => {
      if (props.apartment[key] !== undefined) {
        form[key] = props.apartment[key]
      }
    })
    
    // Load equipment IDs
    if (props.apartment.equipment) {
      form.equipment_ids = props.apartment.equipment.map(e => e.id)
    }
    
    // Load images
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
    // Validate file
    if (!file.type.match(/^image\/(jpeg|png|webp)$/)) {
      alert(`${file.name} is not a valid image format`)
      continue
    }
    
    if (file.size > 10 * 1024 * 1024) {
      alert(`${file.name} exceeds 10MB limit`)
      continue
    }
    
    // Create preview
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
  
  // Update display order
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

const removeImage = async (index) => {
  const image = images.value[index]
  
  // If it's an existing image, delete from server
  if (image.id && isEdit.value) {
    try {
      await apiClient.delete(`/api/apartments/images/${image.id}`)
    } catch (error) {
      console.error('Error deleting image:', error)
      alert('Failed to delete image from server')
      return
    }
  }
  
  images.value.splice(index, 1)
  
  // If removed image was primary, set first image as primary
  if (image.is_primary && images.value.length > 0) {
    images.value[0].is_primary = true
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
      
      await apiClient.post(`/api/apartments/${apartmentId}/images`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
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
      await apiClient.put(`/api/apartments/images/${image.id}`, {
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
    
    const endpoint = isEdit.value
      ? `/api/apartments/${props.apartment.id}`
      : '/api/apartments'
    
    const method = isEdit.value ? 'put' : 'post'
    
    const response = await apiClient[method](endpoint, form)
    
    const apartmentId = response.data.data.id
    
    // Upload new images
    await uploadImages(apartmentId)
    
    // Update existing images
    if (isEdit.value) {
      await updateExistingImages(apartmentId)
    }
    
    successMessage.value = `Apartment ${isEdit.value ? 'updated' : 'created'} successfully!`
    
    setTimeout(() => {
      emit('saved', response.data.data)
      emit('close')
    }, 1000)
    
    saving.value = false
  } catch (error) {
    console.error('Error saving apartment:', error)
    saving.value = false
    
    if (error.response?.data?.error?.details) {
      errors.value = error.response.data.error.details
      errorMessage.value = 'Please fix the validation errors'
    } else {
      errorMessage.value = error.response?.data?.error?.message || 'Failed to save apartment'
    }
  }
}

// Lifecycle
onMounted(() => {
  fetchEquipment()
  loadApartmentData()
})
</script>
