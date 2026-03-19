<template>
  <Teleport to="body">
    <!-- Overlay -->
    <Transition name="fade">
      <div 
        v-if="modelValue"
        class="fixed inset-0 z-[9998] bg-black/30"
        @click="close"
      ></div>
    </Transition>

    <!-- Calendar Modal -->
    <Transition name="scale">
      <div 
        v-if="modelValue"
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#e8dcc8] rounded-lg shadow-2xl p-6 z-[9999] w-[650px] max-w-[95vw]"
        @click.stop
      >
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <button 
            @click="previousMonth" 
            class="p-2 hover:bg-gray-100 rounded-full transition"
            aria-label="Mois précédent"
          >
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
          </button>
          
          <div class="flex gap-8">
            <div class="text-center">
              <h3 class="font-semibold text-gray-900 capitalize text-lg">{{ currentMonthName }}</h3>
            </div>
            <div class="text-center">
              <h3 class="font-semibold text-gray-900 capitalize text-lg">{{ nextMonthName }}</h3>
            </div>
          </div>
          
          <button 
            @click="nextMonth" 
            class="p-2 hover:bg-gray-100 rounded-full transition"
            aria-label="Mois suivant"
          >
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </button>
        </div>

        <!-- Two Month Grid -->
        <div class="grid grid-cols-2 gap-6">
          <!-- Current Month -->
          <div>
            <div class="grid grid-cols-7 gap-1 mb-2">
              <div 
                v-for="day in weekDays" 
                :key="day" 
                class="text-center text-xs font-semibold text-gray-800 lowercase"
              >
                {{ day }}
              </div>
            </div>
            <div class="grid grid-cols-7 gap-1">
              <button
                v-for="(day, index) in currentMonthDays" 
                :key="`current-${index}`"
                @click="selectDate(day)"
                :disabled="!day"
                :class="getDayClasses(day, false)"
                class="aspect-square flex items-center justify-center text-sm rounded-lg transition-all"
              >
                {{ day || '' }}
              </button>
            </div>
          </div>

          <!-- Next Month -->
          <div>
            <div class="grid grid-cols-7 gap-1 mb-2">
              <div 
                v-for="day in weekDays" 
                :key="day" 
                class="text-center text-xs font-semibold text-gray-800 lowercase"
              >
                {{ day }}
              </div>
            </div>
            <div class="grid grid-cols-7 gap-1">
              <button
                v-for="(day, index) in nextMonthDays" 
                :key="`next-${index}`"
                @click="selectDate(day, true)"
                :disabled="!day"
                :class="getDayClasses(day, true)"
                class="aspect-square flex items-center justify-center text-sm rounded-lg transition-all"
              >
                {{ day || '' }}
              </button>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 flex justify-between items-center">
          <button 
            @click="clearDates"
            class="text-gray-600 hover:text-gray-800 text-sm font-medium transition"
          >
            Effacer
          </button>
          <button 
            @click="applyDates"
            :disabled="!selectedStartDate"
            class="bg-[#2d7a8f] hover:bg-[#236270] disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-10 py-3 rounded-lg font-medium transition text-base"
          >
            Appliquer
          </button>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'

interface Props {
  modelValue: boolean
  startDate?: Date | null
  endDate?: Date | null
}

const props = withDefaults(defineProps<Props>(), {
  startDate: null,
  endDate: null
})

const emit = defineEmits<{
  'update:modelValue': [value: boolean]
  'update:dates': [start: Date | null, end: Date | null]
}>()

const currentMonth = ref(new Date())
const selectedStartDate = ref<Date | null>(props.startDate)
const selectedEndDate = ref<Date | null>(props.endDate)

const weekDays = ['lun', 'mar', 'mer', 'jeu', 'ven', 'sam', 'dim']

watch(() => props.modelValue, (newVal) => {
  if (newVal) {
    // Reset to current month when opening
    currentMonth.value = new Date()
    selectedStartDate.value = props.startDate
    selectedEndDate.value = props.endDate
  }
})

const currentMonthName = computed(() => {
  return currentMonth.value.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' })
})

const nextMonthName = computed(() => {
  const next = new Date(currentMonth.value)
  next.setMonth(next.getMonth() + 1)
  return next.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' })
})

