<?php
$pageTitle = "Accueil - Kaylia Suite Home";
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero relative min-h-screen bg-cover bg-center flex flex-col justify-center items-start px-6 md:px-20 text-white">
    <div class="max-w-3xl mb-12">
        <h1 class="font-serif text-3xl md:text-5xl font-light mb-4 leading-tight">
            KAYLIA SUITE HOME<br>
            L'ART du Confort & du Luxe à Yaoundé
        </h1>
        <p class="text-sm md:text-base font-light tracking-wide">
            Vivez une expérience unique, mémorable et chaleureuse
        </p>
    </div>
    
    <!-- Search Box -->
    <div class="flex flex-col md:flex-row gap-0 bg-white/95 rounded overflow-hidden shadow-lg max-w-4xl w-full">
        <div class="flex items-center gap-3 px-6 py-4 bg-white border-b md:border-b-0 md:border-r border-gray-200 cursor-pointer hover:bg-gray-50 transition flex-1">
            <div class="flex-1 min-w-0">
                <label class="block text-xs text-gray-500 mb-1">Choisir vos dates</label>
                <input type="text" placeholder="JJ/MM/AAAA" readonly class="text-sm text-gray-800 bg-transparent border-none outline-none cursor-pointer w-full">
            </div>
            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        
        <div class="flex items-center gap-3 px-6 py-4 bg-white border-b md:border-b-0 md:border-r border-gray-200 cursor-pointer hover:bg-gray-50 transition flex-1">
            <div class="flex-1 min-w-0">
                <label class="block text-xs text-gray-500 mb-1">Nombre de personne</label>
                <select class="text-sm text-gray-800 bg-transparent border-none outline-none cursor-pointer w-full appearance-none">
                    <option>2 Adultes</option>
                    <option>1 Adulte</option>
                    <option>3 Adultes</option>
                    <option>4 Adultes</option>
                </select>
            </div>
            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        
        <div class="flex items-center gap-3 px-6 py-4 bg-white border-b md:border-b-0 md:border-r border-gray-200 cursor-pointer hover:bg-gray-50 transition flex-1">
            <div class="flex-1 min-w-0">
                <label class="block text-xs text-gray-500 mb-1">Code promo</label>
                <input type="text" placeholder="Entrez le code" class="text-sm text-gray-800 bg-transparent border-none outline-none w-full">
            </div>
            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        
        <button class="bg-primary-blue hover:bg-[#086780] text-white px-8 py-4 font-medium text-sm uppercase tracking-wide transition flex-shrink-0">
            Réserver
        </button>
    </div>
</section>

<!-- Apartments Section -->
<section class="py-12 md:py-20 px-6 md:px-20 bg-gray-50">
    <div class="text-center mb-12 md:mb-16">
        <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-800 mb-4">
            Nos <span class="text-primary-blue italic">Appartements</span>
        </h2>
        <p class="text-base text-gray-600 font-light tracking-wide">
            Découvrez nos appartements de standing conçu pour votre confort et votre bien-être.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
        <!-- Apartment 1 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-2 transition-all">
            <div class="apartment-image h-80 relative">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/30"></div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Appartement n°302</h3>
                <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                    Notre appartement le plus spacieux pour accueillir famille, groupe d'amis, séminaire
                </p>
                
                <!-- Rating -->
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-yellow-500">⭐</span>
                    <span class="text-sm font-semibold text-gray-800">4.2</span>
                    <span class="text-sm text-gray-500">(20 avis)</span>
                </div>
                
                <!-- Services -->
                <div class="mb-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Services</p>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">🏠</div>
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">📺</div>
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">👥</div>
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">+4</div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center border-t border-gray-200 pt-5">
                    <div>
                        <div class="text-2xl font-bold text-gray-900">À partir de 152€</div>
                    </div>
                    <a href="#" class="text-primary-blue hover:text-[#086780] font-medium text-sm flex items-center gap-1 transition">
                        Découvrir →
                    </a>
                </div>
            </div>
        </div>

        <!-- Apartment 2 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-2 transition-all">
            <div class="apartment-image h-80 relative">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/30"></div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Appartement n°201</h3>
                <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                    Notre appartement le plus spacieux pour accueillir famille, groupe d'amis, séminaire
                </p>
                
                <!-- Rating -->
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-yellow-500">⭐</span>
                    <span class="text-sm font-semibold text-gray-800">4.2</span>
                    <span class="text-sm text-gray-500">(20 avis)</span>
                </div>
                
                <!-- Services -->
                <div class="mb-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Services</p>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">🛏️</div>
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">🚿</div>
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">📺</div>
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">+4</div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center border-t border-gray-200 pt-5">
                    <div>
                        <div class="text-2xl font-bold text-gray-900">À partir de 70€</div>
                    </div>
                    <a href="#" class="text-primary-blue hover:text-[#086780] font-medium text-sm flex items-center gap-1 transition">
                        Découvrir →
                    </a>
                </div>
            </div>
        </div>

        <!-- Apartment 3 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-2 transition-all">
            <div class="apartment-image h-80 relative">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/30"></div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Appartement n°202</h3>
                <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                    Notre appartement le plus spacieux pour accueillir famille, groupe d'amis, séminaire
                </p>
                
                <!-- Rating -->
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-yellow-500">⭐</span>
                    <span class="text-sm font-semibold text-gray-800">4.2</span>
                    <span class="text-sm text-gray-500">(20 avis)</span>
                </div>
                
                <!-- Services -->
                <div class="mb-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Services</p>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">🏠</div>
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">🛏️</div>
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">🚿</div>
                        <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-sm">+4</div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center border-t border-gray-200 pt-5">
                    <div>
                        <div class="text-2xl font-bold text-gray-900">À partir de 100€</div>
                    </div>
                    <a href="#" class="text-primary-blue hover:text-[#086780] font-medium text-sm flex items-center gap-1 transition">
                        Découvrir →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="appartement.php" class="inline-block border-2 border-primary-blue text-primary-blue hover:bg-primary-blue hover:text-white px-10 py-3 rounded text-sm font-medium uppercase tracking-wide transition">
            Voir tous les appartements
        </a>
    </div>
