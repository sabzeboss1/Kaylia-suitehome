<template>
  <div class="search-box-container">
    <div class="search-box-inner">
      <!-- Zone 1 : Dates -->
      <button @click="openDatePicker" type="button" class="search-zone">
        <span class="search-zone__text">{{ dateRangeText || 'Choisir vos dates' }}</span>
        <svg class="search-zone__chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
      </button>

      <!-- Séparateur blanc -->
      <div class="search-divider"></div>

      <!-- Zone 2 : Nombre de personne -->
      <div class="search-zone">
        <select v-model="guests" class="search-zone__select">
          <option value="" disabled>Nombre de personne</option>
          <option v-for="option in guestOptions" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
        </select>
        <svg class="search-zone__chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
      </div>

      <!-- Séparateur blanc -->
      <div class="search-divider"></div>

      <!-- Zone 3 : Code promo -->
      <div class="search-zone">
        <input v-model="promoCode" type="text" placeholder="Code promo" class="search-zone__input">
        <svg class="search-zone__chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
      </div>

      <!-- Bouton Réserver -->
      <button @click="handleSearch" type="button" class="search-reserve-btn">
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
    return start + ' - ' + end
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

const handleSearch = () => {
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
/* Conteneur externe */
.search-box-container {
  max-width: 56rem;
  width: 100%;
}

/* Conteneur interne avec bordure */
.search-box-inner {
  display: flex;
  align-items: stretch;
  border: 1px solid rgba(255, 255, 255, 0.8);
  border-radius: 7px;
  overflow: hidden;
}

/* Zone de sélection commune */
.search-zone {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  padding: 16px 24px;
  background: rgba(140, 115, 85, 0.55);
  flex: 1;
  cursor: pointer;
  border: none;
  text-align: left;
  transition: background 0.2s ease;
}

.search-zone:first-of-type {
  border-radius: 7px 0 0 7px;
}

.search-zone:hover {
  background: rgba(140, 115, 85, 0.7);
}

/* Texte de la zone */
.search-zone__text {
  font-size: 0.9rem;
  font-weight: 400;
  color: rgba(255, 255, 255, 0.95);
  letter-spacing: 0.02em;
  white-space: nowrap;
}

/* Chevron */
.search-zone__chevron {
  flex-shrink: 0;
  color: rgba(255, 255, 255, 0.8);
  pointer-events: none;
}

/* Select stylé */
.search-zone__select {
  font-size: 0.9rem;
  font-weight: 400;
  color: rgba(255, 255, 255, 0.95);
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

.search-zone__select::-ms-expand {
  display: none;
}

.search-zone__select option {
  background: #5a4a3a;
  color: #fff;
}

/* Input stylé */
.search-zone__input {
  font-size: 0.9rem;
  font-weight: 400;
  color: rgba(255, 255, 255, 0.95);
  background: transparent;
  border: none;
  outline: none;
  flex: 1;
  padding: 0;
  letter-spacing: 0.02em;
}

.search-zone__input::placeholder {
  color: rgba(255, 255, 255, 0.7);
  font-weight: 400;
}

/* Séparateur blanc */
.search-divider {
  width: 1px;
  background: rgba(255, 255, 255, 0.7);
  flex-shrink: 0;
}

/* Bouton Réserver - SANS bordure */
.search-reserve-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px 36px;
  background: #0B6087;
  color: white;
  font-size: 0.95rem;
  font-weight: 500;
  letter-spacing: 0.04em;
  border: none;
  outline: none;
  cursor: pointer;
  transition: background 0.2s ease;
  flex-shrink: 0;
  white-space: nowrap;
  border-radius: 0 7px 7px 0;
}

.search-reserve-btn:hover {
  background: #094d6b;
}

.search-reserve-btn:active {
  transform: scale(0.98);
}

/* Responsive mobile */
@media (max-width: 767px) {
  .search-box-container {
    max-width: 100%;
    padding: 0 24px;
  }

  .search-box-inner {
    flex-direction: column;
    border-radius: 12px;
  }
  
  .search-divider {
    display: none;
  }
  
  .search-zone {
    padding: 14px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
  }
  
  .search-zone:first-of-type {
    border-radius: 12px 12px 0 0;
  }
  
  .search-zone:last-of-type {
    border-bottom: none;
  }
  
  .search-reserve-btn {
    padding: 14px 32px;
    font-size: 1rem;
    font-weight: 500;
    border-radius: 0 0 12px 12px;
    width: 100%;
  }
}
</style>
