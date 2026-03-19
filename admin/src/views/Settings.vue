<template>
  <div class="animate-fade-in">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Paramètres</h1>
        <p class="page-subtitle">Configurez les paramètres système et préférences</p>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="card p-8 text-center">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
      <p class="mt-3 text-navy-400 text-sm">Chargement des paramètres...</p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="card p-6 border-red-200 bg-red-50 text-red-600 text-sm">{{ error }}</div>

    <!-- Tabs + Content -->
    <div v-else>
      <!-- Tab Navigation -->
      <div class="flex flex-wrap gap-1 mb-6">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          class="px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2"
          :class="activeTab === tab.id
            ? 'bg-navy-900 text-white shadow-sm'
            : 'bg-white text-navy-600 hover:bg-navy-50 border border-navy-100'"
        >
          <component :is="tab.icon" class="w-4 h-4" />
          {{ tab.label }}
        </button>
      </div>

      <!-- Tab Content -->
      <div>
        <!-- General -->
        <div v-show="activeTab === 'general'">
          <SettingGroup title="Informations du site" description="Nom, logo et paramètres de base" :settings="generalSettings" @update="updateSetting" />
        </div>

        <!-- SEO -->
        <div v-show="activeTab === 'seo'">
          <SettingGroup title="Référencement naturel (SEO)" description="Optimisez votre visibilité sur les moteurs de recherche" :settings="seoSettings" @update="updateSetting">
            <template #help>
              <div class="mt-4 px-4 py-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-700">
                <p class="font-semibold mb-1">Bonnes pratiques SEO :</p>
                <ul class="list-disc list-inside space-y-0.5">
                  <li>Titre : 50-60 caractères max</li>
                  <li>Description : 150-160 caractères max</li>
                  <li>Image OG : 1200x630px recommandé</li>
                </ul>
              </div>
            </template>
          </SettingGroup>
        </div>

        <!-- Business -->
        <div v-show="activeTab === 'business'">
          <SettingGroup title="Informations de l'entreprise" description="Coordonnées et informations légales" :settings="businessSettings" @update="updateSetting" />
        </div>

        <!-- Social -->
        <div v-show="activeTab === 'social'">
          <SettingGroup title="Réseaux sociaux" description="Connectez vos profils sociaux" :settings="socialSettings" @update="updateSetting">
            <template #help>
              <div class="mt-4 px-4 py-3 bg-navy-50 border border-navy-100 rounded-lg text-xs text-navy-600">
                Entrez l'URL complète de vos profils. Ex : https://www.facebook.com/votreprofil
              </div>
            </template>
          </SettingGroup>
        </div>

        <!-- Email -->
        <div v-show="activeTab === 'email'">
          <SettingGroup title="Configuration SMTP" description="Paramètres du serveur d'envoi d'emails" :settings="emailSettings" @update="updateSetting" />
        </div>

        <!-- Payment -->
        <div v-show="activeTab === 'payment'" class="space-y-6">
          <SettingGroup title="Stripe" description="Configuration du paiement Stripe" :settings="stripeSettings" @update="updateSetting">
            <template #help>
              <div class="mt-4 space-y-3">
                <div class="px-4 py-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-700">
                  <p class="font-semibold mb-1">Comment obtenir les clés Stripe :</p>
                  <ol class="list-decimal list-inside space-y-0.5">
                    <li>Visitez <a href="https://dashboard.stripe.com/apikeys" target="_blank" class="underline">Stripe Dashboard</a></li>
                    <li>Copiez la clé publique (pk_test_... ou pk_live_...)</li>
                    <li>Copiez la clé secrète (sk_test_... ou sk_live_...)</li>
                    <li>Pour le webhook secret, créez un webhook endpoint dans Stripe</li>
                  </ol>
                </div>
                
                <button
                  @click="testStripeConnection"
                  :disabled="stripeTestLoading"
                  class="w-full px-4 py-2 bg-navy-900 text-white rounded-lg hover:bg-navy-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-sm font-medium"
                >
                  {{ stripeTestLoading ? 'Test en cours...' : 'Tester la connexion Stripe' }}
                </button>
                
                <div v-if="stripeTestResult" class="px-4 py-3 rounded-lg text-sm" :class="stripeTestResult.connected ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700'">
                  <p class="font-semibold mb-1">{{ stripeTestResult.connected ? '✅ Connexion réussie' : '❌ Échec de connexion' }}</p>
                  <p>{{ stripeTestResult.message }}</p>
                  <div v-if="stripeTestResult.data" class="mt-2 text-xs">
                    <p>Compte: {{ stripeTestResult.data.account_id }}</p>
                    <p>Pays: {{ stripeTestResult.data.country }}</p>
                    <p>Devise: {{ stripeTestResult.data.currency }}</p>
                  </div>
                </div>
              </div>
            </template>
          </SettingGroup>
          
          <SettingGroup v-if="paypalSettings.length > 0" title="PayPal" description="Configuration du paiement PayPal" :settings="paypalSettings" @update="updateSetting">
            <template #help>
              <div class="mt-4 space-y-3">
                <div class="px-4 py-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-700">
                  <p class="font-semibold mb-1">Comment obtenir les clés PayPal :</p>
                  <ol class="list-decimal list-inside space-y-0.5">
                    <li>Visitez <a href="https://developer.paypal.com/dashboard/" target="_blank" class="underline">PayPal Developer Dashboard</a></li>
                    <li>Créez une application</li>
                    <li>Copiez le Client ID</li>
                    <li>Copiez le Secret</li>
                    <li>Choisissez le mode (sandbox pour test, live pour production)</li>
                  </ol>
                </div>
                
                <button
                  @click="testPayPalConnection"
                  :disabled="paypalTestLoading"
                  class="w-full px-4 py-2 bg-navy-900 text-white rounded-lg hover:bg-navy-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-sm font-medium"
                >
                  {{ paypalTestLoading ? 'Test en cours...' : 'Tester la connexion PayPal' }}
                </button>
                
                <div v-if="paypalTestResult" class="px-4 py-3 rounded-lg text-sm" :class="paypalTestResult.connected ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700'">
                  <p class="font-semibold mb-1">{{ paypalTestResult.connected ? '✅ Connexion réussie' : '❌ Échec de connexion' }}</p>
                  <p>{{ paypalTestResult.message }}</p>
                  <div v-if="paypalTestResult.data" class="mt-2 text-xs">
                    <p>Mode: {{ paypalTestResult.data.mode }}</p>
                  </div>
                </div>
              </div>
            </template>
          </SettingGroup>
          
          <SettingGroup title="Devise et taxes" description="Configuration des devises et taux" :settings="currencySettings" @update="updateSetting" />
        </div>

        <!-- Security -->
        <div v-show="activeTab === 'security'">
          <SettingGroup title="Google reCAPTCHA v3" description="Protection contre les bots et spam" :settings="recaptchaSettings" @update="updateSetting">
            <template #help>
              <div class="mt-4 px-4 py-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-700">
                <p class="font-semibold mb-1">Comment obtenir les clés :</p>
                <ol class="list-decimal list-inside space-y-0.5">
                  <li>Visitez <a href="https://www.google.com/recaptcha/admin" target="_blank" class="underline">Google reCAPTCHA Admin</a></li>
                  <li>Créez un site avec reCAPTCHA v3</li>
                  <li>Ajoutez vos domaines</li>
                  <li>Copiez les clés</li>
                </ol>
              </div>
            </template>
          </SettingGroup>
        </div>

        <!-- Booking -->
        <div v-show="activeTab === 'booking'">
          <SettingGroup title="Paramètres de réservation" description="Règles de réservation" :settings="bookingSettings" @update="updateSetting" />
        </div>
      </div>
    </div>

    <!-- Success Toast -->
    <Transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="translate-y-2 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="translate-y-0 opacity-100"
      leave-to-class="translate-y-2 opacity-0"
    >
      <div v-if="showSuccessToast" class="fixed bottom-4 right-4 bg-navy-900 text-white px-5 py-3 rounded-lg shadow-xl flex items-center gap-2 z-50 text-sm">
        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5" /></svg>
        Paramètre mis à jour
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, h } from 'vue';
import axios from '../api/axios';

