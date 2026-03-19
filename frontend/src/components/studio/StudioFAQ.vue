<template>
  <div class="space-y-0">
    <!-- FAQ Item -->
    <div 
      v-for="(item, index) in items" 
      :key="index"
      class="faq-item border-b border-gray-300"
    >
      <button 
        @click="toggleItem(index)"
        class="faq-question w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition group"
      >
        <span class="text-base text-gray-900 font-normal pr-8">{{ item.question }}</span>
        <div class="faq-icon flex-shrink-0 w-10 h-10 bg-[#0b6087] rounded-full flex items-center justify-center text-white">
          <svg 
            class="w-5 h-5 transition-transform duration-300" 
            :class="{ 'rotate-45': openIndex === index }"
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
        </div>
      </button>
      <div 
        class="faq-answer overflow-hidden transition-all duration-300"
        :style="{ maxHeight: openIndex === index ? `${answerHeights[index]}px` : '0px' }"
      >
        <div 
          :ref="el => setAnswerRef(el, index)"
          class="pb-5 pr-12 text-gray-600 leading-relaxed text-sm"
        >
          {{ item.answer }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue'

interface FAQItem {
  question: string
  answer: string
}

interface Props {
  items: FAQItem[]
}

const props = defineProps<Props>()

const openIndex = ref<number | null>(null)
const answerHeights = ref<number[]>([])
const answerRefs = ref<(HTMLElement | null)[]>([])

const setAnswerRef = (el: any, index: number) => {
  if (el) {
    answerRefs.value[index] = el
  }
}

const toggleItem = (index: number) => {
  if (openIndex.value === index) {
    openIndex.value = null
  } else {
    openIndex.value = index
  }
}

// Calculate heights for smooth animation
onMounted(async () => {
  await nextTick()
  answerHeights.value = answerRefs.value.map(ref => ref?.scrollHeight || 0)
})
</script>

<style scoped>
.rotate-45 {
  transform: rotate(45deg);
}
</style>
