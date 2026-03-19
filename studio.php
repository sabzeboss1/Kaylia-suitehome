<?php
$pageTitle = "Studio - Kaylia Suite Home";
include 'includes/header.php';
?>

<!-- Hero Section with Building Image -->
<section class="relative h-[25vh] md:h-[30vh] bg-cover bg-center flex items-center" style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22><rect fill=%22%23556b7d%22 width=%221200%22 height=%22600%22/></svg>');">
    <div class="container mx-auto px-6 md:px-20">
        <h1 class="text-white font-serif text-2xl md:text-4xl font-light leading-tight max-w-3xl">
            Le studio Chez Kaylia Suite Home<br>s'adapte à votre séjour
        </h1>
    </div>
</section>

<!-- Image Gallery Carousel Section -->
<section class="bg-white py-0">
    <div class="relative">
        <!-- Main Carousel Container -->
        <div class="studio-carousel relative overflow-hidden">
            <!-- Slides Container -->
            <div class="flex transition-transform duration-500 ease-in-out" id="carouselTrack">
                <!-- Slide 1 -->
                <div class="min-w-full relative">
                    <div class="relative h-[400px] md:h-[450px] bg-cover bg-center" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22><rect fill=%22%23e5e5e5%22 width=%221200%22 height=%22600%22/></svg>');">
                        <!-- KAYLIA Logo Overlay -->
                        <div class="absolute top-6 left-1/2 transform -translate-x-1/2 text-center">
                            <div class="font-serif text-3xl md:text-4xl tracking-[0.3em] text-gray-800">
                                KAYLIA
                            </div>
                            <div class="text-xs tracking-[0.4em] text-gray-600 mt-1">
                                SUITE HOME
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="min-w-full relative">
                    <div class="relative h-[400px] md:h-[450px] bg-cover bg-center" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22><rect fill=%22%23d5d5d5%22 width=%221200%22 height=%22600%22/></svg>');">
                        <!-- KAYLIA Logo Overlay -->
                        <div class="absolute top-6 left-1/2 transform -translate-x-1/2 text-center">
                            <div class="font-serif text-3xl md:text-4xl tracking-[0.3em] text-gray-800">
                                KAYLIA
                            </div>
                            <div class="text-xs tracking-[0.4em] text-gray-600 mt-1">
                                SUITE HOME
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="min-w-full relative">
                    <div class="relative h-[400px] md:h-[450px] bg-cover bg-center" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22><rect fill=%22%23c5c5c5%22 width=%221200%22 height=%22600%22/></svg>');">
                        <!-- KAYLIA Logo Overlay -->
                        <div class="absolute top-6 left-1/2 transform -translate-x-1/2 text-center">
                            <div class="font-serif text-3xl md:text-4xl tracking-[0.3em] text-gray-800">
                                KAYLIA
                            </div>
                            <div class="text-xs tracking-[0.4em] text-gray-600 mt-1">
                                SUITE HOME
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <button id="prevBtn" class="absolute left-4 md:left-8 top-1/2 transform -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition z-10">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button id="nextBtn" class="absolute right-4 md:right-8 top-1/2 transform -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition z-10">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Dots Indicator -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-10">
                <button class="carousel-dot w-2 h-2 rounded-full bg-white opacity-50 hover:opacity-100 transition" data-slide="0"></button>
                <button class="carousel-dot w-2 h-2 rounded-full bg-white opacity-50 hover:opacity-100 transition" data-slide="1"></button>
                <button class="carousel-dot w-2 h-2 rounded-full bg-white opacity-50 hover:opacity-100 transition" data-slide="2"></button>
            </div>
        </div>
    </div>
</section>