const GeneralIcon = () => h('svg', { class: 'w-5 h-5', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '1.5', d: 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z' }),
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '1.5', d: 'M15 12a3 3 0 11-6 0 3 3 0 016 0z' })
]);
const BusinessIcon = () => h('svg', { class: 'w-5 h-5', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '1.5', d: 'M2.25 21h19.5M3.75 3v18m4.5-18v18m4.5-18v18m4.5-18v18' })
]);
const EmailIcon = () => h('svg', { class: 'w-5 h-5', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '1.5', d: 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75' })
]);
const PaymentIcon = () => h('svg', { class: 'w-5 h-5', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '1.5', d: 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z' })
]);
const SecurityIcon = () => h('svg', { class: 'w-5 h-5', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '1.5', d: 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z' })
]);
const SocialIcon = () => h('svg', { class: 'w-5 h-5', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '1.5', d: 'M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z' })
]);
const BookingIcon = () => h('svg', { class: 'w-5 h-5', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '1.5', d: 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5' })
]);
const SeoIcon = () => h('svg', { class: 'w-5 h-5', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '1.5', d: 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418' })
]);

const tabs = [
  { id: 'general', label: 'Général', icon: GeneralIcon },
  { id: 'seo', label: 'SEO', icon: SeoIcon },
  { id: 'business', label: 'Entreprise', icon: BusinessIcon },
  { id: 'social', label: 'Social', icon: SocialIcon },
  { id: 'email', label: 'Email', icon: EmailIcon },
  { id: 'payment', label: 'Paiement', icon: PaymentIcon },
  { id: 'security', label: 'Sécurité', icon: SecurityIcon },
  { id: 'booking', label: 'Réservations', icon: BookingIcon }
];

