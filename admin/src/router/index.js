import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/Login.vue'),
    meta: { requiresAuth: false },
  },
  {
    path: '/',
    component: () => import('../layouts/AppLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        name: 'Dashboard',
        component: () => import('../views/Dashboard.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'apartments',
        name: 'Apartments',
        component: () => import('../views/Apartments.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'reservations',
        name: 'Reservations',
        component: () => import('../views/Reservations.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'availability',
        name: 'ApartmentAvailability',
        component: () => import('../views/ApartmentAvailability.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'customers',
        name: 'Customers',
        component: () => import('../views/Customers.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'spa/services',
        name: 'SpaServices',
        component: () => import('../views/SpaServices.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'spa/reservations',
        name: 'SpaReservations',
        component: () => import('../views/SpaReservations.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'reviews',
        name: 'Reviews',
        component: () => import('../views/Reviews.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'promo-codes',
        name: 'PromoCodes',
        component: () => import('../views/PromoCodes.vue'),
        meta: { requiresAuth: true, roles: ['super_admin', 'admin'] },
      },
      {
        path: 'comfort-options',
        name: 'ComfortOptions',
        component: () => import('../views/ComfortOptions.vue'),
        meta: { requiresAuth: true, roles: ['super_admin', 'admin'] },
      },
      {
        path: 'contact-messages',
        name: 'ContactMessages',
        component: () => import('../views/ContactMessages.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'newsletter',
        name: 'Newsletter',
        component: () => import('../views/Newsletter.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'content',
        name: 'Content',
        component: () => import('../views/Content.vue'),
        meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'editor'] },
      },
      {
        path: 'settings',
        name: 'Settings',
        component: () => import('../views/Settings.vue'),
        meta: { requiresAuth: true, roles: ['super_admin', 'admin'] },
      },
      {
        path: 'users',
        name: 'Users',
        component: () => import('../views/Users.vue'),
        meta: { requiresAuth: true, roles: ['super_admin'] },
      },
      {
        path: 'activity-logs',
        name: 'ActivityLogs',
        component: () => import('../views/ActivityLogs.vue'),
        meta: { requiresAuth: true, roles: ['super_admin', 'admin'] },
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory('/admin/'),
  routes,
})

// Navigation guard for authentication
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth)
  const requiredRoles = to.meta.roles

  if (requiresAuth && !authStore.isLoggedIn) {
    // Redirect to login if not authenticated
    next({ name: 'Login', query: { redirect: to.fullPath } })
  } else if (to.name === 'Login' && authStore.isLoggedIn) {
    // Redirect to dashboard if already logged in
    next({ name: 'Dashboard' })
  } else if (requiredRoles && !requiredRoles.includes(authStore.userRole)) {
    // Redirect to dashboard if user doesn't have required role
    next({ name: 'Dashboard' })
  } else {
    next()
  }
})

export default router
