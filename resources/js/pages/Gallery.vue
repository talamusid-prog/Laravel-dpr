<template>
  <div class="min-h-screen bg-gray-50">
    <Header />
    
    <!-- Hero Section -->
    <section class="bg-white py-16 mt-8">
      <div class="max-w-7xl mx-auto px-4">
        <div class="text-center">
          <h1 class="text-4xl lg:text-5xl font-bold mb-4 text-red-600">
            Galeri Dokumentasi
          </h1>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Dokumentasi kegiatan dan aktivitas Dr. Ir. H. AGUS AMBO DJIWA, M.P. sebagai Anggota DPR-RI Dapil Sulawesi Barat
          </p>
        </div>
      </div>
    </section>


    <!-- Gallery Section -->
    <section class="py-6">
      <div class="max-w-7xl mx-auto px-4">
        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div>
          <p class="mt-4 text-gray-600">Memuat galeri...</p>
        </div>

        <!-- Gallery Grid -->
        <div v-else-if="galleries.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="(gallery, index) in galleries.data"
            :key="gallery.id"
            class="group cursor-pointer"
            @click="openLightbox(index)"
          >
            <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 group-hover:scale-105">
              <!-- Image -->
              <img
                :src="gallery.thumbnail_url || gallery.image_url"
                :alt="gallery.title"
                class="w-full h-auto object-cover"
                loading="lazy"
              />

              <!-- Documentation Pattern Overlay -->
              <div class="absolute inset-0 opacity-25">
                <!-- Vertical Lines -->
                <div class="absolute top-0 left-1/4 w-0.5 h-full bg-gradient-to-b from-transparent via-white/60 to-transparent"></div>
                <div class="absolute top-0 left-1/2 w-0.5 h-full bg-gradient-to-b from-transparent via-white/50 to-transparent"></div>
                <div class="absolute top-0 left-3/4 w-0.5 h-full bg-gradient-to-b from-transparent via-white/55 to-transparent"></div>
                
                <!-- Horizontal Lines -->
                <div class="absolute top-1/4 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-white/50 to-transparent"></div>
                <div class="absolute top-3/4 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-white/55 to-transparent"></div>
                
                <!-- Diagonal Lines -->
                <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-white/40 to-transparent transform rotate-12 origin-left"></div>
                <div class="absolute bottom-0 right-0 w-full h-0.5 bg-gradient-to-l from-transparent via-white/40 to-transparent transform -rotate-12 origin-right"></div>
              </div>

              <!-- Overlay -->
              <div class="absolute inset-0 bg-black/0 group-hover:bg-black/50 transition-all duration-300 flex items-center justify-center">
                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center text-white p-4">
                  <h3 class="font-semibold text-lg mb-2">{{ gallery.title }}</h3>
                  <p v-if="gallery.description" class="text-sm mb-2">{{ gallery.description }}</p>
                  <div class="flex items-center justify-center gap-2">
                    <Calendar class="w-4 h-4" />
                    <span class="text-xs">{{ formatDate(gallery.created_at) }}</span>
                  </div>
                </div>
              </div>

              <!-- Category Badge -->
              <div class="absolute top-3 left-3">
                <span
                  class="px-2 py-1 text-xs font-medium rounded-full text-white"
                  :class="getCategoryColor(gallery.category)"
                >
                  {{ gallery.category }}
                </span>
              </div>

              <!-- Featured Badge -->
              <div v-if="gallery.is_featured" class="absolute top-3 right-3">
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-500 text-white">
                  Featured
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12">
          <Image class="w-16 h-16 text-gray-400 mx-auto mb-4" />
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada dokumentasi</h3>
          <p class="text-gray-600">Belum ada dokumentasi yang tersedia saat ini.</p>
        </div>

        <!-- Pagination -->
        <div v-if="galleries.data.length > 0" class="mt-12 flex justify-center">
          <nav class="flex items-center space-x-2">
            <button
              v-for="link in galleries.links"
              :key="link.label"
              @click="handlePageChange(link.url)"
              :disabled="!link.url"
              class="px-3 py-2 text-sm font-medium rounded-md transition-colors"
              :class="link.active 
                ? 'bg-primary text-white' 
                : link.url 
                  ? 'text-gray-700 hover:bg-gray-100' 
                  : 'text-gray-400 cursor-not-allowed'"
              v-html="link.label"
            />
          </nav>
        </div>
      </div>
    </section>

    <!-- Lightbox Modal -->
    <div
      v-if="lightboxOpen"
      class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
      @click="closeLightbox"
    >
      <div class="relative max-w-6xl max-h-full" @click.stop>
        <button
          @click="closeLightbox"
          class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors"
        >
          <X class="w-8 h-8" />
        </button>

        <img
          :src="galleries.data[currentIndex].image_url"
          :alt="galleries.data[currentIndex].title"
          class="max-w-full max-h-full rounded-lg"
        />

        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-white">
          <h3 class="text-2xl font-semibold mb-2">{{ galleries.data[currentIndex].title }}</h3>
          <p v-if="galleries.data[currentIndex].description" class="text-sm mb-2">
            {{ galleries.data[currentIndex].description }}
          </p>
          <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
              <Calendar class="w-4 h-4" />
              <span class="text-sm">{{ formatDate(galleries.data[currentIndex].created_at) }}</span>
            </div>
            <span
              class="px-2 py-1 text-xs font-medium rounded-full text-white"
              :class="getCategoryColor(galleries.data[currentIndex].category)"
            >
              {{ galleries.data[currentIndex].category }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Calendar, Image, X } from 'lucide-vue-next';
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import { router } from '@inertiajs/vue3';

// Props from controller
interface Props {
  galleries: {
    data: Array<{
      id: number;
      title: string;
      description?: string;
      image: string;
      image_url?: string;
      thumbnail_url?: string;
      category: string;
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

defineProps<Props>();

// Reactive data
const loading = ref(false);
const lightboxOpen = ref(false);
const currentIndex = ref(0);

// Methods
const getCategoryColor = (category: string) => {
  const colorMap: Record<string, string> = {
    'Politik': 'bg-blue-500',
    'Kegiatan': 'bg-green-500',
    'Sosialisasi': 'bg-purple-500',
    'Kerjasama': 'bg-orange-500',
    'Acara': 'bg-red-500',
    'Masyarakat': 'bg-indigo-500',
    'Pendidikan': 'bg-pink-500',
    'Ekonomi': 'bg-teal-500'
  };
  return colorMap[category] || 'bg-gray-500';
};

const formatDate = (dateString: string): string => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
};

const openLightbox = (index: number) => {
  currentIndex.value = index;
  lightboxOpen.value = true;
};

const closeLightbox = () => {
  lightboxOpen.value = false;
};


const handlePageChange = (url: string | null) => {
  if (url) {
    loading.value = true;
    router.visit(url, {
      onFinish: () => {
        loading.value = false;
      }
    });
  }
};

// Lifecycle
onMounted(() => {
  // Any initialization logic
});
</script>

<style scoped>
/* Custom styles for gallery grid */
.group {
  aspect-ratio: 16/10;
  overflow: hidden;
  border-radius: 0.75rem;
}

.group img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.3s ease;
}

.group:hover img {
  transform: scale(1.05);
}
</style>