<!-- Info Bar with Reservation -->
<section class="bg-white border-t border-b border-gray-200 py-5">
    <div class="container mx-auto px-6 md:px-20">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <!-- Left Side - Features -->
            <div class="flex flex-wrap items-center gap-4 md:gap-8">
                <!-- Capacity -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-900 font-medium">2 personnes</span>
                </div>

                <!-- Surface -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-900 font-medium">40m²</span>
                </div>

                <!-- Bed -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-900 font-medium">1 lit King Size</span>
                </div>

                <!-- Floor -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 border-2 border-gray-800 bg-white rounded flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-900 font-medium">1er étage</span>
                </div>
            </div>

            <!-- Right Side - Price & CTA (No gap between buttons) -->
            <div class="flex items-stretch w-full md:w-auto">
                <!-- Price Button -->
                <div class="bg-[#b8a088] text-white px-6 py-3 flex flex-col justify-center items-center rounded-l">
                    <div class="text-xs font-normal whitespace-nowrap">À partir de</div>
                    <div class="text-2xl font-bold whitespace-nowrap">70€</div>
                </div>
                <!-- Reserve Button -->
                <a href="reserver.php" class="bg-primary-blue hover:bg-[#086780] text-white px-8 py-3 flex items-center justify-center rounded-r text-sm font-semibold transition whitespace-nowrap">
                    Réserver
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Description and FAQ Section -->
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 md:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Left Column - Description & Video -->
            <div>
                <!-- Description -->
                <div class="mb-12">
                    <h2 class="font-serif text-3xl md:text-4xl font-light text-gray-900 mb-6">
                        Un studio pensé pour<br>votre confort
                    </h2>
                    <p class="text-gray-600 leading-relaxed text-base">
                        Lorem ipsum dolor sit amet. Et adipisci rerum hic suscipit tempore aut quasi eligendi est Lorem temporibus aut voluptatibus officia id quasi verum. Est rerum illo aut adipisci suscipit vel voluptatibus natus. Cum praesertium necessitatibus et quas temetur est rerum excepturi. Cum quas recusandae qui quis dolore est dicta voluptatum nerum itaque vel inventore laudantium non cupiditate aut...
                    </p>
                </div>

                <!-- Video Section -->
                <div>
                    <h3 class="font-serif text-2xl md:text-3xl font-light text-gray-900 mb-6">Vidéo</h3>
                    <div class="relative bg-gray-200 rounded-lg overflow-hidden aspect-video flex items-center justify-center cursor-pointer hover:bg-gray-300 transition group">
                        <!-- Video Placeholder -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-400 group-hover:text-gray-500 transition" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - FAQ -->
            <div>
                <div class="space-y-0">
                    <!-- FAQ Item 1 -->
                    <div class="faq-item-studio border-b border-gray-300">
                        <button class="faq-question-studio w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition group">
                            <span class="text-base text-gray-900 font-normal pr-8">Comment accéder à mon appartement le jour de mon arrivée ?</span>
                            <div class="faq-icon-studio flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-studio max-h-0 overflow-hidden transition-all duration-300">
                            <div class="pb-5 pr-12 text-gray-600 leading-relaxed text-sm">
                                Vous recevrez toutes les instructions d'accès par email 24h avant votre arrivée. Un code d'accès personnel vous sera fourni pour entrer dans la résidence et votre appartement.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="faq-item-studio border-b border-gray-300">
                        <button class="faq-question-studio w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition group">
                            <span class="text-base text-gray-900 font-normal pr-8">Le ménage est-il fait tous les jours ?</span>
                            <div class="faq-icon-studio flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-studio max-h-0 overflow-hidden transition-all duration-300">
                            <div class="pb-5 pr-12 text-gray-600 leading-relaxed text-sm">
                                Le ménage est effectué avant votre arrivée et après votre départ. Pour les séjours de plus de 7 jours, un service de ménage hebdomadaire est inclus.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="faq-item-studio border-b border-gray-300">
                        <button class="faq-question-studio w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition group">
                            <span class="text-base text-gray-900 font-normal pr-8">Y a-t-il une bagagerie dans la résidence ?</span>
                            <div class="faq-icon-studio flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-studio max-h-0 overflow-hidden transition-all duration-300">
                            <div class="pb-5 pr-12 text-gray-600 leading-relaxed text-sm">
                                Oui, nous disposons d'une bagagerie sécurisée gratuite. Vous pouvez déposer vos bagages avant le check-in ou après le check-out.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="faq-item-studio border-b border-gray-300">
                        <button class="faq-question-studio w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition group">
                            <span class="text-base text-gray-900 font-normal pr-8">Peut-on arriver avant 15h ?</span>
                            <div class="faq-icon-studio flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-studio max-h-0 overflow-hidden transition-all duration-300">
                            <div class="pb-5 pr-12 text-gray-600 leading-relaxed text-sm">
                                Le check-in standard est à partir de 15h. Un early check-in peut être possible selon la disponibilité de l'appartement, moyennant un supplément.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="faq-item-studio border-b border-gray-300">
                        <button class="faq-question-studio w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition group">
                            <span class="text-base text-gray-900 font-normal pr-8">Peut-on partir après 10h ?</span>
                            <div class="faq-icon-studio flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-studio max-h-0 overflow-hidden transition-all duration-300">
                            <div class="pb-5 pr-12 text-gray-600 leading-relaxed text-sm">
                                Le check-out standard est à 10h. Un late check-out peut être organisé selon la disponibilité, moyennant un supplément.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 6 -->
                    <div class="faq-item-studio border-b border-gray-300">
                        <button class="faq-question-studio w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition group">
                            <span class="text-base text-gray-900 font-normal pr-8">Y-a-t-il une personne sur place 24h/24 ?</span>
                            <div class="faq-icon-studio flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-studio max-h-0 overflow-hidden transition-all duration-300">
                            <div class="pb-5 pr-12 text-gray-600 leading-relaxed text-sm">
                                Oui, notre service de sécurité est présent 24h/24 et 7j/7. Notre équipe de conciergerie est également joignable à tout moment.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 7 -->
                    <div class="faq-item-studio border-b border-gray-300">
                        <button class="faq-question-studio w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition group">
                            <span class="text-base text-gray-900 font-normal pr-8">Est-ce que la résidence dispose de la climatisation ?</span>
                            <div class="faq-icon-studio flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-studio max-h-0 overflow-hidden transition-all duration-300">
                            <div class="pb-5 pr-12 text-gray-600 leading-relaxed text-sm">
                                Oui, tous nos appartements sont équipés de la climatisation réversible pour votre confort optimal.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 8 -->
                    <div class="faq-item-studio border-b border-gray-300">
                        <button class="faq-question-studio w-full flex items-center justify-between py-5 text-left hover:text-primary-blue transition group">
                            <span class="text-base text-gray-900 font-normal pr-8">Y-a-t-il un ascenseur dans l'immeuble ?</span>
                            <div class="faq-icon-studio flex-shrink-0 w-10 h-10 bg-primary-blue rounded-full flex items-center justify-center text-white">
                                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-studio max-h-0 overflow-hidden transition-all duration-300">
                            <div class="pb-5 pr-12 text-gray-600 leading-relaxed text-sm">
                                Oui, la résidence dispose d'un ascenseur moderne et spacieux pour faciliter l'accès à tous les étages.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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


