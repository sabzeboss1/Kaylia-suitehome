<?php
$pageTitle = "Réserver - Kaylia Suite Home";
include 'includes/header.php';
?>

<!-- Reservation Page -->
<section class="bg-[#c9b5a0] pt-8 md:pt-12 pb-4">
    <div class="container mx-auto px-6 md:px-20">
        <!-- Progress Steps -->
        <div class="flex items-center justify-start gap-4 md:gap-8 mb-8">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                </div>
                <span class="text-sm text-gray-900 font-medium">Tarif</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-sm text-gray-600">Récapitulatif</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-sm text-gray-600">Réservé</span>
            </div>
        </div>
    </div>

    <!-- Image Gallery Carousel - Full Width -->
    <div class="relative mb-8 overflow-hidden">
        <!-- Carousel Container -->
        <div class="flex justify-center">
            <div class="w-full max-w-6xl px-4 md:px-8">
                <div class="overflow-visible">
                    <div id="carouselTrack" class="flex transition-transform duration-500 ease-in-out">
                        <!-- Slide 1 -->
                        <div class="carousel-slide flex-shrink-0 w-full px-2">
                            <div class="grid grid-cols-2 gap-1">
                                <div class="relative h-48 md:h-80 lg:h-96">
                                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80" 
                                         alt="Salon de l'appartement" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="relative h-48 md:h-80 lg:h-96">
                                    <img src="https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=800&q=80" 
                                         alt="Salle de bain" 
                                         class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="carousel-slide flex-shrink-0 w-full px-2">
                            <div class="grid grid-cols-2 gap-1">
                                <div class="relative h-48 md:h-80 lg:h-96">
                                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&q=80" 
                                         alt="Cuisine" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="relative h-48 md:h-80 lg:h-96">
                                    <img src="https://images.unsplash.com/photo-1540518614846-7eded433c457?w=800&q=80" 
                                         alt="Chambre" 
                                         class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="carousel-slide flex-shrink-0 w-full px-2">
                            <div class="grid grid-cols-2 gap-1">
                                <div class="relative h-48 md:h-80 lg:h-96">
                                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=800&q=80" 
                                         alt="Balcon" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="relative h-48 md:h-80 lg:h-96">
                                    <img src="https://images.unsplash.com/photo-1484101403633-562f891dc89a?w=800&q=80" 
                                         alt="Salle à manger" 
                                         class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Arrows - Bottom Right -->
        <div class="absolute bottom-4 right-4 md:right-8 flex gap-2 z-10">
            <button onclick="prevSlide()" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button onclick="nextSlide()" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="container mx-auto px-6 md:px-20">

        <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const totalSlides = slides.length;

        function updateCarousel() {
            const track = document.getElementById('carouselTrack');
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateCarousel();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateCarousel();
        }
        </script>

        <!-- Apartment Features -->
        <div class="flex flex-wrap items-center justify-between gap-4 md:gap-6">
            <div class="flex flex-wrap items-center gap-4 md:gap-6">
                <!-- Capacity -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 border-2 border-gray-900 bg-white rounded flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-900 font-medium">4 personnes</span>
                </div>

                <!-- Surface -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 border-2 border-gray-900 bg-white rounded flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-900 font-medium">40m²</span>
                </div>

                <!-- Beds -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 border-2 border-gray-900 bg-white rounded flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-900 font-medium">2 lits King Size</span>
                </div>

                <!-- Floor -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 border-2 border-gray-900 bg-white rounded flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-900 font-medium">2e étage</span>
                </div>
            </div>

            <!-- Navigation Arrows for Mobile -->
            <div class="flex gap-2 md:hidden">
                <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Section -->
