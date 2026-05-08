/**
 * Simple translation system
 * Manual translations for better control and reliability
 */

export const translations = {
  fr: {
    // Navigation
    'nav.apartments': 'Nos Appartements',
    'nav.all_apartments': 'Tous les appartements',
    'nav.room': 'Chambre',
    'nav.spa': 'SPA',
    'nav.our_story': 'Notre Histoire',
    'nav.contact': 'Contact',
    'nav.reserve': 'Réserver',
    
    // Common
    'common.adults': 'Adultes',
    'common.adult': 'Adulte',
    'common.persons': 'personnes',
    'common.person': 'personne',
    'common.night': 'nuit',
    'common.nights': 'nuits',
    'common.from': 'À partir de',
    'common.per_night': 'par nuit',
    'common.available': 'disponibles',
    'common.select_dates': 'Sélectionner les dates',
    'common.choose_dates': 'Choisir vos dates',
    'common.promo_code': 'Code promo',
    'common.number_of_persons': 'Nombre de personne',
    'common.number_of_rooms': 'Nombre de chambre',
    
    // Home page
    'home.hero.title': 'Bienvenue à Kaylia Suite Home',
    'home.hero.subtitle': 'Votre havre de paix au cœur de la ville',
    'home.apartments.title': 'Nos Appartements',
    'home.spa.title': 'Espace Bien-être',
    'home.services.title': 'Nos Services',
    
    // Apartments
    'apartments.title': 'appartements',
    'apartments.subtitle': 'Retrouvez nos appartements disponibles par rapport à vos dates de séjour.',
    'apartments.show_filters': 'Afficher les filtres',
    'apartments.hide_filters': 'Masquer les filtres',
    'apartments.studio': 'Studio',
    'apartments.bedroom': 'chambre',
    'apartments.bedrooms': 'chambres',
    
    // Booking
    'booking.check_in': 'Arrivée',
    'booking.check_out': 'Départ',
    'booking.guests': 'Voyageurs',
    'booking.total': 'Total',
    'booking.book_now': 'Réserver maintenant',
    
    // Contact
    'contact.title': 'Contactez-nous',
    'contact.name': 'Nom',
    'contact.email': 'Email',
    'contact.message': 'Message',
    'contact.send': 'Envoyer',
    
    // Footer
    'footer.follow_us': 'Suivez-nous',
    'footer.rights': 'Tous droits réservés',
  },
  
  en: {
    // Navigation
    'nav.apartments': 'Our Apartments',
    'nav.all_apartments': 'All apartments',
    'nav.room': 'Room',
    'nav.spa': 'SPA',
    'nav.our_story': 'Our Story',
    'nav.contact': 'Contact',
    'nav.reserve': 'Book',
    
    // Common
    'common.adults': 'Adults',
    'common.adult': 'Adult',
    'common.persons': 'persons',
    'common.person': 'person',
    'common.night': 'night',
    'common.nights': 'nights',
    'common.from': 'From',
    'common.per_night': 'per night',
    'common.available': 'available',
    'common.select_dates': 'Select dates',
    'common.choose_dates': 'Choose your dates',
    'common.promo_code': 'Promo code',
    'common.number_of_persons': 'Number of persons',
    'common.number_of_rooms': 'Number of rooms',
    
    // Home page
    'home.hero.title': 'Welcome to Kaylia Suite Home',
    'home.hero.subtitle': 'Your haven of peace in the heart of the city',
    'home.apartments.title': 'Our Apartments',
    'home.spa.title': 'Wellness Area',
    'home.services.title': 'Our Services',
    
    // Apartments
    'apartments.title': 'apartments',
    'apartments.subtitle': 'Find our available apartments according to your stay dates.',
    'apartments.show_filters': 'Show filters',
    'apartments.hide_filters': 'Hide filters',
    'apartments.studio': 'Studio',
    'apartments.bedroom': 'bedroom',
    'apartments.bedrooms': 'bedrooms',
    
    // Booking
    'booking.check_in': 'Check-in',
    'booking.check_out': 'Check-out',
    'booking.guests': 'Guests',
    'booking.total': 'Total',
    'booking.book_now': 'Book now',
    
    // Contact
    'contact.title': 'Contact us',
    'contact.name': 'Name',
    'contact.email': 'Email',
    'contact.message': 'Message',
    'contact.send': 'Send',
    
    // Footer
    'footer.follow_us': 'Follow us',
    'footer.rights': 'All rights reserved',
  }
}

export type TranslationKey = keyof typeof translations.fr
export type Language = 'fr' | 'en'