</section>

<!-- Spa Section -->
<section class="bg-white py-12 md:py-20">
    <div class="container mx-auto px-6 md:px-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
            <!-- Image -->
            <div class="order-2 md:order-1">
                <div class="spa-image bg-cover bg-center rounded-lg h-80 md:h-96"></div>
            </div>
            
            <!-- Content -->
            <div class="order-1 md:order-2">
                <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-900 mb-6">Le SPA & Bien-être</h2>
                <p class="text-base text-gray-700 font-light leading-relaxed mb-6">
                    Plongez dans un univers de détente et de relaxation. Notre espace bien-être vous offre une parenthèse de sérénité au cœur de Yaoundé.
                </p>
                
                <ul class="space-y-2 mb-8 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="text-primary-blue mt-1">•</span>
                        <span>Piscine avec coin détente</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-primary-blue mt-1">•</span>
                        <span>Jacuzzi</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-primary-blue mt-1">•</span>
                        <span>Sauna Finlandais traditionnel</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-primary-blue mt-1">•</span>
                        <span>Massages et soins personnalisés</span>
                    </li>
                </ul>

                <button class="bg-[#b8a088] hover:bg-[#a89078] text-white px-8 py-3 rounded text-sm font-medium transition">
                    Découvrir le SPA
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="bg-[#1e3a3f] text-white py-12 md:py-20 px-6 md:px-20">
    <div class="text-center mb-12 md:mb-16">
        <h2 class="font-serif text-4xl md:text-5xl font-light mb-4">
            Nos <span class="italic">Services</span>
        </h2>
        <p class="text-base text-gray-300 font-light tracking-wide max-w-3xl mx-auto">
            Profitez d'un séjour sans compromis avec nos services premium conçus pour votre confort.
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 md:gap-12 max-w-4xl mx-auto">
        <div class="text-center">
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center text-2xl text-gray-800">
                �
            </div>
            <h3 class="text-sm font-medium">Wi-Fi haut débit</h3>
        </div>

        <div class="text-center">
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center text-2xl text-gray-800">
                🛡️
            </div>
            <h3 class="text-sm font-medium">Sécurité 24/7</h3>
        </div>

        <div class="text-center">
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center text-2xl text-gray-800">
                �
            </div>
            <h3 class="text-sm font-medium">SPA & Bien-être</h3>
        </div>

        <div class="text-center">
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center text-2xl text-gray-800">
                �
            </div>
            <h3 class="text-sm font-medium">Conciergerie</h3>
        </div>

        <div class="text-center">
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center text-2xl text-gray-800">
                🍳
            </div>
            <h3 class="text-sm font-medium">Cuisine Équipée</h3>
        </div>

        <div class="text-center">
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center text-2xl text-gray-800">
                ❄️
            </div>
            <h3 class="text-sm font-medium">Climatisation</h3>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="grid grid-cols-1 md:grid-cols-2 min-h-[500px] bg-white">
    <div class="location-map bg-gray-200 h-96 md:h-auto order-2 md:order-1"></div>
    <div class="bg-white px-6 md:px-16 py-12 md:py-20 flex flex-col justify-center order-1 md:order-2">
        <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-900 mb-6">Localisation</h2>
        <p class="text-base text-gray-700 font-light leading-relaxed mb-6">
            Idéalement situé dans le quartier calme et sécurisé de Jouvence, Kaylia Suite Home vous offre un accès privilégié aux attractions de la ville de Yaoundé, tout en vous garantissant tranquillité et sérénité.
        </p>
        
        <div class="mb-8">
            <p class="text-sm text-gray-700 flex items-start gap-2">
                <span class="text-primary-blue">•</span>
                <span>(Avantages de la localisation)</span>
            </p>
        </div>

        <a href="#" class="self-start border-2 border-primary-blue text-primary-blue hover:bg-primary-blue hover:text-white px-8 py-3 rounded text-sm font-medium transition">
            Voir sur la carte
        </a>
    </div>
