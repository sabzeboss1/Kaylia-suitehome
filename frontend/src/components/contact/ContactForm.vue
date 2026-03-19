<template>
  <form @submit="onSubmit" class="space-y-6">
    <!-- Name Field -->
    <div>
      <label for="name" class="block text-sm font-medium text-gray-900 mb-2">Nom</label>
      <input 
        v-model="name"
        type="text" 
        id="name" 
        name="name"
        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-sm text-gray-900 outline-none focus:border-[#1c5d78] focus:bg-white transition"
        :class="{ 'border-red-500': errors.name }"
      />
      <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name }}</p>
    </div>

    <!-- Email Field -->
    <div>
      <label for="email" class="block text-sm font-medium text-gray-900 mb-2">Email</label>
      <input 
        v-model="email"
        type="email" 
        id="email" 
        name="email"
        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-sm text-gray-900 outline-none focus:border-[#1c5d78] focus:bg-white transition"
        :class="{ 'border-red-500': errors.email }"
      />
      <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
    </div>

    <!-- Subject Field -->
    <div>
      <label for="subject" class="block text-sm font-medium text-gray-900 mb-2">Sujet</label>
      <select 
        v-model="subject"
        id="subject" 
        name="subject"
        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-sm text-gray-900 outline-none focus:border-[#1c5d78] focus:bg-white transition appearance-none cursor-pointer"
        :class="{ 'border-red-500': errors.subject }"
        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1em;"
      >
        <option value="" disabled>Sélectionner un sujet</option>
        <option value="reservation-appartement">Réservation Appart'hôtel</option>
        <option value="reservation-spa">Réservation SPA</option>
        <option value="tarif">Tarif</option>
        <option value="autres">Autres</option>
      </select>
      <p v-if="errors.subject" class="text-red-500 text-xs mt-1">{{ errors.subject }}</p>
    </div>

    <!-- Message Field -->
    <div>
      <label for="message" class="block text-sm font-medium text-gray-900 mb-2">Message</label>
      <textarea 
        v-model="message"
        id="message" 
        name="message"
        rows="6"
        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-sm text-gray-900 outline-none focus:border-[#1c5d78] focus:bg-white transition resize-none"
        :class="{ 'border-red-500': errors.message }"
      ></textarea>
      <p v-if="errors.message" class="text-red-500 text-xs mt-1">{{ errors.message }}</p>
    </div>

    <!-- Submit Button -->
    <button 
      type="submit"
      :disabled="isSubmitting || loading"
      class="w-full bg-[#1c5d78] hover:bg-[#154a5f] text-white py-4 rounded-lg text-base font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed"
    >
      <span v-if="loading">Envoi en cours...</span>
      <span v-else>Soumettre</span>
    </button>
  </form>
</template>

<script setup lang="ts">
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import { onMounted } from 'vue'
import { useContact } from '@/composables/useContact'
import { useRecaptcha } from '@/composables/useRecaptcha'
import { useUIStore } from '@/stores/ui'

const { sendMessage, loading } = useContact()
const { init: initRecaptcha, execute: executeRecaptcha, config: recaptchaConfig } = useRecaptcha()
const uiStore = useUIStore()

// Initialize reCAPTCHA on mount
onMounted(async () => {
  await initRecaptcha()
})

// Validation schema
const schema = yup.object({
  name: yup.string().required('Le nom est requis').min(2, 'Le nom doit contenir au moins 2 caractères'),
  email: yup.string().required('L\'email est requis').email('L\'email doit être valide'),
  subject: yup.string().required('Le sujet est requis'),
  message: yup.string().required('Le message est requis').min(10, 'Le message doit contenir au moins 10 caractères')
})

// Form setup
const { defineField, handleSubmit, errors, isSubmitting, resetForm } = useForm({
  validationSchema: schema,
  initialValues: {
    name: '',
    email: '',
    subject: '',
    message: ''
  }
})

const [name] = defineField('name')
const [email] = defineField('email')
const [subject] = defineField('subject')
const [message] = defineField('message')

// Submit handler
const onSubmit = handleSubmit(async (values) => {
  try {
    // Get reCAPTCHA token if enabled
    let recaptchaToken = null
    if (recaptchaConfig.value.enabled) {
      recaptchaToken = await executeRecaptcha('contact')
      if (!recaptchaToken) {
        uiStore.showToast('Échec de la vérification reCAPTCHA. Veuillez réessayer.', 'error')
        return
      }
    }

    // Split name into firstName and lastName
    const nameParts = values.name.trim().split(' ')
    const firstName = nameParts[0] || ''
    const lastName = nameParts.slice(1).join(' ') || firstName

    await sendMessage({
      firstName,
      lastName,
      email: values.email,
      phone: undefined,
      subject: values.subject,
      message: values.message,
      recaptcha_token: recaptchaToken
    })

    // Show success toast
    uiStore.showToast('Votre message a été envoyé avec succès !', 'success')
    
    // Reset form
    resetForm()
  } catch (error) {
    // Show error toast
    uiStore.showToast('Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.', 'error')
  }
})
</script>
