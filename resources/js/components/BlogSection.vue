<template>
  <section id="blog" class="bg-white py-12 pb-16">
    <div class="max-w-6xl mx-auto px-4">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-red-100 text-red-800 text-sm font-medium px-4 py-2 rounded-full mb-4">
          <BookOpen class="w-4 h-4" />
          BERITA TERBARU
        </div>
        
        <!-- Title -->
        <h2 
          class="text-3xl lg:text-4xl font-bold mb-4"
          style="background: linear-gradient(to right, var(--color-primary), var(--color-primary-dark)); -webkit-background-clip: text; background-clip: text; color: transparent;"
        >
          Berita Terbaru
        </h2>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="grid lg:grid-cols-3 gap-8">
        <!-- Left Column Skeleton -->
        <div class="lg:col-span-2">
          <div class="h-96 bg-gray-200 rounded-2xl animate-pulse"></div>
        </div>
        
        <!-- Right Column Skeleton -->
        <div class="space-y-6">
          <div v-for="i in 3" :key="i" class="h-32 bg-gray-200 rounded-lg animate-pulse"></div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else-if="posts.length === 0" class="text-center py-12">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <BookOpen class="w-8 h-8 text-gray-400" />
        </div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Berita</h3>
        <p class="text-gray-500">Berita akan segera hadir.</p>
      </div>

      <!-- Main Content -->
      <div v-else class="grid lg:grid-cols-3 gap-8">
        <!-- Featured Article (Left Column) -->
        <div class="lg:col-span-2">
          <div class="relative h-96 rounded-2xl overflow-hidden">
            <!-- Slide Container -->
            <div class="relative h-full">
              <div 
                v-for="(post, index) in posts.slice(0, 3)" 
                :key="post.id"
                class="absolute inset-0 transition-opacity duration-500"
                :class="{ 'opacity-100': currentSlide === index, 'opacity-0': currentSlide !== index }"
              >
                <div 
                  class="relative group cursor-pointer h-full"
                  @click="navigateToPost(post.slug)"
                >
                  <!-- Featured Image or Placeholder -->
                  <div v-if="post.featured_image_url" class="w-full h-full">
                    <img 
                      :src="post.featured_image_url" 
                      :alt="post.title"
                      class="w-full h-full object-cover"
                    />
                  </div>
                  <div v-else class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                    <BookOpen class="w-12 h-12 text-primary/60" />
                  </div>
                  
                  <!-- Dark Overlay -->
                  <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                  
                  <!-- Content Overlay -->
                  <div class="absolute bottom-0 p-6 text-white">
                    <!-- Date -->
                    <p class="text-sm text-white/80 mb-2">
                      {{ formatDate(post.published_at) }}
                    </p>
                    
                    <!-- Title -->
                    <h3 class="text-2xl lg:text-3xl font-bold text-red-300 leading-tight">
                      {{ post.title }}
                    </h3>
                  </div>
                </div>
              </div>
            </div>

            <!-- Navigation Controls -->
            <div v-if="posts.length > 1" class="absolute left-4 right-4 top-1/2 -translate-y-1/2 flex justify-between">
              <button 
                @click="previousSlide"
                class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white/30 transition-all duration-300"
              >
                <ChevronLeft class="w-5 h-5 text-white" />
              </button>
              <button 
                @click="nextSlide"
                class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white/30 transition-all duration-300"
              >
                <ChevronRight class="w-5 h-5 text-white" />
              </button>
            </div>

            <!-- Pagination Dots -->
            <div v-if="posts.length > 1" class="flex justify-center mt-6 space-x-2">
              <button 
                v-for="(post, index) in posts.slice(0, 3)" 
                :key="index"
                @click="goToSlide(index)"
                class="w-3 h-3 rounded-full transition-colors"
                :class="currentSlide === index ? 'bg-red-600' : 'bg-white border-2 border-gray-300'"
              ></button>
            </div>
          </div>
        </div>

        <!-- Sidebar Articles (Right Column) -->
        <div class="lg:col-span-1">
          <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
            <div 
              v-for="(post, index) in posts.slice(1, 5)" 
              :key="post.id"
              class="flex gap-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer group transition-colors"
              :class="{ 'hidden lg:flex': index >= 2 }"
              @click="navigateToPost(post.slug)"
            >
              <!-- Thumbnail -->
              <div class="flex-shrink-0">
                <div class="w-20 h-20 rounded-lg overflow-hidden">
                  <img 
                    v-if="post.featured_image_url"
                    :src="post.featured_image_url" 
                    :alt="post.title"
                    class="w-full h-full object-cover"
                  />
                  <div v-else class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                    <BookOpen class="w-6 h-6 text-primary/60" />
                  </div>
                </div>
              </div>
              
              <!-- Content -->
              <div class="flex-1 min-w-0">
                <!-- Category Tag -->
                <span class="inline-block bg-primary text-white text-xs font-medium px-2 py-1 rounded mb-2">
                  BERITA TERBARU
                </span>
                
                <!-- Title -->
                <h4 class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors line-clamp-2 mb-1">
                  {{ post.title }}
                </h4>
                
                <!-- Date -->
                <p class="text-xs text-gray-500">
                  {{ formatDate(post.published_at) }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- View All Button -->
      <div class="text-center mt-12">
        <button 
          class="inline-flex items-center gap-2 border border-primary text-primary hover:bg-primary hover:text-white text-sm sm:text-lg font-medium px-4 sm:px-8 py-2 sm:py-3 rounded-lg transition-colors"
          @click="navigateToPost('all')"
        >
          <span>Lihat Semua Berita</span>
          <ArrowRight class="w-4 h-4" />
        </button>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { BookOpen, ChevronLeft, ChevronRight, ArrowRight } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

// Types
interface BlogPost {
  id: number;
  title: string;
  slug: string;
  published_at: string;
  featured_image_url?: string;
}

// Props
const props = defineProps<{
  posts?: BlogPost[];
}>();

// Reactive data
const loading = ref(false);
const currentSlide = ref(0);
const autoSlideInterval = ref<number | null>(null);

// Use props data instead of dummy data
const posts = computed(() => props.posts || []);

// Methods
const navigateToPost = (slug: string) => {
  if (slug === 'all') {
    router.visit('/blog');
  } else {
    router.visit(`/blog/${slug}`);
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

const nextSlide = () => {
  if (posts.value.length > 1) {
    currentSlide.value = (currentSlide.value + 1) % Math.min(3, posts.value.length);
  }
};

const previousSlide = () => {
  if (posts.value.length > 1) {
    currentSlide.value = currentSlide.value === 0 ? Math.min(2, posts.value.length - 1) : currentSlide.value - 1;
  }
};

const goToSlide = (index: number) => {
  currentSlide.value = index;
};

const startAutoSlide = () => {
  if (posts.value.length > 1) {
    autoSlideInterval.value = setInterval(() => {
      nextSlide();
    }, 5000);
  }
};

const stopAutoSlide = () => {
  if (autoSlideInterval.value) {
    clearInterval(autoSlideInterval.value);
    autoSlideInterval.value = null;
  }
};

// Lifecycle
onMounted(() => {
  // Start auto slide if we have posts
  if (posts.value.length > 1) {
    startAutoSlide();
  }
});

onUnmounted(() => {
  stopAutoSlide();
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
</style>
