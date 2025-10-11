<template>
  <AdminLayout page-title="Manajemen Artikel">
    <!-- Header -->
    <div class="mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Manajemen Artikel</h1>
          <p class="text-gray-600">Kelola artikel dan konten website</p>
        </div>
        <a 
          href="/admin/articles/create"
          class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
        >
          <Plus class="w-4 h-4 mr-2" />
          Buat Artikel Baru
        </a>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Cari Artikel</label>
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Cari berdasarkan judul atau excerpt..."
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
            <option value="published">Published</option>
            <option value="draft">Draft</option>
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

    <!-- Articles Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <!-- Bulk Actions -->
      <div v-if="selectedArticles.length > 0" class="bg-gray-50 px-6 py-3 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <span class="text-sm text-gray-700">{{ selectedArticles.length }} artikel dipilih</span>
          <div class="flex space-x-2">
            <button 
              @click="bulkAction('publish')"
              class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700"
            >
              Publish
            </button>
            <button 
              @click="bulkAction('draft')"
              class="px-3 py-1 bg-orange-600 text-white text-sm rounded hover:bg-orange-700"
            >
              Draft
            </button>
            <button 
              @click="bulkAction('delete')"
              class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700"
            >
              Hapus
            </button>
          </div>
        </div>
      </div>

      <!-- Table Header -->
      <div class="px-6 py-3 border-b border-gray-200">
        <div class="flex items-center">
          <input 
            v-model="selectAll"
            type="checkbox" 
            class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary"
            @change="toggleSelectAll"
          />
          <div class="ml-3 flex-1 grid grid-cols-12 gap-4">
            <div class="col-span-1 font-medium text-gray-900">Thumbnail</div>
            <div class="col-span-5 font-medium text-gray-900">Judul</div>
            <div class="col-span-2 font-medium text-gray-900">Status</div>
            <div class="col-span-2 font-medium text-gray-900">Views</div>
            <div class="col-span-2 font-medium text-gray-900">Aksi</div>
          </div>
        </div>
      </div>

      <!-- Table Body -->
      <div class="divide-y divide-gray-200">
        <div 
          v-for="article in articles.data" 
          :key="article.id"
          class="px-6 py-4 hover:bg-gray-50"
        >
          <div class="flex items-center">
            <input 
              v-model="selectedArticles"
              :value="article.id"
              type="checkbox" 
              class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary"
            />
            <div class="ml-3 flex-1 grid grid-cols-12 gap-4">
              <!-- Thumbnail Column -->
              <div class="col-span-1 flex items-center">
                <div class="h-12 w-12">
                  <img 
                    v-if="article.featured_image_url"
                    :src="article.featured_image_url" 
                    :alt="article.title"
                    class="h-12 w-12 rounded-lg object-cover border border-gray-200"
                    @error="handleImageError"
                  />
                  <div v-else class="h-12 w-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center border border-gray-200">
                    <FileText class="w-6 h-6 text-gray-400" />
                  </div>
                </div>
              </div>
              
              <!-- Title Column -->
              <div class="col-span-5">
                <div class="text-sm font-medium text-gray-900 truncate">{{ article.title }}</div>
                <div class="text-sm text-gray-500 truncate">{{ article.excerpt }}</div>
                <div class="text-xs text-gray-400 mt-1">
                  {{ new Date(article.created_at).toLocaleDateString('id-ID') }}
                </div>
              </div>
              <div class="col-span-2">
                <span 
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="[
                    article.status === 'published' 
                      ? 'bg-green-100 text-green-800' 
                      : 'bg-orange-100 text-orange-800'
                  ]"
                >
                  {{ article.status }}
                </span>
              </div>
              <div class="col-span-2 text-sm text-gray-900">{{ article.views }}</div>
              <div class="col-span-2">
                <div class="flex space-x-2">
                  <a 
                    :href="`/admin/articles/${article.id}/edit`"
                    class="text-indigo-600 hover:text-indigo-900"
                  >
                    <Edit class="w-4 h-4" />
                  </a>
                  <button 
                    @click="deleteArticle(article.id)"
                    class="text-red-600 hover:text-red-900"
                  >
                    <Trash2 class="w-4 h-4" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="articles.links" class="px-6 py-3 border-t border-gray-200">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700">
            Menampilkan {{ articles.from }} sampai {{ articles.to }} dari {{ articles.total }} artikel
          </div>
          <div class="flex space-x-2">
            <a 
              v-for="link in articles.links" 
              :key="link.label"
              :href="link.url || undefined"
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
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { Plus, FileText, Edit, Trash2 } from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';

// Props
interface Props {
  articles: {
    data: Array<{
      id: number;
      title: string;
      excerpt: string;
      status: string;
      views: number;
      featured_image?: string;
      featured_image_url?: string;
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
  filters: {
    search?: string;
    status?: string;
  };
}

const props = defineProps<Props>();

// State
const searchQuery = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || '');
const selectedArticles = ref<number[]>([]);

// Computed
const selectAll = computed({
  get: () => selectedArticles.value.length === props.articles.data.length && props.articles.data.length > 0,
  set: (value: boolean) => {
    if (value) {
      selectedArticles.value = props.articles.data.map(article => article.id);
    } else {
      selectedArticles.value = [];
    }
  }
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
  
  window.location.href = `/admin/articles?${params.toString()}`;
};

const clearFilters = () => {
  searchQuery.value = '';
  statusFilter.value = '';
  applyFilters();
};

const toggleSelectAll = () => {
  if (selectAll.value) {
    selectedArticles.value = [];
  } else {
    selectedArticles.value = props.articles.data.map(article => article.id);
  }
};

const bulkAction = (action: string) => {
  if (selectedArticles.value.length === 0) {
    alert('Pilih artikel terlebih dahulu');
    return;
  }
  
  if (action === 'delete') {
    if (confirm(`Apakah Anda yakin ingin menghapus ${selectedArticles.value.length} artikel yang dipilih?`)) {
      // Use Inertia.js to delete multiple articles
      router.post('/admin/articles/bulk-action', {
        action: 'delete',
        article_ids: selectedArticles.value
      }, {
        onSuccess: () => {
          selectedArticles.value = [];
          console.log('Articles deleted successfully');
        },
        onError: (errors) => {
          console.error('Error deleting articles:', errors);
          alert('Gagal menghapus artikel');
        }
      });
    }
  } else {
    // Implement other bulk actions
    console.log(`${action} articles:`, selectedArticles.value);
  }
};

const deleteArticle = (id: number) => {
  if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
    // Use Inertia.js to delete article
    router.delete(`/admin/articles/${id}`, {
      onSuccess: () => {
        // Article deleted successfully, page will reload automatically
        console.log('Article deleted successfully');
      },
      onError: (errors) => {
        console.error('Error deleting article:', errors);
        alert('Gagal menghapus artikel');
      }
    });
  }
};

const handleImageError = (event: Event) => {
  const img = event.target as HTMLImageElement;
  img.style.display = 'none';
  const parent = img.parentElement;
  if (parent) {
    parent.innerHTML = `
      <div class="h-12 w-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center border border-gray-200">
        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
      </div>
    `;
  }
};
</script>

