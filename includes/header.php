<?php
// Charger la configuration
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : SITE_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@0;1&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="font-sans">
    <header class="bg-[#2c3e4f] text-white">
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="index.php" class="font-serif text-2xl tracking-[0.2em] leading-tight">
                    KAYLIA<br>
                    <span class="text-xs font-light tracking-[0.3em]">SUITE HOME</span>
                </a>
            </div>

            <!-- Navigation Menu -->
            <ul class="hidden lg:flex items-center space-x-8 text-sm font-medium">
                <li class="relative group">
                    <a href="appartement.php" class="hover:text-gray-300 flex items-center transition">
                        Nos Appartements
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <!-- Dropdown Menu -->
                    <div class="absolute left-0 top-full mt-2 w-56 bg-[#c9b5a0] rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <ul class="py-3">
                            <li>
                                <a href="studio.php" class="block px-6 py-3 text-gray-900 hover:bg-[#b8a088] transition text-base font-normal">Studio</a>
                            </li>
                            <li class="border-t border-gray-400 my-1"></li>
                            <li>
                                <a href="appartement-t2.php" class="block px-6 py-3 text-gray-900 hover:bg-[#b8a088] transition text-base font-normal">Appartement T2</a>
                            </li>
                            <li class="border-t border-gray-400 my-1"></li>
                            <li>
                                <a href="appartement-t3.php" class="block px-6 py-3 text-gray-900 hover:bg-[#b8a088] transition text-base font-normal">Appartement T3</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="relative group">
                    <a href="sejours.php" class="hover:text-gray-300 flex items-center transition">
                        Séjours
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="spa.php" class="hover:text-gray-300 transition">Notre SPA</a>
                </li>
                <li>
                    <a href="histoire.php" class="hover:text-gray-300 transition">Notre Histoire</a>
                </li>
                <li>
                    <a href="contact.php" class="hover:text-gray-300 transition">Contact</a>
                </li>
            </ul>

            <!-- Language & CTA -->
            <div class="hidden lg:flex items-center space-x-4">
                <div class="relative group">
                    <button class="flex items-center hover:text-gray-300 transition text-sm font-medium">
                        FR
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                <a href="reserver.php" class="bg-[#107c96] hover:bg-[#0d6278] text-white px-6 py-2.5 rounded text-sm font-medium transition">
                    Réserver
                </a>
            </div>

            <!-- Mobile CTA & Menu Toggle -->
            <div class="lg:hidden flex items-center space-x-3">
                <a href="reserver.php" class="bg-[#107c96] hover:bg-[#0d6278] text-white px-4 py-2 rounded text-sm font-medium transition">
                    Réserver
                </a>
                <button class="mobile-menu-toggle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="mobile-menu hidden lg:hidden bg-[#2c3e4f] border-t border-gray-600">
            <ul class="container mx-auto px-6 py-4 space-y-3">
                <li>
                    <a href="appartement.php" class="block hover:text-gray-300 transition font-medium">Nos Appartements</a>
                    <ul class="ml-4 mt-2 space-y-2 border-l-2 border-gray-600 pl-4">
                        <li>
                            <a href="studio.php" class="block text-sm text-gray-300 hover:text-white transition">Studio</a>
                        </li>
                        <li>
                            <a href="appartement-t2.php" class="block text-sm text-gray-300 hover:text-white transition">Appartement T2</a>
                        </li>
                        <li>
                            <a href="appartement-t3.php" class="block text-sm text-gray-300 hover:text-white transition">Appartement T3</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="sejours.php" class="block hover:text-gray-300 transition">Séjours</a>
                </li>
                <li>
                    <a href="spa.php" class="block hover:text-gray-300 transition">Notre SPA</a>
                </li>
                <li>
                    <a href="histoire.php" class="block hover:text-gray-300 transition">Notre Histoire</a>
                </li>
                <li>
                    <a href="contact.php" class="block hover:text-gray-300 transition">Contact</a>
                </li>
            </ul>
        </div>
    </header>