const getDaysInMonth = (date: Date): (number | null)[] => {
  const year = date.getFullYear()
  const month = date.getMonth()
  const firstDay = new Date(year, month, 1)
  const lastDay = new Date(year, month + 1, 0)
  const daysInMonth = lastDay.getDate()
  const startingDayOfWeek = (firstDay.getDay() + 6) % 7 // Monday = 0
  
  const days: (number | null)[] = []
  
  for (let i = 0; i < startingDayOfWeek; i++) {
    days.push(null)
  }
  
  for (let i = 1; i <= daysInMonth; i++) {
    days.push(i)
  }
  
  return days
}

const currentMonthDays = computed(() => getDaysInMonth(currentMonth.value))

const nextMonthDays = computed(() => {
  const next = new Date(currentMonth.value)
  next.setMonth(next.getMonth() + 1)
  return getDaysInMonth(next)
})

const previousMonth = () => {
  const prev = new Date(currentMonth.value)
  prev.setMonth(prev.getMonth() - 1)
  currentMonth.value = prev
}

const nextMonth = () => {
  const next = new Date(currentMonth.value)
  next.setMonth(next.getMonth() + 1)
  currentMonth.value = next
}

const selectDate = (day: number | null, isNextMonth = false) => {
  if (!day) return
  
  const selectedDate = new Date(currentMonth.value)
  if (isNextMonth) {
    selectedDate.setMonth(selectedDate.getMonth() + 1)
  }
  selectedDate.setDate(day)
  selectedDate.setHours(0, 0, 0, 0)
  
  if (!selectedStartDate.value || (selectedStartDate.value && selectedEndDate.value)) {
    // Start new selection
    selectedStartDate.value = selectedDate
    selectedEndDate.value = null
  } else if (selectedDate > selectedStartDate.value) {
    // Set end date
    selectedEndDate.value = selectedDate
  } else {
    // Swap dates if end is before start
    selectedEndDate.value = selectedStartDate.value
    selectedStartDate.value = selectedDate
  }
}

const getDayClasses = (day: number | null, isNextMonth: boolean): string => {
  if (!day) return 'invisible'
  
  const date = new Date(currentMonth.value)
  if (isNextMonth) {
    date.setMonth(date.getMonth() + 1)
  }
  date.setDate(day)
  date.setHours(0, 0, 0, 0)
  
  const dateTime = date.getTime()
  const today = new Date()
  today.setHours(0, 0, 0, 0)
  const isToday = dateTime === today.getTime()
  const isPast = dateTime < today.getTime()
  
  if (!selectedStartDate.value) {
    return `hover:bg-[#5a8a9a] hover:text-white ${isPast ? 'text-gray-400 cursor-not-allowed' : 'text-gray-900 cursor-pointer font-medium'} ${isToday ? 'font-bold' : ''}`
  }
  
  const startTime = selectedStartDate.value.getTime()
  const endTime = selectedEndDate.value?.getTime()
  
  const isStart = dateTime === startTime
  const isEnd = endTime && dateTime === endTime
  const isInRange = endTime && dateTime > startTime && dateTime < endTime
  
  if (isStart || isEnd) {
    return 'bg-[#5a8a9a] text-white font-semibold cursor-pointer hover:bg-[#4a7c8c]'
  }
  
  if (isInRange) {
    return 'bg-[#5a8a9a] text-white font-medium cursor-pointer hover:bg-[#4a7c8c]'
  }
  
  return `hover:bg-[#5a8a9a] hover:text-white ${isPast ? 'text-gray-400 cursor-not-allowed' : 'text-gray-900 cursor-pointer font-medium'} ${isToday ? 'font-bold' : ''}`
}

const clearDates = () => {
  selectedStartDate.value = null
  selectedEndDate.value = null
}

const applyDates = () => {
  emit('update:dates', selectedStartDate.value, selectedEndDate.value)
  close()
}

const close = () => {
  emit('update:modelValue', false)
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.scale-enter-active,
.scale-leave-active {
  transition: all 0.2s ease;
}

.scale-enter-from,
.scale-leave-to {
  opacity: 0;
  transform: translate(-50%, -50%) scale(0.95);
}
</style>
