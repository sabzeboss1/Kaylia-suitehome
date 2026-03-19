<template>
  <div class="flex items-center justify-center gap-8 md:gap-16 py-6">
    <div
      v-for="(step, index) in steps"
      :key="index"
      class="flex flex-col items-center gap-3 cursor-pointer group transition-opacity hover:opacity-80"
      :class="{ 'opacity-50': currentStep < index + 1 }"
    >
      <!-- Icon -->
      <div class="w-12 h-12 flex items-center justify-center">
        <component
          :is="step.icon"
          class="w-8 h-8 text-gray-700 transition-transform group-hover:scale-110"
        />
      </div>
      <!-- Label -->
      <span class="text-sm font-medium text-gray-800">
        {{ step.label }}
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { h } from 'vue'

interface Step {
  label: string
  icon: any
}

interface Props {
  currentStep: 1 | 2 | 3
}

defineProps<Props>()

// Simple SVG icons as components
const TagIcon = () => h('svg', {
  fill: 'none',
  stroke: 'currentColor',
  viewBox: '0 0 24 24',
  xmlns: 'http://www.w3.org/2000/svg'
}, [
  h('path', {
    'stroke-linecap': 'round',
    'stroke-linejoin': 'round',
    'stroke-width': '1.5',
    d: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'
  })
])

const DocumentIcon = () => h('svg', {
  fill: 'none',
  stroke: 'currentColor',
  viewBox: '0 0 24 24',
  xmlns: 'http://www.w3.org/2000/svg'
}, [
  h('path', {
    'stroke-linecap': 'round',
    'stroke-linejoin': 'round',
    'stroke-width': '1.5',
    d: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
  })
])

const CheckIcon = () => h('svg', {
  fill: 'none',
  stroke: 'currentColor',
  viewBox: '0 0 24 24',
  xmlns: 'http://www.w3.org/2000/svg'
}, [
  h('path', {
    'stroke-linecap': 'round',
    'stroke-linejoin': 'round',
    'stroke-width': '1.5',
    d: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
  })
])

const steps: Step[] = [
  {
    label: 'Tarif',
    icon: TagIcon
  },
  {
    label: 'Récapitulatif',
    icon: DocumentIcon
  },
  {
    label: 'Réservé',
    icon: CheckIcon
  }
]
</script>
