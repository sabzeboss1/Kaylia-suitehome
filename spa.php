<?php
$pageTitle = "Le SPA - Kaylia Suite Home";
include 'includes/header.php';
?>

<!-- SPA Hero Section -->
<section class="bg-[#c9b5a0] py-8 md:py-12">
    <div class="container mx-auto px-6 md:px-20">
        <!-- Title and Rating -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="font-serif text-3xl md:text-4xl font-light text-gray-900 mb-2">
                    KAYLIA SUITE HOME - Le SPA
                </h1>
                <div class="flex items-center gap-2">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <span class="text-gray-900 font-medium">4.5 (17 avis)</span>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-3 mt-4 md:mt-0">
                <button class="bg-primary-blue hover:bg-[#086780] text-white px-6 py-2.5 rounded text-sm font-medium transition">
                    Évènements
                </button>
                <button class="bg-white hover:bg-gray-100 text-gray-900 border-2 border-gray-900 px-6 py-2.5 rounded text-sm font-medium transition">
                    Prendre RDV
                </button>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- Large Image - Left Side (2 columns) -->
            <div class="md:col-span-2 relative rounded-lg overflow-hidden h-96 md:h-[550px]">
                <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1200&q=80" 
                     alt="Piscine intérieure Kaylia Suite Home" 
                     class="w-full h-full object-cover">
            </div>

            <!-- Right Column - 3 Small Images (same total height as large image) -->
            <div class="flex flex-col gap-3 h-96 md:h-[550px]">
                <!-- Image 1 - Jacuzzi -->
                <div class="relative rounded-lg overflow-hidden flex-1">
                    <img src="https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=600&q=80" 
                         alt="Jacuzzi" 
                         class="w-full h-full object-cover">
                </div>

                <!-- Image 2 - Salle de sport -->
                <div class="relative rounded-lg overflow-hidden flex-1">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600&q=80" 
                         alt="Salle de sport" 
                         class="w-full h-full object-cover">
                </div>

                <!-- Image 3 - Vue d'ensemble -->
                <div class="relative rounded-lg overflow-hidden flex-1">
                    <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=600&q=80" 
                         alt="Vue d'ensemble" 
                         class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tabs Section - Prendre RDV & Évènements -->
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 md:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Column - Tabs and Content -->
            <div>
                <!-- Tabs Navigation -->
                <div class="flex border-b-2 border-gray-300 mb-8">
                    <button class="tab-btn active px-6 py-3 text-lg font-medium text-gray-900 border-b-4 border-gray-900 -mb-0.5" data-tab="rdv">
                        Prendre RDV
                    </button>
                    <button class="tab-btn px-6 py-3 text-lg font-medium text-gray-500 hover:text-gray-900 transition" data-tab="events">
                        Évènements
                    </button>
                </div>

                <!-- Tab Content - Prendre RDV -->
                <div id="rdv-content" class="tab-content space-y-4">
                    <!-- Service 1 -->
                    <div class="border-2 border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Spa - 1h Non Privatisé</h3>
                        <p class="text-sm text-gray-700 mb-4 leading-relaxed">
                            Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000
                        </p>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-gray-900">10,00€</span>
                        </div>
                    </div>

                    <!-- Service 2 -->
                    <div class="border-2 border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Spa - 2h Non Privatisé</h3>
                        <p class="text-sm text-gray-700 mb-4 leading-relaxed">
                            Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000
                        </p>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-gray-900">20,00€</span>
                        </div>
                    </div>

                    <!-- Service 3 -->
                    <div class="border-2 border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Spa - 1h Non Privatisé en Duo</h3>
                        <p class="text-sm text-gray-700 mb-4 leading-relaxed">
                            Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000
                        </p>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-gray-900">30,00€</span>
                        </div>
                    </div>

                    <!-- Service 4 -->
                    <div class="border-2 border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Spa - 2h Non Privatisé en Duo</h3>
                        <p class="text-sm text-gray-700 mb-4 leading-relaxed">
                            Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000
                        </p>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-gray-900">50,00€</span>
                        </div>
                    </div>
                </div>

                <!-- Tab Content - Évènements (Hidden by default) -->
                <div id="events-content" class="tab-content hidden space-y-4">
                    <!-- Event 1 -->
                    <div class="border-2 border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Spa - 2h Privatisé - Anniversaire 5-10 personnes</h3>
                        <p class="text-sm text-gray-700 mb-4 leading-relaxed">
                            Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000
                        </p>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-gray-900">70,00€</span>
                        </div>
                    </div>

                    <!-- Event 2 -->
                    <div class="border-2 border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Spa - 2h Privatisé - Pack Romance</h3>
                        <p class="text-sm text-gray-600 italic mb-3">
                            Une bouteille de champagne et un panier gourmand (fruits & spécialités artisanales)
                        </p>
                        <p class="text-sm text-gray-700 mb-4 leading-relaxed">
                            Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000
                        </p>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-gray-900">60,00€</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Note & Horaires -->
            <div class="bg-[#d9d3ca] rounded-lg p-8">
                <!-- Note Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Note</h3>
                    <div class="flex gap-4">
                        <!-- Rating Score -->
                        <div class="bg-primary-blue text-white rounded-lg w-24 h-24 flex items-center justify-center flex-shrink-0">
                            <span class="text-4xl font-bold">4,9</span>
                        </div>
                        
                        <!-- Rating Details -->
                        <div class="flex-1">
                            <div class="space-y-1.5 mb-3">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-900">Accueil :</span>
                                    <span class="font-semibold text-gray-900">4,9 ★</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-900">Propreté :</span>
                                    <span class="font-semibold text-gray-900">4,9 ★</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-900">Cadre & Ambiance :</span>
                                    <span class="font-semibold text-gray-900">4,9 ★</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-900">Qualité de la prestation :</span>
                                    <span class="font-semibold text-gray-900">5,0 ★</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-700">17 clients ont donné leur avis</p>
                        </div>
                    </div>
                </div>

                <!-- Horaires Section -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Horaires d'ouverture</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-400">
                            <span class="text-gray-900">Lundi</span>
                            <span class="text-gray-900">10:00 - 20:00</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-400">
                            <span class="text-gray-900">Mardi</span>
                            <span class="text-gray-900">10:00 - 20:00</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-400">
                            <span class="text-gray-900">Mercredi</span>
                            <span class="text-gray-900">10:00 - 20:00</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-400">
                            <span class="text-gray-900">Jeudi</span>
                            <span class="text-gray-900">10:00 - 20:00</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-400">
                            <span class="text-gray-900">Vendredi</span>
                            <span class="text-gray-900">10:00 - 20:00</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-400">
                            <span class="text-gray-900">Samedi</span>
                            <span class="text-gray-900">10:00 - 20:00</span>
                        </div>
                        <div class="flex justify-between items-center pb-3">
                            <span class="text-gray-900">Dimanche</span>
                            <span class="text-gray-900">10:00 - 17:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Avis Clients Section -->
