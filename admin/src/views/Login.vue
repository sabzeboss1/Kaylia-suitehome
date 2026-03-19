<template>
  <div class="min-h-screen flex">
    <!-- Left panel — decorative -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-navy-dark items-center justify-center overflow-hidden">
      <!-- Background pattern -->
      <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23c5a47e&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
      
      <!-- Floating gradient orbs -->
      <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-gold-500/10 rounded-full blur-3xl"></div>
      <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-gold-500/5 rounded-full blur-3xl"></div>
      
      <!-- Content -->
      <div class="relative z-10 text-center px-12">
        <div class="mb-8">
          <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 mb-6">
            <svg class="w-10 h-10 text-gold-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
          </div>
        </div>
        <h1 class="font-display text-4xl text-white font-semibold mb-3">Kaylia Suite Home</h1>
        <p class="text-navy-300 text-lg max-w-md mx-auto leading-relaxed">Administration & gestion de votre résidence hôtelière d'exception</p>
        
        <div class="mt-16 flex items-center justify-center gap-8 text-navy-400">
          <div class="text-center">
            <div class="text-2xl font-bold text-white">24/7</div>
            <div class="text-xs mt-1">Support</div>
          </div>
          <div class="w-px h-8 bg-navy-600"></div>
          <div class="text-center">
            <div class="text-2xl font-bold text-white">100%</div>
            <div class="text-xs mt-1">Sécurisé</div>
          </div>
          <div class="w-px h-8 bg-navy-600"></div>
          <div class="text-center">
            <div class="text-2xl font-bold text-white">Pro</div>
            <div class="text-xs mt-1">Interface</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right panel — login form -->
    <div class="flex-1 flex items-center justify-center px-6 py-12 bg-white">
      <div class="w-full max-w-md">
        <!-- Mobile logo -->
        <div class="lg:hidden text-center mb-10">
          <h1 class="font-display text-3xl text-navy-900 font-semibold">Kaylia Suite Home</h1>
          <p class="text-navy-400 text-sm mt-1">Administration</p>
        </div>

        <div class="mb-10">
          <h2 class="text-3xl font-bold text-navy-900 tracking-tight">Bon retour</h2>
          <p class="text-navy-400 mt-2">Connectez-vous à votre espace administrateur</p>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-5">
          <div>
            <label for="email" class="input-label">Adresse email</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
              </div>
              <input
                id="email"
                v-model="email"
                type="email"
                required
                class="input pl-11"
                placeholder="admin@kaylia.com"
              />
            </div>
          </div>

          <div>
            <label for="password" class="input-label">Mot de passe</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <input
                id="password"
                v-model="password"
                :type="showPassword ? 'text' : 'password'"
                required
                class="input pl-11 pr-11"
                placeholder="••••••••"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-navy-300 hover:text-navy-500 transition-colors"
              >
                <svg v-if="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Error message -->
          <div v-if="errorMessage" class="flex items-start gap-3 p-4 bg-red-50 border border-red-100 rounded-lg animate-fade-in">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            <p class="text-sm text-red-600">{{ errorMessage }}</p>
          </div>

          <button
            type="submit"
            :disabled="isLoading"
            class="btn btn-primary w-full btn-lg group"
          >
            <svg v-if="isLoading" class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>{{ isLoading ? 'Connexion...' : 'Se connecter' }}</span>
            <svg v-if="!isLoading" class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
          </button>
        </form>

        <p class="mt-8 text-center text-xs text-navy-300">
          © {{ new Date().getFullYear() }} Kaylia Suite Home. Tous droits réservés.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const isLoading = ref(false)
const showPassword = ref(false)

const handleLogin = async () => {
  errorMessage.value = ''
  isLoading.value = true

  const result = await authStore.login(email.value, password.value)

  isLoading.value = false

  if (result.success) {
    const redirect = route.query.redirect || '/'
    router.push(redirect)
  } else {
    errorMessage.value = result.message
  }
}
</script>
