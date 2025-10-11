<template>
  <div class="min-h-screen">
    <!-- Header -->
    <Header />
    
    <!-- Main Content -->
    <main class="bg-gradient-to-b from-background to-muted min-h-screen">
      <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-muted-foreground mb-4 sm:mb-6 overflow-x-auto">
          <a 
            href="/" 
            class="flex items-center gap-1 hover:text-primary transition-colors"
            @click="navigateTo('/')"
          >
            <Home class="w-4 h-4" />
            <span class="hidden sm:inline">Beranda</span>
          </a>
          <ChevronRight class="w-4 h-4 flex-shrink-0" />
          <a 
            href="/blog" 
            class="hover:text-primary transition-colors"
            @click="navigateTo('/blog')"
          >
            Blog
          </a>
          <ChevronRight class="w-4 h-4 flex-shrink-0" />
          <span class="text-primary font-medium truncate max-w-[200px] sm:max-w-xs">
            {{ loading ? 'Memuat...' : (post?.title || 'Artikel') }}
          </span>
        </nav>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div>
          <p class="text-muted-foreground mt-4">Memuat artikel...</p>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="text-center py-12">
          <h1 class="text-2xl font-bold text-secondary mb-4">Artikel tidak ditemukan</h1>
          <p class="text-muted-foreground mb-6">
            Artikel yang Anda cari tidak dapat ditemukan atau telah dihapus.
          </p>
          <button 
            @click="navigateTo('/')"
            class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors"
          >
            <ArrowLeft class="w-4 h-4" />
            Kembali ke Beranda
          </button>
        </div>

        <!-- Main Content -->
        <div v-else class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
          <!-- Article Content (Left Column) -->
          <article class="lg:col-span-3">
            <!-- Article Card -->
            <div class="bg-white rounded-lg overflow-hidden mt-6">
              <!-- Article Header -->
              <div class="p-4 sm:p-6 md:p-8">
                <!-- Title -->
                <h1 class="text-2xl md:text-3xl font-bold text-black mb-4 leading-tight text-center">
                  {{ post?.title }}
                </h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground mb-6">
                  <div class="flex items-center gap-1">
                    <User class="w-4 h-4" />
                    <span>{{ post?.author || 'Admin' }}</span>
                  </div>
                  <div class="flex items-center gap-1">
                    <Clock class="w-4 h-4" />
                    <span>{{ formatReadingTime(post?.content || '') }}</span>
                  </div>
                  <div class="flex items-center gap-1">
                    <Eye class="w-4 h-4" />
                    <span>{{ post?.views || 0 }}</span>
                  </div>
                </div>
              </div>

              <!-- Featured Image -->
              <div class="w-full max-w-4xl mx-auto mb-4 rounded-lg overflow-hidden">
                <img
                  v-if="post?.featured_image_url"
                  :src="post.featured_image_url"
                  :alt="post.title"
                  class="w-full h-auto object-contain rounded-lg"
                  loading="eager"
                  decoding="async"
                  @error="handleImageError"
                />
                <div v-else class="w-full h-64 md:h-96 bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center relative z-10 text-center rounded-lg">
                  <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center">
                      <Tag class="w-8 h-8 text-white" />
                    </div>
                    <span class="text-muted-foreground font-medium">Artikel</span>
                  </div>
                </div>
              </div>

              <!-- Article Content -->
              <div class="p-4 sm:p-6 md:p-8">

                <!-- Excerpt -->
                <div v-if="post?.excerpt" class="bg-gray-50 border-l-4 border-gray-300 p-4 mb-6">
                  <p class="text-lg text-gray-800 font-medium">{{ post.excerpt }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-3 mb-8">
                  <ShareButton 
                    :title="post?.title"
                    :url="getCurrentUrl()"
                    :description="post?.excerpt"
                    button-text="Bagikan"
                  />
                  <button class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-md text-sm hover:bg-gray-50 transition-colors">
                    <Bookmark class="w-4 h-4" />
                    Simpan
                  </button>
                  <button class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-md text-sm hover:bg-gray-50 transition-colors">
                    <MessageCircle class="w-4 h-4" />
                    Komentar
                  </button>
                </div>

                <!-- Separator -->
                <div class="border-t border-gray-200 mb-8"></div>

                <!-- Article Content -->
                <div class="prose prose-lg max-w-none">
                  <div 
                    class="leading-loose text-gray-800"
                    v-html="formatContentWithHeadings(post?.content || '')"
                  ></div>
                </div>

                <!-- Tags Section -->
                <div v-if="post?.tags && post.tags.length > 0" class="mt-8 pt-6 border-t border-gray-200">
                  <div class="flex items-center gap-2 mb-4">
                    <Tag class="w-4 h-4 text-orange-500" />
                    <span class="text-sm font-medium text-muted-foreground">Tags:</span>
                  </div>
                  <div class="flex flex-wrap gap-2">
                    <span
                      v-for="tag in post.tags"
                      :key="tag"
                      class="px-2 py-1 text-xs bg-orange-100 text-orange-700 border border-orange-200 rounded-full hover:bg-orange-200 transition-colors cursor-pointer"
                    >
                      #{{ tag }}
                    </span>
                  </div>
                </div>

                <!-- Article Footer -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                  <ShareButton 
                    :title="post?.title"
                    :url="getCurrentUrl()"
                    :description="post?.excerpt"
                    button-text="Bagikan Artikel"
                    class="ml-auto"
                  />
                </div>
              </div>
            </div>
          </article>

          <!-- Sidebar (Right Column) -->
          <aside class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
              <!-- Popular Posts Card -->
              <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-black mb-4">Berita Populer</h3>
                <div class="space-y-4">
                  <article
                    v-for="popularPost in props.popularPosts"
                    :key="popularPost.id"
                    class="flex gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded-md transition-colors"
                    @click="navigateToArticle(popularPost.slug)"
                  >
                    <div class="w-16 h-16 rounded-md flex items-center justify-center flex-shrink-0 overflow-hidden">
                      <!-- Actual Image -->
                      <img 
                        v-if="popularPost.featured_image_url" 
                        :src="popularPost.featured_image_url" 
                        :alt="popularPost.title"
                        class="w-full h-full object-cover"
                      />
                      <!-- Fallback Icon -->
                      <div v-else class="w-full h-full bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                      <BookOpen class="w-6 h-6 text-primary" />
                      </div>
                    </div>
                    <div class="flex-1 min-w-0">
                      <h4 class="text-sm font-medium text-gray-900 line-clamp-2 mb-1">
                        {{ popularPost.title }}
                      </h4>
                      <p class="text-xs text-gray-500">
                        {{ formatDate(popularPost.published_at) }}
                      </p>
                    </div>
                  </article>
                </div>
              </div>

              <!-- Popular Tags Card -->
              <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-black mb-4">Tag Terpopuler</h3>
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="tag in popularTags"
                    :key="tag"
                    class="px-2 py-1 text-xs bg-orange-100 text-orange-700 border border-orange-200 rounded-full hover:bg-orange-200 transition-colors cursor-pointer"
                    @click="navigateToTag(tag)"
                  >
                    #{{ tag }}
                  </span>
                </div>
              </div>

            </div>
          </aside>
        </div>

        <!-- Related Articles Section -->
        <div class="mt-8">
          <div class="bg-white rounded-lg p-4">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Artikel Terkait</h2>
            
            <!-- Slider Container -->
            <div class="relative">
              <!-- Slider Wrapper -->
              <div class="overflow-hidden">
                <div 
                  ref="sliderContainer"
                  class="flex transition-transform duration-300 ease-in-out"
                  :style="{ transform: `translateX(-${currentSlide * slideWidth}px)` }"
                >
                  <!-- Related Article Cards -->
                  <div 
                    v-for="relatedArticle in relatedArticles" 
                    :key="relatedArticle.id"
                    class="flex-shrink-0 px-1"
                    :style="{ width: slideWidth + 'px' }"
                  >
                    <article class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow cursor-pointer">
                      <!-- Article Image -->
                      <div class="aspect-video bg-gradient-to-br from-primary/20 to-accent/20 relative overflow-hidden">
                        <img 
                          v-if="relatedArticle.featured_image_url" 
                          :src="relatedArticle.featured_image_url" 
                          :alt="relatedArticle.title"
                          class="w-full h-full object-cover"
                        />
                        <div v-else class="absolute inset-0 flex items-center justify-center">
                          <BookOpen class="w-12 h-12 text-primary/60" />
                        </div>
                      </div>
                      
                      <!-- Article Content -->
                      <div class="p-3">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                          {{ relatedArticle.title }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                          {{ relatedArticle.excerpt }}
                        </p>
                      </div>
                    </article>
                  </div>
                </div>
              </div>

              <!-- Navigation Buttons -->
              <button 
                v-if="canSlideLeft"
                @click="slideLeft"
                class="absolute left-0 top-1/2 -translate-y-1/2 -ml-4 w-8 h-8 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors shadow-md"
              >
                <ChevronLeft class="w-4 h-4 text-gray-600" />
              </button>
              
              <button 
                v-if="canSlideRight"
                @click="slideRight"
                class="absolute right-0 top-1/2 -translate-y-1/2 -mr-4 w-8 h-8 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors shadow-md"
              >
                <ChevronRight class="w-4 h-4 text-gray-600" />
              </button>
            </div>

          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <Footer />
    
    <!-- Back to Top Button -->
    <BackToTop />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { 
  Home, 
  ChevronRight, 
  ChevronLeft,
  ArrowLeft, 
  User, 
  Clock, 
  Eye, 
  Share2, 
  Bookmark, 
  MessageCircle, 
  Tag, 
  BookOpen 
} from 'lucide-vue-next';
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import BackToTop from '@/components/BackToTop.vue';
import ShareButton from '@/components/ShareButton.vue';

// Types
interface Post {
  id: number;
  title: string;
  excerpt: string;
  content: string;
  slug: string;
  featured_image?: string;
  featured_image_url?: string;
  author: string;
  views: number;
  tags: string[];
  published_at: string;
  category: string;
}

// Props
interface Props {
  article: Post;
  popularPosts: Post[];
  popularTags: string[];
}

const props = defineProps<Props>();

// State
const loading = ref(false);
const error = ref(false);
const post = ref<Post | null>(props.article);
const imageError = ref(false);

// Slider state
const currentSlide = ref(0);
const slideWidth = ref(0);
const sliderContainer = ref<HTMLElement | null>(null);
const relatedArticles = ref<Post[]>([]);

// Methods

const handleImageError = () => {
  imageError.value = true;
};

const formatDate = (dateString: string): string => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  });
};

