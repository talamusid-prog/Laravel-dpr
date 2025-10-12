<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Mobile sidebar overlay -->
    <div 
      v-if="sidebarOpen" 
      class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
      @click="sidebarOpen = false"
    ></div>

    <!-- Sidebar -->
    <div 
      class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 px-4 border-b border-gray-200">
          <h1 class="text-xl font-bold text-gray-800">Admin Panel</h1>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-3">
          <a 
            v-for="item in navigation" 
            :key="item.name"
            :href="item.href"
            class="flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors"
            :class="[
              isActiveRoute(item.href) 
                ? 'bg-gradient-to-r from-red-500/20 to-red-600/20 text-red-700 border border-red-200 backdrop-blur-sm' 
                : 'text-gray-700 hover:bg-gray-100'
            ]"
          >
            <component :is="item.icon" class="w-5 h-5 mr-3" />
            {{ item.name }}
            <span 
              v-if="item.badge" 
              class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full"
            >
              {{ item.badge }}
            </span>
          </a>
        </nav>

        <!-- User info -->
        <div class="p-4 border-t border-gray-200">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
              <User class="w-4 h-4 text-white" />
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-gray-700">Admin</p>
              <p class="text-xs text-gray-500">Administrator</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="lg:pl-64">
      <!-- Top bar -->
      <div class="sticky top-0 z-20 bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between h-16 px-4">
          <!-- Mobile menu button -->
          <button 
            @click="sidebarOpen = true"
            class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100"
          >
            <Menu class="w-6 h-6" />
          </button>

          <!-- Page title -->
          <h2 class="text-lg font-semibold text-gray-800">{{ pageTitle }}</h2>

          <!-- User menu -->
          <div class="flex items-center space-x-4">
            <button class="p-2 text-gray-600 hover:text-gray-900">
              <Bell class="w-5 h-5" />
            </button>
            <button class="p-2 text-gray-600 hover:text-gray-900">
              <Settings class="w-5 h-5" />
            </button>
            <form method="POST" action="/logout" class="inline">
              <input type="hidden" name="_token" :value="$page.props.csrf_token" />
              <button 
                type="submit"
                class="p-2 text-gray-600 hover:text-gray-900"
                title="Logout"
              >
                <LogOut class="w-5 h-5" />
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Page content -->
      <main class="p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { 
  LayoutDashboard, 
  FileText, 
  Image, 
  MessageSquare, 
  Calendar, 
  BarChart3, 
  Settings, 
  Palette,
  User, 
  Users,
  Menu, 
  Bell,
  LogOut
} from 'lucide-vue-next';

import { usePage } from '@inertiajs/vue3';

// Props
interface Props {
  pageTitle?: string;
}

defineProps<Props>();
const page = usePage();

// State
const sidebarOpen = ref(false);

// Navigation items
const navigation = computed(() => [
  { name: 'Dashboard', href: '/admin', icon: LayoutDashboard },
  { name: 'Artikel', href: '/admin/articles', icon: FileText },
  { name: 'Galeri', href: '/admin/gallery', icon: Image },
  { 
    name: 'Aspirasi', 
    href: '/admin/aspirations', 
    icon: MessageSquare, 
    badge: (page.props.aspirationStats as any)?.new ? (page.props.aspirationStats as any).new.toString() : '0'
  },
  { name: 'Kalender', href: '/admin/events', icon: Calendar },
  { name: 'Pendaftaran Anggota', href: '/admin/member-registrations', icon: Users },
  { name: 'Analytics', href: '/admin/analytics', icon: BarChart3 },
  { name: 'Pengaturan', href: '/admin/settings', icon: Settings },
  { name: 'Pengaturan Warna', href: '/admin/settings/colors', icon: Palette },
]);

// Methods
const isActiveRoute = (href: string): boolean => {
  const currentUrl = window.location.pathname;
  
  // Special case for dashboard - only active if exactly /admin or /admin/
  if (href === '/admin') {
    return currentUrl === '/admin' || currentUrl === '/admin/';
  }
  
  // Special case for settings - only active if exactly /admin/settings
  if (href === '/admin/settings') {
    return currentUrl === '/admin/settings' || currentUrl === '/admin/settings/';
  }
  
  // For other routes, check if current URL starts with the href
  return currentUrl.startsWith(href);
};
</script>