<script>
    // FAQ Accordion functionality for studio page
    document.querySelectorAll('.faq-question-studio').forEach(button => {
        button.addEventListener('click', () => {
            const faqItem = button.parentElement;
            const answer = faqItem.querySelector('.faq-answer-studio');
            const icon = button.querySelector('.faq-icon-studio svg');
            const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

            // Close all other FAQs
            document.querySelectorAll('.faq-item-studio').forEach(item => {
                if (item !== faqItem) {
                    const otherAnswer = item.querySelector('.faq-answer-studio');
                    const otherIcon = item.querySelector('.faq-icon-studio svg');
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

    // Carousel functionality
    let currentSlide = 0;
    const track = document.getElementById('carouselTrack');
    const dots = document.querySelectorAll('.carousel-dot');
    const totalSlides = 3;

    function updateCarousel() {
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Update dots
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.remove('opacity-50');
                dot.classList.add('opacity-100');
            } else {
                dot.classList.remove('opacity-100');
                dot.classList.add('opacity-50');
            }
        });
    }

    document.getElementById('prevBtn').addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateCarousel();
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    });

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateCarousel();
        });
    });

    // Initialize
    updateCarousel();

    // Auto-play (optional)
    setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    }, 5000);
</script>

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

<?php include 'includes/footer.php'; ?>
