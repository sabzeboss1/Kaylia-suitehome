<template>
  <div 
    class="flex items-center justify-center"
    :class="containerClass"
  >
    <div class="relative">
      <!-- Spinner -->
      <div 
        class="animate-spin rounded-full border-t-2 border-b-2"
        :class="[sizeClass, colorClass]"
      ></div>
      
      <!-- Optional text -->
      <p v-if="text" class="mt-4 text-center text-gray-600" :class="textSizeClass">
        {{ text }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  size?: 'sm' | 'md' | 'lg' | 'xl'
  color?: 'primary' | 'white' | 'gray'
  text?: string
  fullScreen?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  size: 'md',
  color: 'primary',
  text: '',
  fullScreen: false
})

const sizeClass = computed(() => {
  const sizes = {
    sm: 'w-6 h-6',
    md: 'w-10 h-10',
    lg: 'w-16 h-16',
    xl: 'w-24 h-24'
  }
  return sizes[props.size]
})

const colorClass = computed(() => {
  const colors = {
    primary: 'border-relic-blue',
    white: 'border-white',
    gray: 'border-gray-400'
  }
  return colors[props.color]
})

const textSizeClass = computed(() => {
  const sizes = {
    sm: 'text-xs',
    md: 'text-sm',
    lg: 'text-base',
    xl: 'text-lg'
  }
  return sizes[props.size]
})

const containerClass = computed(() => {
  return props.fullScreen 
    ? 'fixed inset-0 bg-white bg-opacity-90 z-50' 
    : 'py-8'
})
</script>

<style scoped>
/* Additional styles if needed */
</style>
