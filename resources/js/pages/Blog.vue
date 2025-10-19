<template>
  <div class="min-h-screen">
    <!-- Header -->
    <Header />
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-background to-muted py-8 pt-20 md:pt-24">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-8">
          <!-- Badge -->
          <div class="inline-flex items-center gap-2 bg-primary/10 text-primary text-sm font-medium px-4 py-2 rounded-full mb-4">
            <BookOpen class="w-4 h-4" />
            Blog & Berita
          </div>
          
          <!-- Title -->
          <h1 class="text-4xl lg:text-6xl font-bold bg-gradient-to-r from-primary to-primary/80 bg-clip-text text-transparent mb-4">
            Berita & Informasi Terkini
          </h1>
          
          <!-- Subtitle -->
          <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
            Dapatkan informasi terbaru seputar kegiatan dan program kerja kami
          </p>
        </div>
      </div>
    </section>

    <!-- Blog Content -->
    <section class="bg-white py-16">
      <div class="max-w-6xl mx-auto px-4">
        <!-- Search and Filter -->
        <div class="mb-12">
          <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search -->
            <div class="relative flex-1 max-w-md">
              <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" />
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Cari artikel..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
              />
            </div>
            
            <!-- Category Filter -->
            <div class="flex gap-2 flex-wrap">
              <button
                v-for="category in categories"
                :key="category"
                @click="selectedCategory = selectedCategory === category ? null : category"
                class="px-4 py-2 rounded-full text-sm font-medium transition-colors"
                :class="selectedCategory === category 
                  ? 'bg-primary text-white' 
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
              >
                {{ category }}
              </button>
            </div>
          </div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
          <div class="animate-spin rounded-full h-8 w-8 border-2 border-primary mx-auto mb-4"></div>
          <p class="text-gray-600">Memuat artikel...</p>
        </div>

        <!-- Empty State -->
        <div v-else-if="filteredArticles.length === 0" class="text-center py-12">
          <BookOpen class="w-16 h-16 text-gray-300 mx-auto mb-4" />
          <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada artikel</h3>
          <p class="text-gray-500">Artikel akan segera tersedia</p>
        </div>

        <!-- Articles Grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <article
            v-for="article in paginatedArticles"
            :key="article.id"
            class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-200 hover:border-primary/20"
            @click="navigateToArticle(article.slug)"
          >
            <!-- Featured Image -->
            <div class="aspect-video bg-gradient-to-br from-primary/20 to-accent/20 relative overflow-hidden">
              <!-- Actual Image -->
              <img 
                v-if="article.featured_image_url" 
                :src="article.featured_image_url" 
                :alt="article.title"
                class="w-full h-full object-cover"
              />
              <!-- Fallback Icon -->
              <div v-else class="absolute inset-0 flex items-center justify-center">
                <BookOpen class="w-16 h-16 text-primary/60" />
              </div>
              
              <!-- Category Badge -->
              <div class="absolute top-4 left-4">
                <span class="bg-primary text-white text-xs font-medium px-2 py-1 rounded-full">
                  {{ article.category }}
                </span>
              </div>
              <!-- Date Badge -->
              <div class="absolute top-4 right-4">
                <span class="bg-white/90 text-gray-700 text-xs font-medium px-2 py-1 rounded-full">
                  {{ formatDate(article.published_at) }}
                </span>
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <!-- Title -->
              <h3 class="text-xl font-bold text-black mb-3 line-clamp-2 hover:text-primary transition-colors">
                {{ article.title }}
              </h3>

              <!-- Excerpt -->
              <p class="text-gray-600 mb-4 line-clamp-3">
                {{ article.excerpt }}
              </p>

              <!-- Meta Info -->
              <div class="flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center gap-2">
                  <User class="w-4 h-4" />
                  <span>Admin</span>
                  <img src="/verified.png" alt="Verified" class="w-4 h-4" />
                </div>
                <div class="flex items-center gap-2">
                  <Eye class="w-4 h-4" />
                  <span>{{ article.views || 0 }}</span>
                </div>
              </div>

              <!-- Tags -->
              <div v-if="article.tags && article.tags.length > 0" class="mt-4 flex flex-wrap gap-2">
                <span
                  v-for="tag in article.tags.slice(0, 3)"
                  :key="tag"
                  class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full"
                >
                  #{{ tag }}
                </span>
                <span v-if="article.tags.length > 3" class="text-gray-400 text-xs">
                  +{{ article.tags.length - 3 }} lainnya
                </span>
              </div>
            </div>
          </article>
        </div>

        <!-- Pagination -->
        <div v-if="totalPages > 1" class="mt-12 flex justify-center">
          <nav class="flex items-center gap-2">
            <button
              @click="currentPage = Math.max(1, currentPage - 1)"
              :disabled="currentPage === 1"
              class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
              :class="currentPage === 1 
                ? 'text-gray-400 cursor-not-allowed' 
                : 'text-gray-700 hover:bg-gray-100'"
            >
              <ChevronLeft class="w-4 h-4" />
            </button>

            <button
              v-for="page in visiblePages"
              :key="page"
              @click="currentPage = page"
              class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
              :class="currentPage === page 
                ? 'bg-primary text-white' 
                : 'text-gray-700 hover:bg-gray-100'"
            >
              {{ page }}
            </button>

            <button
              @click="currentPage = Math.min(totalPages, currentPage + 1)"
              :disabled="currentPage === totalPages"
              class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
              :class="currentPage === totalPages 
                ? 'text-gray-400 cursor-not-allowed' 
                : 'text-gray-700 hover:bg-gray-100'"
            >
              <ChevronRight class="w-4 h-4" />
            </button>
          </nav>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { 
  BookOpen, 
  Search, 
  User, 
  Eye, 
  ChevronLeft, 
  ChevronRight
} from 'lucide-vue-next';
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';