<section class="bg-[#b8a088] py-12 md:py-16">
    <div class="container mx-auto px-6 md:px-20">
        <!-- Title -->
        <div class="text-center mb-12">
            <h2 class="font-serif text-3xl md:text-4xl font-light text-white mb-4">
                Avis <span class="text-primary-blue">clients</span>
            </h2>
            <p class="text-white text-base font-light">
                Nos clients ont aussi profité du SPA. Votre satisfaction est notre principale préoccupation.
            </p>
        </div>

        <!-- Reviews Carousel -->
        <div class="relative max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Review 1 -->
                <div class="bg-transparent border-2 border-white rounded-lg p-6">
                    <div class="flex items-center gap-1 mb-4">
                        <span class="text-white text-xl font-semibold">4,9</span>
                        <span class="text-white text-xl">★</span>
                    </div>
                    <p class="text-white text-sm leading-relaxed mb-4">
                        Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home
                    </p>
                    <p class="text-white text-xs opacity-80">24/10/2025</p>
                </div>

                <!-- Review 2 -->
                <div class="bg-transparent border-2 border-white rounded-lg p-6">
                    <div class="flex items-center gap-1 mb-4">
                        <span class="text-white text-xl font-semibold">4,9</span>
                        <span class="text-white text-xl">★</span>
                    </div>
                    <p class="text-white text-sm leading-relaxed mb-4">
                        Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home
                    </p>
                    <p class="text-white text-xs opacity-80">24/10/2025</p>
                </div>

                <!-- Review 3 -->
                <div class="bg-transparent border-2 border-white rounded-lg p-6">
                    <div class="flex items-center gap-1 mb-4">
                        <span class="text-white text-xl font-semibold">4,9</span>
                        <span class="text-white text-xl">★</span>
                    </div>
                    <p class="text-white text-sm leading-relaxed mb-4">
                        Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home
                    </p>
                    <p class="text-white text-xs opacity-80">24/10/2025</p>
                </div>

                <!-- Review 4 -->
                <div class="bg-transparent border-2 border-white rounded-lg p-6">
                    <div class="flex items-center gap-1 mb-4">
                        <span class="text-white text-xl font-semibold">4,9</span>
                        <span class="text-white text-xl">★</span>
                    </div>
                    <p class="text-white text-sm leading-relaxed mb-4">
                        Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home
                    </p>
                    <p class="text-white text-xs opacity-80">24/10/2025</p>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <div class="flex justify-center gap-3">
                <button class="w-12 h-12 bg-primary-blue hover:bg-[#086780] text-white rounded-full flex items-center justify-center transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="w-12 h-12 bg-primary-blue hover:bg-[#086780] text-white rounded-full flex items-center justify-center transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
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
                id="consent-studio" 
                class="mt-1 w-4 h-4 flex-shrink-0 cursor-pointer"
                required
            >
            <label for="consent-studio" class="text-xs text-gray-700 leading-relaxed cursor-pointer">
                En cochant cette case, je consens à l'utilisation des informations fournies à des fins de marketing par e-mail.
            </label>
        </div>
    </div>
</section>



<script>
    // Tabs functionality
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', () => {
            const tabName = button.getAttribute('data-tab');
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'border-gray-900', 'text-gray-900', 'border-b-4');
                btn.classList.add('text-gray-500');
            });
            
            // Add active class to clicked tab
            button.classList.add('active', 'border-gray-900', 'text-gray-900', 'border-b-4');
            button.classList.remove('text-gray-500');
            
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
        });
    });
