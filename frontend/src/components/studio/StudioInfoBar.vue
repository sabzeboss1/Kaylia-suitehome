<template>
  <section class="bg-white border-t border-b border-gray-200 py-5">
    <div class="max-w-7xl mx-auto px-6 md:px-8">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <!-- Left Side - Features -->
        <div class="flex flex-wrap items-center gap-4 md:gap-8">
          <!-- Capacity -->
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
              <img src="/images/equipements/Personne.ico" alt="Capacité" class="w-5 h-5 object-contain" />
            </div>
            <span class="text-sm text-gray-900 font-medium">{{ capacity }} personnes</span>
          </div>

          <!-- Surface -->
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
              <img src="/images/equipements/Maison.ico" alt="Surface" class="w-5 h-5 object-contain" />
            </div>
            <span class="text-sm text-gray-900 font-medium">{{ surface }}m²</span>
          </div>

          <!-- Bed -->
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
              <img src="/images/equipements/Group-1776.ico" alt="Lits" class="w-5 h-5 object-contain" />
            </div>
            <span class="text-sm text-gray-900 font-medium">{{ bedDescription }}</span>
          </div>

          <!-- Floor -->
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
              <img src="/images/equipements/Escalier.ico" alt="Étage" class="w-5 h-5 object-contain" />
            </div>
            <span class="text-sm text-gray-900 font-medium">{{ floor }}</span>
          </div>
        </div>

        <!-- Right Side - Price & CTA -->
        <div class="flex items-stretch overflow-hidden rounded-lg shadow-md">
          <!-- Price Badge -->
          <div class="bg-[#b39a85] text-white px-6 py-3 flex items-center">
            <p class="text-sm font-medium whitespace-nowrap">À partir de {{ price }}€</p>
          </div>
          <!-- Reserve Button -->
          <button
            @click="$emit('reserve')"
            class="bg-[#0b6087] hover:bg-[#094d6b] text-white px-8 py-3 font-medium transition whitespace-nowrap flex items-center"
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
