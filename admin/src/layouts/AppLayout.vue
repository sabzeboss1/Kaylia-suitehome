<template>
  <div class="min-h-screen bg-surface-50">
    <!-- Sidebar -->
    <Sidebar :collapsed="sidebarCollapsed" @toggle="toggleSidebar" />
    
    <!-- Main content area -->
    <div 
      class="transition-all duration-300 ease-in-out"
      :class="sidebarCollapsed ? 'ml-[72px]' : 'ml-64'"
    >
      <!-- Header -->
      <Header :sidebar-collapsed="sidebarCollapsed" @toggle-sidebar="toggleSidebar" />
      
      <!-- Page content -->
      <main class="pt-16 min-h-screen">
        <div class="p-6 lg:p-8">
          <router-view />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Header from '../components/Header.vue'
import Sidebar from '../components/Sidebar.vue'

const sidebarCollapsed = ref(false)

const toggleSidebar = () => {
  sidebarCollapsed.value = !sidebarCollapsed.value
}
</script>
