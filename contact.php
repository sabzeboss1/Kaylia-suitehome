<?php
$pageTitle = "Contact - Kaylia Suite Home";
include 'includes/header.php';
?>

<!-- Contact Section -->
<section class="bg-[#c9b5a0] py-12 md:py-20">
    <div class="container mx-auto px-6 md:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Left Column - Contact Info -->
            <div class="text-gray-900">
                <h1 class="font-serif text-4xl md:text-5xl font-light text-primary-blue mb-8">
                    Contactez-nous !
                </h1>
                <p class="text-base leading-relaxed mb-12">
                    Vous avez des questions pour préparer votre séjour ou des idées d'amélioration ? N'hésitez pas à nous contacter. Nous serions ravis de vous renseignez et d'écouter vos suggestions.
                </p>

                <!-- Email -->
                <div class="mb-10">
                    <h2 class="text-2xl font-light text-primary-blue mb-3">Email</h2>
                    <a href="mailto:contact@kayliasuitehome.com" class="text-base text-gray-900 hover:text-primary-blue transition">
                        contact@kayliasuitehome.com
                    </a>
                </div>

                <!-- WhatsApp -->
                <div class="mb-10">
                    <h2 class="text-2xl font-light text-primary-blue mb-3">WhatsApp</h2>
                    <a href="https://wa.me/237658973853" class="text-base text-gray-900 hover:text-primary-blue transition">
                        +237 6 58 97 38 53
                    </a>
                </div>

                <!-- Social Networks -->
                <div>
                    <h2 class="text-2xl font-light text-primary-blue mb-4">Nos réseaux sociaux</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-base text-gray-900 hover:text-primary-blue transition">Instagram</a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-900 hover:text-primary-blue transition">TikTok</a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-900 hover:text-primary-blue transition">Facebook</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column - Contact Form -->
            <div>
                <form class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm text-gray-900 mb-2">Nom</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded text-sm text-gray-900 outline-none focus:border-primary-blue transition"
                            required
                        >
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm text-gray-900 mb-2">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded text-sm text-gray-900 outline-none focus:border-primary-blue transition"
                            required
                        >
                    </div>

                    <!-- Subject Field -->
                    <div>
                        <label for="subject" class="block text-sm text-gray-900 mb-2">Sujet</label>
                        <select 
                            id="subject" 
                            name="subject"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded text-sm text-gray-900 outline-none focus:border-primary-blue transition appearance-none cursor-pointer"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1em;"
                            required
                        >
                            <option value="" disabled selected>Sélectionner un sujet</option>
                            <option value="reservation-appartement">Réservation Appart'hôtel</option>
                            <option value="reservation-spa">Réservation SPA</option>
                            <option value="tarif">Tarif</option>
                            <option value="autres">Autres</option>
                        </select>
                    </div>

                    <!-- Message Field -->
                    <div>
                        <label for="message" class="block text-sm text-gray-900 mb-2">Message</label>
                        <textarea 
                            id="message" 
                            name="message"
                            rows="6"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded text-sm text-gray-900 outline-none focus:border-primary-blue transition resize-none"
                            required
                        ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-primary-blue hover:bg-[#086780] text-white py-4 rounded text-sm font-semibold transition"
                    >
                        Soumettre
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
