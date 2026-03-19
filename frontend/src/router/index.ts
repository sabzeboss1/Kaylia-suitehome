import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import { useBookingStore } from '@/stores/booking'

// Define route meta interface for type safety
declare module 'vue-router' {
  interface RouteMeta {
    title?: string
    requiresBooking?: boolean
  }
}

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/views/HomePage.vue'),
    meta: { title: 'Accueil - Kaylia Suite Home' }
  },
  {
    path: '/nos-appartements',
    name: 'apartments-list',
    component: () => import('@/views/ApartmentsListPage.vue'),
    meta: { title: 'Nos Appartements - Kaylia Suite Home' }
  },
  {
    path: '/appartements',
    name: 'apartments-search',
    component: () => import('@/views/ApartmentsPage.vue'),
    meta: { title: 'Recherche d\'Appartements - Kaylia Suite Home' }
  },
  {
    path: '/appartements/:slug',
    name: 'apartment-detail',
    component: () => import('@/views/ApartmentDetailPage.vue'),
    meta: { title: 'Appartement - Kaylia Suite Home' }
  },
  {
    path: '/studio',
    name: 'studio',
    component: () => import('@/views/StudioPage.vue'),
    meta: { title: 'Studio - Kaylia Suite Home' }
  },
  {
    path: '/spa',
    name: 'spa',
    component: () => import('@/views/SpaPage.vue'),
    meta: { title: 'Le SPA - Kaylia Suite Home' }
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('@/views/ContactPage.vue'),
    meta: { title: 'Contact - Kaylia Suite Home' }
  },
  {
    path: '/histoire',
    name: 'about',
    component: () => import('@/views/AboutPage.vue'),
    meta: { title: 'Notre Histoire - Kaylia Suite Home' }
  },
  {
    path: '/reserver',
    name: 'booking',
    component: () => import('@/views/BookingPage.vue'),
    meta: { title: 'Réserver - Kaylia Suite Home' }
  },
  {
    path: '/paiement',
    name: 'payment',
    component: () => import('@/views/PaymentPage.vue'),
    meta: { 
      title: 'Paiement - Kaylia Suite Home',
      requiresBooking: true
    }
  },
  {
    path: '/confirmation',
    name: 'confirmation',
    component: () => import('@/views/ConfirmationPage.vue'),
    meta: { 
      title: 'Confirmation - Kaylia Suite Home',
      requiresBooking: true
    }
  },
  {
    path: '/error',
    name: 'error',
    component: () => import('@/views/ErrorPage.vue'),
    meta: { title: 'Erreur - Kaylia Suite Home' }
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: () => import('@/views/NotFoundPage.vue'),
    meta: { title: 'Page non trouvée - Kaylia Suite Home' }
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, _from, savedPosition) {
    // If the user navigated using browser back/forward buttons, restore their scroll position
    if (savedPosition) {
      return savedPosition
    }
    
    // If navigating to a route with a hash (anchor), scroll to that element
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth'
      }
    }
    
    // Otherwise, scroll to top of page
    return { top: 0, behavior: 'smooth' }
  }
})

// Navigation guards
router.beforeEach((to, _from, next) => {
  // Set page title from meta field
  if (to.meta.title) {
    document.title = to.meta.title as string
  }
  
  // Check booking requirement for payment and confirmation pages
  if (to.meta.requiresBooking) {
    const bookingStore = useBookingStore()
    
    // Redirect to home if booking data is missing
    if (!bookingStore.apartment) {
      console.warn('Access denied: Booking data required for this page')
      next({ name: 'home' })
      return
    }
  }
  
  // Proceed with navigation
  next()
})

export default router
