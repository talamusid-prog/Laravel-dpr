<template>
  <AdminLayout page-title="Dashboard">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <FileText class="w-6 h-6 text-blue-600" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Artikel</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.total_articles }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 rounded-lg">
            <Eye class="w-6 h-6 text-green-600" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Published</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.published_articles }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-orange-100 rounded-lg">
            <EyeOff class="w-6 h-6 text-orange-600" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Draft</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.draft_articles }}</p>
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
            <p class="text-2xl font-bold text-gray-900">{{ stats.total_views }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Recent Posts -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Artikel Terbaru</h3>
            <a 
              href="/admin/articles" 
              class="text-sm text-primary hover:text-primary/80"
            >
              Lihat semua
            </a>
          </div>
        </div>
        <div class="divide-y divide-gray-200">
          <div 
            v-for="post in recentPosts" 
            :key="post.id"
            class="px-6 py-4 flex items-center justify-between"
          >
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-900 truncate">{{ post.title }}</p>
              <p class="text-sm text-gray-500">{{ post.views }} views</p>
            </div>
            <div class="flex items-center space-x-2">
              <span 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="[
                  post.status === 'published' 
                    ? 'bg-green-100 text-green-800' 
                    : 'bg-orange-100 text-orange-800'
                ]"
              >
                {{ post.status }}
              </span>
              <a 
                :href="`/admin/articles/${post.id}/edit`"
                class="text-gray-400 hover:text-gray-600"
              >
                <Edit class="w-4 h-4" />
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Aspirations -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Aspirasi Terbaru</h3>
            <a 
              href="/admin/aspirations" 
              class="text-sm text-primary hover:text-primary/80"
            >
              Lihat semua
            </a>
          </div>
        </div>
        <div class="divide-y divide-gray-200">
          <div 
            v-for="aspiration in recentAspirations" 
            :key="aspiration.id"
            class="px-6 py-4"
          >
            <div class="flex items-center justify-between">
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ aspiration.title }}</p>
                <p class="text-sm text-gray-500">{{ aspiration.submitter_name }}</p>
              </div>
              <span 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="[
                  aspiration.status === 'baru' 
                    ? 'bg-red-100 text-red-800' 
                    : aspiration.status === 'diproses'
                    ? 'bg-yellow-100 text-yellow-800'
                    : 'bg-green-100 text-green-800'
                ]"
              >
                {{ aspiration.status }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
        <div class="flex flex-wrap gap-4">
          <a 
            href="/admin/articles/create"
            class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
          >
            <Plus class="w-4 h-4 mr-2" />
            Buat Artikel Baru
          </a>
          <a 
            href="/admin/events/create"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            <Calendar class="w-4 h-4 mr-2" />
            Tambah Event
          </a>
          <a 
            href="/admin/gallery/create"
            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
          >
            <Image class="w-4 h-4 mr-2" />
            Upload Galeri
          </a>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { FileText, Eye, EyeOff, BarChart3, Edit, Plus, Calendar, Image } from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';

// Props
interface Props {
  stats: {
    total_articles: number;
    published_articles: number;
    draft_articles: number;
    total_views: number;
    new_aspirations: number;
    upcoming_events: number;
    total_galleries: number;
  };
  recentPosts: Array<{
    id: number;
    title: string;
    status: string;
    views: number;
    created_at: string;
  }>;
  recentAspirations: Array<{
    id: number;
    title: string;
    status: string;
    submitter_name: string;
    created_at: string;
  }>;
  upcomingEvents: Array<{
    id: number;
    title: string;
    type: string;
    start_date: string;
    location: string;
  }>;
}

defineProps<Props>();
</script>
