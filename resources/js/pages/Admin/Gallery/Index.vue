<template>
  <AdminLayout page-title="Manajemen Galeri">
    <!-- Header -->
    <div class="mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Manajemen Galeri</h1>
          <p class="text-gray-600">Kelola dokumentasi dan galeri foto</p>
        </div>
        <div class="flex space-x-3">
          <a 
            href="/admin/gallery/create"
            class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
          >
            <Plus class="w-4 h-4 mr-2" />
            Upload Gambar
          </a>
          <a 
            href="/admin/gallery/bulk-upload"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            <Upload class="w-4 h-4 mr-2" />
            Bulk Upload
          </a>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Cari Gambar</label>
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Cari berdasarkan judul atau deskripsi..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
            @input="debouncedSearch"
          />
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
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Featured</label>
          <select 
            v-model="featuredFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
            @change="applyFilters"
          >
            <option value="">Semua</option>
            <option value="1">Featured</option>
            <option value="0">Tidak Featured</option>
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

    <!-- Gallery Grid -->
    <div v-if="galleries.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <div 
        v-for="gallery in galleries.data" 
        :key="gallery.id"
        class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow"
      >
        <!-- Image -->
        <div class="aspect-w-16 aspect-h-9 bg-gray-200">
          <img 
            :src="gallery.thumbnail_path || gallery.image_path" 
            :alt="gallery.title"
            class="w-full h-48 object-cover"
          />
        </div>
        
        <!-- Content -->
        <div class="p-4">
          <div class="flex items-start justify-between mb-2">
            <h3 class="text-sm font-medium text-gray-900 line-clamp-2">{{ gallery.title }}</h3>
            <div class="flex items-center space-x-1 ml-2">
              <span 
                v-if="gallery.is_featured"
                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
              >
                Featured
              </span>
            </div>
          </div>
          
          <p class="text-xs text-gray-500 mb-2">{{ gallery.category }}</p>
          
          <div v-if="gallery.location" class="text-xs text-gray-500 mb-2">
            <MapPin class="w-3 h-3 inline mr-1" />
            {{ gallery.location }}
          </div>
          
          <div v-if="gallery.photographer" class="text-xs text-gray-500 mb-3">
            <User class="w-3 h-3 inline mr-1" />
            {{ gallery.photographer }}
          </div>
          
          <!-- Actions -->
          <div class="flex items-center justify-between">
            <div class="flex space-x-2">
              <a 
                :href="`/admin/gallery/${gallery.id}/edit`"
                class="text-indigo-600 hover:text-indigo-900"
                title="Edit"
              >
                <Edit class="w-4 h-4" />
              </a>
              <button 
                @click="deleteGallery(gallery.id)"
                class="text-red-600 hover:text-red-900"
                title="Hapus"
              >
                <Trash2 class="w-4 h-4" />
              </button>
            </div>
            
            <span class="text-xs text-gray-400">
              {{ formatDate(gallery.created_at || '') }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="galleries.data.length === 0" class="text-center py-12">
      <Image class="w-12 h-12 text-gray-400 mx-auto mb-4" />
      <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada gambar</h3>
      <p class="text-gray-500 mb-4">Mulai dengan mengupload gambar pertama Anda</p>
      <a 
        href="/admin/gallery/create"
        class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
      >
        <Plus class="w-4 h-4 mr-2" />
        Upload Gambar
      </a>
    </div>

    <!-- Pagination -->
    <div v-if="galleries.links" class="mt-8">
      <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
          Menampilkan {{ galleries.from }} sampai {{ galleries.to }} dari {{ galleries.total }} gambar
        </div>
        <div class="flex space-x-2">
          <a 
            v-for="link in galleries.links" 
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
import { ref } from 'vue';
import { Plus, Upload, Edit, Trash2, Image, MapPin, User } from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';

// Props
interface Props {
  galleries: {
    data: Array<{
      id: number;
      title: string;
      description?: string;
      image_path: string;
      thumbnail_path?: string;
      category: string;
      location?: string;
      photographer?: string;
      is_featured: boolean;
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
  categories: string[];
  filters: {
    search?: string;
    category?: string;
    featured?: string;
  };
}

const props = defineProps<Props>();

// State
const searchQuery = ref(props.filters.search || '');
const categoryFilter = ref(props.filters.category || '');
const featuredFilter = ref(props.filters.featured || '');

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
  if (categoryFilter.value) params.set('category', categoryFilter.value);
  if (featuredFilter.value) params.set('featured', featuredFilter.value);
  
  window.location.href = `/admin/gallery?${params.toString()}`;
};

const clearFilters = () => {
  searchQuery.value = '';
  categoryFilter.value = '';
  featuredFilter.value = '';
  applyFilters();
};

const deleteGallery = (id: number) => {
  if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
    // Implement delete
    console.log('Delete gallery:', id);
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