const activeTab = ref('general');
const settings = ref([]);
const loading = ref(false);
const error = ref(null);
const showSuccessToast = ref(false);

const generalSettings = computed(() => settings.value.filter(s => ['site_name', 'site_tagline', 'site_description', 'site_logo', 'site_favicon', 'default_language', 'timezone', 'maintenance_mode', 'maintenance_message'].includes(s.setting_key)));
const seoSettings = computed(() => settings.value.filter(s => ['seo_meta_title', 'seo_meta_description', 'seo_meta_keywords', 'seo_og_image', 'google_analytics_id', 'google_tag_manager_id'].includes(s.setting_key)));
const businessSettings = computed(() => settings.value.filter(s => ['business_name', 'business_address', 'business_phone', 'business_email', 'business_whatsapp', 'business_registration', 'business_tax_id'].includes(s.setting_key)));
const socialSettings = computed(() => settings.value.filter(s => s.setting_key.startsWith('social_')));
const emailSettings = computed(() => settings.value.filter(s => s.setting_key.startsWith('smtp_') || s.setting_key.startsWith('mail_')));
const stripeSettings = computed(() => settings.value.filter(s => s.setting_key.startsWith('stripe_')));
const paypalSettings = computed(() => settings.value.filter(s => s.setting_key.startsWith('paypal_')));
const currencySettings = computed(() => settings.value.filter(s => ['default_currency', 'tax_rate'].includes(s.setting_key)));
const recaptchaSettings = computed(() => settings.value.filter(s => s.setting_key.startsWith('recaptcha_')));
const bookingSettings = computed(() => settings.value.filter(s => ['booking_enabled', 'min_booking_days', 'max_booking_days', 'booking_advance_days', 'cancellation_hours'].includes(s.setting_key)));

// Payment test states
const stripeTestLoading = ref(false);
const stripeTestResult = ref(null);
const paypalTestLoading = ref(false);
const paypalTestResult = ref(null);

const fetchSettings = async () => {
  loading.value = true; error.value = null;
  try {
    const response = await axios.get('/settings');
    settings.value = response.data.data.map(s => ({ ...s, setting_value: parseSettingValue(s.setting_value, s.setting_type) }));
  } catch (err) { error.value = err.response?.data?.message || 'Échec du chargement'; }
  finally { loading.value = false; }
};

const parseSettingValue = (value, type) => {
  if (type === 'boolean') return value === '1' || value === 'true' || value === true;
  if (type === 'number') return Number(value);
  if (type === 'json') { try { return typeof value === 'string' ? JSON.stringify(JSON.parse(value), null, 2) : JSON.stringify(value, null, 2); } catch { return value; } }
  return value;
};

