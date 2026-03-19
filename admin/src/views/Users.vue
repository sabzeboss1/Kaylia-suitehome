<template>
  <div class="animate-fade-in">
    <div class="page-header">
      <div>
        <h1 class="page-title">Utilisateurs</h1>
        <p class="page-subtitle">Gérer les administrateurs du système</p>
      </div>
      <button @click="openCreateModal" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        Nouvel utilisateur
      </button>
    </div>

    <div class="card mb-6"><div class="card-body">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="input-label">Rôle</label>
          <select v-model="filters.role" class="input" @change="fetchUsers">
            <option value="">Tous</option>
            <option value="super_admin">Super Admin</option>
            <option value="admin">Admin</option>
            <option value="editor">Éditeur</option>
          </select>
        </div>
        <div>
          <label class="input-label">Statut</label>
          <select v-model="filters.is_active" class="input" @change="fetchUsers">
            <option value="">Tous</option>
            <option value="1">Actif</option>
            <option value="0">Inactif</option>
          </select>
        </div>
        <div>
          <label class="input-label">Rechercher</label>
          <input v-model="filters.search" type="text" placeholder="Nom ou email..." class="input" @input="debouncedSearch" />
        </div>
        <div class="flex items-end">
          <button @click="resetFilters" class="btn btn-outline btn-sm">Réinitialiser</button>
        </div>
      </div>
    </div></div>

    <div v-if="loading" class="card p-8 text-center">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gold-500"></div>
      <p class="mt-3 text-navy-400 text-sm">Chargement...</p>
    </div>
    <div v-else-if="error" class="card p-6 border-red-200 bg-red-50 text-red-600 text-sm">{{ error }}</div>

    <div v-else class="card overflow-hidden">
      <div v-if="users.length > 0">
        <table class="min-w-full">
          <thead class="table-header"><tr>
            <th>Utilisateur</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Dernière connexion</th><th class="text-right">Actions</th>
          </tr></thead>
          <tbody>
            <tr v-for="user in users" :key="user.id" class="table-row group">
              <td>
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-gradient-navy text-white text-xs font-bold flex items-center justify-center">{{ user.username.charAt(0).toUpperCase() }}</div>
                  <span class="font-medium text-navy-900 text-sm">{{ user.username }}</span>
                </div>
              </td>
              <td><span class="text-sm text-navy-500">{{ user.email }}</span></td>
              <td><span class="badge" :class="getRoleBadgeClass(user.role)">{{ formatRole(user.role) }}</span></td>
              <td>
                <span class="badge" :class="user.is_active ? 'badge-success' : 'badge-danger'">
                  <span class="w-1.5 h-1.5 rounded-full" :class="user.is_active ? 'bg-emerald-500' : 'bg-red-500'"></span>
                  {{ user.is_active ? 'Actif' : 'Inactif' }}
                </span>
              </td>
              <td><span class="text-xs text-navy-400">{{ user.last_login ? formatDateTime(user.last_login) : 'Jamais' }}</span></td>
              <td class="text-right">
                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                  <button @click="editUser(user)" class="btn btn-ghost btn-sm" title="Modifier">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
                  </button>
                  <button @click="toggleUserStatus(user.id, !user.is_active)" class="btn btn-sm" :class="user.is_active ? 'text-amber-600 hover:bg-amber-50' : 'text-emerald-600 hover:bg-emerald-50'">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="user.is_active ? 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : 'M4.5 12.75l6 6 9-13.5'" /></svg>
                  </button>
                  <button @click="deleteUser(user.id)" class="btn btn-sm text-red-500 hover:bg-red-50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="pagination.total > pagination.per_page" class="px-6 py-4 flex items-center justify-between border-t border-gray-100">
          <span class="text-xs text-navy-400">{{ (pagination.current_page - 1) * pagination.per_page + 1 }} à {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} sur {{ pagination.total }}</span>
          <div class="flex gap-1">
            <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="btn btn-outline btn-sm"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg></button>
            <button @click="changePage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="btn btn-outline btn-sm"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg></button>
          </div>
        </div>
      </div>
      <div v-else class="p-12 text-center">
        <p class="text-navy-700 font-medium mb-1">Aucun utilisateur trouvé</p>
        <p class="text-navy-400 text-sm">Aucun utilisateur ne correspond à vos filtres.</p>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click.self="closeModal">
      <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-hidden shadow-2xl animate-slide-down">
        <div class="bg-gradient-navy px-6 py-4 flex justify-between items-center">
          <div>
            <h2 class="text-lg font-bold text-white">{{ editingUser ? 'Modifier' : 'Nouvel utilisateur' }}</h2>
            <p class="text-navy-300 text-xs">{{ editingUser ? 'Mettre à jour' : 'Ajouter un administrateur' }}</p>
          </div>
          <button @click="closeModal" class="text-white/60 hover:text-white rounded-lg p-1.5"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        <form @submit.prevent="saveUser" class="p-6 space-y-4 overflow-y-auto max-h-[calc(90vh-120px)]">
          <div><label class="input-label">Nom d'utilisateur *</label><input v-model="form.username" type="text" required class="input" /></div>
          <div><label class="input-label">Email *</label><input v-model="form.email" type="email" required class="input" /></div>
          <div><label class="input-label">Mot de passe {{ editingUser ? '(optionnel)' : '*' }}</label><input v-model="form.password" type="password" :required="!editingUser" minlength="8" class="input" /></div>
          <div>
            <label class="input-label">Rôle *</label>
            <select v-model="form.role" required class="input"><option value="super_admin">Super Admin</option><option value="admin">Admin</option><option value="editor">Éditeur</option></select>
          </div>
          <div class="bg-navy-50/50 rounded-lg p-3 border border-navy-100">
            <label class="flex items-center justify-between cursor-pointer">
              <span class="text-sm font-medium text-navy-800">Compte actif</span>
              <div class="relative"><input type="checkbox" v-model="form.is_active" class="sr-only peer" /><div class="w-10 h-6 bg-navy-200 rounded-full peer-checked:bg-emerald-500 transition-colors"></div><div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div></div>
            </label>
          </div>
          <div class="flex gap-3 pt-4 border-t border-gray-100">
            <button type="button" @click="closeModal" class="btn btn-outline flex-1">Annuler</button>
            <button type="submit" :disabled="saving" class="btn btn-primary flex-1">{{ saving ? 'Enregistrement...' : (editingUser ? 'Mettre à jour' : 'Créer') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../api/axios';

const users = ref([]); const loading = ref(false); const error = ref(null);
const showModal = ref(false); const editingUser = ref(null); const saving = ref(false);
const filters = ref({ role: '', is_active: '', search: '' });
const pagination = ref({ current_page: 1, per_page: 20, total: 0, last_page: 1 });
const form = ref({ username: '', email: '', password: '', role: 'admin', is_active: true });
let searchTimeout = null;

const fetchUsers = async () => {
  loading.value = true; error.value = null;
  try {
    const params = { page: pagination.value.current_page, per_page: pagination.value.per_page };
    if (filters.value.role) params.role = filters.value.role;
    if (filters.value.is_active !== '') params.is_active = filters.value.is_active;
    if (filters.value.search) params.search = filters.value.search;
    const r = await axios.get('/admin-users', { params });
    users.value = r.data.data; pagination.value = r.data.meta;
  } catch (e) { error.value = e.response?.data?.message || 'Échec du chargement'; }
  finally { loading.value = false; }
};
const debouncedSearch = () => { clearTimeout(searchTimeout); searchTimeout = setTimeout(() => { pagination.value.current_page = 1; fetchUsers(); }, 500); };
const resetFilters = () => { filters.value = { role: '', is_active: '', search: '' }; pagination.value.current_page = 1; fetchUsers(); };
const changePage = (p) => { pagination.value.current_page = p; fetchUsers(); };
const openCreateModal = () => { editingUser.value = null; form.value = { username: '', email: '', password: '', role: 'admin', is_active: true }; showModal.value = true; };
const editUser = (u) => { editingUser.value = u; form.value = { username: u.username, email: u.email, password: '', role: u.role, is_active: u.is_active }; showModal.value = true; };
const closeModal = () => { showModal.value = false; editingUser.value = null; };
const saveUser = async () => {
  saving.value = true;
  try { const p = { ...form.value }; if (editingUser.value && !p.password) delete p.password;
    if (editingUser.value) await axios.put(`/admin-users/${editingUser.value.id}`, p); else await axios.post('/admin-users', p);
    closeModal(); fetchUsers();
  } catch (e) { alert(e.response?.data?.message || 'Erreur'); } finally { saving.value = false; }
};
const toggleUserStatus = async (id, a) => { try { await axios.put(`/admin-users/${id}`, { is_active: a }); fetchUsers(); } catch (e) { alert('Erreur'); } };
const deleteUser = async (id) => { if (!confirm('Supprimer cet utilisateur ?')) return; try { await axios.delete(`/admin-users/${id}`); fetchUsers(); } catch (e) { alert('Erreur'); } };
const getRoleBadgeClass = (r) => ({ super_admin: 'badge-gold', admin: 'badge-info', editor: 'badge-success' }[r] || 'badge-neutral');
const formatRole = (r) => ({ super_admin: 'Super Admin', admin: 'Admin', editor: 'Éditeur' }[r] || r);
const formatDateTime = (d) => new Date(d).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
onMounted(() => { fetchUsers(); });
</script>
