<template>
  <section class="bg-white border-t border-b border-gray-200 py-5">
    <div class="container mx-auto px-6 md:px-20">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <!-- Left Side - Features -->
        <div class="flex flex-wrap items-center gap-4 md:gap-8">
          <!-- Capacity -->
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
              </svg>
            </div>
            <span class="text-sm text-gray-900 font-medium">{{ capacity }} personnes</span>
          </div>

          <!-- Surface -->
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
              </svg>
            </div>
            <span class="text-sm text-gray-900 font-medium">{{ surface }}m²</span>
          </div>

          <!-- Bed -->
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
              </svg>
            </div>
            <span class="text-sm text-gray-900 font-medium">{{ bedDescription }}</span>
          </div>

          <!-- Floor -->
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
              </svg>
            </div>
            <span class="text-sm text-gray-900 font-medium">{{ floor }}</span>
          </div>
        </div>

        <!-- Right Side - Price & CTA -->
        <div class="flex items-center gap-3">
          <!-- Price Badge -->
          <div class="bg-[#b39a85] text-white px-6 py-3 rounded-lg">
            <p class="text-sm font-medium whitespace-nowrap">À partir de {{ price }}€</p>
          </div>
          <!-- Reserve Button -->
          <button
            @click="$emit('reserve')"
            class="bg-[#0b6087] hover:bg-[#094d6b] text-white px-8 py-3 rounded-lg font-medium transition shadow-md whitespace-nowrap"
          >
            Réserver
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
interface Props {
  capacity: number
  surface: number
  bedDescription: string
  floor: string
  price: number
}

defineProps<Props>()

defineEmits<{
  'reserve': []
}>()
</script>