</script>

<!-- Instagram Section -->
<section class="bg-[#b8a088] py-12 md:py-16">
    <div class="text-center mb-8 px-6">
        <h2 class="font-serif text-3xl md:text-4xl font-light text-white mb-3">
            Suivez-nous sur <span class="text-primary-blue italic">Instagram</span>
        </h2>
        <p class="text-white text-base">@kayliasuitehome</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-0">
        <!-- Instagram Post 1 -->
        <div class="relative bg-gray-800 h-64 md:h-80 overflow-hidden group cursor-pointer">
            <img src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=600&q=80" 
                 alt="Instagram post" 
                 class="w-full h-full object-cover opacity-70 group-hover:opacity-90 transition">
            <div class="absolute inset-0 flex items-center justify-center p-8">
                <div class="text-center">
                    <div class="w-20 h-20 border-4 border-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-3xl font-serif">K</span>
                    </div>
                    <p class="text-white text-sm leading-relaxed">
                        Un espace pur, une atmosphère apaisée pour vous détendre.
                    </p>
                </div>
            </div>
        </div>

        <!-- Instagram Post 2 -->
        <div class="relative bg-gray-700 h-64 md:h-80 overflow-hidden group cursor-pointer">
            <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600&q=80" 
                 alt="Instagram post" 
                 class="w-full h-full object-cover opacity-70 group-hover:opacity-90 transition">
            <div class="absolute inset-0 flex items-center justify-center p-8">
                <div class="text-center text-white">
                    <div class="font-serif text-2xl mb-4 tracking-wider">
                        KAYLIA<br>
                        <span class="text-sm tracking-widest">SUITE HOME</span>
                    </div>
                    <p class="text-sm leading-relaxed mb-4">
                        Je recommande l'Appart-Hôtel Kaylia Suite Home à 1000%. Le lieu est digne des plus grands hôtels. À la fois spacieux et très chaleureux.
                    </p>
                    <p class="text-sm leading-relaxed">
                        Le personnel est très accueillant et à l'écoute ce qui a rendu notre séjour encore plus agréable.
                    </p>
                    <p class="text-xs mt-4 font-semibold">AVIS CLIENT KAYLIA SUITE HOME</p>
                </div>
            </div>
        </div>

        <!-- Instagram Post 3 -->
        <div class="relative bg-gray-200 h-64 md:h-80 overflow-hidden group cursor-pointer">
            <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=600&q=80" 
                 alt="Instagram post" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        </div>

        <!-- Instagram Post 4 -->
        <div class="relative bg-gray-800 h-64 md:h-80 overflow-hidden group cursor-pointer">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80" 
                 alt="Instagram post" 
                 class="w-full h-full object-cover opacity-70 group-hover:opacity-90 transition">
            <div class="absolute inset-0 flex items-center justify-center p-8">
                <div class="text-center text-white">
                    <div class="font-serif text-3xl mb-6 tracking-wider">
                        KAYLIA<br>
                        <span class="text-sm tracking-widest">SUITE HOME</span>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Nous vous accueillons dans notre Appart-hôtel avec des appartements spacieux pour un séjour agréable en famille
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
