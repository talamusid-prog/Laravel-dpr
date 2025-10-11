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
      <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        <!-- Layanan Aspirasi Card -->
        <div 
          class="group relative bg-white rounded-xl shadow-sm hover:shadow-md border border-primary/30 hover:border-primary p-4 h-full overflow-hidden transition-all duration-300 cursor-pointer"
          @click="navigateTo('/aspirasi')"
        >
          <!-- Decorative Element -->
          <div class="absolute -top-4 -right-4 w-16 h-16 rounded-full group-hover:scale-110 transition-all duration-500 ease-out" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); opacity: 0.1;"></div>
          
          <!-- Card Content -->
          <div class="relative z-10 flex gap-4">
            <!-- Icon Container -->
            <div class="flex-shrink-0 w-10 h-10 bg-primary group-hover:bg-primary/10 text-white group-hover:text-primary rounded-lg flex items-center justify-center transition-all duration-300">
              <MessageSquare class="w-5 h-5" />
            </div>
            
            <!-- Text Content -->
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary mb-2 transition-colors duration-300">
                Layanan Aspirasi
              </h3>
              <p class="text-sm text-muted-foreground mb-4 leading-relaxed">
                Menyediakan informasi tentang layanan serap aspirasi
              </p>
              <div class="flex items-center text-primary text-sm font-medium group-hover:gap-2 transition-all duration-300">
                <span>Selengkapnya</span>
                <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" />
              </div>
            </div>
          </div>
        </div>

        <!-- Kegiatan Terbaru Card -->
        <div 
          class="group relative bg-white rounded-xl shadow-sm hover:shadow-md border border-primary/30 hover:border-primary p-4 h-full overflow-hidden transition-all duration-300 cursor-pointer"
          @click="navigateTo('/kalender')"
        >
          <!-- Decorative Element -->
          <div class="absolute -top-4 -right-4 w-16 h-16 rounded-full group-hover:scale-110 transition-all duration-500 ease-out" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); opacity: 0.1;"></div>
          
          <!-- Card Content -->
          <div class="relative z-10 flex gap-4">
            <!-- Icon Container -->
            <div class="flex-shrink-0 w-10 h-10 bg-primary group-hover:bg-primary/10 text-white group-hover:text-primary rounded-lg flex items-center justify-center transition-all duration-300">
              <Calendar class="w-5 h-5" />
            </div>
            
            <!-- Text Content -->
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary mb-2 transition-colors duration-300">
                Kegiatan Terbaru
              </h3>
              <p class="text-sm text-muted-foreground mb-4 leading-relaxed">
                Dapatkan informasi terkini tentang kebijakan dan program
              </p>
              <div class="flex items-center text-primary text-sm font-medium group-hover:gap-2 transition-all duration-300">
                <span>Selengkapnya</span>
                <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" />
              </div>
            </div>
          </div>
        </div>

        <!-- Profil Card -->
        <div 
          class="group relative bg-white rounded-xl shadow-sm hover:shadow-md border border-primary/30 hover:border-primary p-4 h-full overflow-hidden transition-all duration-300 cursor-pointer"
          @click="navigateTo('/profil')"
        >
          <!-- Decorative Element -->
          <div class="absolute -top-4 -right-4 w-16 h-16 rounded-full group-hover:scale-110 transition-all duration-500 ease-out" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); opacity: 0.1;"></div>
          
          <!-- Card Content -->
          <div class="relative z-10 flex gap-4">
            <!-- Icon Container -->
            <div class="flex-shrink-0 w-10 h-10 bg-primary group-hover:bg-primary/10 text-white group-hover:text-primary rounded-lg flex items-center justify-center transition-all duration-300">
              <User class="w-5 h-5" />
            </div>
            
            <!-- Text Content -->
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary mb-2 transition-colors duration-300">
                Profil Bapak Dr. Ir. H. AGUS AMBO DJIWA, M.P.,
              </h3>
              <p class="text-sm text-muted-foreground mb-4 leading-relaxed">
                Temukan informasi lengkap tentang profil dan visi misi
              </p>
              <div class="flex items-center text-primary text-sm font-medium group-hover:gap-2 transition-all duration-300">
                <span>Selengkapnya</span>
                <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" />
              </div>
            </div>
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
import { MessageSquare, Calendar, User, ArrowRight } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

// Methods
const navigateTo = (url: string) => {
  router.visit(url);
};
</script>
