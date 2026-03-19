<template>
  <div class="flex flex-wrap items-center justify-center gap-6 md:gap-8 py-6">
    <!-- Capacity -->
    <div class="flex items-center gap-3">
      <div class="w-14 h-14 bg-[#b8a088] rounded-lg flex items-center justify-center flex-shrink-0">
        <svg
          class="w-7 h-7 text-white"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          stroke-width="1.5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
          />
        </svg>
      </div>
      <span class="text-base text-gray-800 font-medium">
        {{ capacity }} personnes
      </span>
    </div>

    <!-- Surface -->
    <div class="flex items-center gap-3">
      <div class="w-14 h-14 bg-[#b8a088] rounded-lg flex items-center justify-center flex-shrink-0">
        <svg
          class="w-7 h-7 text-white"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          stroke-width="1.5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"
          />
        </svg>
      </div>
      <span class="text-base text-gray-800 font-medium">{{ surface }}m²</span>
    </div>

    <!-- Beds -->
    <div class="flex items-center gap-3">
      <div class="w-14 h-14 bg-[#b8a088] rounded-lg flex items-center justify-center flex-shrink-0">
        <svg
          class="w-7 h-7 text-white"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          stroke-width="1.5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
          />
        </svg>
      </div>
      <span class="text-base text-gray-800 font-medium">{{ bedsText }}</span>
    </div>

    <!-- Floor -->
    <div class="flex items-center gap-3">
      <div class="w-14 h-14 bg-[#b8a088] rounded-lg flex items-center justify-center flex-shrink-0">
        <svg
          class="w-7 h-7 text-white"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          stroke-width="1.5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819"
          />
        </svg>
      </div>
      <span class="text-base text-gray-800 font-medium">{{ floor }}</span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  capacity: number
  surface: number
  beds: Array<{ type: string; count: number }>
  floor: string
}

const props = defineProps<Props>()

const bedsText = computed(() => {
  if (props.beds.length === 0) return 'Aucun lit'
  if (props.beds.length === 1) {
    const bed = props.beds[0]
    if (!bed) return 'Aucun lit'
    return `${bed.count} ${bed.type}`
  }
  return props.beds.map((bed) => `${bed.count} ${bed.type}`).join(', ')
})
</script>
