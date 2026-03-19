<template>
  <div id="app">
    <RouterView />
    <ToastNotification />
  </div>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import ToastNotification from '@/components/common/ToastNotification.vue'
</script>

<style>
/* Global styles are in main.css */
</style>
