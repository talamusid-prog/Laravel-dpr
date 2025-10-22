<template>
  <header 
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    :class="[
      isScrolled 
        ? 'bg-white/10 backdrop-blur-xl border-b border-white/20 shadow-lg shadow-black/5' 
        : 'bg-gradient-primary'
    ]"
  >
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex items-center justify-between h-16 md:h-20">
        <!-- Logo Section -->
        <div 
          class="flex items-center space-x-2 cursor-pointer hover:opacity-80 transition-opacity"
          @click="handleLogoClick"
        >
              <img 
                src="/logo.png" 
                alt="DPR Logo"
                class="w-12 h-12 md:w-16 md:h-16 object-contain"
              />
              <img 
                src="/logo2.png" 
                alt="RI Logo"
                class="w-12 h-12 md:w-16 md:h-16 object-contain"
              />
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-6 lg:space-x-8">
          <a 
            href="/" 
            class="transition-smooth font-medium bg-transparent border-none cursor-pointer text-sm lg:text-base"
            :class="[
              isScrolled 
                ? 'text-foreground hover:text-primary' 
                : 'text-white hover:text-white/80'
            ]"
            @click="handleNavigation('/')"
          >
            Home
          </a>
          <a 
            href="/profil" 
            class="transition-smooth font-medium bg-transparent border-none cursor-pointer text-sm lg:text-base"
            :class="[
              isScrolled 
                ? 'text-foreground hover:text-primary' 
                : 'text-white hover:text-white/80'
            ]"
            @click="handleNavigation('/profil')"
          >
            Profil
          </a>
          <a 
            href="/kalender" 
            class="transition-smooth font-medium bg-transparent border-none cursor-pointer text-sm lg:text-base"
            :class="[
              isScrolled 
                ? 'text-foreground hover:text-primary' 
                : 'text-white hover:text-white/80'
            ]"
            @click="handleNavigation('/kalender')"
          >
            Kalender Kegiatan
          </a>
          <a 
            href="/berita-utama" 
            class="transition-smooth font-medium bg-transparent border-none cursor-pointer text-sm lg:text-base"
            :class="[
              isScrolled 
                ? 'text-foreground hover:text-primary' 
                : 'text-white hover:text-white/80'
            ]"
            @click="handleNavigation('/berita-utama')"
          >
            Berita Utama
          </a>
          <a 
            href="/aspirasi" 
            class="transition-smooth font-medium bg-transparent border-none cursor-pointer text-sm lg:text-base"
            :class="[
              isScrolled 
                ? 'text-foreground hover:text-primary' 
                : 'text-white hover:text-white/80'
            ]"
            @click="handleNavigation('/aspirasi')"
          >
            Aspirasi
          </a>
        </nav>


        <!-- Mobile Menu Toggle -->
        <button 
          @click="isMenuOpen = !isMenuOpen"
          class="md:hidden flex items-center"
        >
          <Menu 
            v-if="!isMenuOpen" 
            class="w-6 h-6 transition-colors"
            :class="[
              isScrolled 
                ? 'text-foreground' 
                : 'text-white'
            ]"
          />
          <X 
            v-else 
            class="w-6 h-6 transition-colors"
            :class="[
              isScrolled 
                ? 'text-foreground' 
                : 'text-white'
            ]"
          />
        </button>
      </div>

      <!-- Mobile Menu Content -->
      <div 
        v-if="isMenuOpen" 
        class="md:hidden py-4 border-t border-border"
      >
        <div class="flex flex-col space-y-4">
          <a 
            href="/" 
            class="text-white hover:text-white/80 transition-smooth font-medium bg-transparent border-none cursor-pointer text-left"
            @click="handleNavigation('/')"
          >
            Home
          </a>
          <a 
            href="/profil" 
            class="text-white hover:text-white/80 transition-smooth font-medium bg-transparent border-none cursor-pointer text-left"
            @click="handleNavigation('/profil')"
          >
            Profil
          </a>
          <a 
            href="/kalender" 
            class="text-white hover:text-white/80 transition-smooth font-medium bg-transparent border-none cursor-pointer text-left"
            @click="handleNavigation('/kalender')"
          >
            Kalender Kegiatan
          </a>
          <a 
            href="/berita-utama" 
            class="text-white hover:text-white/80 transition-smooth font-medium bg-transparent border-none cursor-pointer text-left"
            @click="handleNavigation('/berita-utama')"
          >
            Berita Utama
          </a>
          <a 
            href="/aspirasi" 
            class="text-white hover:text-white/80 transition-smooth font-medium bg-transparent border-none cursor-pointer text-left"
            @click="handleNavigation('/aspirasi')"
          >
            Aspirasi
          </a>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Menu, X } from 'lucide-vue-next';

// Props
interface Props {
  onLogoClick?: () => void;
}

const props = defineProps<Props>();

// State
const isMenuOpen = ref(false);
const isScrolled = ref(false);

// Methods
const handleScroll = () => {
  isScrolled.value = window.scrollY > 50;
};

const handleLogoClick = () => {
  if (props.onLogoClick) {
    props.onLogoClick();
  } else {
    window.location.href = '/';
  }
};

const handleNavigation = (path: string) => {
  isMenuOpen.value = false;
  
  if (path === '/' && window.location.pathname === '/') {
    // Smooth scroll to top if already on home page
    window.scrollTo({ top: 0, behavior: 'smooth' });
  } else {
    // Navigate to other pages
    window.location.href = path;
  }
};


// Lifecycle
onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
.transition-smooth {
  transition: all 0.3s ease;
}

.hover\:shadow-glow:hover {
  box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
}
</style>