const formatReadingTime = (content: string): string => {
  const wordsPerMinute = 200;
  const wordCount = content.split(' ').length;
  const minutes = Math.ceil(wordCount / wordsPerMinute);
  return `${minutes} menit membaca`;
};

const formatContentWithHeadings = (content: string): string => {
  if (!content) return '';
  
  let formatted = content;
  
  // If content already contains HTML tags, process them
  if (formatted.includes('<h1>') || formatted.includes('<h2>') || formatted.includes('<h3>')) {
    // Process existing HTML headings
    formatted = formatted
      .replace(/<h1[^>]*>(.*?)<\/h1>/gi, '<h1 class="text-2xl font-bold text-gray-900 mb-6 mt-8">$1</h1>')
      .replace(/<h2[^>]*>(.*?)<\/h2>/gi, '<h2 class="text-xl font-bold text-gray-900 mb-4 mt-8">$1</h2>')
      .replace(/<h3[^>]*>(.*?)<\/h3>/gi, '<h3 class="text-lg font-bold text-gray-900 mb-3 mt-6">$1</h3>');
  } else {
    // Convert markdown-style headings to HTML
    formatted = formatted
      .replace(/^### (.*$)/gim, '<h3 class="text-lg font-bold text-gray-900 mb-3 mt-6">$1</h3>')
      .replace(/^## (.*$)/gim, '<h2 class="text-xl font-bold text-gray-900 mb-4 mt-8">$1</h2>')
      .replace(/^# (.*$)/gim, '<h1 class="text-2xl font-bold text-gray-900 mb-6 mt-8">$1</h1>');
  }
  
  // Process existing HTML lists or convert markdown lists
  if (formatted.includes('<ul>') || formatted.includes('<ol>')) {
    // Process existing HTML lists
    formatted = formatted
      .replace(/<ul[^>]*>/gi, '<ul class="list-disc list-inside mb-6 space-y-2">')
      .replace(/<ol[^>]*>/gi, '<ol class="list-decimal list-inside mb-6 space-y-2">')
      .replace(/<li[^>]*>(.*?)<\/li>/gi, '<li class="mb-2">$1</li>');
  } else {
    // Convert markdown lists
    formatted = formatted.replace(/^(\d+)\. (.*$)/gim, '<li class="mb-2"><strong>$1.</strong> $2</li>');
    formatted = formatted.replace(/^[-*•] (.*$)/gim, '<li class="mb-2">• <strong>$1</strong></li>');
    
    // Wrap lists in proper containers
    formatted = formatted.replace(/(<li class="mb-2">.*<\/li>)/gs, (match) => {
      // Check if it's a numbered list
      if (match.includes('<strong>') && match.includes('.</strong>')) {
        return `<ol class="list-decimal list-inside mb-6 space-y-2">${match}</ol>`;
      } else {
        return `<ul class="list-disc list-inside mb-6 space-y-2">${match}</ul>`;
      }
    });
  }
  
  // Process paragraphs
  if (formatted.includes('<p>')) {
    // Process existing HTML paragraphs
    formatted = formatted.replace(/<p[^>]*>(.*?)<\/p>/gi, '<p class="mb-6 text-gray-800 leading-relaxed">$1</p>');
  } else {
    // Convert line breaks to paragraphs
    const paragraphs = formatted.split('\n\n');
    formatted = paragraphs.map(p => {
      const trimmed = p.trim();
      if (!trimmed) return '';
      
      // Skip if already wrapped in HTML tags
      if (trimmed.startsWith('<h') || trimmed.startsWith('<li') || trimmed.startsWith('<ul') || trimmed.startsWith('<ol')) {
        return trimmed;
      }
      
      // Wrap in paragraph with proper styling
      return `<p class="mb-6 text-gray-800 leading-relaxed">${trimmed}</p>`;
    }).filter(p => p).join('');
  }
  
  // Process blockquotes
  formatted = formatted.replace(/<blockquote[^>]*>(.*?)<\/blockquote>/gi, 
    '<blockquote class="border-l-4 border-blue-500 pl-4 py-2 my-6 italic text-gray-600 bg-gray-50">$1</blockquote>');
  
  // Process links
  formatted = formatted.replace(/<a[^>]*href="([^"]*)"[^>]*>(.*?)<\/a>/gi, 
    '<a href="$1" class="text-blue-600 hover:text-blue-800 underline" target="_blank" rel="noopener noreferrer">$2</a>');
  
  // Process strong/bold text
  formatted = formatted.replace(/<strong[^>]*>(.*?)<\/strong>/gi, '<strong class="font-semibold text-gray-900">$1</strong>');
  
  // Process tables
  formatted = formatted.replace(/<table[^>]*>(.*?)<\/table>/gi, 
    '<div class="overflow-x-auto my-6"><table class="min-w-full border-collapse border border-gray-300">$1</table></div>');
  formatted = formatted.replace(/<th[^>]*>(.*?)<\/th>/gi, 
    '<th class="border border-gray-300 px-4 py-2 bg-gray-100 font-semibold text-left">$1</th>');
  formatted = formatted.replace(/<td[^>]*>(.*?)<\/td>/gi, 
    '<td class="border border-gray-300 px-4 py-2">$1</td>');
  
  return formatted;
};

// Slider computed properties
const totalSlides = computed(() => {
  const cardsPerView = window.innerWidth >= 1024 ? 3 : 2;
  return Math.ceil(relatedArticles.value.length / cardsPerView);
});

const canSlideLeft = computed(() => currentSlide.value > 0);
const canSlideRight = computed(() => currentSlide.value < totalSlides.value - 1);

// Slider methods
const updateSlideWidth = () => {
  if (sliderContainer.value) {
    const containerWidth = sliderContainer.value.offsetWidth;
    const cardsPerView = window.innerWidth >= 1024 ? 3 : 2;
    slideWidth.value = containerWidth / cardsPerView;
  }
};

const slideLeft = () => {
  if (canSlideLeft.value) {
    currentSlide.value--;
  }
};

const slideRight = () => {
  if (canSlideRight.value) {
    currentSlide.value++;
  }
};


// Initialize related articles (mock data for now)
const initializeRelatedArticles = () => {
  // This would typically come from props or API call
  relatedArticles.value = props.popularPosts.slice(0, 6); // Take first 6 popular posts as related
};

const navigateTo = (path: string) => {
  router.visit(path);
};

const navigateToArticle = (slug: string) => {
  router.visit(`/blog/${slug}`);
};

const navigateToTag = (tag: string) => {
  router.visit(`/blog?search=${encodeURIComponent(tag)}`);
};

const getCurrentUrl = () => {
  return window.location.href;
};


// Lifecycle
onMounted(() => {
  // Initialize with props data
  if (!props.article) {
    error.value = true;
  }
  
  // Initialize slider
  initializeRelatedArticles();
  updateSlideWidth();
  
  // Update slide width on window resize
  window.addEventListener('resize', updateSlideWidth);
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

/* Prose styling for article content */
.prose h1 {
  font-size: 1.875rem;
  font-weight: 700;
  color: #111827;
  margin-bottom: 1.5rem;
  margin-top: 2rem;
  line-height: 1.2;
}

.prose h2 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #111827;
  margin-bottom: 1rem;
  margin-top: 2rem;
  line-height: 1.3;
}

.prose h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #111827;
  margin-bottom: 0.75rem;
  margin-top: 1.5rem;
  line-height: 1.4;
}

.prose p {
  margin-bottom: 1.5rem;
  line-height: 1.7;
  color: #374151;
  font-size: 1rem;
}

.prose ul {
  margin-bottom: 1.5rem;
  padding-left: 0;
  list-style: none;
}

.prose ol {
  margin-bottom: 1.5rem;
  padding-left: 0;
  list-style: none;
}

.prose li {
  margin-bottom: 0.75rem;
  padding-left: 1.5rem;
  position: relative;
}

.prose ul li::before {
  content: "•";
  color: #3b82f6;
  font-weight: bold;
  position: absolute;
  left: 0;
}

.prose ol li::before {
  content: counter(list-counter) ".";
  counter-increment: list-counter;
  color: #3b82f6;
  font-weight: bold;
  position: absolute;
  left: 0;
}

.prose ol {
  counter-reset: list-counter;
}

.prose li strong {
  font-weight: 600;
  color: #111827;
}

.prose blockquote {
  border-left: 4px solid #3b82f6;
  padding-left: 1rem;
  margin: 1.5rem 0;
  font-style: italic;
  color: #6b7280;
  background-color: #f9fafb;
  padding: 1rem;
  border-radius: 0.375rem;
}

.prose a {
  color: #3b82f6;
  text-decoration: underline;
  font-weight: 500;
}

.prose a:hover {
  color: #1d4ed8;
}

.prose strong {
  font-weight: 600;
  color: #111827;
}

.prose table {
  border-collapse: collapse;
  width: 100%;
  margin: 1.5rem 0;
  border: 1px solid #d1d5db;
}

.prose th {
  background-color: #f9fafb;
  font-weight: 600;
  padding: 0.75rem;
  text-align: left;
  border: 1px solid #d1d5db;
}

.prose td {
  padding: 0.75rem;
  border: 1px solid #d1d5db;
}

.prose tr:nth-child(even) {
  background-color: #f9fafb;
}

/* Additional styling for better readability */
.prose {
  max-width: none;
}

.prose * {
  max-width: 100%;
}
</style>
