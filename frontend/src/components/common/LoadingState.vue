<template>
  <div class="flex flex-col items-center justify-center py-12 px-4">
    <!-- Spinner -->
    <div class="relative mb-4">
      <div
        class="w-12 h-12 border-4 border-gray-200 border-t-deep-slate-blue rounded-full animate-spin"
      ></div>
    </div>

    <!-- Loading text -->
    <p v-if="message" class="text-gray-600 text-sm">
      {{ message }}
    </p>
  </div>
</template>

<script setup lang="ts">
interface Props {
  message?: string
}

withDefaults(defineProps<Props>(), {
  message: 'Loading...'
})
</script>

<style scoped>
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}
</style>
