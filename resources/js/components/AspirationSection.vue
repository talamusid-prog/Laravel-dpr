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
          Update Aspirasi Masyarakat
        </h2>
        <p class="text-lg text-black">
          Pantau Perkembangan Aspirasi yang Telah Diterima
        </p>
      </div>

      <!-- Main Content Container -->
      <div class="bg-white rounded-2xl shadow-2xl p-4 lg:p-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
          <!-- Left Panel - Statistics & CTA -->
          <div class="text-center">
            <!-- Icon Container -->
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));">
              <MessageSquare class="w-10 h-10 text-white" />
            </div>
            
            <!-- Title -->
            <h3 class="text-3xl font-bold text-gray-700 mb-4">
              Statistik Aspirasi
            </h3>
            
            <!-- Statistics -->
            <div class="mb-6">
              <div class="text-4xl lg:text-5xl font-bold mb-2" style="background: linear-gradient(to right, var(--color-primary), var(--color-primary-dark)); -webkit-background-clip: text; background-clip: text; color: transparent;">
                150+
              </div>
              <p class="text-gray-600">Aspirasi Diterima</p>
            </div>
            
            <!-- CTA Button -->
            <button 
              class="w-full lg:w-auto bg-gradient-accent hover:opacity-90 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 hover:shadow-lg hover:shadow-accent/25"
              @click="navigateTo('/aspirasi')"
            >
              Kirim Aspirasi
            </button>
          </div>

          <!-- Right Panel - Aspirasi Updates -->
          <div class="space-y-3 lg:space-y-4 flex flex-col justify-center">
            <!-- Loading State -->
            <div v-if="loading" class="text-center">
              <p class="text-sm text-gray-500">Memuat aspirasi...</p>
            </div>
            
            <!-- Empty State -->
            <div v-else-if="aspirations.length === 0" class="text-center">
              <p class="text-sm text-gray-500">Belum ada aspirasi.</p>
            </div>
            
            <!-- Aspirasi Cards -->
            <div v-else>
              <!-- Top Row - 3 Cards -->
              <div class="grid grid-cols-3 gap-1 lg:gap-2 mb-3 lg:mb-4">
                <div 
                  v-for="aspiration in aspirations.slice(0, 3)" 
                  :key="aspiration.id"
                  class="bg-gray-50 rounded-lg p-2 border border-primary/20 hover:border-primary/50 hover:shadow-md transition-all duration-300 text-center"
                  style="border: 1px solid rgba(59, 130, 246, 0.2);"
                >
                  <!-- Icon -->
                  <component 
                    :is="getIcon(aspiration.category)" 
                    class="w-8 h-8 text-primary mx-auto mb-1" 
                  />
                  
                  <!-- Title -->
                  <h4 class="font-semibold text-gray-700 text-xs lg:text-sm mb-1">
                    {{ aspiration.title }}
                  </h4>
                  
                  <!-- Description -->
                  <p class="text-gray-600 text-xs mb-2 line-clamp-2">
                    {{ truncateText(aspiration.description, 80) }}
                  </p>
                  
                  <!-- Footer -->
                  <div class="flex flex-col gap-1">
                    <!-- Date -->
                    <div class="flex items-center justify-center gap-1">
                      <Clock class="w-3 h-3 text-gray-500" />
                      <span class="text-xs text-gray-500">{{ formatDate(aspiration.created_at) }}</span>
                    </div>
                    
                    <!-- Status Badge -->
                    <span 
                      class="text-xs font-medium px-2 py-1 rounded-full"
                      :class="getStatusClasses(aspiration.status)"
                    >
                      {{ getStatusText(aspiration.status) }}
                    </span>
                  </div>
                </div>
              </div>
              
              <!-- Bottom Row - 2 Cards -->
              <div class="grid grid-cols-2 gap-2 lg:gap-4">
                <div 
                  v-for="aspiration in aspirations.slice(3, 5)" 
                  :key="aspiration.id"
                  class="bg-gray-50 rounded-xl p-3 lg:p-4 border border-primary/20 hover:border-primary/50 hover:shadow-md transition-all duration-300 text-center"
                  style="border: 1px solid rgba(59, 130, 246, 0.2);"
                >
                  <!-- Icon -->
                  <component 
                    :is="getIcon(aspiration.category)" 
                    class="w-8 h-8 text-primary mx-auto mb-1" 
                  />
                  
                  <!-- Title -->
                  <h4 class="font-semibold text-gray-700 text-sm lg:text-base mb-1">
                    {{ aspiration.title }}
                  </h4>
                  
                  <!-- Description -->
                  <p class="text-gray-600 text-xs lg:text-sm mb-2 line-clamp-2">
                    {{ truncateText(aspiration.description, 80) }}
                  </p>
                  
                  <!-- Footer -->
                  <div class="flex items-center justify-between">
                    <!-- Date -->
                    <div class="flex items-center gap-1">
                      <Clock class="w-3 h-3 text-gray-500" />
                      <span class="text-xs text-gray-500">{{ formatDate(aspiration.created_at) }}</span>
                    </div>
                    
                    <!-- Status Badge -->
                    <span 
                      class="text-xs font-medium px-2 py-1 rounded-full"
                      :class="getStatusClasses(aspiration.status)"
                    >
                      {{ getStatusText(aspiration.status) }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { MessageSquare, Users, Calendar, Clock } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

// Types
interface Aspiration {
  id: number;
  title: string;
  description: string;
  category: string;
  status: string;
  created_at: string;
}

// Reactive data
const loading = ref(true);
const currentSlide = ref(0);
const autoSlideInterval = ref<number | null>(null);

// Sample data untuk demo
const aspirations = ref<Aspiration[]>([
  {
    id: 1,
    title: "Perbaikan Jalan",
    description: "Permintaan perbaikan jalan di Desa Pasangkayu yang sudah rusak parah dan mengganggu aktivitas warga",
    category: "infrastruktur",
    status: "diproses",
    created_at: "2024-01-15"
  },
  {
    id: 2,
    title: "Bantuan UMKM",
    description: "Permohonan bantuan modal untuk pengembangan usaha kecil menengah di wilayah NTB",
    category: "umkm",
    status: "baru",
    created_at: "2024-01-14"
  },
  {
    id: 3,
    title: "Program Kesehatan",
    description: "Usulan program kesehatan gratis untuk masyarakat kurang mampu di daerah terpencil",
    category: "kesehatan",
    status: "selesai",
    created_at: "2024-01-13"
  },
  {
    id: 4,
    title: "Pendidikan Gratis",
    description: "Aspirasi untuk program pendidikan gratis dan beasiswa untuk anak-anak di NTB",
    category: "pendidikan",
    status: "diproses",
    created_at: "2024-01-12"
  },
  {
    id: 5,
    title: "Lingkungan Hijau",
    description: "Inisiatif penanaman pohon dan program lingkungan hijau di seluruh NTB",
    category: "lingkungan",
    status: "baru",
    created_at: "2024-01-11"
  }
]);

// Methods
const navigateTo = (url: string) => {
  router.visit(url);
};

const getIcon = (category: string) => {
  const iconMap: Record<string, any> = {
    'kesehatan': Users,
    'infrastruktur': Calendar,
    'umkm': MessageSquare,
    'lingkungan': Users,
    'pendidikan': MessageSquare
  };
  return iconMap[category] || MessageSquare;
};

const getStatusText = (status: string) => {
  const statusMap: Record<string, string> = {
    'selesai': 'Selesai',
    'diproses': 'Dalam Proses',
    'baru': 'Baru'
  };
  return statusMap[status] || 'Dalam Proses';
};

const getStatusClasses = (status: string) => {
  const statusClasses: Record<string, string> = {
    'selesai': 'bg-green-100 text-green-800',
    'diproses': 'bg-red-100 text-red-800',
    'baru': 'bg-yellow-100 text-yellow-800'
  };
  return statusClasses[status] || 'bg-red-100 text-red-800';
};

const formatDate = (dateString: string): string => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
};

const truncateText = (text: string, maxLength: number): string => {
  if (text.length <= maxLength) return text;
  return text.substring(0, maxLength) + '…';
};

// Auto-slide methods
const startAutoSlide = () => {
  autoSlideInterval.value = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % aspirations.value.length;
  }, 3000); // Change slide every 3 seconds
};

const stopAutoSlide = () => {
  if (autoSlideInterval.value) {
    clearInterval(autoSlideInterval.value);
    autoSlideInterval.value = null;
  }
};

// Lifecycle
onMounted(() => {
  // Simulate loading
  setTimeout(() => {
    loading.value = false;
    // Start auto-slide after loading
    startAutoSlide();
  }, 1000);
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