// Types
interface Article {
  id: number;
  title: string;
  excerpt: string;
  content: string;
  slug: string;
  category: string;
  tags: string[];
  published_at: string;
  views: number;
  status: 'draft' | 'published';
  featured_image_url?: string;
}

// State
const loading = ref(true);
const searchQuery = ref('');
const selectedCategory = ref<string | null>(null);
const currentPage = ref(1);
const itemsPerPage = 9;

// Props
interface Props {
  articles?: Article[];
  categories?: string[];
}

const props = defineProps<Props>();

// Articles data from props
const articles = ref<Article[]>(props.articles || []);

// Categories
const categories = ['Semua', ...(props.categories || ['Kegiatan', 'Pendidikan', 'Ekonomi', 'Legislasi', 'Pemerintahan'])];

// Computed
const filteredArticles = computed(() => {
  let filtered = articles.value.filter(article => article.status === 'published');
  
  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(article => 
      article.title.toLowerCase().includes(query) ||
      article.excerpt.toLowerCase().includes(query) ||
      article.tags.some(tag => tag.toLowerCase().includes(query))
    );
  }
  
  // Filter by category
  if (selectedCategory.value && selectedCategory.value !== 'Semua') {
    filtered = filtered.filter(article => article.category === selectedCategory.value);
  }
  
  return filtered;
});

const totalPages = computed(() => Math.ceil(filteredArticles.value.length / itemsPerPage));

const visiblePages = computed(() => {
  const pages = [];
  const start = Math.max(1, currentPage.value - 2);
  const end = Math.min(totalPages.value, currentPage.value + 2);
  
  for (let i = start; i <= end; i++) {
    pages.push(i);
  }
  
  return pages;
});

const paginatedArticles = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredArticles.value.slice(start, end);
});

// Methods
const formatDate = (dateString: string): string => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });
};

const navigateToArticle = (slug: string) => {
  router.visit(`/blog/${slug}`);
};

// Lifecycle
onMounted(() => {
  // Data is already loaded from props
  loading.value = false;
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
