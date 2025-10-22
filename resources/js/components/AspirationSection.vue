<template>
  <section class="relative pt-8 pb-16 overflow-hidden">
    <!-- Split Background -->
    <div class="absolute inset-0">
      <!-- Top Half - Gradient Primary with Background Image -->
      <div 
        class="absolute inset-0 h-1/2"
        style="background: linear-gradient(135deg, var(--color-primary), rgba(var(--color-primary), 0.8));"
      >
        <div 
          class="absolute inset-0 opacity-40"
          style="background-image: url('/background2.png'); background-size: cover; background-position: center;"
        ></div>
      </div>
      
      <!-- Bottom Half - White Background -->
      <div class="absolute inset-0 top-1/2 bg-white"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-6xl mx-auto px-4">
      <!-- Header Section -->
      <div class="text-center mb-8">
        <h2 
          class="text-3xl lg:text-4xl font-bold mb-4"
          style="background: linear-gradient(to right, var(--color-primary), var(--color-primary-dark)); -webkit-background-clip: text; background-clip: text; color: transparent;"
        >
          Dokumentasi Kegiatan
        </h2>
        <p class="text-lg text-black">
          Galeri Foto dan Dokumentasi Kegiatan Dr. Ir. H. AGUS AMBO DJIWA, M.P.
        </p>
      </div>

      <!-- Gallery Masonry Container -->
      <div class="bg-white rounded-2xl border border-gray-200 p-4 lg:p-8">
        <!-- Gallery Grid -->
        <div class="columns-1 md:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
          <!-- Gallery Items -->
          <div 
            v-for="(item, index) in galleryItems" 
            :key="item.id"
            class="break-inside-avoid mb-4 group cursor-pointer"
            @click="openLightbox(index)"
          >
            <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 group-hover:scale-105">
              <!-- Image -->
              <img 
                :src="item.image" 
                :alt="item.title"
                class="w-full h-auto object-cover"
                :class="item.height"
              />
              
              <!-- Overlay -->
              <div class="absolute inset-0 bg-black/0 group-hover:bg-black/50 transition-all duration-300 flex items-center justify-center">
                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center text-white p-4">
                  <h3 class="font-semibold text-lg">{{ item.title }}</h3>
                </div>
              </div>
              
              <!-- Category Badge -->
              <div class="absolute top-3 left-3">
                <span 
                  class="px-2 py-1 text-xs font-medium rounded-full text-white"
                  :class="getCategoryColor(item.category)"
                >
                  {{ item.category }}
                    </span>
                  </div>
                </div>
              </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="text-center mt-8 space-y-4">
          <!-- Load More Button -->
          <a
            href="/gallery"
            class="inline-flex items-center bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-medium px-6 py-3 rounded-full transition-all duration-300 hover:shadow-lg"
          >
            Lihat Lebih Banyak
          </a>
          
        </div>
      </div>
      
      <!-- Lightbox Modal -->
      <div 
        v-if="lightboxOpen" 
        class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
        @click="closeLightbox"
      >
        <div class="relative max-w-4xl max-h-full" @click.stop>
          <button 
            @click="closeLightbox"
            class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors"
          >
            <X class="w-8 h-8" />
          </button>
          
          <img 
            :src="galleryItems[currentIndex].image" 
            :alt="galleryItems[currentIndex].title"
            class="max-w-full max-h-full rounded-lg"
          />
          
          <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-white">
            <h3 class="text-xl font-semibold mb-2">{{ galleryItems[currentIndex].title }}</h3>
            <p class="text-sm mb-2">{{ galleryItems[currentIndex].description }}</p>
            <div class="flex items-center gap-2">
              <Calendar class="w-4 h-4" />
              <span class="text-xs">{{ formatDate(galleryItems[currentIndex].created_at) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Calendar, X } from 'lucide-vue-next';

// Types
interface GalleryItem {
  id: number;
  title: string;
  description: string;
  image: string;
  category: string;
  created_at: string;
  height?: string;
}

// Props from controller
interface Props {
  galleryItems?: GalleryItem[];
}

const props = defineProps<Props>();

// Reactive data
const loading = ref(true);
const lightboxOpen = ref(false);
const currentIndex = ref(0);

// Gallery data from props or fallback
const galleryItems = ref<GalleryItem[]>(props.galleryItems || []);

// Fallback data if no props provided
const fallbackData: GalleryItem[] = [
  {
    id: 1,
    title: "Rapat DPR-RI",
    description: "Sidang paripurna DPR-RI membahas RUU penting",
    image: "/gallery/rapat-dpr.jpg",
    category: "Politik",
    created_at: "2024-01-15",
    height: "h-64"
  },
  {
    id: 2,
    title: "Kunjungan Kerja",
    description: "Kunjungan kerja ke Sulawesi Barat",
    image: "/gallery/kunjungan-kerja.jpg",
    category: "Kegiatan",
    created_at: "2024-01-14",
    height: "h-80"
  },
  {
    id: 3,
    title: "Sosialisasi Program",
    description: "Sosialisasi program pembangunan di masyarakat",
    image: "/gallery/sosialisasi.jpg",
    category: "Sosialisasi",
    created_at: "2024-01-13",
    height: "h-72"
  },
  {
    id: 4,
    title: "Rapat Komisi",
    description: "Rapat komisi membahas anggaran daerah",
    image: "/gallery/rapat-komisi.jpg",
    category: "Politik",
    created_at: "2024-01-12",
    height: "h-60"
  },
  {
    id: 5,
    title: "Penandatanganan MoU",
    description: "Penandatanganan MoU dengan perguruan tinggi",
    image: "/gallery/mou.jpg",
    category: "Kerjasama",
    created_at: "2024-01-11",
    height: "h-96"
  },
  {
    id: 6,
    title: "Hari Kemerdekaan",
    description: "Upacara peringatan hari kemerdekaan RI",
    image: "/gallery/17-agustus.jpg",
    category: "Acara",
    created_at: "2024-01-10",
    height: "h-68"
  },
  {
    id: 7,
    title: "Rapat dengan Masyarakat",
    description: "Rapat koordinasi dengan tokoh masyarakat",
    image: "/gallery/rapat-masyarakat.jpg",
    category: "Masyarakat",
    created_at: "2024-01-09",
    height: "h-76"
  },
  {
    id: 8,
    title: "Kunjungan ke Sekolah",
    description: "Kunjungan ke sekolah untuk program pendidikan",
    image: "/gallery/kunjungan-sekolah.jpg",
    category: "Pendidikan",
    created_at: "2024-01-08",
    height: "h-84"
  }
];

// Use fallback data if no props provided
if (!props.galleryItems || props.galleryItems.length === 0) {
  galleryItems.value = fallbackData;
}

// Methods
const getCategoryColor = (category: string) => {
  const colorMap: Record<string, string> = {
    'Politik': 'bg-blue-500',
    'Kegiatan': 'bg-green-500',
    'Sosialisasi': 'bg-purple-500',
    'Kerjasama': 'bg-orange-500',
    'Acara': 'bg-red-500',
    'Masyarakat': 'bg-indigo-500',
    'Pendidikan': 'bg-pink-500'
  };
  return colorMap[category] || 'bg-gray-500';
};

const openLightbox = (index: number) => {
  currentIndex.value = index;
  lightboxOpen.value = true;
};

const closeLightbox = () => {
  lightboxOpen.value = false;
};


const formatDate = (dateString: string): string => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
};




// Lifecycle
onMounted(() => {
  // Simulate loading
  setTimeout(() => {
    loading.value = false;
  }, 1000);
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
