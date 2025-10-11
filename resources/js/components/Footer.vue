<template>
  <footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Company Info -->
        <div class="lg:col-span-1">
          <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
              <span class="text-white font-bold text-lg">DPR</span>
            </div>
            <div>
              <h3 class="text-lg font-bold">DPR-RI</h3>
              <p class="text-sm text-gray-400">Sulawesi Barat</p>
            </div>
          </div>
          <p class="text-gray-400 text-sm leading-relaxed mb-4">
            Mewakili aspirasi masyarakat Sulawesi Barat di tingkat nasional untuk mewujudkan pembangunan yang berkelanjutan dan sejahtera.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <Facebook class="w-5 h-5" />
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <Instagram class="w-5 h-5" />
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <Twitter class="w-5 h-5" />
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <Youtube class="w-5 h-5" />
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="text-lg font-semibold mb-4">Menu Utama</h4>
          <ul class="space-y-2">
            <li>
              <a href="/" class="text-gray-400 hover:text-white transition-colors text-sm">
                Beranda
              </a>
            </li>
            <li>
              <a href="/profil" class="text-gray-400 hover:text-white transition-colors text-sm">
                Profil
              </a>
            </li>
            <li>
              <a href="/artikel" class="text-gray-400 hover:text-white transition-colors text-sm">
                Artikel
              </a>
            </li>
            <li>
              <a href="/galeri" class="text-gray-400 hover:text-white transition-colors text-sm">
                Galeri
              </a>
            </li>
            <li>
              <a href="/aspirasi" class="text-gray-400 hover:text-white transition-colors text-sm">
                Aspirasi
              </a>
            </li>
            <li>
              <a href="/kontak" class="text-gray-400 hover:text-white transition-colors text-sm">
                Kontak
              </a>
            </li>
          </ul>
        </div>

        <!-- Program & Layanan -->
        <div>
          <h4 class="text-lg font-semibold mb-4">Program & Layanan</h4>
          <ul class="space-y-2">
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">
                Bantuan Sosial
              </a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">
                Pembangunan Infrastruktur
              </a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">
                Pemberdayaan UMKM
              </a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">
                Pendidikan & Kesehatan
              </a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">
                Pengembangan Pariwisata
              </a>
            </li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h4 class="text-lg font-semibold mb-4">Kontak</h4>
          <div class="space-y-3">
            <div class="flex items-start space-x-3">
              <MapPin class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
              <div>
                <p class="text-sm text-gray-400">
                  Gedung DPR-RI<br>
                  Jl. Gatot Subroto, Jakarta
                </p>
              </div>
            </div>
            <div class="flex items-center space-x-3">
              <Phone class="w-5 h-5 text-primary flex-shrink-0" />
              <a href="tel:+6281234567890" class="text-sm text-gray-400 hover:text-white transition-colors">
                +62 812-3456-7890
              </a>
            </div>
            <div class="flex items-center space-x-3">
              <Mail class="w-5 h-5 text-primary flex-shrink-0" />
              <a href="mailto:agus.ambo@dpr-ri.com" class="text-sm text-gray-400 hover:text-white transition-colors">
                agus.ambo@dpr-ri.com
              </a>
            </div>
            <div class="flex items-center space-x-3">
              <Clock class="w-5 h-5 text-primary flex-shrink-0" />
              <p class="text-sm text-gray-400">
                Senin - Jumat: 08:00 - 17:00
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="border-t border-gray-800 mt-8 pt-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="text-sm text-gray-400 mb-4 md:mb-0">
            © 2024 Dr. Ir. H. AGUS AMBO DJIWA, M.P. - Anggota DPR-RI Dapil Sulawesi Barat. All rights reserved.
          </div>
          <div class="flex space-x-6 text-sm">
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              Privacy Policy
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              Terms of Service
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              Disclaimer
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import { 
  Facebook, 
  Instagram, 
  Twitter, 
  Youtube, 
  MapPin, 
  Phone, 
  Mail, 
  Clock 
} from 'lucide-vue-next';
</script>