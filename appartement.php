<?php
$pageTitle = "Nos Appartements - Kaylia Suite Home";
include 'includes/header.php';
?>

<!-- Hero Section with Building Image -->
<section class="relative h-[40vh] md:h-[50vh] bg-cover bg-center flex items-center" style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22><rect fill=%22%23556b7d%22 width=%221200%22 height=%22600%22/></svg>');">
    <div class="container mx-auto px-6 md:px-20">
        <h1 class="text-white font-serif text-3xl md:text-5xl font-light leading-tight max-w-3xl">
            Des appartements de haut standing pour rendre<br>votre séjour inoubliable !
        </h1>
    </div>
</section>

<!-- Gallery Section with 3 Images -->
<section class="bg-[#c9b5a0] py-0">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
            <!-- Image 1 - Living Room -->
            <div class="relative h-64 md:h-80 bg-cover bg-center" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22><rect fill=%22%23e5e5e5%22 width=%22400%22 height=%22300%22/></svg>');">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
            </div>
            
            <!-- Image 2 - Bedroom -->
            <div class="relative h-64 md:h-80 bg-cover bg-center" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22><rect fill=%22%23d5d5d5%22 width=%22400%22 height=%22300%22/></svg>');">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
            </div>
            
            <!-- Image 3 - Bathroom/Kitchen -->
            <div class="relative h-64 md:h-80 bg-cover bg-center" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22><rect fill=%22%23c5c5c5%22 width=%22400%22 height=%22300%22/></svg>');">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
            </div>
        </div>
    </div>
</section>

