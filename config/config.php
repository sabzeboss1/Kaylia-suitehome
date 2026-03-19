<?php
// Configuration générale du site

// Informations du site
define('SITE_NAME', 'KAYLIA SUITE HOME');
define('SITE_TAGLINE', "L'Art du Confort et du Luxe à Yaoundé");
define('SITE_URL', 'http://localhost');

// Informations de contact
define('CONTACT_ADDRESS', 'Quartier Jouvence, Yaoundé, Cameroun');
define('CONTACT_EMAIL', 'info@kayliasuitehome.com');
define('CONTACT_PHONE', '+237 6XXX XXX XXX');

// Chemins
define('ASSETS_PATH', '/assets');
define('CSS_PATH', ASSETS_PATH . '/css');
define('JS_PATH', ASSETS_PATH . '/js');
define('IMG_PATH', ASSETS_PATH . '/images');

// Menu de navigation
$mainMenu = [
    [
        'title' => 'Nos Appartements',
        'url' => 'appartements.php',
        'hasDropdown' => true
    ],
    [
        'title' => 'Séjours',
        'url' => 'sejours.php',
        'hasDropdown' => true
    ],
    [
        'title' => 'Notre SPA',
        'url' => 'spa.php',
        'hasDropdown' => false
    ],
    [
        'title' => 'Notre Histoire',
        'url' => 'histoire.php',
        'hasDropdown' => false
    ],
    [
        'title' => 'Contact',
        'url' => 'contact.php',
        'hasDropdown' => false
    ]
];

// Liens rapides du footer
$footerLinks = [
    ['title' => 'Nos appartements', 'url' => 'appartements.php'],
    ['title' => 'Séjours', 'url' => 'sejours.php'],
    ['title' => 'Le SPA', 'url' => 'spa.php'],
    ['title' => 'Nos services', 'url' => 'services.php'],
    ['title' => 'Notre histoire', 'url' => 'histoire.php'],
    ['title' => 'Mentions légales', 'url' => 'mentions-legales.php']
];

// Liens légaux du footer
$legalLinks = [
    ['title' => 'Gestion des cookies', 'url' => 'cookies.php'],
    ['title' => 'Mentions légales', 'url' => 'mentions-legales.php'],
    ['title' => 'Politique de confidentialité', 'url' => 'confidentialite.php']
];

// Langues disponibles
$languages = [
    'FR' => 'Français',
    'EN' => 'English'
];

// Année pour le copyright
define('COPYRIGHT_YEAR', date('Y'));
