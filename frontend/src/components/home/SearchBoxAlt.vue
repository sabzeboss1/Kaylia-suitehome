<template>
  <div class="reservation-bar-wrapper">
    <div class="reservation-bar">
      <!-- Bloc 1 : Choisir vos dates -->
      <button @click="openDatePicker" type="button" class="selection-block">
        <span class="selection-text">{{ dateRangeText || 'Choisir vos dates' }}</span>
        <svg class="chevron-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
      </button>

      <!-- Séparateur vertical -->
      <div class="vertical-divider"></div>

      <!-- Bloc 2 : Nombre de personnes -->
      <div class="selection-block">
        <select v-model="guests" class="selection-input">
          <option value="" disabled>Nombre de personnes</option>
          <option v-for="option in guestOptions" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
        </select>
        <svg class="chevron-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
      </div>

      <!-- Séparateur vertical -->
      <div class="vertical-divider"></div>

      <!-- Bloc 3 : Code promo -->
      <div class="selection-block">
        <input v-model="promoCode" type="text" placeholder="Code promo" class="selection-input">
        <svg class="chevron-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
      </div>

      <!-- Bouton Réserver - SANS bordure, coins gauches droits -->
      <button @click="handleReservation" type="button" class="reserve-button">
        Réserver
      </button>
    </div>

    <DatePicker v-model="showDatePicker" :start-date="startDate" :end-date="endDate" @update:dates="handleDateUpdate" />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import DatePicker from '@/components/common/DatePicker.vue'
import { useApartments } from '@/composables/useApartments'

const router = useRouter()
const guests = ref('2')
const promoCode = ref('')
const showDatePicker = ref(false)
const startDate = ref<Date | null>(null)
const endDate = ref<Date | null>(null)
const maxCapacity = ref(6) // Valeur par défaut

const { fetchApartments, apartments } = useApartments()

const emit = defineEmits<{ 
  search: [params: { dateRange: string; guests: number; promoCode: string; checkIn: string | null; checkOut: string | null }] 
}>()

// Récupérer la capacité maximale des appartements
onMounted(async () => {
  try {
    await fetchApartments()
    if (apartments.value.length > 0) {
      maxCapacity.value = Math.max(...apartments.value.map(apt => apt.capacity))
    }
  } catch (error) {
    console.error('Erreur lors du chargement des capacités:', error)
  }
})

// Générer dynamiquement les options de nombre de personnes
const guestOptions = computed(() => {
  const options = []
  for (let i = 1; i <= maxCapacity.value; i++) {
    options.push({
      value: i.toString(),
      label: i === 1 ? '1 Adulte' : `${i} Adultes`
    })
  }
  return options
})

const dateRangeText = computed(() => {
  if (startDate.value && endDate.value) {
    const start = startDate.value.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' })
    const end = endDate.value.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' })
    return `${start} - ${end}`
  }
  return ''
})

const openDatePicker = () => { 
  showDatePicker.value = true 
}

const handleDateUpdate = (start: Date | null, end: Date | null) => { 
  startDate.value = start
  endDate.value = end
  
  if (start && end) {
    const checkIn = start.toISOString().split('T')[0]
    const checkOut = end.toISOString().split('T')[0]
    
    emit('search', { 
      dateRange: dateRangeText.value, 
      guests: parseInt(guests.value), 
      promoCode: promoCode.value,
      checkIn,
      checkOut
    })
  }
}

const handleReservation = () => {
  const checkIn = startDate.value ? startDate.value.toISOString().split('T')[0] : null
  const checkOut = endDate.value ? endDate.value.toISOString().split('T')[0] : null
  
  emit('search', { 
    dateRange: dateRangeText.value, 
    guests: parseInt(guests.value), 
    promoCode: promoCode.value,
    checkIn,
    checkOut
  })
  
  if (router.currentRoute.value.name !== 'apartments-list') {
    const query: any = { guests: guests.value }
    if (promoCode.value) query.promo = promoCode.value
    if (startDate.value) query.checkIn = startDate.value.toISOString().split('T')[0]
    if (endDate.value) query.checkOut = endDate.value.toISOString().split('T')[0]
    
    router.push({ name: 'apartments-search', query })
  }
}
</script>

<style scoped>
/* Wrapper principal */
.reservation-bar-wrapper {
  max-width: 56rem;
  width: 100%;
}

/* Barre de réservation - Bloc compact et continu */
.reservation-bar {
  display: flex;
  align-items: stretch;
  height: 60px;
  overflow: hidden;
}

/* Blocs de sélection (Gris/Brun) */
.selection-block {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 0 24px;
  background: rgba(90, 74, 58, 0.85);
  flex: 1;
  cursor: pointer;
  border: 1px solid rgba(255, 255, 255, 0.8);
  outline: none;
  text-align: left;
  transition: background 0.25s ease;
  position: relative;
}

.selection-block:hover {
  background: rgba(90, 74, 58, 0.95);
}

/* Texte des blocs */
.selection-text {
  font-size: 0.9rem;
  font-weight: 400;
  color: #ffffff;
  letter-spacing: 0.02em;
  white-space: nowrap;
}

/* Chevron (flèche vers le bas) */
.chevron-icon {
  flex-shrink: 0;
  color: rgba(255, 255, 255, 0.85);
  pointer-events: none;
}

/* Input et Select stylés */
.selection-input {
  font-size: 0.9rem;
  font-weight: 400;
  color: #ffffff;
  background: transparent;
  border: none;
  outline: none;
  cursor: pointer;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 0;
  flex: 1;
  letter-spacing: 0.02em;
}

.selection-input::-ms-expand {
  display: none;
}

.selection-input option {
  background: #5a4a3a;
  color: #ffffff;
}

.selection-input::placeholder {
  color: rgba(255, 255, 255, 0.75);
  font-weight: 400;
}

/* Séparateur vertical blanc/gris discret */
.vertical-divider {
  width: 1px;
  background: rgba(255, 255, 255, 0.3);
  flex-shrink: 0;
}

/* Bouton Réserver - ZÉRO bordure, coins gauches droits */
.reserve-button {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 40px;
  background: #0B6087;
  color: #ffffff;
  font-size: 0.95rem;
  font-weight: 500;
  letter-spacing: 0.05em;
  border: none;
  outline: none;
  cursor: pointer;
  transition: background 0.25s ease;
  flex-shrink: 0;
  white-space: nowrap;
  border-radius: 0 6px 6px 0;
  gap: 0;
  margin: 0;
}

.reserve-button:hover {
  background: #094d6b;
}

.reserve-button:active {
  transform: scale(0.98);
}

/* Responsive mobile */
@media (max-width: 767px) {
  .reservation-bar {
    flex-direction: column;
    height: auto;
    border-radius: 12px;
    overflow: hidden;
  }
  
  .vertical-divider {
    display: none;
  }
  
  .selection-block {
    padding: 16px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.25);
  }
  
  .selection-block:last-of-type {
    border-bottom: none;
  }
  
  .reserve-button {
    padding: 20px 24px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 0 0 12px 12px;
  }
}
</style>
