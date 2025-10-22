<template>
  <div v-if="showNotification" class="fixed top-4 right-4 z-50 max-w-sm">
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
      <!-- Header -->
      <div class="bg-gradient-to-r from-red-500 to-orange-500 px-4 py-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            <Bell class="w-5 h-5 text-white" />
            <span class="text-white font-medium text-sm">Berita Terbaru</span>
          </div>
          <button @click="closeNotification" class="text-white/80 hover:text-white">
            <X class="w-4 h-4" />
          </button>
        </div>
      </div>

      <!-- Content -->
      <div class="p-4">
        <div class="flex gap-3">
          <div class="w-12 h-12 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
            <img 
              v-if="latestNews?.featured_image_url"
              :src="latestNews.featured_image_url" 
              :alt="latestNews.title"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full bg-gradient-to-br from-red-100 to-orange-100 flex items-center justify-center">
              <Newspaper class="w-6 h-6 text-red-500" />
            </div>
          </div>
          
          <div class="flex-1 min-w-0">
            <h4 class="font-semibold text-gray-900 text-sm line-clamp-2 mb-1">
              {{ latestNews?.title || 'Berita Terbaru Tersedia' }}
            </h4>
            <p class="text-xs text-gray-600 mb-2">
              {{ formatTime(latestNews?.published_at) }}
            </p>
            <button 
              @click="viewNews"
              class="text-xs text-red-600 hover:text-red-700 font-medium"
            >
              Baca Selengkapnya →
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Bell, X, Newspaper } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

// State
const showNotification = ref(false);
const latestNews = ref(null);
const notificationTimeout = ref(null);

// Methods
const checkSubscription = () => {
  const subscription = localStorage.getItem('newsletter_subscription');
  return subscription ? JSON.parse(subscription) : null;
};

const checkForNewNews = () => {
  const subscription = checkSubscription();
  if (!subscription) return;

  // Simulate checking for new news
  // In real app, this would be an API call
  const lastChecked = localStorage.getItem('last_news_check');
  const now = new Date().getTime();
  
  // Show notification every 30 seconds for demo purposes
  if (!lastChecked || (now - parseInt(lastChecked)) > 30000) {
    showLatestNews();
    localStorage.setItem('last_news_check', now.toString());
  }
};

const showLatestNews = () => {
  // Simulate latest news data
  latestNews.value = {
    id: Math.floor(Math.random() * 1000),
    title: 'Update Terbaru: Program Pembangunan Infrastruktur di Sulawesi Barat',
    excerpt: 'Dr. Ir. H. AGUS AMBO DJIWA, M.P. mengumumkan program terbaru...',
    slug: 'update-terbaru-program-pembangunan',
    published_at: new Date().toISOString(),
    featured_image_url: null
  };

  showNotification.value = true;

  // Auto close after 10 seconds
  notificationTimeout.value = setTimeout(() => {
    closeNotification();
  }, 10000);
};

const closeNotification = () => {
  showNotification.value = false;
  if (notificationTimeout.value) {
    clearTimeout(notificationTimeout.value);
    notificationTimeout.value = null;
  }
};

const viewNews = () => {
  if (latestNews.value?.slug) {
    router.visit(`/blog/${latestNews.value.slug}`);
  } else {
    router.visit('/blog');
  }
  closeNotification();
};

const formatTime = (dateString) => {
  if (!dateString) return 'Baru saja';
  
  const date = new Date(dateString);
  const now = new Date();
  const diffInMinutes = Math.floor((now - date) / (1000 * 60));
  
  if (diffInMinutes < 1) return 'Baru saja';
  if (diffInMinutes < 60) return `${diffInMinutes} menit yang lalu`;
  
  const diffInHours = Math.floor(diffInMinutes / 60);
  if (diffInHours < 24) return `${diffInHours} jam yang lalu`;
  
  const diffInDays = Math.floor(diffInHours / 24);
  return `${diffInDays} hari yang lalu`;
};

// Lifecycle
onMounted(() => {
  // Check for subscription on mount
  const subscription = checkSubscription();
  if (subscription) {
    // Start checking for new news every 30 seconds
    const interval = setInterval(checkForNewNews, 30000);
    
    // Cleanup interval on unmount
    onUnmounted(() => {
      clearInterval(interval);
    });
  }
});

onUnmounted(() => {
  if (notificationTimeout.value) {
    clearTimeout(notificationTimeout.value);
  }
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
