<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle ?? config('site_name')); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
</head>
<body class="bg-white">
    <header class="bg-[#1a2332] text-white">
        <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?php echo url(); ?>" class="text-2xl font-serif tracking-wider">
                    KAYLIA<br>
                    <span class="text-sm font-light tracking-widest">SUITE HOME</span>
                </a>
            </div>

            <!-- Navigation Menu -->
            <ul class="hidden md:flex items-center space-x-8 text-sm">
                <li class="relative group">
                    <a href="<?php echo url('appartements.php'); ?>" class="hover:text-gray-300 flex items-center">
                        Nos Appartements
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                </li>
                <li class="relative group">
                    <a href="<?php echo url('sejours.php'); ?>" class="hover:text-gray-300 flex items-center">
                        Séjours
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                </li>
                <li><a href="<?php echo url('spa.php'); ?>" class="hover:text-gray-300">Notre SPA</a></li>
                <li><a href="<?php echo url('histoire.php'); ?>" class="hover:text-gray-300">Notre Histoire</a></li>
                <li><a href="<?php echo url('contact.php'); ?>" class="hover:text-gray-300">Contact</a></li>
            </ul>

            <!-- Language & CTA -->
            <div class="flex items-center space-x-4">
                <div class="relative group">
                    <button class="flex items-center hover:text-gray-300">
                        FR
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                <a href="<?php echo url('reserver.php'); ?>" class="bg-[#107c96] hover:bg-[#0d6278] text-white px-6 py-2 rounded transition">
                    Réserver
                </a>
                
                <!-- Mobile Menu Toggle -->
                <button class="md:hidden mobile-menu-toggle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="mobile-menu hidden md:hidden bg-[#1a2332] border-t border-gray-700">
            <ul class="px-4 py-4 space-y-3">
                <li><a href="<?php echo url('appartements.php'); ?>" class="block hover:text-gray-300">Nos Appartements</a></li>
                <li><a href="<?php echo url('sejours.php'); ?>" class="block hover:text-gray-300">Séjours</a></li>
                <li><a href="<?php echo url('spa.php'); ?>" class="block hover:text-gray-300">Notre SPA</a></li>
                <li><a href="<?php echo url('histoire.php'); ?>" class="block hover:text-gray-300">Notre Histoire</a></li>
                <li><a href="<?php echo url('contact.php'); ?>" class="block hover:text-gray-300">Contact</a></li>
            </ul>
        </div>
    </header>
