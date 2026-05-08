<template>
  <DefaultLayout>
    <!-- Contact Section -->
    <section class="bg-[#cfc6b8] pt-[62px] md:pt-20 pb-12 md:pb-16 min-h-screen">
      <div class="container-aligned">
        <!-- Layout principal: 1236px width, gap 135px, top 152px -->
        <div class="max-w-[1236px] mx-auto pt-[152px] flex flex-col lg:flex-row gap-7 lg:gap-[135px]">
          <!-- Left Column - Contact Info: 538px width, gap 54px -->
          <div class="w-full lg:w-[538px] flex flex-col gap-[54px]">
            <!-- Titre principal: Silver Garden 64px -->
            <div class="flex flex-col gap-6">
              <h1 
                class="text-[64px] leading-[100%] text-[#1c5d78]" 
                style="font-family: 'Silver Garden', serif; font-weight: 400; letter-spacing: 0%;"
              >
                Contactez-nous
              </h1>
              <p 
                class="text-[20px] leading-[100%] text-gray-800" 
                style="font-family: 'Poppins', sans-serif; font-weight: 400;"
              >
                Vous avez des questions pour préparer votre séjour ou des idées d'amélioration ? N'hésitez pas à nous contacter. Nous serions ravis de vous renseigner et d'écouter vos suggestions.
              </p>
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-3">
              <h2 
                class="text-[32px] leading-[100%] text-[#1c5d78]" 
                style="font-family: 'Poppins', sans-serif; font-weight: 500; letter-spacing: 0%;"
              >
                Email
              </h2>
              <a 
                href="mailto:contact@kayliasuitehome.com" 
                class="text-[20px] leading-[100%] text-gray-800 hover:text-[#1c5d78] transition" 
                style="font-family: 'Poppins', sans-serif; font-weight: 400;"
              >
                contact@kayliasuitehome.com
              </a>
            </div>

            <!-- WhatsApp -->
            <div class="flex flex-col gap-3">
              <h2 
                class="text-[32px] leading-[100%] text-[#1c5d78]" 
                style="font-family: 'Poppins', sans-serif; font-weight: 500; letter-spacing: 0%;"
              >
                WhatsApp
              </h2>
              <a 
                href="https://wa.me/237658973853" 
                class="text-[20px] leading-[100%] text-gray-800 hover:text-[#1c5d78] transition" 
                style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                target="_blank"
                rel="noopener noreferrer"
              >
                +237 6 58 97 38 53
              </a>
            </div>

            <!-- Social Networks -->
            <div class="flex flex-col gap-4">
              <h2 
                class="text-[32px] leading-[100%] text-[#1c5d78]" 
                style="font-family: 'Poppins', sans-serif; font-weight: 500; letter-spacing: 0%;"
              >
                Nos réseaux sociaux
              </h2>
              <ul class="space-y-3">
                <li>
                  <a 
                    href="#" 
                    class="text-[20px] leading-[100%] text-gray-800 hover:text-[#1c5d78] transition" 
                    style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    Instagram
                  </a>
                </li>
                <li>
                  <a 
                    href="#" 
                    class="text-[20px] leading-[100%] text-gray-800 hover:text-[#1c5d78] transition" 
                    style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    TikTok
                  </a>
                </li>
                <li>
                  <a 
                    href="#" 
                    class="text-[20px] leading-[100%] text-gray-800 hover:text-[#1c5d78] transition" 
                    style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    Facebook
                  </a>
                </li>
                <li>
                  <a 
                    href="#" 
                    class="text-[20px] leading-[100%] text-gray-800 hover:text-[#1c5d78] transition" 
                    style="font-family: 'Poppins', sans-serif; font-weight: 400;"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    Youtube
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <!-- Right Column - Contact Form: 563px width, gap 28px -->
          <div class="w-full lg:w-[563px] lg:pt-20">
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
