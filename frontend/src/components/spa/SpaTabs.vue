<template>
  <div>
    <!-- Tabs Navigation -->
    <div class="flex border-b-2 border-gray-300 mb-8">
      <button 
        @click="selectTab('rdv')"
        @keydown.enter="selectTab('rdv')"
        @keydown.space.prevent="selectTab('rdv')"
        :class="[
          'px-6 py-3 text-lg font-medium transition',
          activeTab === 'rdv' 
            ? 'text-gray-900 border-b-4 border-gray-900 -mb-0.5' 
            : 'text-gray-500 hover:text-gray-900'
        ]"
        :aria-selected="activeTab === 'rdv'"
        role="tab"
        tabindex="0"
      >
        Prendre RDV
      </button>
      <button 
        @click="selectTab('events')"
        @keydown.enter="selectTab('events')"
        @keydown.space.prevent="selectTab('events')"
        :class="[
          'px-6 py-3 text-lg font-medium transition',
          activeTab === 'events' 
            ? 'text-gray-900 border-b-4 border-gray-900 -mb-0.5' 
            : 'text-gray-500 hover:text-gray-900'
        ]"
        :aria-selected="activeTab === 'events'"
        role="tab"
        tabindex="0"
      >
        Évènements
      </button>
    </div>

    <!-- Tab Content with smooth transition -->
    <div class="relative">
      <Transition name="fade" mode="out-in">
        <div :key="activeTab" role="tabpanel">
          <slot :name="activeTab" />
        </div>
      </Transition>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'

interface Props {
  defaultTab?: 'rdv' | 'events'
}

const props = withDefaults(defineProps<Props>(), {
  defaultTab: 'rdv'
})

const emit = defineEmits<{
  'tab-change': [tab: 'rdv' | 'events']
}>()

const activeTab = ref<'rdv' | 'events'>(props.defaultTab)

const selectTab = (tab: 'rdv' | 'events') => {
  activeTab.value = tab
  emit('tab-change', tab)
}

watch(() => props.defaultTab, (newTab) => {
  activeTab.value = newTab
})
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
</style>
