<template>
  <section id="blog" class="bg-white py-4 sm:py-12 pb-8 sm:pb-16">
    <div class="max-w-6xl mx-auto px-4">
      <!-- Header Section -->
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 sm:mb-8 gap-3 sm:gap-0">
        <!-- Title -->
        <h2 
          class="text-3xl lg:text-4xl font-bold mb-4"
          style="background: linear-gradient(to right, var(--color-primary), var(--color-primary-dark)); -webkit-background-clip: text; background-clip: text; color: transparent;"
        >
          Berita Utama
        </h2>
        
        <!-- View All Link -->
        <button 
          class="bg-red-600 hover:bg-red-700 text-white font-medium text-sm px-4 py-2 rounded-lg transition-colors self-end sm:self-auto shadow-sm hover:shadow-md"
          @click="navigateToPost('all')"
        >
          Lihat Semua
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="relative">
        <div class="h-80 bg-gray-200 rounded-2xl animate-pulse"></div>
      </div>

      <!-- Empty State -->
      <div v-else-if="posts.length === 0" class="text-center py-12">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <BookOpen class="w-8 h-8 text-gray-400" />
        </div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Berita</h3>
        <p class="text-gray-500">Berita akan segera hadir.</p>
      </div>

      <!-- Main Carousel Content -->
      <div v-else class="relative">
        <!-- Carousel Container -->
        <div class="relative overflow-hidden rounded-2xl">
          <!-- Slide Container -->
          <div 
            class="flex transition-transform duration-700 ease-out"
            :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
            @touchstart="handleTouchStart"
            @touchmove="handleTouchMove"
            @touchend="handleTouchEnd"
          >
            <!-- Slide Pages -->
            <div 
              v-for="(page, pageIndex) in paginatedPosts" 
              :key="pageIndex"
              class="w-full flex-shrink-0"
            >
              <!-- Cards Grid -->
              <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-1 lg:gap-0">
                <!-- Mobile: Show only first 2 cards, Desktop: Show all 4 cards -->
                <div 
                  v-for="(post, index) in page" 
                  :key="post.id"
                  class="relative group cursor-pointer aspect-[1300/1900] max-h-80 sm:max-h-96 rounded-xl overflow-hidden"
                  :class="{ 'hidden lg:block': index >= 2 }"
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
                  <div v-else class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                    <BookOpen class="w-12 h-12 text-blue-400" />
                  </div>
                  
                  <!-- Dark Overlay -->
                  <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                  
                  <!-- Content Overlay -->
                  <div class="absolute bottom-0 left-0 right-0 text-white">
                    <!-- Title with Glassmorphism Effect -->
                    <div class="backdrop-blur-md bg-white/10 rounded-xl p-3 sm:p-4 border border-white/20 min-h-16 sm:min-h-20">
                      <!-- Berita Utama Label inside glassmorphism -->
                      <div class="inline-block bg-red-600/90 text-white text-xs font-medium px-2 py-0.5 rounded-full mb-3">
                        Berita Utama
                      </div>
                      
                      <!-- Title -->
                      <h3 class="text-xs sm:text-sm lg:text-base font-bold leading-tight line-clamp-2 sm:line-clamp-3 text-white drop-shadow-lg">
                        {{ post.title }}
                      </h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Navigation Controls -->
        <div v-if="totalPages > 1" class="absolute left-2 right-2 sm:left-4 sm:right-4 top-1/2 -translate-y-1/2 flex justify-between">
          <button 
            @click="previousSlide"
            class="w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white transition-all duration-300 shadow-lg"
          >
            <ChevronLeft class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700" />
          </button>
          <button 
            @click="nextSlide"
            class="w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white transition-all duration-300 shadow-lg"
          >
            <ChevronRight class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700" />
          </button>
        </div>

        <!-- Pagination Dots -->
        <div v-if="totalPages > 1" class="flex justify-center mt-6 space-x-2">
          <button 
            v-for="pageIndex in totalPages" 
            :key="pageIndex"
            @click="goToSlide(pageIndex - 1)"
            class="w-3 h-3 rounded-full transition-colors"
            :class="currentSlide === (pageIndex - 1) ? 'bg-orange-500' : 'bg-gray-300'"
          ></button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { BookOpen, ChevronLeft, ChevronRight } from 'lucide-vue-next';
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
const touchStartX = ref(0);
const touchEndX = ref(0);

// Use props data
const posts = computed(() => {
  return props.posts || [];
});

// Pagination logic - responsive posts per page
const postsPerPage = computed(() => {
  // Always use 4 cards per page, but CSS will handle responsive display
  return 4;
});

const totalPages = computed(() => Math.ceil(posts.value.length / postsPerPage.value));

const paginatedPosts = computed(() => {
  const pages = [];
  for (let i = 0; i < posts.value.length; i += postsPerPage.value) {
    pages.push(posts.value.slice(i, i + postsPerPage.value));
  }
  return pages;
});

// Methods
const navigateToPost = (slug: string) => {
  if (slug === 'all') {
    router.visit('/blog');
  } else {
    router.visit(`/blog/${slug}`);
  }
};


// const formatDate = (dateString: string): string => {
//   const date = new Date(dateString);
//   return date.toLocaleDateString('id-ID', {
//     day: '2-digit',
//     month: 'short',
//     year: 'numeric'
//   });
// };

const nextSlide = () => {
  if (totalPages.value > 1) {
    const oldSlide = currentSlide.value;
    currentSlide.value = (currentSlide.value + 1) % totalPages.value;
    console.log('Sliding from', oldSlide, 'to', currentSlide.value);
  }
};

const previousSlide = () => {
  if (totalPages.value > 1) {
    currentSlide.value = currentSlide.value === 0 ? totalPages.value - 1 : currentSlide.value - 1;
  }
};

const goToSlide = (index: number) => {
  currentSlide.value = index;
};

// Touch events for swipe
const handleTouchStart = (e: TouchEvent) => {
  touchStartX.value = e.touches[0].clientX;
};

const handleTouchMove = (e: TouchEvent) => {
  touchEndX.value = e.touches[0].clientX;
};

const handleTouchEnd = () => {
  if (!touchStartX.value || !touchEndX.value) return;
  
  const distance = touchStartX.value - touchEndX.value;
  const isLeftSwipe = distance > 50;
  const isRightSwipe = distance < -50;
  
  if (isLeftSwipe) {
    nextSlide();
  } else if (isRightSwipe) {
    previousSlide();
  }
  
  // Reset touch values
  touchStartX.value = 0;
  touchEndX.value = 0;
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