<section class="bg-white py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">
            <!-- Left Column - Apartment Details -->
            <div class="lg:col-span-3 space-y-6 md:space-y-8">
                <!-- Apartment Description -->
                <div>
                    <h2 class="text-xl md:text-2xl font-serif font-bold text-gray-900 mb-3 md:mb-4">Appartement X</h2>
                    <p class="text-sm md:text-base text-gray-700 leading-relaxed">
                        Lorem ipsum dolor sit amet. Et adipisci neque eos quam temporis est voluptatem 
                        consequatur qui laboris tempore. Rem voluptatem voluptatem et voluptatem 
                        voluptatem qui voluptatem voluptatem. Qui voluptatem voluptatem et voluptatem 
                        praesentium aut rerum facilis qui ut eos consequatur. Eum quasi voluptatem 
                        voluptatem sed dolor sed dicta voluptatem sed eos ipsum et voluptatem 
                        voluptatem non aperiam aut.
                    </p>
                </div>

                <!-- Les équipements -->
                <div>
                    <h3 class="text-lg md:text-xl font-serif font-bold text-gray-900 mb-4 md:mb-6">Les équipements</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                        <!-- Row 1 -->
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 10.5h-3v-3c0-.83-.67-1.5-1.5-1.5h-9C6.67 6 6 6.67 6 7.5v3H3c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h3v1.5c0 .83.67 1.5 1.5 1.5h9c.83 0 1.5-.67 1.5-1.5V18.5h3c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Baignoire</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 6V4h2V2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14v-2h-4.03A4.966 4.966 0 0018 16v-5H8v5c0 1.64.81 3.09 2.03 4H6V4h2v2c0 .55.45 1 1 1h8c.55 0 1-.45 1-1z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Machine à café</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5h2v14H8zm6 0h2v14h-2z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Lave-vaisselle</span>
                        </div>

                        <!-- Row 2 -->
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.1-.9-2-2-2zm0 14H3V5h18v12z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">TV</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Machine à laver</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Four micro-ondes</span>
                        </div>

                        <!-- Row 3 -->
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <rect x="4" y="4" width="16" height="16" rx="2"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Four</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 2.01L6 2c-1.1 0-2 .89-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.11-.9-1.99-2-1.99zM18 20H6v-9.02h12V20z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Cuisine équipée</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 11c0-.55-.45-1-1-1h-3.17l1.24-1.24c.39-.39.39-1.02 0-1.41-.39-.39-1.02-.39-1.41 0L14 10h-4L7.34 7.34c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41L7.17 10H4c-.55 0-1 .45-1 1s.45 1 1 1h3.17l-1.24 1.24c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0L10 12h4l2.66 2.66c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L16.83 12H20c.55 0 1-.45 1-1z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Fer à repasser</span>
                        </div>

                        <!-- Row 4 -->
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79c1.31-1.05 2.87-1.81 4.59-2.18l.07-.02zM1 10.5h3v2H1v-2zM11 .55h2V3.5h-2V.55zm8.04 2.495l1.408 1.407-1.79 1.79c-1.05-1.31-1.81-2.87-2.18-4.59l.02-.07 1.79 1.8zm-1.8 15.115l1.79 1.8 1.41-1.41-1.8-1.79c-1.05 1.31-1.81 2.87-2.18 4.59l.02.07 1.79-1.8zM20 10.5h3v2h-3v-2zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Climatisation</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.17 6l2 2H20v10H4V6h5.17M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Savon et shampooing</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 6V4h2V2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14v-2h-4.03A4.966 4.966 0 0018 16v-5H8v5c0 1.64.81 3.09 2.03 4H6V4h2v2c0 .55.45 1 1 1h8c.55 0 1-.45 1-1z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Bouilloire</span>
                        </div>

                        <!-- Row 5 -->
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 11c0-.55-.45-1-1-1h-3.17l1.24-1.24c.39-.39.39-1.02 0-1.41-.39-.39-1.02-.39-1.41 0L14 10h-4L7.34 7.34c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41L7.17 10H4c-.55 0-1 .45-1 1s.45 1 1 1h3.17l-1.24 1.24c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0L10 12h4l2.66 2.66c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L16.83 12H20c.55 0 1-.45 1-1z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Repassage</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 20H4v-4h4v4zm0-6H4v-4h4v4zm0-6H4V4h4v4zm6 12h-4v-4h4v4zm0-6h-4v-4h4v4zm0-6h-4V4h4v4zm6 12h-4v-4h4v4zm0-6h-4v-4h4v4zm0-6h-4V4h4v4z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Draps et serviettes</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">WIFI</span>
                        </div>

                        <!-- Row 6 -->
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 2.01L6 2c-1.1 0-2 .89-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.11-.9-1.99-2-1.99zM18 20H6V4h12v16z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Réfrigérateur</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5.5-2.5l7.51-3.49L17.5 6.5 9.99 9.99 6.5 17.5zm5.5-6.6c.61 0 1.1.49 1.1 1.1s-.49 1.1-1.1 1.1-1.1-.49-1.1-1.1.49-1.1 1.1-1.1z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Vaisselles</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 11v2h10v-2H7zm5-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                </svg>
                            </div>
                            <span class="text-xs md:text-sm text-gray-700">Chaise bébé</span>
                        </div>
                    </div>
                </div>

                <!-- Autour de vous -->
                <div>
                    <h3 class="text-lg md:text-xl font-serif font-bold text-gray-900 mb-3 md:mb-4">Autour de vous</h3>
                    <ul class="space-y-2 text-sm md:text-base text-gray-700">
                        <li class="flex items-start gap-2">
                            <span class="text-gray-900">•</span>
                            <span>Lorem ipsum dolor sit amet. Et adipisci neque eos quam temporis</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-gray-900">•</span>
                            <span>Quia eligendi est laborum tempore aut voluptatem officia est quam</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-gray-900">•</span>
                            <span>Neque est ratione voluptatem qui voluptatem voluptatem</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-gray-900">•</span>
                            <span>Quia recusandae qui dicta dolore sed dicta voluptatem sed eos ipsum et</span>
                        </li>
                    </ul>
                </div>

                <!-- Vidéo -->
                <div>
                    <h3 class="text-lg md:text-xl font-serif font-bold text-gray-900 mb-3 md:mb-4">Vidéo</h3>
                    <div class="bg-gray-200 rounded-lg h-48 md:h-64 lg:h-80 flex items-center justify-center">
                        <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Right Column - Booking Panel -->
            <div class="lg:col-span-2">
                <div class="bg-[#c9b5a0] rounded-lg p-4 md:p-5 lg:sticky lg:top-4 space-y-5">
                    <!-- Vos informations -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Vos informations</h3>
                        <div class="border-2 border-gray-800 rounded bg-[#d4c4b0] p-3">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between text-xs text-gray-900 pb-3 border-b border-gray-600">
                                    <span>Jour d'entrée</span>
                                    <span class="text-gray-500">━━━━━</span>
                                    <span>Jour de départ</span>
                                </div>
                                <div class="pt-1 space-y-3 border-b border-gray-600 pb-3">
                                    <div class="text-xs text-gray-900 font-medium">
                                        Appartement X
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-900">Adultes</span>
                                        <div class="flex items-center gap-2">
                                            <button class="w-6 h-6 bg-primary-blue text-white rounded-full flex items-center justify-center text-sm font-bold">-</button>
                                            <span class="text-sm text-gray-900 font-medium w-4 text-center">2</span>
                                            <button class="w-6 h-6 bg-primary-blue text-white rounded-full flex items-center justify-center text-sm font-bold">+</button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-900">Enfants (0 à 18 ans)</span>
                                        <div class="flex items-center gap-2">
                                            <button class="w-6 h-6 bg-primary-blue text-white rounded-full flex items-center justify-center text-sm font-bold">-</button>
                                            <span class="text-sm text-gray-900 font-medium w-4 text-center">1</span>
                                            <button class="w-6 h-6 bg-primary-blue text-white rounded-full flex items-center justify-center text-sm font-bold">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Options confort+ -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Options confort+</h3>
                        <div class="border-2 border-gray-800 rounded p-3 space-y-2">
                            <!-- Option 1 -->
                            <div class="bg-[#d4c4b0] rounded p-2 flex items-center gap-2">
                                <img src="https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=100&q=80" 
                                     alt="Ménage - Chambre" 
                                     class="w-14 h-14 object-cover rounded flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-900 font-medium leading-tight">Ménage - Chambre</p>
                                    <p class="text-xs text-gray-900 mt-0.5">
                                        <span class="font-bold">15,00€</span><span class="font-normal">/nuit</span>
                                    </p>
                                </div>
                                <input type="checkbox" class="w-4 h-4 flex-shrink-0 accent-primary-blue">
                            </div>

                            <!-- Option 2 -->
                            <div class="bg-[#d4c4b0] rounded p-2 flex items-center gap-2">
                                <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=100&q=80" 
                                     alt="Ménage - Tout l'appartement" 
                                     class="w-14 h-14 object-cover rounded flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-900 font-medium leading-tight">Ménage - Tout l'appartement</p>
                                    <p class="text-xs text-gray-900 mt-0.5">
                                        <span class="font-bold">25,00€</span><span class="font-normal">/nuit</span>
                                    </p>
                                </div>
                                <input type="checkbox" class="w-4 h-4 flex-shrink-0 accent-primary-blue">
                            </div>

                            <!-- Option 3 -->
                            <div class="bg-[#d4c4b0] rounded p-2 flex items-center gap-2">
                                <img src="https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=100&q=80" 
                                     alt="Ménage - Chambre" 
                                     class="w-14 h-14 object-cover rounded flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-900 font-medium leading-tight">Ménage - Chambre</p>
                                    <p class="text-xs text-gray-900 mt-0.5">
                                        <span class="font-bold">25,00€</span><span class="font-normal">/nuit</span>
                                    </p>
                                </div>
                                <input type="checkbox" class="w-4 h-4 flex-shrink-0 accent-primary-blue">
                            </div>

                            <!-- Option 4 -->
                            <div class="bg-[#d4c4b0] rounded p-2 flex items-center gap-2">
                                <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=100&q=80" 
                                     alt="Ménage - Tout l'appartement" 
                                     class="w-14 h-14 object-cover rounded flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-900 font-medium leading-tight">Ménage - Tout l'appartement</p>
                                    <p class="text-xs text-gray-900 mt-0.5">
                                        <span class="font-bold">25,00€</span><span class="font-normal">/nuit</span>
                                    </p>
                                </div>
                                <input type="checkbox" class="w-4 h-4 flex-shrink-0 accent-primary-blue">
                            </div>
                        </div>
                    </div>

                    <!-- Vin & confiseries -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Vin & confiseries</h3>
                        <div class="border-2 border-gray-800 rounded p-3 space-y-2">
                            <!-- Item 1 -->
                            <div class="bg-[#d4c4b0] rounded p-2 flex items-center gap-2">
                                <img src="https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=100&q=80" 
                                     alt="Bouteille de vin rouge" 
                                     class="w-14 h-14 object-cover rounded flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-900 font-medium leading-tight">Bouteille de vin rouge</p>
                                    <p class="text-xs text-gray-900 mt-0.5 font-bold">30,00€</p>
                                </div>
                                <input type="checkbox" class="w-4 h-4 flex-shrink-0 accent-primary-blue">
                            </div>

                            <!-- Item 2 -->
                            <div class="bg-[#d4c4b0] rounded p-2 flex items-center gap-2">
                                <img src="https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=100&q=80" 
                                     alt="Bouteille de vin blanc" 
                                     class="w-14 h-14 object-cover rounded flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-900 font-medium leading-tight">Bouteille de vin blanc</p>
                                    <p class="text-xs text-gray-900 mt-0.5 font-bold">30,00€</p>
                                </div>
                                <input type="checkbox" class="w-4 h-4 flex-shrink-0 accent-primary-blue">
                            </div>

                            <!-- Item 3 -->
                            <div class="bg-[#d4c4b0] rounded p-2 flex items-center gap-2">
                                <img src="https://images.unsplash.com/photo-1481391319762-47dff72954d9?w=100&q=80" 
                                     alt="Panier gourmand" 
                                     class="w-14 h-14 object-cover rounded flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-900 font-medium leading-tight">Panier gourmand</p>
                                    <p class="text-xs text-gray-900 mt-0.5 font-bold">25,00€</p>
                                </div>
                                <input type="checkbox" class="w-4 h-4 flex-shrink-0 accent-primary-blue">
                            </div>
                        </div>
                    </div>

                    <!-- Tarif -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Tarif</h3>
                        <div class="border-2 border-gray-800 rounded p-3 space-y-2">
                            <!-- Tarif flexible -->
                            <div class="bg-[#d4c4b0] rounded p-3">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div class="flex-1">
                                        <p class="text-xs font-medium text-gray-900 mb-1">Tarif - flexible</p>
                                        <p class="text-[10px] text-gray-700 leading-relaxed">
                                            Lorem ipsum dolor sit amet. Et adipisci neque eos quam temporis est voluptatem 
                                            consequatur qui laboris tempore. Rem voluptatem voluptatem et voluptatem.
                                        </p>
                                    </div>
                                    <input type="radio" name="tarif" class="w-4 h-4 mt-0.5 flex-shrink-0 accent-primary-blue" checked>
                                </div>
                                <p class="text-sm font-bold text-gray-900">192€<span class="text-xs font-normal">/nuit</span></p>
                            </div>

                            <!-- Tarif paiement sur place -->
                            <div class="bg-[#d4c4b0] rounded p-3">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div class="flex-1">
                                        <p class="text-xs font-medium text-gray-900 mb-1">Tarif - paiement sur place</p>
                                        <p class="text-[10px] text-gray-700 leading-relaxed">
                                            Lorem ipsum dolor sit amet. Et adipisci neque eos quam temporis est voluptatem 
                                            consequatur qui laboris tempore. Rem voluptatem voluptatem et voluptatem.
                                        </p>
                                    </div>
                                    <input type="radio" name="tarif" class="w-4 h-4 mt-0.5 flex-shrink-0 accent-gray-400">
                                </div>
                                <p class="text-sm font-bold text-gray-900">170€<span class="text-xs font-normal">/nuit</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Résumé -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Résumé</h3>
                        <div class="border-2 border-gray-800 rounded p-3 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-900">
                                    <span class="font-bold">192€</span><span class="font-normal">/nuit</span>
                                </span>
                                <span class="text-base font-bold text-gray-900">4 298€</span>
                            </div>
                            <div class="text-xs text-gray-700">
                                28 nuits
                            </div>
                            
                            <!-- Code promo -->
                            <div class="space-y-1.5">
                                <label class="text-xs text-gray-900 font-medium">Code promo</label>
                                <div class="flex gap-2">
                                    <input type="text" 
                                           class="flex-1 px-2 py-1.5 bg-white border border-gray-300 rounded text-xs"
                                           placeholder="">
                                    <button class="px-3 py-1.5 bg-primary-blue text-white rounded text-xs font-medium hover:bg-opacity-90 transition">
                                        Appliquer
                                    </button>
                                </div>
                            </div>

                            <!-- Suivant button -->
                            <button onclick="openPaymentModal()" class="w-full py-2 bg-white text-gray-900 rounded text-sm font-medium hover:bg-gray-100 transition mt-3">
                                Suivant
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Payment Modal -->
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-[#2c4a4e] rounded-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
        <!-- Close Button -->
        <button onclick="closePaymentModal()" class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition z-10">
            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Form Content -->
        <div class="p-6 md:p-10">
            <form class="space-y-6">
                <!-- Row 1: Nom & Prénom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label class="block text-white text-sm mb-2">Nom*</label>
                        <input type="text" 
                               placeholder="Votre nom" 
                               class="w-full px-4 py-3 rounded bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-blue">
                    </div>
                    <div>
                        <label class="block text-white text-sm mb-2">Prénom*</label>
                        <input type="text" 
                               placeholder="Votre prénom" 
                               class="w-full px-4 py-3 rounded bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-blue">
                    </div>
                </div>

                <!-- Row 2: Email & Téléphone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label class="block text-white text-sm mb-2">Adresse mail*</label>
                        <input type="email" 
                               placeholder="ex : nom.mail@hotmail.fr" 
                               class="w-full px-4 py-3 rounded bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-blue">
                    </div>
                    <div>
                        <label class="block text-white text-sm mb-2">Numéro de téléphone*</label>
                        <input type="tel" 
                               placeholder="ex : 06 00 00 00 00 ou +237 000" 
                               class="w-full px-4 py-3 rounded bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-blue">
                    </div>
                </div>

                <!-- Row 3: Nationalité -->
                <div>
                    <label class="block text-white text-sm mb-2">Nationalité</label>
                    <input type="text" 
                           placeholder="Votre nationalité" 
                           class="w-full px-4 py-3 rounded bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-blue">
                </div>

                <!-- Row 4: Demandes spéciales -->
                <div>
                    <label class="block text-white text-sm mb-2">Demandes spéciales</label>
                    <textarea rows="5" 
                              placeholder="Entrée votre message" 
                              class="w-full px-4 py-3 rounded bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-blue resize-none"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center pt-4">
                    <button type="submit" 
                            class="px-12 py-3 bg-white text-gray-900 rounded text-base font-medium hover:bg-gray-100 transition">
                        Procéder au paiement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openPaymentModal() {
    document.getElementById('paymentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentModal();
    }
});

