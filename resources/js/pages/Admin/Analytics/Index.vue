<template>
  <AdminLayout page-title="Analytics & Laporan">
    <!-- Header -->
    <div class="mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Analytics & Laporan</h1>
          <p class="text-gray-600">Pantau performa website dan engagement</p>
        </div>
        <div class="flex space-x-3">
          <button 
            @click="exportReport"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            <Download class="w-4 h-4 mr-2" />
            Export Laporan
          </button>
        </div>
      </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
          <input 
            v-model="startDate"
            type="date" 
            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
          <input 
            v-model="endDate"
            type="date" 
            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
          />
        </div>
        <div class="flex items-end">
          <button 
            @click="applyDateRange"
            class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors"
          >
            Terapkan
          </button>
        </div>
      </div>
    </div>

    <!-- Blog Analytics -->
    <div class="mb-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Blog Analytics</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <FileText class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Artikel</p>
              <p class="text-2xl font-bold text-gray-900">{{ blogStats.total_articles }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <Eye class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Artikel Published</p>
              <p class="text-2xl font-bold text-gray-900">{{ blogStats.published_articles }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
              <BarChart3 class="w-6 h-6 text-purple-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Views</p>
              <p class="text-2xl font-bold text-gray-900">{{ formatNumber(blogStats.total_views) }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-orange-100 rounded-lg">
              <TrendingUp class="w-6 h-6 text-orange-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Avg Views/Artikel</p>
              <p class="text-2xl font-bold text-gray-900">{{ formatNumber(blogStats.avg_views_per_article) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Aspirasi Analytics -->
    <div class="mb-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Aspirasi Analytics</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
              <MessageSquare class="w-6 h-6 text-red-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Aspirasi</p>
              <p class="text-2xl font-bold text-gray-900">{{ aspirationStats.total_aspirations }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <Clock class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Baru</p>
              <p class="text-2xl font-bold text-gray-900">{{ aspirationStats.new_aspirations }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <Settings class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Diproses</p>
              <p class="text-2xl font-bold text-gray-900">{{ aspirationStats.processed_aspirations }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <CheckCircle class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Response Rate</p>
              <p class="text-2xl font-bold text-gray-900">{{ formatPercentage(aspirationStats.response_rate) }}%</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page Analytics -->
    <div class="mb-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Page Analytics</h2>
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Halaman Terpopuler</h3>
        </div>
        <div v-if="pageAnalytics.length > 0" class="divide-y divide-gray-200">
          <div 
            v-for="page in pageAnalytics" 
            :key="page.page"
            class="px-6 py-4 flex items-center justify-between"
          >
            <div>
              <p class="text-sm font-medium text-gray-900">{{ page.page }}</p>
              <p class="text-sm text-gray-500">{{ formatNumber(page.total_visitors) }} pengunjung unik</p>
            </div>
            <div class="text-right">
              <p class="text-sm font-medium text-gray-900">{{ formatNumber(page.total_views) }} views</p>
              <p class="text-sm text-gray-500">{{ formatDuration(page.avg_duration) }} rata-rata</p>
            </div>
          </div>
        </div>
        <div v-else class="px-6 py-8 text-center text-gray-500">
          <BarChart3 class="w-8 h-8 mx-auto mb-2" />
          <p>Belum ada data analytics</p>
        </div>
      </div>
    </div>

    <!-- Category Analytics -->
    <div class="mb-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Kategori Aspirasi</h2>
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Distribusi Kategori</h3>
        </div>
        <div v-if="categoryAnalytics.length > 0" class="divide-y divide-gray-200">
          <div 
            v-for="category in categoryAnalytics" 
            :key="category.category"
            class="px-6 py-4 flex items-center justify-between"
          >
            <div>
              <p class="text-sm font-medium text-gray-900">{{ category.category }}</p>
            </div>
            <div class="flex items-center">
              <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                <div 
                  class="bg-primary h-2 rounded-full" 
                  :style="{ width: `${(category.count / Math.max(...categoryAnalytics.map(c => c.count))) * 100}%` }"
                ></div>
              </div>
              <span class="text-sm font-medium text-gray-900">{{ category.count }}</span>
            </div>
          </div>
        </div>
        <div v-else class="px-6 py-8 text-center text-gray-500">
          <MessageSquare class="w-8 h-8 mx-auto mb-2" />
          <p>Belum ada data kategori aspirasi</p>
        </div>
      </div>
    </div>

    <!-- Daily Analytics Chart -->
    <div class="mb-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Trend Harian</h2>
      <div class="bg-white rounded-lg shadow p-6">
        <div v-if="dailyAnalytics.length > 0" class="h-64 flex items-center justify-center text-gray-500">
          <div class="text-center">
            <BarChart3 class="w-12 h-12 mx-auto mb-2" />
            <p>Data analytics tersedia</p>
            <p class="text-sm">{{ dailyAnalytics.length }} hari data tersedia</p>
            <p class="text-xs text-gray-400 mt-2">Chart visualization akan ditambahkan di versi berikutnya</p>
          </div>
        </div>
        <div v-else class="h-64 flex items-center justify-center text-gray-500">
          <div class="text-center">
            <BarChart3 class="w-12 h-12 mx-auto mb-2" />
            <p>Belum ada data analytics</p>
            <p class="text-sm">Data akan muncul setelah ada aktivitas di website</p>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { 
  FileText, 
  Eye, 
  BarChart3, 
  TrendingUp, 
  MessageSquare, 
  Clock, 
  Settings, 
  CheckCircle, 
  Download 
} from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';

// Props
interface Props {
  blogStats: {
    total_articles: number;
    published_articles: number;
    total_views: number;
    avg_views_per_article: number;
    most_viewed_article?: {
      title: string;
      views: number;
    };
  };
  aspirationStats: {
    total_aspirations: number;
    new_aspirations: number;
    processed_aspirations: number;
    completed_aspirations: number;
    response_rate: number;
  };
  pageAnalytics: Array<{
    page: string;
    total_views: number;
    total_visitors: number;
    avg_duration: number;
  }>;
  dailyAnalytics: Array<{
    date: string;
    total_views: number;
    total_visitors: number;
  }>;
  categoryAnalytics: Array<{
    category: string;
    count: number;
  }>;
  dateRange: {
    start_date: string;
    end_date: string;
  };
}

const props = defineProps<Props>();

// State
const startDate = ref(props.dateRange.start_date);
const endDate = ref(props.dateRange.end_date);

// Methods
const applyDateRange = () => {
  window.location.href = `/admin/analytics?start_date=${startDate.value}&end_date=${endDate.value}`;
};

const exportReport = () => {
  window.location.href = `/admin/analytics/export?start_date=${startDate.value}&end_date=${endDate.value}`;
};

const formatNumber = (num: number): string => {
  return new Intl.NumberFormat('id-ID').format(num);
};

const formatPercentage = (num: number): string => {
  return num.toFixed(1);
};

const formatDuration = (seconds: number): string => {
  const minutes = Math.floor(seconds / 60);
  const remainingSeconds = Math.floor(seconds % 60);
  return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
};
</script>
