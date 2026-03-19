<?php
$pageTitle = "Paiement - Kaylia Suite Home";
include 'includes/header.php';
?>

<!-- Payment Page -->
<section class="bg-gray-50 py-8 md:py-12">
    <div class="container mx-auto px-4 md:px-6 max-w-7xl">
        <!-- Progress Steps -->
        <div class="flex items-center justify-center gap-4 md:gap-8 mb-8">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-sm text-gray-600">Tarif</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-sm text-gray-600">Récapitulatif</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center">
                    <span class="text-white text-sm font-semibold">3</span>
                </div>
                <span class="text-sm text-gray-900 font-semibold">Réservé</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Payment Form -->
            <div>
                <!-- Currency Selection -->
                <div class="bg-white rounded-lg p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Sélection de la devise</h2>
                        <button class="text-sm text-gray-600 hover:text-gray-900">Modifier votre devise</button>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-4">
                        <p class="text-sm text-gray-700">
                            Vous pouvez payer dans la devise qui vous convient le mieux.
                        </p>
                    </div>
                    <select class="w-full px-4 py-3 border-2 border-gray-300 rounded text-gray-900 outline-none focus:border-primary-blue transition">
                        <option>€ EUR</option>
                        <option>$ USD</option>
                        <option>£ GBP</option>
                    </select>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Mode de paiement</h2>
                    
                    <div class="space-y-4">
                        <!-- Credit Card -->
                        <label class="flex items-center justify-between p-4 border-2 border-gray-300 rounded cursor-pointer hover:border-primary-blue transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment" value="card" class="w-5 h-5" checked>
                                <span class="text-gray-900">Carte de crédit ou de débit</span>
                            </div>
                            <svg class="w-10 h-6" viewBox="0 0 40 24" fill="none">
                                <rect width="40" height="24" rx="4" fill="#1A1F71"/>
                                <rect x="8" y="8" width="24" height="8" rx="2" fill="white"/>
                            </svg>
                        </label>

                        <!-- SEPA -->
                        <label class="flex items-center justify-between p-4 border-2 border-gray-300 rounded cursor-pointer hover:border-primary-blue transition">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-3 mb-1">
                                    <input type="radio" name="payment" value="sepa" class="w-5 h-5">
                                    <span class="text-gray-900">Prélèvement SEPA</span>
                                </div>
                                <span class="text-sm text-gray-500 ml-8">Compte bancaire en EUR requis</span>
                            </div>
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 80 30'%3E%3Ctext x='10' y='20' font-family='Arial' font-size='16' font-weight='bold' fill='%230066CC'%3ESEPA%3C/text%3E%3C/svg%3E" alt="SEPA" class="h-8">
                        </label>

                        <!-- PayPal -->
                        <label class="flex items-center justify-between p-4 border-2 border-gray-300 rounded cursor-pointer hover:border-primary-blue transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment" value="paypal" class="w-5 h-5">
                                <span class="text-gray-900">PAYPAL</span>
                            </div>
                            <svg class="h-6" viewBox="0 0 100 32" fill="none">
                                <text x="0" y="24" font-family="Arial" font-size="20" font-weight="bold" fill="#003087">Pay</text>
                                <text x="35" y="24" font-family="Arial" font-size="20" font-weight="bold" fill="#009CDE">Pal</text>
                            </svg>
                        </label>

                        <!-- Apple Pay -->
                        <label class="flex items-center justify-between p-4 border-2 border-gray-300 rounded cursor-pointer hover:border-primary-blue transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment" value="applepay" class="w-5 h-5">
                                <span class="text-gray-900">Apple Pay</span>
                            </div>
                            <svg class="h-8" viewBox="0 0 50 32" fill="black">
                                <path d="M8.5 10c-.8 0-1.4.3-1.9.8-.5.5-.8 1.2-.8 2 0 .8.3 1.5.8 2 .5.5 1.1.8 1.9.8.7 0 1.4-.3 1.9-.8.5-.5.8-1.2.8-2 0-.8-.3-1.5-.8-2-.5-.5-1.2-.8-1.9-.8zm5.5 0c-.8 0-1.4.3-1.9.8-.5.5-.8 1.2-.8 2 0 .8.3 1.5.8 2 .5.5 1.1.8 1.9.8.7 0 1.4-.3 1.9-.8.5-.5.8-1.2.8-2 0-.8-.3-1.5-.8-2-.5-.5-1.2-.8-1.9-.8z"/>
                            </svg>
                        </label>
                    </div>

                    <!-- Pay Button -->
                    <button class="w-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-4 rounded mt-6 transition">
                        Payer 4 258€
                    </button>
                </div>
            </div>

            <!-- Right Column - Summary -->
            <div class="space-y-6">
                <!-- Total -->
                <div class="bg-white rounded-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Vous allez payer</h2>
                        <span class="text-2xl font-bold text-gray-900">4 348€</span>
                    </div>
                    
                    <div class="bg-gray-50 rounded p-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Informations relatives au prix</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Le prix total inclut les frais de service et les taxes. Le montant final peut varier en fonction de votre mode de paiement et de votre pays de résidence. Pour plus d'informations, veuillez consulter nos conditions générales de vente.
                        </p>
                    </div>
                </div>

                <!-- Reservation Details -->
                <div class="bg-white rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Les détails de votre réservation</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-900 font-medium">Appartement X - 40m2</p>
                                <p class="text-sm text-gray-500">du 10/05/2025 au 06/06/2025</p>
                            </div>
                            <span class="text-gray-900 font-semibold">4 256€</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <p class="text-gray-700">Ménage quotidien - tout l'appartement</p>
                            <span class="text-gray-900">35€</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <p class="text-gray-700">1 Bouteille de vin rouge</p>
                            <span class="text-gray-900">30€</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <p class="text-gray-700">1 panier gourmand</p>
                            <span class="text-gray-900">25€</span>
                        </div>
                        
                        <div class="border-t pt-4 flex justify-between items-center">
                            <p class="text-lg font-semibold text-gray-900">Total</p>
                            <span class="text-xl font-bold text-gray-900">4 348€</span>
                        </div>
                    </div>
                </div>

                <!-- Practical Information -->
                <div class="bg-white rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Informations pratiques</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Comment s'y rendre</p>
                                <p class="text-sm text-gray-600">Quartier Jouvence, Yaoundé Cameroun</p>
                            </div>
                        </div>
                        
                        <select class="w-full px-4 py-3 border border-gray-300 rounded text-sm text-gray-700 outline-none focus:border-primary-blue transition">
                            <option>Appartement X</option>
                        </select>
                        
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Numéro de confirmation de la réservation</p>
                                <p class="text-sm text-gray-600">123</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Nombre de clients</p>
                                <p class="text-sm text-gray-600">3</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="bg-white rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Nous contacter</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Site Web</p>
                                <a href="https://www.kayliasuitehome.com" class="text-sm text-gray-600 hover:text-primary-blue">www.kayliasuitehome.com</a>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">E-mail</p>
                                <a href="mailto:contact@kayliasuitehome.com" class="text-sm text-gray-600 hover:text-primary-blue">contact@kayliasuitehome.com</a>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">WhatsApp</p>
                                <a href="tel:+237000000000" class="text-sm text-gray-600 hover:text-primary-blue">+237 00 00 00 00</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="text-center text-xs text-gray-500 leading-relaxed">
                    <p>Ce site est protégé par reCAPTCHA et les <a href="#" class="text-primary-blue hover:underline">Politique de confidentialité et Conditions d'utilisation</a> de Google s'appliquent. Pour plus d'information, veuillez visiter <a href="#" class="text-primary-blue hover:underline">Avis de confidentialité de Mews</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
