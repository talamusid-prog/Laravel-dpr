<template>
  <section class="relative min-h-[100vh] max-h-[100vh] sm:min-h-[60vh] sm:max-h-none overflow-hidden pt-8 md:pt-10">
    <!-- Background Gradient -->
    <div class="absolute inset-0 bg-gradient-primary"></div>
    
    <!-- Grid Pattern Overlay -->
    <div 
      class="absolute inset-0 opacity-30"
      style="background-image: linear-gradient(rgba(255,255,255,0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 50px 50px;"
    ></div>
    
    <!-- Main Container -->
    <div class="relative z-10 max-w-6xl mx-auto px-4 pt-0 mb-0 pb-0">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
        <!-- Content Column (Left) -->
        <div class="flex flex-col justify-center space-y-3 mt-8 sm:mt-0">
          <!-- Badge -->
          <div class="inline-flex items-center justify-start mt-12 sm:mt-0">
            <span class="bg-white/20 backdrop-blur-sm border-2 border-white rounded-full px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm lg:text-base font-medium text-white shadow-lg">
              Official Website
            </span>
          </div>
          
          <!-- Heading -->
          <h1 class="text-white font-bold text-5xl sm:text-4xl lg:text-6xl leading-none lg:leading-tight">
            Dr. Ir. H. AGUS AMBO DJIWA, M.P.
          </h1>
          
          <!-- Subtitle -->
          <p class="text-white/90 text-lg lg:text-xl leading-relaxed">
            Anggota DPR-RI periode 2024-2029
          </p>
          
          <!-- CTA Button -->
          <div class="pt-4">
            <a 
              href="/aspirasi"
              class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 rounded-[30px] px-6 py-3 text-white font-medium transition-all duration-300 hover:shadow-lg hover:shadow-red-500/25 overflow-hidden"
            >
              <MessageSquare class="w-5 h-5 relative z-10" />
              <span class="relative z-10">Kirim Aspirasi</span>
              <!-- Glow effect -->
              <div class="absolute inset-0 rounded-[30px] bg-gradient-to-r from-red-500 to-orange-500 opacity-0 group-hover:opacity-30 blur-sm transition-opacity duration-300 -z-10"></div>
            </a>
          </div>
        </div>
        
        <!-- Image Column (Right) -->
        <div class="flex items-center justify-center lg:justify-end">
          <div class="w-full max-w-md lg:max-w-lg">
            <img 
              src="/hero-image.png" 
              alt="Dr. Ir. H. AGUS AMBO DJIWA, M.P."
              class="w-full h-auto object-contain transform -translate-y-8 lg:translate-y-20"
            />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { MessageSquare } from 'lucide-vue-next';
</script>
