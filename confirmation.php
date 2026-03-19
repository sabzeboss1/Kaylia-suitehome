<?php
$pageTitle = "Confirmation - Kaylia Suite Home";
include 'includes/header.php';
?>

<!-- Confirmation Page -->
<section class="bg-[#c9b5a0] py-12 md:py-20 min-h-[60vh]">
    <div class="container mx-auto px-6 md:px-20 max-w-4xl">
        <!-- Progress Steps -->
        <div class="flex items-center justify-start gap-4 md:gap-8 mb-12">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-sm text-gray-700">Tarif</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-sm text-gray-700">Récapitulatif</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-sm text-gray-700">Réservé</span>
            </div>
        </div>

        <!-- Confirmation Message -->
        <div class="text-center md:text-left mb-12">
            <h1 class="text-3xl md:text-4xl font-light text-gray-900 mb-8">
                Votre réservation est <span class="text-primary-blue">validée.</span>
            </h1>
            
            <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
                Merci pour votre réservation chez Kaylia Suite Home, nous sommes ravis de vous accueillir prochainement.
            </p>
            
            <p class="text-base text-gray-700">
                Si vous avez des questions, n'hésitez pas à nous contacter.
            </p>
        </div>

        <!-- Contact Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl">
            <!-- E-mail -->
            <div class="text-center md:text-left">
                <h3 class="text-xl font-semibold text-gray-900 mb-3">E-mail</h3>
                <a href="mailto:contact@kayliasuitehome.com" class="text-gray-700 hover:text-primary-blue transition">
                    contact@kayliasuitehome.com
                </a>
            </div>

            <!-- WhatsApp -->
            <div class="text-center md:text-left">
                <h3 class="text-xl font-semibold text-gray-900 mb-3">WhatsApp</h3>
                <a href="https://wa.me/237000000000" class="text-gray-700 hover:text-primary-blue transition">
                    +237 00 00 00 00
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="bg-gray-100 py-12 md:py-16 px-6 md:px-20">
    <div class="container mx-auto text-center max-w-3xl">
        <h2 class="font-serif text-3xl md:text-4xl font-light text-gray-900 mb-3">
            Inscrivez-vous à notre <span class="text-primary-blue italic">newsletter</span> et recevez nos codes promos
        </h2>
        <p class="text-base text-gray-700 font-light mb-8">
            Recevez des offres exclusives et restez informé de nos actualités.
        </p>
        
        <form class="flex flex-col sm:flex-row justify-center gap-3 mb-6">
            <input 
                type="email" 
                placeholder="Votre adresse email" 
                class="flex-1 max-w-md px-6 py-4 border-2 border-gray-300 rounded text-sm outline-none focus:border-primary-blue transition"
                required
            >
            <button 
                type="submit" 
                class="bg-primary-blue hover:bg-[#086780] text-white px-10 py-4 rounded text-sm font-medium transition whitespace-nowrap"
            >
                S'inscrire
            </button>
        </form>

        <div class="flex items-start justify-center gap-3 text-left">
            <input 
                type="checkbox" 
                id="consent-confirmation" 
                class="mt-1 w-4 h-4 flex-shrink-0 cursor-pointer"
                required
            >
            <label for="consent-confirmation" class="text-xs text-gray-700 leading-relaxed cursor-pointer">
                En cochant cette case, je consens à l'utilisation des informations fournies à des fins de marketing par e-mail.
            </label>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
