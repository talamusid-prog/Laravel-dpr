<template>
  <section class="relative min-h-[200px] sm:min-h-[250px] overflow-hidden">
    <!-- Background Image -->
    <div 
      class="absolute inset-0 bg-cover bg-center bg-no-repeat"
      style="background-image: url('/background2.jpg');"
    ></div>
    
    <!-- Overlay -->
    <div class="absolute inset-0 bg-white/60"></div>
    
    <!-- Content -->
    <div class="relative z-10 max-w-6xl mx-auto px-4 py-4 mt-4 mb-8">
      <!-- Loading State -->
      <div v-if="loading" class="flex flex-col items-center justify-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-2 border-red-600 mb-2"></div>
        <p class="text-sm text-gray-600">Memuat artikel...</p>
      </div>
      
      <!-- Empty State -->
      <div v-else-if="!articles || articles.length === 0" class="text-center py-8">
        <p class="text-gray-600">Belum ada artikel tersedia.</p>
      </div>
      
      <!-- Carousel Container -->
      <div v-else class="relative overflow-hidden">
        <div 
          class="flex infinite-scroll"
        >
          <!-- Duplicate articles untuk infinite loop -->
          <div 
            v-for="(article, index) in [...articles, ...articles, ...articles]" 
            :key="`${article.id}-${Math.floor(index / articles.length)}`"
            class="flex-shrink-0 w-1/2"
            :class="{
              'sm:w-1/2': true,
              'md:w-1/3': true,
              'lg:w-1/5': true
            }"
          >
            <div class="px-2 mb-2 sm:mb-0">
              <article 
                class="bg-white rounded-lg border border-primary/20 hover:border-primary/50 p-3 sm:p-4 h-28 sm:h-32 cursor-pointer hover:shadow-lg hover:scale-105 transition-all duration-300"
                style="border: 1px solid rgba(59, 130, 246, 0.2);"
                @click="navigateToArticle(article.slug)"
              >
                <div class="flex h-full">
                  <!-- Number Badge -->
                  <div class="flex-shrink-0 mr-2 sm:mr-3">
                    <span 
                      class="text-3xl sm:text-4xl font-black italic tracking-tight"
                      style="-webkit-text-stroke: 2px var(--color-primary); color: transparent; font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;"
                    >
                      {{ String(index + 1).padStart(2, '0') }}
                    </span>
                  </div>
                  
                  <!-- Content Area -->
                  <div class="flex-1 min-w-0">
                    <!-- Date -->
                    <p class="text-xs text-gray-500 mb-1 sm:mb-2">
                      {{ formatDate(article.published_at) }}
                    </p>
                    
                    <!-- Title -->
                    <h3 
                      class="text-xs sm:text-sm font-bold text-primary line-clamp-2 hover:text-primary/80 transition-colors duration-300 mb-1"
                    >
                      {{ article.title }}
                    </h3>
                    
                    <!-- Description -->
                    <p 
                      class="text-xs text-primary/70 line-clamp-2 hover:text-primary/90 transition-colors duration-300"
                    >
                      {{ article.excerpt }}
                    </p>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

// Props
interface Article {
  id: number;
  title: string;
  excerpt: string;
  slug: string;
  published_at: string;
}

defineProps<{
  articles?: Article[];
}>();

// Reactive data
const loading = ref(false);

// Methods
const formatDate = (dateString: string): string => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
};

const navigateToArticle = (slug: string) => {
  router.visit(`/blog/${slug}`);
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

@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-33.333%);
  }
}

.infinite-scroll {
  animation: scroll 8s linear infinite;
}

.infinite-scroll:hover {
  animation-play-state: paused;
}
</style>