const updateSetting = async (setting) => {
  try {
    let value = setting.setting_value;
    if (setting.setting_type === 'boolean') value = value ? '1' : '0';
    else if (setting.setting_type === 'json') { try { JSON.parse(value); } catch { alert('Format JSON invalide'); return; } }
    await axios.put(`/settings/${setting.setting_key}`, { setting_value: value });
    showSuccessToast.value = true;
    setTimeout(() => { showSuccessToast.value = false; }, 2500);
  } catch (err) { alert(err.response?.data?.message || 'Échec de la mise à jour'); fetchSettings(); }
};

const testStripeConnection = async () => {
  stripeTestLoading.value = true;
  stripeTestResult.value = null;
  try {
    const response = await axios.get('/settings/payment/test-stripe');
    stripeTestResult.value = response.data;
  } catch (err) {
    stripeTestResult.value = err.response?.data || { success: false, message: 'Test failed' };
  } finally {
    stripeTestLoading.value = false;
  }
};

const testPayPalConnection = async () => {
  paypalTestLoading.value = true;
  paypalTestResult.value = null;
  try {
    const response = await axios.get('/settings/payment/test-paypal');
    paypalTestResult.value = response.data;
  } catch (err) {
    paypalTestResult.value = err.response?.data || { success: false, message: 'Test failed' };
  } finally {
    paypalTestLoading.value = false;
  }
};

onMounted(() => { fetchSettings(); });
</script>

<script>
import { h } from 'vue';

export const SettingGroup = {
  props: { title: String, description: String, settings: Array },
  emits: ['update'],
  setup(props, { emit, slots }) {
    const formatKey = (key) => key.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');

    return () => h('div', { class: 'card' }, [
      h('div', { class: 'card-body' }, [
        h('div', { class: 'mb-4' }, [
          h('h3', { class: 'text-sm font-semibold text-navy-800' }, props.title),
          h('p', { class: 'text-xs text-navy-400 mt-0.5' }, props.description)
        ]),
        h('div', { class: 'space-y-3' }, props.settings.map(setting =>
          h('div', {
            key: setting.setting_key,
            class: 'grid grid-cols-1 md:grid-cols-3 gap-3 items-start p-3 bg-navy-50/30 rounded-lg border border-navy-50 hover:bg-navy-50/60 transition-colors'
          }, [
            h('div', [
              h('label', { class: 'block text-sm font-medium text-navy-800' }, formatKey(setting.setting_key)),
              setting.description && h('p', { class: 'text-[11px] text-navy-400 mt-0.5' }, setting.description)
            ]),
            h('div', { class: 'md:col-span-2' }, [
              setting.setting_type === 'text' && h('input', {
                type: 'text', value: setting.setting_value,
                class: 'w-full px-3 py-2 text-sm border border-navy-100 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 transition-all',
                onBlur: (e) => { setting.setting_value = e.target.value; emit('update', setting); }
              }),
              setting.setting_type === 'number' && h('input', {
                type: 'number', value: setting.setting_value,
                class: 'w-full px-3 py-2 text-sm border border-navy-100 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 transition-all',
                onBlur: (e) => { setting.setting_value = Number(e.target.value); emit('update', setting); }
              }),
              setting.setting_type === 'boolean' && h('label', { class: 'flex items-center justify-between cursor-pointer bg-white rounded-lg border border-navy-100 px-3 py-2' }, [
                h('span', { class: 'text-sm text-navy-700' }, setting.setting_value ? 'Activé' : 'Désactivé'),
                h('div', { class: 'relative' }, [
                  h('input', { type: 'checkbox', checked: setting.setting_value, class: 'sr-only peer', onChange: (e) => { setting.setting_value = e.target.checked; emit('update', setting); } }),
                  h('div', { class: 'w-10 h-6 bg-navy-200 rounded-full peer-checked:bg-emerald-500 transition-colors' }),
                  h('div', { class: 'absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4' })
                ])
              ]),
              setting.setting_type === 'json' && h('textarea', {
                value: setting.setting_value, rows: 4,
                class: 'w-full px-3 py-2 text-xs font-mono border border-navy-100 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 transition-all',
                onBlur: (e) => { setting.setting_value = e.target.value; emit('update', setting); }
              })
            ])
          ])
        )),
        slots.help && slots.help()
      ])
    ]);
  }
};
</script>
