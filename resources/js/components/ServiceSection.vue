<template>
  <section id="layanan-aspirasi" class="bg-white -mt-8 sm:-mt-12 pb-16">
    <div class="max-w-6xl mx-auto px-4">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h2 
          class="text-3xl lg:text-4xl font-bold mb-4 relative z-50"
          style="background: linear-gradient(to right, var(--color-primary), var(--color-primary-dark)); -webkit-background-clip: text; background-clip: text; color: transparent;"
        >
          Layanan Aspirasi
        </h2>
        <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
          Akses berbagai layanan dan informasi terkini untuk mendukung aspirasi masyarakat
        </p>
      </div>

      <!-- Service Cards Grid -->
      <div class="relative overflow-hidden mb-12">
        <!-- Mobile Swipe Container -->
        <div 
          class="flex lg:grid lg:grid-cols-3 gap-3 sm:gap-6 transition-transform duration-300 ease-out"
          :style="{ transform: `translateX(-${currentSlide * 50}%)` }"
          @touchstart="handleTouchStart"
          @touchmove="handleTouchMove"
          @touchend="handleTouchEnd"
        >
        <!-- Layanan Aspirasi Card -->
        <div class="w-1/2 lg:w-auto flex-shrink-0">
          <div 
            class="group relative rounded-xl shadow-sm hover:shadow-lg border p-3 sm:p-4 h-full overflow-hidden transition-all duration-300 cursor-pointer"
            style="background: var(--color-primary); border-color: rgba(255, 255, 255, 0.3);"
            @click="navigateTo('/aspirasi')"
          >
            <!-- Background Pattern - Lines -->
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
          <!-- Decorative Elements -->
          <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full group-hover:scale-110 transition-all duration-500 ease-out" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); opacity: 0.3;"></div>
          <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full group-hover:scale-105 transition-all duration-700 ease-out" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); opacity: 0.2;"></div>
          
          <!-- Card Content -->
          <div class="relative z-10 flex flex-col sm:flex-row gap-3 sm:gap-4 h-full">
            <!-- Mobile: Icon at top, Desktop: Icon at left -->
            <div class="flex items-start justify-start sm:contents">
              <!-- Mobile Icon (top) -->
              <div class="sm:hidden">
                <MessageSquare class="w-8 h-8 sm:w-9 sm:h-9 text-white" />
              </div>
              
              <!-- Desktop Icon (left) -->
              <div class="hidden sm:flex flex-shrink-0">
                <MessageSquare class="w-6 h-6 text-white" />
              </div>
            </div>
            
            <!-- Text Content -->
            <div class="flex-1 flex flex-col h-full">
              <h3 class="text-xl sm:text-2xl font-semibold text-white mb-2 transition-colors duration-300">
                Layanan Aspirasi
              </h3>
              <p class="text-base sm:text-lg text-white/90 mb-3 sm:mb-4 leading-relaxed flex-1">
                Menyediakan informasi tentang layanan serap aspirasi
              </p>
              
              <!-- Arrow (bottom) -->
              <div class="flex justify-end pb-2 sm:pb-2 self-end">
                <div class="w-8 h-8 bg-white/20 group-hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-all duration-300">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>

        <!-- Kegiatan Terbaru Card -->
        <div class="w-1/2 lg:w-auto flex-shrink-0">
          <div 
            class="group relative rounded-xl shadow-sm hover:shadow-lg border p-3 sm:p-4 h-full overflow-hidden transition-all duration-300 cursor-pointer"
            style="background: var(--color-primary); border-color: rgba(255, 255, 255, 0.3);"
            @click="navigateTo('/kalender')"
          >
            <!-- Background Pattern - Lines -->
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
          <!-- Decorative Elements -->
          <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full group-hover:scale-110 transition-all duration-500 ease-out" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); opacity: 0.3;"></div>
          <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full group-hover:scale-105 transition-all duration-700 ease-out" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); opacity: 0.2;"></div>
          
          <!-- Card Content -->
          <div class="relative z-10 flex flex-col sm:flex-row gap-3 sm:gap-4 h-full">
            <!-- Mobile: Icon at top, Desktop: Icon at left -->
            <div class="flex items-start justify-start sm:contents">
              <!-- Mobile Icon (top) -->
              <div class="sm:hidden">
                <Calendar class="w-8 h-8 sm:w-9 sm:h-9 text-white" />
              </div>
              
              <!-- Desktop Icon (left) -->
              <div class="hidden sm:flex flex-shrink-0">
                <Calendar class="w-6 h-6 text-white" />
              </div>
            </div>
            
            <!-- Text Content -->
            <div class="flex-1 flex flex-col h-full">
              <h3 class="text-xl sm:text-2xl font-semibold text-white mb-2 transition-colors duration-300">
                Kegiatan Terbaru
              </h3>
              <p class="text-base sm:text-lg text-white/90 mb-3 sm:mb-4 leading-relaxed flex-1">
                Dapatkan informasi terkini tentang kebijakan dan program
              </p>
              
              <!-- Arrow (bottom) -->
              <div class="flex justify-end pb-2 sm:pb-2 self-end">
                <div class="w-8 h-8 bg-white/20 group-hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-all duration-300">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>

        <!-- Profil Card -->
        <div class="w-1/2 lg:w-auto flex-shrink-0">
          <div 
            class="group relative rounded-xl shadow-sm hover:shadow-lg border p-3 sm:p-4 h-full overflow-hidden transition-all duration-300 cursor-pointer"
            style="background: var(--color-primary); border-color: rgba(255, 255, 255, 0.3);"
            @click="navigateTo('/profil')"
          >
            <!-- Background Pattern - Lines -->
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
          <!-- Decorative Elements -->
          <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full group-hover:scale-110 transition-all duration-500 ease-out" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); opacity: 0.3;"></div>
          <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full group-hover:scale-105 transition-all duration-700 ease-out" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); opacity: 0.2;"></div>
          
          <!-- Card Content -->
          <div class="relative z-10 flex flex-col sm:flex-row gap-3 sm:gap-4 h-full">
            <!-- Mobile: Icon at top, Desktop: Icon at left -->
            <div class="flex items-start justify-start sm:contents">
              <!-- Mobile Icon (top) -->
              <div class="sm:hidden">
                <User class="w-8 h-8 sm:w-9 sm:h-9 text-white" />
              </div>
              
              <!-- Desktop Icon (left) -->
              <div class="hidden sm:flex flex-shrink-0">
                <User class="w-6 h-6 text-white" />
              </div>
            </div>
            
            <!-- Text Content -->
            <div class="flex-1 flex flex-col h-full">
              <h3 class="text-xl sm:text-2xl font-semibold text-white mb-2 transition-colors duration-300">
                Profil Kami
              </h3>
              <p class="text-base sm:text-lg text-white/90 mb-3 sm:mb-4 leading-relaxed flex-1">
                Temukan informasi lengkap tentang profil dan visi misi
              </p>
              
              <!-- Arrow (bottom) -->
              <div class="flex justify-end pb-2 sm:pb-2 self-end">
                <div class="w-8 h-8 bg-white/20 group-hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-all duration-300">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        </div>

        <!-- Mobile Navigation Dots -->
        <div class="flex justify-center mt-4 lg:hidden">
          <div class="flex space-x-2">
            <button
              v-for="index in 2"
              :key="index"
              @click="goToSlide(index - 1)"
              :class="[
                'w-2 h-2 rounded-full transition-all duration-200',
                index - 1 === currentSlide 
                  ? 'bg-primary scale-125' 
                  : 'bg-gray-300'
              ]"
            />
          </div>
        </div>
      </div>

      <!-- Call to Action Section -->
      <div class="mt-12 text-center bg-gradient-to-r from-primary/5 to-secondary/5 rounded-2xl p-8 border border-primary/10">
        <h3 class="text-xl font-semibold text-gray-900 mb-2">
          Ada Pertanyaan atau Saran?
        </h3>
        <p class="text-muted-foreground mb-6">
          Tim kami siap membantu Anda dengan informasi dan layanan terbaik
        </p>
        
        <!-- CTA Buttons -->
        <div class="flex flex-row gap-2 sm:gap-4 justify-center">
          <!-- Button 1 (Primary) -->
          <button 
            class="group inline-flex items-center gap-2 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-[30px] transition-all duration-300 hover:shadow-lg hover:shadow-red-500/25"
            @click="navigateTo('/aspirasi')"
          >
            <MessageSquare class="w-4 h-4 sm:w-5 sm:h-5" />
            <span class="hidden sm:inline">Kirim Aspirasi</span>
            <span class="sm:hidden">Aspirasi</span>
          </button>
          
          <!-- Button 2 (Secondary) -->
          <button 
            class="group inline-flex items-center gap-2 border border-primary text-primary hover:bg-primary hover:text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-[30px] transition-all duration-300"
            @click="navigateTo('/kontak')"
          >
            <User class="w-4 h-4 sm:w-5 sm:h-5" />
            <span class="hidden sm:inline">Hubungi Kami</span>
            <span class="sm:hidden">Kontak</span>
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { MessageSquare, Calendar, User } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

// Reactive data for swipe functionality
const currentSlide = ref(0);
const touchStartX = ref(0);
const touchEndX = ref(0);

// Methods
const navigateTo = (url: string) => {
  router.visit(url);
};

// Touch events for swipe
const handleTouchStart = (e: TouchEvent) => {
  touchStartX.value = e.touches[0].clientX;
};

const handleTouchMove = (e: TouchEvent) => {
  touchEndX.value = e.touches[0].clientX;
};

const handleTouchEnd = () => {
  if (!touchStartX.value || !touchEndX.value) return;
  
  const distance = touchStartX.value - touchEndX.value;
  const isLeftSwipe = distance > 50;
  const isRightSwipe = distance < -50;
  
  if (isLeftSwipe && currentSlide.value < 1) {
    currentSlide.value++;
  } else if (isRightSwipe && currentSlide.value > 0) {
    currentSlide.value--;
  }
  
  // Reset touch values
  touchStartX.value = 0;
  touchEndX.value = 0;
};

const goToSlide = (index: number) => {
  currentSlide.value = index;
};
</script>
