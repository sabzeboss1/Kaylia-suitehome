<template>
  <section class="bg-white py-16 md:py-20">
    <div class="container mx-auto px-6 md:px-20 max-w-4xl">
      <div class="text-center mb-12">
        <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-900 mb-4">
          Avez vous des <span class="text-primary-blue italic">questions ?</span>
        </h2>
        <p class="text-base text-gray-600 font-light">
          Toutes les réponses à vos questions sur votre réservation sont ici. Besoin d'aide supplémentaire ? 
          <router-link to="/contact" class="text-primary-blue hover:underline">Contactez-nous</router-link>
        </p>
      </div>

      <!-- FAQ Accordion -->
      <div class="space-y-4">
        <div 
          v-for="(faq, index) in faqs" 
          :key="index"
          class="faq-item border-b border-gray-300"
        >
          <button 
            @click="toggleFAQ(index)"
            class="w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition"
          >
            <span class="text-lg text-gray-900 font-normal pr-8">{{ faq.question }}</span>
            <div class="flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
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
          <Transition name="expand">
            <div v-if="openIndex === index" class="overflow-hidden">
              <div class="pb-5 pr-12 text-gray-600 leading-relaxed">
                {{ faq.answer }}
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const openIndex = ref<number | null>(null)

const faqs = ref([
  {
    question: "Comment accéder à mon appartement le jour de mon arrivée ?",
    answer: "Vous recevrez toutes les instructions d'accès par email 24h avant votre arrivée. Un code d'accès personnel vous sera fourni pour entrer dans la résidence et votre appartement. Notre équipe reste disponible 24/7 pour vous assister."
  },
  {
    question: "Le ménage est-il fait tous les jours ?",
    answer: "Le ménage est effectué avant votre arrivée et après votre départ. Pour les séjours de plus de 7 jours, un service de ménage hebdomadaire est inclus. Un service quotidien peut être ajouté sur demande moyennant un supplément."
  },
  {
    question: "Y a-t-il une bagagerie dans la résidence ?",
    answer: "Oui, nous disposons d'une bagagerie sécurisée gratuite. Vous pouvez déposer vos bagages avant le check-in ou après le check-out. Contactez notre conciergerie pour organiser le dépôt de vos bagages."
  },
  {
    question: "Peut-on arriver avant 15h ?",
    answer: "Le check-in standard est à partir de 15h. Un early check-in peut être possible selon la disponibilité de l'appartement, moyennant un supplément. Nous vous recommandons de nous contacter à l'avance pour vérifier la disponibilité."
  },
  {
    question: "Peut-on partir après 10h ?",
    answer: "Le check-out standard est à 10h. Un late check-out peut être organisé selon la disponibilité, moyennant un supplément. Contactez-nous au moins 24h à l'avance pour faire votre demande."
  },
  {
    question: "Y-a-t-il une personne sur place 24h/24 ?",
    answer: "Oui, notre service de sécurité est présent 24h/24 et 7j/7. Notre équipe de conciergerie est également joignable à tout moment pour répondre à vos besoins et assurer votre confort durant votre séjour."
  },
  {
    question: "Est-ce que la résidence dispose de la climatisation ?",
    answer: "Oui, tous nos appartements sont équipés de la climatisation réversible pour votre confort optimal. Vous pouvez régler la température selon vos préférences dans chaque pièce."
  },
  {
    question: "Y-a-t-il un ascenseur dans l'immeuble ?",
    answer: "Oui, la résidence dispose d'un ascenseur moderne et spacieux pour faciliter l'accès à tous les étages. L'immeuble est également accessible aux personnes à mobilité réduite."
  }
])

const toggleFAQ = (index: number) => {
  openIndex.value = openIndex.value === index ? null : index
}
</script>

<style scoped>
.primary-blue {
  color: #4a7c8c;
}

.bg-primary-blue {
  background-color: #4a7c8c;
}

.expand-enter-active,
.expand-leave-active {
  transition: all 0.3s ease;
}

.expand-enter-from,
.expand-leave-to {
  opacity: 0;
  max-height: 0;
}

.expand-enter-to,
.expand-leave-from {
  opacity: 1;
  max-height: 500px;
}
</style>
