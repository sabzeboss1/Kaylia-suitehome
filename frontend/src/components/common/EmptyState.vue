<template>
  <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
    <!-- Icon -->
    <div class="mb-4">
      <slot name="icon">
        <svg
          class="w-16 h-16 text-gray-300"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
          />
        </svg>
      </slot>
    </div>

    <!-- Title -->
    <h3 class="text-lg font-serif font-semibold text-gray-900 mb-2">
      {{ title }}
    </h3>

    <!-- Description -->
    <p class="text-gray-600 max-w-md mb-6">
      {{ description }}
    </p>

    <!-- Action button (optional) -->
    <slot name="action">
      <button
        v-if="actionText && actionHref"
        @click="handleAction"
        class="px-6 py-2 bg-deep-slate-blue text-white rounded-lg hover:bg-relic-blue transition-colors"
      >
        {{ actionText }}
      </button>
    </slot>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'

interface Props {
  title: string
  description: string
  actionText?: string
  actionHref?: string
}

const props = defineProps<Props>()
const router = useRouter()

const handleAction = () => {
  if (props.actionHref) {
    if (props.actionHref.startsWith('http')) {
      window.location.href = props.actionHref
    } else {
      router.push(props.actionHref)
    }
  }
}
</script>