<!-- Info Bar Section -->
<section class="bg-white border-t border-b border-gray-200 py-6">
    <div class="container mx-auto px-6 md:px-20">
        <div class="flex flex-wrap items-center justify-between gap-6">
            <!-- Location -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <span class="text-sm md:text-base text-gray-800">Quartier Jouvence, Yaoundé</span>
            </div>
            
            <!-- Apartments Count -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span class="text-sm md:text-base text-gray-800">7 appartements</span>
            </div>
            
            <!-- Capacity -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-sm md:text-base text-gray-800">1 à 4 personnes</span>
            </div>
            
            <!-- Surface -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"></path>
                    </svg>
                </div>
                <span class="text-sm md:text-base text-gray-800">du 11 au T3</span>
            </div>
            
            <!-- Navigation Arrows -->
            <div class="flex items-center gap-2 ml-auto">
                <button class="w-10 h-10 border-2 border-gray-300 rounded-full flex items-center justify-center hover:border-primary-blue hover:text-primary-blue transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="w-10 h-10 border-2 border-gray-300 rounded-full flex items-center justify-center hover:border-primary-blue hover:text-primary-blue transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>



    <!-- Hero Section -->
    <div class="hero-gradient border-b-2 border-stone-200">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="text-center animate-fade-in-up">
                <h1 class="font-display text-5xl md:text-6xl font-bold text-gray-900 mb-4">
                    <span class="text-5xl">5</span> 
                    <span class="text-teal-700 italic">appartements</span> 
                    <span class="font-normal">disponibles</span>
                </h1>
                <p class="text-gray-600 text-lg md:text-xl max-w-2xl mx-auto tracking-wide">
                    Retrouvez nos appartements disponibles par rapport à vos dates de séjour.
                </p>
            </div>

            <!-- Filter Section -->
            <div class="mt-12 flex flex-wrap items-center justify-center gap-4 animate-fade-in-up stagger-1">
                <div class="relative">
                    <select class="appearance-none bg-white border-2 border-stone-300 rounded-lg px-6 py-3 pr-10 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors cursor-pointer">
                        <option>Nombre de personne</option>
                        <option>1 personne</option>
                        <option>2 personnes</option>
                        <option>3 personnes</option>
                        <option>4 personnes</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <select class="appearance-none bg-white border-2 border-stone-300 rounded-lg px-6 py-3 pr-10 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors cursor-pointer">
                        <option>Nombre de chambre</option>
                        <option>Studio</option>
                        <option>1 chambre</option>
                        <option>2 chambres</option>
                        <option>3 chambres</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <input type="text" value="11/05/2026 - 26/05/2026" 
                           class="bg-white border-2 border-stone-300 rounded-lg px-6 py-3 text-gray-700 focus:outline-none focus:border-teal-600 transition-colors w-64" />
                </div>

                <button class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-8 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Réserver
                </button>
            </div>
        </div>
    </div>

    <!-- Apartments Listing -->
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="space-y-12">
            
            <!-- Apartment 1 -->
            <div class="apartment-card bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up stagger-1" style="opacity: 1;">
                <div class="grid md:grid-cols-5 gap-0">
                    <!-- Image Gallery -->
                    <div class="md:col-span-2 relative image-container bg-gray-100 h-80 md:h-auto">
                        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80" 
                             alt="Appartement luxueux" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 font-display text-2xl text-white drop-shadow-lg">
                            <div class="font-bold tracking-wider">KAYLIA</div>
                            <div class="text-xs tracking-widest opacity-90">LUXURY LIVING</div>
                        </div>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:col-span-3 p-8 md:p-10">
                        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4">Appartement X</h2>
                        
                        <!-- Features -->
                        <div class="flex flex-wrap gap-4 mb-6">
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">2 personnes</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">40m²</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">1 lit king size</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 font-medium">3e étage</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                            Lorem ipsum dolor sit amet. Et adipisci rerum hic suscipit tempore aut quasi eligendi est Lorem temporibus aut voluptatibus officia id quasi verum. Est rerum illo aut adipisci suscipit vel voluptatibus natus. Cum praesertium necessitatibus et quas temetur est rerum excepturi. Cum quas recusandae qui quis dolore est dicta voluptatum nerum itaque vel inventore laudantium non cupiditate aut...
                        </p>

                        <!-- Price and CTA -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                            <div>
                                <div class="text-sm text-gray-500 mb-1 uppercase tracking-wider">À partir de</div>
                                <div class="font-display text-4xl font-bold text-gray-900">
                                    152€<span class="text-2xl font-normal text-gray-600">/Nuit</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">+ 308€ de taxe de séjour (28 nuits)</div>
                            </div>
                            <button class="select-btn w-full sm:w-auto bg-white border-2 border-teal-600 text-teal-600 font-semibold px-10 py-4 rounded-lg">
                                Sélectionner
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apartment 2 - Most Desired -->
            <div class="apartment-card bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up stagger-2" style="opacity: 1;">
                <div class="grid md:grid-cols-5 gap-0">
                    <!-- Image Gallery -->
                    <div class="md:col-span-2 relative image-container bg-gray-100 h-80 md:h-auto">
                        <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&q=80" 
                             alt="Appartement moderne" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 font-display text-2xl text-white drop-shadow-lg">
                            <div class="font-bold tracking-wider">KAYLIA</div>
                            <div class="text-xs tracking-widest opacity-90">LUXURY LIVING</div>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="badge-premium text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                Appartement le plus désiré
                            </span>
                        </div>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:col-span-3 p-8 md:p-10">
                        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4">Appartement X</h2>
                        
                        <!-- Features -->
                        <div class="flex flex-wrap gap-4 mb-6">
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">2 personnes</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">40m²</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">1 lit king size</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 font-medium">1er étage</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                            Lorem ipsum dolor sit amet. Et adipisci rerum hic suscipit tempore aut quasi eligendi est Lorem temporibus aut voluptatibus officia id quasi verum. Est rerum illo aut adipisci suscipit vel voluptatibus natus. Cum praesertium necessitatibus et quas temetur est rerum excepturi. Cum quas recusandae qui quis dolore est dicta voluptatum nerum itaque vel inventore laudantium non cupiditate aut...
                        </p>

                        <!-- Price and CTA -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                            <div>
                                <div class="text-sm text-gray-500 mb-1 uppercase tracking-wider">À partir de</div>
                                <div class="font-display text-4xl font-bold text-gray-900">
                                    70€<span class="text-2xl font-normal text-gray-600">/Nuit</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">+ 308€ de taxe de séjour (28 nuits)</div>
                            </div>
                            <button class="select-btn w-full sm:w-auto bg-white border-2 border-teal-600 text-teal-600 font-semibold px-10 py-4 rounded-lg">
                                Sélectionner
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apartment 3 -->
            <div class="apartment-card bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up stagger-3" style="opacity: 1;">
                <div class="grid md:grid-cols-5 gap-0">
                    <!-- Image Gallery -->
                    <div class="md:col-span-2 relative image-container bg-gray-100 h-80 md:h-auto">
                        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80" 
                             alt="Appartement élégant" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 font-display text-2xl text-white drop-shadow-lg">
                            <div class="font-bold tracking-wider">KAYLIA</div>
                            <div class="text-xs tracking-widest opacity-90">LUXURY LIVING</div>
                        </div>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:col-span-3 p-8 md:p-10">
                        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4">Appartement X</h2>
                        
                        <!-- Features -->
                        <div class="flex flex-wrap gap-4 mb-6">
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">2 personnes</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">40m²</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">1 lit king size</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 font-medium">2e étage</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                            Lorem ipsum dolor sit amet. Et adipisci rerum hic suscipit tempore aut quasi eligendi est Lorem temporibus aut voluptatibus officia id quasi verum. Est rerum illo aut adipisci suscipit vel voluptatibus natus. Cum praesertium necessitatibus et quas temetur est rerum excepturi. Cum quas recusandae qui quis dolore est dicta voluptatum nerum itaque vel inventore laudantium non cupiditate aut...
                        </p>

                        <!-- Price and CTA -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                            <div>
                                <div class="text-sm text-gray-500 mb-1 uppercase tracking-wider">À partir de</div>
                                <div class="font-display text-4xl font-bold text-gray-900">
                                    100€<span class="text-2xl font-normal text-gray-600">/Nuit</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">+ 308€ de taxe de séjour (28 nuits)</div>
                            </div>
                            <button class="select-btn w-full sm:w-auto bg-white border-2 border-teal-600 text-teal-600 font-semibold px-10 py-4 rounded-lg">
                                Sélectionner
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apartment 4 -->
            <div class="apartment-card bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up stagger-4" style="opacity: 1;">
                <div class="grid md:grid-cols-5 gap-0">
                    <!-- Image Gallery -->
                    <div class="md:col-span-2 relative image-container bg-gray-100 h-80 md:h-auto">
                        <img src="https://images.unsplash.com/photo-1556912167-f556f1f39faa?w=800&q=80" 
                             alt="Appartement spacieux" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 font-display text-2xl text-white drop-shadow-lg">
                            <div class="font-bold tracking-wider">KAYLIA</div>
                            <div class="text-xs tracking-widest opacity-90">LUXURY LIVING</div>
                        </div>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:col-span-3 p-8 md:p-10">
                        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4">Appartement X</h2>
                        
                        <!-- Features -->
                        <div class="flex flex-wrap gap-4 mb-6">
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">2 personnes</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">40m²</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">2 lits king size</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 font-medium">4e étage</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                            Lorem ipsum dolor sit amet. Et adipisci rerum hic suscipit tempore aut quasi eligendi est Lorem temporibus aut voluptatibus officia id quasi verum. Est rerum illo aut adipisci suscipit vel voluptatibus natus. Cum praesertium necessitatibus et quas temetur est rerum excepturi. Cum quas recusandae qui quis dolore est dicta voluptatum nerum itaque vel inventore laudantium non cupiditate aut...
                        </p>

                        <!-- Price and CTA -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                            <div>
                                <div class="text-sm text-gray-500 mb-1 uppercase tracking-wider">À partir de</div>
                                <div class="font-display text-4xl font-bold text-gray-900">
                                    138€<span class="text-2xl font-normal text-gray-600">/Nuit</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">+ 864€ de taxe de séjour (28 nuits)</div>
                            </div>
                            <button class="select-btn w-full sm:w-auto bg-white border-2 border-teal-600 text-teal-600 font-semibold px-10 py-4 rounded-lg">
                                Sélectionner
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apartment 5 -->
            <div class="apartment-card bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up stagger-5" style="opacity: 1;">
                <div class="grid md:grid-cols-5 gap-0">
                    <!-- Image Gallery -->
                    <div class="md:col-span-2 relative image-container bg-gray-100 h-80 md:h-auto">
                        <img src="https://images.unsplash.com/photo-1536376072261-38c75010e6c9?w=800&q=80" 
                             alt="Appartement confortable" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 font-display text-2xl text-white drop-shadow-lg">
                            <div class="font-bold tracking-wider">KAYLIA</div>
                            <div class="text-xs tracking-widest opacity-90">LUXURY LIVING</div>
                        </div>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button class="nav-arrow w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:col-span-3 p-8 md:p-10">
                        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4">Appartement X</h2>
                        
                        <!-- Features -->
                        <div class="flex flex-wrap gap-4 mb-6">
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">2 personnes</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">35m²</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">1 lit king size</span>
                            </div>
                            <div class="flex items-center space-x-2 feature-icon">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 font-medium">1er étage</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                            Lorem ipsum dolor sit amet. Et adipisci rerum hic suscipit tempore aut quasi eligendi est Lorem temporibus aut voluptatibus officia id quasi verum. Est rerum illo aut adipisci suscipit vel voluptatibus natus. Cum praesertium necessitatibus et quas temetur est rerum excepturi. Cum quas recusandae qui quis dolore est dicta voluptatum nerum itaque vel inventore laudantium non cupiditate aut...
                        </p>

                        <!-- Price and CTA -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                            <div>
                                <div class="text-sm text-gray-500 mb-1 uppercase tracking-wider">À partir de</div>
                                <div class="font-display text-4xl font-bold text-gray-900">
                                    94€<span class="text-2xl font-normal text-gray-600">/Nuit</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">+ 308€ de taxe de séjour (28 nuits)</div>
                            </div>
                            <button class="select-btn w-full sm:w-auto bg-white border-2 border-teal-600 text-teal-600 font-semibold px-10 py-4 rounded-lg">
                                Sélectionner
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>




