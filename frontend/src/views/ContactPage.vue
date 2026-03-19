<template>
  <DefaultLayout>
    <!-- Contact Section -->
    <section class="bg-[#cfc6b8] py-20 md:py-32">
      <div class="container mx-auto px-6 md:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
          <!-- Left Column - Contact Info -->
          <div class="text-gray-900">
            <h1 class="text-[48px] leading-[100%] font-normal text-[#1c5d78] mb-6" style="font-family: 'Silver Garden', serif; font-weight: 400;">
              Contactez-nous !
            </h1>
            <p class="text-[20px] leading-[100%] font-normal mb-12 text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
              Vous avez des questions pour préparer votre séjour ou des idées d'amélioration ? N'hésitez pas à nous contacter. Nous serions ravis de vous renseigner et d'écouter vos suggestions.
            </p>

            <!-- Email -->
            <div class="mb-10">
              <h2 class="text-[32px] leading-[100%] font-normal text-[#1c5d78] mb-3" style="font-family: 'Silver Garden', serif; font-weight: 400;">Email</h2>
              <a 
                href="mailto:contact@kayliasuitehome.com" 
                class="text-[20px] leading-[100%] font-normal text-gray-800 hover:text-[#1c5d78] transition" style="font-family: 'Poppins', sans-serif; font-weight: 400;"
              >
                contact@kayliasuitehome.com
              </a>
            </div>

            <!-- WhatsApp -->
            <div class="mb-10">
              <h2 class="text-[32px] leading-[100%] font-normal text-[#1c5d78] mb-3" style="font-family: 'Silver Garden', serif; font-weight: 400;">WhatsApp</h2>
              <a 
                href="https://wa.me/237658973853" 
                class="text-[20px] leading-[100%] font-normal text-gray-800 hover:text-[#1c5d78] transition" style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                target="_blank"
                rel="noopener noreferrer"
              >
                +237 6 58 97 38 53
              </a>
            </div>

            <!-- Social Networks -->
            <div>
              <h2 class="text-[32px] leading-[100%] font-normal text-[#1c5d78] mb-4" style="font-family: 'Silver Garden', serif; font-weight: 400;">Nos réseaux sociaux</h2>
              <ul class="space-y-3">
                <li>
                  <a 
                    href="#" 
                    class="text-[20px] leading-[100%] font-normal text-gray-800 hover:text-[#1c5d78] transition" style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    Instagram
                  </a>
                </li>
                <li>
                  <a 
                    href="#" 
                    class="text-[20px] leading-[100%] font-normal text-gray-800 hover:text-[#1c5d78] transition" style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    TikTok
                  </a>
                </li>
                <li>
                  <a 
                    href="#" 
                    class="text-[20px] leading-[100%] font-normal text-gray-800 hover:text-[#1c5d78] transition" style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    Facebook
                  </a>
                </li>
                <li>
                  <a 
                    href="#" 
                    class="text-[20px] leading-[100%] font-normal text-gray-800 hover:text-[#1c5d78] transition" style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    Youtube
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <!-- Right Column - Contact Form -->
          <div>
            <ContactForm />
          </div>
        </div>
      </div>
    </section>
  </DefaultLayout>
</template>

<script setup lang="ts">
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import ContactForm from '@/components/contact/ContactForm.vue'
</script>
