<template>
  <div v-if="isOpen" class="fixed inset-0 z-[9999] overflow-y-auto">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal"></div>
    
    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
      <div class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white shadow-xl transition-all">
        <!-- Header -->
        <div class="bg-gradient-to-r from-red-500 to-orange-500 px-6 py-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                <Bell class="w-5 h-5 text-white" />
              </div>
              <div>
                <h3 class="text-lg font-semibold text-white">Berlangganan Update</h3>
                <p class="text-sm text-white/90">Dapatkan notifikasi berita terbaru</p>
              </div>
            </div>
            <button @click="closeModal" class="text-white/80 hover:text-white transition-colors">
              <X class="w-6 h-6" />
            </button>
          </div>
        </div>

        <!-- Content -->
        <div class="p-6">
          <!-- Social Media Icons -->
          <div class="text-center">
            <h4 class="text-lg font-semibold text-gray-900 mb-6">Ikuti Kami di Media Sosial</h4>
            
            <div class="flex justify-center gap-4 mb-6">
              <!-- Facebook -->
              <a 
                href="https://web.facebook.com/adj.agusambodjiwa/" 
                target="_blank"
                class="group flex flex-col items-center p-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105"
              >
                <Facebook class="w-8 h-8 mb-2" />
                <span class="text-sm font-medium">Facebook</span>
              </a>

              <!-- Instagram -->
              <a 
                href="https://www.instagram.com/agus.adj2/" 
                target="_blank"
                class="group flex flex-col items-center p-4 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105"
              >
                <Instagram class="w-8 h-8 mb-2" />
                <span class="text-sm font-medium">Instagram</span>
              </a>


              <!-- YouTube -->
              <a 
                href="https://www.youtube.com/@agusadji1" 
                target="_blank"
                class="group flex flex-col items-center p-4 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105"
              >
                <Youtube class="w-8 h-8 mb-2" />
                <span class="text-sm font-medium">YouTube</span>
              </a>
            </div>

            <!-- Info Message -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
              <div class="flex items-start gap-3">
                <div class="w-5 h-5 text-blue-600 mt-0.5">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-sm font-medium text-blue-900 mb-1">Update Berita Terbaru</h4>
                  <p class="text-xs text-blue-700">
                    Ikuti media sosial kami untuk mendapatkan update berita dan informasi terbaru dari Dr. Ir. H. AGUS AMBO DJIWA, M.P.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { X, Facebook, Instagram, Youtube } from 'lucide-vue-next';

// Props
interface Props {
  isOpen: boolean;
}

defineProps<Props>();

// Emits
const emit = defineEmits<{
  close: [];
}>();

// Methods
const closeModal = () => {
  emit('close');
};
</script>