<!-- Equipment Section -->
<section class="bg-gray-50 py-16 md:py-20">
    <div class="container mx-auto px-6 md:px-20">
        <div class="text-center mb-12">
            <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-900 mb-4">
                Les <span class="text-primary-blue italic">équipements</span>
            </h2>
            <p class="text-base text-gray-600 font-light max-w-3xl mx-auto">
                Votre confort est pensé dans les moindres détails afin de rendre votre séjour le plus agréable.
            </p>
        </div>

        <!-- Equipment Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 max-w-6xl mx-auto">
            <!-- Row 1 -->
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Literie de luxe</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Valiselles</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Machine à café</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Four</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Savon et Shampooing</span>
            </div>

            <!-- Row 2 -->
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Climatisation</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Fer à repasser</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Four Micro-ondes</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Bouilloire</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">TV</span>
            </div>

            <!-- Row 3 -->
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Lave-vaisselle</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Chaise bébé</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Escalier</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Cuisine équipée</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Réfrigérateur</span>
            </div>

            <!-- Row 4 - Last 2 items centered -->
            <div class="flex flex-col items-center text-center lg:col-start-2">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">WiFi</span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <span class="text-sm text-gray-800">Machine à laver</span>
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

<!-- Gallery Photos Section -->
<section class="bg-white py-16 md:py-20">
    <div class="container mx-auto px-6 md:px-20">
        <!-- Title -->
        <div class="text-center mb-12">
            <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-900 mb-4">
                Galerie <span class="text-primary-blue italic">photos</span>
            </h2>
            <p class="text-base text-gray-600 font-light">
                Retrouvez nos appartements disponibles par rapport à vos dates de séjour.
            </p>
        </div>

        <!-- Gallery Grid -->
        <div class="flex flex-col lg:flex-row gap-3 max-w-7xl mx-auto">
            <!-- Large Image - Left Side (takes more space) -->
            <div class="flex-1 lg:w-[70%] relative rounded-lg overflow-hidden h-96 lg:h-[650px]">
                <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1200&q=80" 
                     alt="Kaylia Suite Home Building" 
                     class="w-full h-full object-cover">
                
                <!-- Navigation Arrows -->
                <div class="absolute bottom-4 right-4 flex gap-2">
                    <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Right Column - 3 Small Images (takes less space) -->
            <div class="flex flex-col gap-3 lg:w-[30%] lg:max-w-[280px]">
                <!-- Image 1 - Kitchen -->
                <div class="relative rounded-lg overflow-hidden h-40 lg:h-[210px]">
                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80" 
                         alt="Cuisine moderne" 
                         class="w-full h-full object-cover">
                </div>

                <!-- Image 2 - View All Photos -->
                <div class="relative rounded-lg overflow-hidden h-40 lg:h-[210px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80" 
                         alt="Salon élégant" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center group-hover:bg-opacity-70 transition">
                        <span class="text-white font-semibold text-base">Voir les</span>
                        <span class="text-white font-bold text-xl">57 photos</span>
                    </div>
                </div>

                <!-- Image 3 - View Video -->
                <div class="relative rounded-lg overflow-hidden h-40 lg:h-[210px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1540518614846-7eded433c457?w=600&q=80" 
                         alt="Chambre confortable" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center group-hover:bg-opacity-70 transition">
                        <span class="text-white font-semibold text-base">Voir la vidéo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="bg-white py-16 md:py-20">
    <div class="container mx-auto px-6 md:px-20 max-w-4xl">
        <div class="text-center mb-12">
            <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-900 mb-4">
                Avez vous des <span class="text-primary-blue italic">questions ?</span>
            </h2>
            <p class="text-base text-gray-600 font-light">
                Toutes les réponses à vos questions sur votre réservation sont ici. Besoin d'aide supplémentaire ? 
                <a href="contact.php" class="text-primary-blue hover:underline">Contactez-nous</a>
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4">
            <!-- Question 1 -->
            <div class="faq-item border-b border-gray-300">
                <button class="faq-question w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition">
                    <span class="text-lg text-gray-900 font-normal pr-8">Comment accéder à mon appartement le jour de mon arrivée ?</span>
                    <div class="faq-icon flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                    <div class="pb-5 pr-12 text-gray-600 leading-relaxed">
                        Vous recevrez toutes les instructions d'accès par email 24h avant votre arrivée. Un code d'accès personnel vous sera fourni pour entrer dans la résidence et votre appartement. Notre équipe reste disponible 24/7 pour vous assister.
                    </div>
                </div>
            </div>

            <!-- Question 2 -->
            <div class="faq-item border-b border-gray-300">
                <button class="faq-question w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition">
                    <span class="text-lg text-gray-900 font-normal pr-8">Le ménage est-il fait tous les jours ?</span>
                    <div class="faq-icon flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                    <div class="pb-5 pr-12 text-gray-600 leading-relaxed">
                        Le ménage est effectué avant votre arrivée et après votre départ. Pour les séjours de plus de 7 jours, un service de ménage hebdomadaire est inclus. Un service quotidien peut être ajouté sur demande moyennant un supplément.
                    </div>
                </div>
            </div>

            <!-- Question 3 -->
            <div class="faq-item border-b border-gray-300">
                <button class="faq-question w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition">
                    <span class="text-lg text-gray-900 font-normal pr-8">Y a-t-il une bagagerie dans la résidence ?</span>
                    <div class="faq-icon flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                    <div class="pb-5 pr-12 text-gray-600 leading-relaxed">
                        Oui, nous disposons d'une bagagerie sécurisée gratuite. Vous pouvez déposer vos bagages avant le check-in ou après le check-out. Contactez notre conciergerie pour organiser le dépôt de vos bagages.
                    </div>
                </div>
            </div>

            <!-- Question 4 -->
            <div class="faq-item border-b border-gray-300">
                <button class="faq-question w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition">
                    <span class="text-lg text-gray-900 font-normal pr-8">Peut-on arriver avant 15h ?</span>
                    <div class="faq-icon flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                    <div class="pb-5 pr-12 text-gray-600 leading-relaxed">
                        Le check-in standard est à partir de 15h. Un early check-in peut être possible selon la disponibilité de l'appartement, moyennant un supplément. Nous vous recommandons de nous contacter à l'avance pour vérifier la disponibilité.
                    </div>
                </div>
            </div>

            <!-- Question 5 -->
            <div class="faq-item border-b border-gray-300">
                <button class="faq-question w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition">
                    <span class="text-lg text-gray-900 font-normal pr-8">Peut-on partir après 10h ?</span>
                    <div class="faq-icon flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                    <div class="pb-5 pr-12 text-gray-600 leading-relaxed">
                        Le check-out standard est à 10h. Un late check-out peut être organisé selon la disponibilité, moyennant un supplément. Contactez-nous au moins 24h à l'avance pour faire votre demande.
                    </div>
                </div>
            </div>

            <!-- Question 6 -->
            <div class="faq-item border-b border-gray-300">
                <button class="faq-question w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition">
                    <span class="text-lg text-gray-900 font-normal pr-8">Y-a-t-il une personne sur place 24h/24 ?</span>
                    <div class="faq-icon flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                    <div class="pb-5 pr-12 text-gray-600 leading-relaxed">
                        Oui, notre service de sécurité est présent 24h/24 et 7j/7. Notre équipe de conciergerie est également joignable à tout moment pour répondre à vos besoins et assurer votre confort durant votre séjour.
                    </div>
                </div>
            </div>

            <!-- Question 7 -->
            <div class="faq-item border-b border-gray-300">
                <button class="faq-question w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition">
                    <span class="text-lg text-gray-900 font-normal pr-8">Est-ce que la résidence dispose de la climatisation ?</span>
                    <div class="faq-icon flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                    <div class="pb-5 pr-12 text-gray-600 leading-relaxed">
                        Oui, tous nos appartements sont équipés de la climatisation réversible pour votre confort optimal. Vous pouvez régler la température selon vos préférences dans chaque pièce.
                    </div>
                </div>
            </div>

            <!-- Question 8 -->
            <div class="faq-item border-b border-gray-300">
                <button class="faq-question w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition">
                    <span class="text-lg text-gray-900 font-normal pr-8">Y-a-t-il un ascenseur dans l'immeuble ?</span>
                    <div class="faq-icon flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                    <div class="pb-5 pr-12 text-gray-600 leading-relaxed">
                        Oui, la résidence dispose d'un ascenseur moderne et spacieux pour faciliter l'accès à tous les étages. L'immeuble est également accessible aux personnes à mobilité réduite.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




    <script>
        // FAQ Accordion functionality
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const faqItem = button.parentElement;
                const answer = faqItem.querySelector('.faq-answer');
                const icon = button.querySelector('.faq-icon svg');
                const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

                // Close all other FAQs
                document.querySelectorAll('.faq-item').forEach(item => {
                    if (item !== faqItem) {
                        const otherAnswer = item.querySelector('.faq-answer');
                        const otherIcon = item.querySelector('.faq-icon svg');
                        otherAnswer.style.maxHeight = '0px';
                        otherIcon.style.transform = 'rotate(0deg)';
                    }
                });

                // Toggle current FAQ
                if (isOpen) {
                    answer.style.maxHeight = '0px';
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    icon.style.transform = 'rotate(45deg)';
                }
            });
        });

        // Scroll animation for apartment cards
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.apartment-card').forEach(card => {
            observer.observe(card);
        });

        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

<?php include 'includes/footer.php'; ?>
