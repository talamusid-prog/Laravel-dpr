<template>
  <AdminLayout page-title="Manajemen Kalender">
    <!-- Header -->
    <div class="mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Manajemen Kalender</h1>
          <p class="text-gray-600">Kelola jadwal dan kegiatan</p>
        </div>
        <div class="flex space-x-3">
          <a 
            href="/admin/events/create"
            class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
          >
            <Plus class="w-4 h-4 mr-2" />
            Tambah Event
          </a>
          <a 
            href="/admin/events/calendar"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            <Calendar class="w-4 h-4 mr-2" />
            Kalender
          </a>
          <a 
            href="/kalender"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            target="_blank"
          >
            <Eye class="w-4 h-4 mr-2" />
            Lihat Publik
          </a>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Cari Event</label>
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Cari berdasarkan judul atau lokasi..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
            @input="debouncedSearch"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
          <select 
            v-model="typeFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
            @change="applyFilters"
          >
            <option value="">Semua Tipe</option>
            <option v-for="type in types" :key="type" :value="type">
              {{ type }}
            </option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
          <select 
            v-model="statusFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
            @change="applyFilters"
          >
            <option value="">Semua Status</option>
            <option v-for="status in statuses" :key="status" :value="status">
              {{ status }}
            </option>
          </select>
        </div>
        <div class="flex items-end">
          <button 
            @click="clearFilters"
            class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors"
          >
            Reset Filter
          </button>
        </div>
      </div>
    </div>

    <!-- Events List -->
    <div v-if="events.data.length > 0" class="bg-white rounded-lg shadow overflow-hidden">
      <div class="divide-y divide-gray-200">
        <div 
          v-for="event in events.data" 
          :key="event.id"
          class="p-6 hover:bg-gray-50 transition-colors"
        >
          <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
              <div class="flex items-center space-x-3 mb-2">
                <h3 class="text-lg font-medium text-gray-900">{{ event.title }}</h3>
                <span 
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="[
                    event.status === 'terjadwal' 
                      ? 'bg-blue-100 text-blue-800' 
                      : event.status === 'berlangsung'
                      ? 'bg-green-100 text-green-800'
                      : event.status === 'selesai'
                      ? 'bg-gray-100 text-gray-800'
                      : 'bg-red-100 text-red-800'
                  ]"
                >
                  {{ event.status }}
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                  {{ event.type }}
                </span>
              </div>
              
              <p v-if="event.description" class="text-sm text-gray-600 mb-3 line-clamp-2">{{ event.description }}</p>
              
              <div class="flex items-center space-x-4 text-xs text-gray-500">
                <div class="flex items-center">
                  <Calendar class="w-3 h-3 mr-1" />
                  {{ formatDateTime(event.start_date) }}
                </div>
                <div v-if="event.end_date" class="flex items-center">
                  <Clock class="w-3 h-3 mr-1" />
                  Sampai {{ formatDateTime(event.end_date) }}
                </div>
                <div v-if="event.location" class="flex items-center">
                  <MapPin class="w-3 h-3 mr-1" />
                  {{ event.location }}
                </div>
              </div>
              
              <div v-if="event.participants && event.participants.length > 0" class="mt-3">
                <div class="flex items-center">
                  <Users class="w-4 h-4 text-gray-400 mr-2" />
                  <span class="text-sm text-gray-600">
                    {{ event.participants.length }} peserta
                  </span>
                </div>
              </div>
            </div>
            
            <div class="flex items-center space-x-2 ml-4">
              <a 
                :href="`/admin/events/${event.id}`"
                class="text-indigo-600 hover:text-indigo-900"
                title="Lihat Detail"
              >
                <Eye class="w-4 h-4" />
              </a>
              <a 
                :href="`/admin/events/${event.id}/edit`"
                class="text-blue-600 hover:text-blue-900"
                title="Edit"
              >
                <Edit class="w-4 h-4" />
              </a>
              <button 
                @click="deleteEvent(event.id)"
                class="text-red-600 hover:text-red-900"
                title="Hapus"
              >
                <Trash2 class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="events.data.length === 0" class="text-center py-12">
      <Calendar class="w-12 h-12 text-gray-400 mx-auto mb-4" />
      <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada event</h3>
      <p class="text-gray-500 mb-4">Mulai dengan menambahkan event pertama Anda</p>
      <a 
        href="/admin/events/create"
        class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
      >
        <Plus class="w-4 h-4 mr-2" />
        Tambah Event
      </a>
    </div>

    <!-- Pagination -->
    <div v-if="events.links" class="mt-8">
      <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
          Menampilkan {{ events.from }} sampai {{ events.to }} dari {{ events.total }} event
        </div>
        <div class="flex space-x-2">
          <a 
            v-for="link in events.links" 
            :key="link.label"
            :href="link.url"
            class="px-3 py-1 text-sm border rounded"
            :class="[
              link.active 
                ? 'bg-primary text-white border-primary' 
                : 'text-gray-700 border-gray-300 hover:bg-gray-50'
            ]"
            v-html="link.label"
          ></a>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Plus, Calendar, Eye, Edit, Trash2, Clock, MapPin, Users } from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';

// Props
interface Props {
  events: {
    data: Array<{
      id: number;
      title: string;
      description?: string;
      type: string;
      status: string;
      start_date: string;
      end_date?: string;
      location?: string;
      participants?: string[];
      created_at: string;
    }>;
    links: Array<{
      label: string;
      url: string | null;
      active: boolean;
    }>;
    from: number;
    to: number;
    total: number;
  };
  types: string[];
  statuses: string[];
  filters: {
    search?: string;
    type?: string;
    status?: string;
  };
}

const props = defineProps<Props>();

// State
const searchQuery = ref(props.filters.search || '');
const typeFilter = ref(props.filters.type || '');
const statusFilter = ref(props.filters.status || '');

// Methods
const debouncedSearch = (() => {
  let timeout: number;
  return () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      applyFilters();
    }, 500);
  };
})();

const applyFilters = () => {
  const params = new URLSearchParams();
  if (searchQuery.value) params.set('search', searchQuery.value);
  if (typeFilter.value) params.set('type', typeFilter.value);
  if (statusFilter.value) params.set('status', statusFilter.value);
  
  window.location.href = `/admin/events?${params.toString()}`;
};

const clearFilters = () => {
  searchQuery.value = '';
  typeFilter.value = '';
  statusFilter.value = '';
  applyFilters();
};

const deleteEvent = (id: number) => {
  if (confirm('Apakah Anda yakin ingin menghapus event ini?')) {
    // Implement delete
    console.log('Delete event:', id);
  }
};

const formatDateTime = (dateString: string): string => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