</section>

<!-- Newsletter Section -->
<section class="bg-gray-100 py-12 md:py-16 px-6 md:px-20 text-center">
    <h2 class="font-serif text-3xl md:text-4xl font-light mb-3">
        Inscrivez-vous à notre <span class="text-primary-blue italic">newsletter</span> et recevez nos codes promos
    </h2>
    <p class="text-base text-gray-700 font-light mb-8">
        Recevez des offres exclusives et restez informé de nos actualités.
    </p>
    
    <form class="flex flex-col md:flex-row justify-center gap-4 max-w-2xl mx-auto mb-6">
        <input type="email" placeholder="Votre adresse email" class="flex-1 px-6 py-4 border-2 border-gray-300 rounded text-sm outline-none focus:border-primary-blue transition">
        <button type="submit" class="bg-[#0a5f7d] hover:bg-[#084a61] text-white px-10 py-4 rounded text-sm font-medium transition">
            S'inscrire
        </button>
    </form>

    <div class="flex items-start justify-center gap-3 max-w-3xl mx-auto text-left">
        <input type="checkbox" id="consent" class="mt-1 w-4 h-4 flex-shrink-0">
        <label for="consent" class="text-xs text-gray-700 leading-relaxed">
            En cochant cette case, je consens à l'utilisation des informations fournies à des fins de marketing par e-mail.
        </label>
    </div>
</section>

<!-- Reservation Banner -->
<section class="bg-[#b8a088] text-white py-12 md:py-20 px-6 md:px-20 text-center">
    <h2 class="font-serif text-4xl md:text-5xl font-light mb-4">
        Réservez <span class="italic">sur notre site</span>
    </h2>
    <p class="text-base font-light mb-12 opacity-95 max-w-3xl mx-auto">
        Réservez directement sur le site Kaylia Suite Home pour profiter d'avantages exclusifs lors de votre séjour dans notre appart'hôtel
    </p>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 md:gap-12 mb-12 max-w-5xl mx-auto">
        <div class="text-center">
            <div class="w-20 h-20 bg-[#1e3a3f] rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                🏷️
            </div>
            <h3 class="text-sm font-medium">Meilleur Tarif Garanti</h3>
        </div>

        <div class="text-center">
            <div class="w-20 h-20 bg-[#1e3a3f] rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                %
            </div>
            <h3 class="text-sm font-medium">Offres exclusives</h3>
        </div>

        <div class="text-center">
            <div class="w-20 h-20 bg-[#1e3a3f] rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                ✕
            </div>
            <h3 class="text-sm font-medium">Flexibilité</h3>
        </div>

        <div class="text-center">
            <div class="w-20 h-20 bg-[#1e3a3f] rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                👥
            </div>
            <h3 class="text-sm font-medium">Service client personnalisé</h3>
        </div>

        <div class="text-center">
            <div class="w-20 h-20 bg-[#1e3a3f] rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                �
            </div>
            <h3 class="text-sm font-medium">Accueil sur mesure</h3>
        </div>
    </div>

    <p class="text-sm italic mb-8 opacity-90">
        Vivez une expérience unique et authentique en réservant maintenant pour des souvenirs mémorables
    </p>

    <button class="bg-[#0a5f7d] hover:bg-[#084a61] text-white px-12 py-4 rounded font-medium text-sm transition shadow-lg hover:shadow-xl">
        Réserver
    </button>
</section>

<!-- Social Section -->
<section class="bg-white py-12 md:py-20">
    <div class="text-center mb-12 px-6">
        <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-900 mb-3">
            Suivez-nous sur <span class="text-primary-blue italic">Instagram</span>
        </h2>
        <p class="text-base text-gray-700">@kayliasuitehome</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-0">
        <div class="social-image hover:opacity-90 transition cursor-pointer h-64 md:h-80"></div>
        <div class="social-image hover:opacity-90 transition cursor-pointer h-64 md:h-80"></div>
        <div class="social-image hover:opacity-90 transition cursor-pointer h-64 md:h-80"></div>
        <div class="social-image hover:opacity-90 transition cursor-pointer h-64 md:h-80"></div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
