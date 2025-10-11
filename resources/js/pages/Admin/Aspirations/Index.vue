<template>
  <AdminLayout page-title="Manajemen Aspirasi">
    <!-- Header -->
    <div class="mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Manajemen Aspirasi</h1>
          <p class="text-gray-600">Kelola aspirasi dan tanggapan masyarakat</p>
        </div>
        <div class="flex items-center space-x-4">
          <div class="flex items-center space-x-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
              <MessageSquare class="w-4 h-4 mr-1" />
              {{ newAspirationsCount }} Baru
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
              {{ (page.props.aspirationStats as any)?.processing || 0 }} Diproses
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
              {{ (page.props.aspirationStats as any)?.completed || 0 }} Selesai
            </span>
          </div>
          <button 
            @click="exportAspirations"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            <Download class="w-4 h-4 mr-2" />
            Export
          </button>
          <a 
            href="/aspirasi"
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
          <label class="block text-sm font-medium text-gray-700 mb-2">Cari Aspirasi</label>
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Cari berdasarkan judul, deskripsi, atau nama..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
            @input="debouncedSearch"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
          <select 
            v-model="statusFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
            @change="applyFilters"
          >
            <option value="">Semua Status</option>
            <option value="baru">Baru</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
          <select 
            v-model="categoryFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
            @change="applyFilters"
          >
            <option value="">Semua Kategori</option>
            <option v-for="category in categories" :key="category" :value="category">
              {{ category }}
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

    <!-- Aspirations List -->
    <div v-if="aspirations.data.length > 0" class="bg-white rounded-lg shadow overflow-hidden">
      <div class="divide-y divide-gray-200">
        <div 
          v-for="aspiration in aspirations.data" 
          :key="aspiration.id"
          class="p-6 hover:bg-gray-50 transition-colors"
        >
          <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
              <div class="flex items-center space-x-3 mb-2">
                <h3 class="text-lg font-medium text-gray-900 truncate">{{ aspiration.title }}</h3>
                <span 
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="[
                    aspiration.status === 'baru' 
                      ? 'bg-red-100 text-red-800' 
                      : aspiration.status === 'diproses'
                      ? 'bg-yellow-100 text-yellow-800'
                      : 'bg-green-100 text-green-800'
                  ]"
                >
                  {{ aspiration.status }}
                </span>
              </div>
              
              <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ aspiration.description }}</p>
              
              <div class="flex items-center space-x-4 text-xs text-gray-500">
                <div class="flex items-center">
                  <User class="w-3 h-3 mr-1" />
                  {{ aspiration.submitter_name }}
                </div>
                <div class="flex items-center">
                  <Tag class="w-3 h-3 mr-1" />
                  {{ aspiration.category }}
                </div>
                <div class="flex items-center">
                  <Calendar class="w-3 h-3 mr-1" />
                  {{ formatDate(aspiration.created_at || '') }}
                </div>
              </div>
              
              <div v-if="aspiration.admin_response" class="mt-3 p-3 bg-blue-50 rounded-lg">
                <div class="flex items-start">
                  <MessageSquare class="w-4 h-4 text-blue-600 mr-2 mt-0.5" />
                  <div>
                    <p class="text-sm font-medium text-blue-900 mb-1">Tanggapan Admin:</p>
                    <p class="text-sm text-blue-800">{{ aspiration.admin_response }}</p>
                    <p class="text-xs text-blue-600 mt-1">
                      Direspons pada {{ formatDate(aspiration.responded_at || '') }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="flex items-center space-x-2 ml-4">
              <a 
                :href="`/admin/aspirations/${aspiration.id}`"
                class="text-indigo-600 hover:text-indigo-900"
                title="Lihat Detail"
              >
                <Eye class="w-4 h-4" />
              </a>
              <button 
                @click="respondToAspiration(aspiration.id)"
                class="text-green-600 hover:text-green-900"
                title="Berikan Tanggapan"
              >
                <MessageSquare class="w-4 h-4" />
              </button>
              <button 
                @click="deleteAspiration(aspiration.id)"
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
    <div v-if="aspirations.data.length === 0" class="text-center py-12">
      <MessageSquare class="w-12 h-12 text-gray-400 mx-auto mb-4" />
      <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada aspirasi</h3>
      <p class="text-gray-500">Aspirasi dari masyarakat akan muncul di sini</p>
    </div>

    <!-- Pagination -->
    <div v-if="aspirations.links" class="mt-8">
      <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
          Menampilkan {{ aspirations.from }} sampai {{ aspirations.to }} dari {{ aspirations.total }} aspirasi
        </div>
        <div class="flex space-x-2">
          <a 
            v-for="link in aspirations.links" 
            :key="link.label"
            :href="link.url || '#'"
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
import { ref, computed } from 'vue';
import { MessageSquare, Download, User, Tag, Calendar, Eye, Trash2 } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

// Props
interface Props {
  aspirations: {
    data: Array<{
      id: number;
      title: string;
      description: string;
      category: string;
      status: string;
      submitter_name: string;
      submitter_email: string;
      submitter_phone?: string;
      admin_response?: string;
      responded_at?: string;
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
  statuses: string[];
  categories: string[];
  filters: {
    search?: string;
    status?: string;
    category?: string;
  };
}

const props = defineProps<Props>();
const page = usePage();

// State
const searchQuery = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || '');
const categoryFilter = ref(props.filters.category || '');

// Computed
const newAspirationsCount = computed(() => {
  return (page.props.aspirationStats as any)?.new || 0;
});

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
  if (statusFilter.value) params.set('status', statusFilter.value);
  if (categoryFilter.value) params.set('category', categoryFilter.value);
  
  window.location.href = `/admin/aspirations?${params.toString()}`;
};

const clearFilters = () => {
  searchQuery.value = '';
  statusFilter.value = '';
  categoryFilter.value = '';
  applyFilters();
};

const respondToAspiration = (id: number) => {
  // Implement respond functionality
  console.log('Respond to aspiration:', id);
};

const deleteAspiration = async (id: number) => {
  const result = await Swal.fire({
    title: 'Hapus Aspirasi',
    text: 'Apakah Anda yakin ingin menghapus aspirasi ini?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  });

  if (result.isConfirmed) {
    try {
      // Implement delete
      console.log('Delete aspiration:', id);
      await Swal.fire({
        title: 'Berhasil!',
        text: 'Aspirasi berhasil dihapus.',
        icon: 'success',
        confirmButtonColor: '#ef4444'
      });
    } catch {
      await Swal.fire({
        title: 'Gagal!',
        text: 'Gagal menghapus aspirasi.',
        icon: 'error',
        confirmButtonColor: '#ef4444'
      });
    }
  }
};

const exportAspirations = async () => {
  const result = await Swal.fire({
    title: 'Export Aspirasi',
    text: 'Apakah Anda ingin mengexport data aspirasi?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#10b981',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, Export!',
    cancelButtonText: 'Batal'
  });

  if (result.isConfirmed) {
    try {
      // Implement export functionality
      console.log('Export aspirations');
      await Swal.fire({
        title: 'Berhasil!',
        text: 'Data aspirasi berhasil diexport.',
        icon: 'success',
        confirmButtonColor: '#10b981'
      });
    } catch {
      await Swal.fire({
        title: 'Gagal!',
        text: 'Gagal mengexport data aspirasi.',
        icon: 'error',
        confirmButtonColor: '#ef4444'
      });
    }
  }
};

const formatDate = (dateString: string): string => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
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