// Carousel functionality
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const totalSlides = slides.length;

function updateCarousel() {
    const track = document.getElementById('carouselTrack');
    track.style.transform = `translateX(-${currentSlide * 100}%)`;
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
}
</script>

<!-- Promotional Section -->
<section class="bg-[#b8a088] py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 md:px-6 text-center">
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-serif text-gray-900 leading-relaxed">
            Réserver chez nous c'est la garantis d'un <span class="italic">service personnalisé</span><br class="hidden md:block">
            et des <span class="italic">tarifs avantageux.</span>
        </h2>
    </div>
</section>

<!-- Newsletter Section -->
<section class="bg-gray-100 py-12 md:py-16">
    <div class="max-w-3xl mx-auto px-4 md:px-6 text-center">
        <h2 class="text-xl md:text-2xl lg:text-3xl font-serif text-gray-900 mb-3 md:mb-4">
            Inscrivez-vous à notre <span class="text-primary-blue">newsletter</span> et recevez nos codes promos
        </h2>
        <p class="text-sm md:text-base text-gray-600 mb-6 md:mb-8">
            Recevez des offres exclusives et restez informé de nos actualités.
        </p>
        
        <!-- Newsletter Form -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center items-center mb-6">
            <input type="email" 
                   placeholder="Votre adresse email" 
                   class="w-full sm:w-96 px-4 py-3 border border-gray-300 rounded text-sm focus:outline-none focus:border-primary-blue">
            <button class="w-full sm:w-auto px-8 py-3 bg-primary-blue text-white rounded text-sm font-medium hover:bg-opacity-90 transition">
                S'inscrire
            </button>
        </div>
        
        <!-- Consent Checkbox -->
        <div class="flex items-start justify-center gap-2 text-left max-w-2xl mx-auto">
            <input type="checkbox" 
                   id="newsletter-consent" 
                   class="w-4 h-4 mt-0.5 flex-shrink-0 accent-primary-blue">
            <label for="newsletter-consent" class="text-xs md:text-sm text-gray-600">
                En cochant cette case, je consens à l'utilisation des informations fournies à des fins de marketing par e-mail.
            </label>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
