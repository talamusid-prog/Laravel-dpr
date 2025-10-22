<template>
  <div class="min-h-screen">
    <!-- Header -->
    <Header />
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-background to-muted py-8 pt-20 md:pt-24">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-8">
          <!-- Badge -->
          <div class="inline-flex items-center gap-2 bg-primary/10 text-primary text-sm font-medium px-4 py-2 rounded-full mb-4">
            <Users class="w-4 h-4" />
            Profil
          </div>
          
          <!-- Title -->
          <h1 class="text-4xl lg:text-6xl font-bold mb-4" style="background: linear-gradient(to right, var(--color-primary), var(--color-primary-dark)); -webkit-background-clip: text; background-clip: text; color: transparent;">
            Dr. Ir. H. AGUS AMBO DJIWA, M.P.
          </h1>
          
          <!-- Subtitle -->
          <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
            Anggota DPR-RI Dapil Sulawesi Barat periode 2024-2029
          </p>
        </div>
      </div>
    </section>

    <!-- Profile Content Section -->
    <section class="bg-white py-16">
      <div class="max-w-4xl mx-auto px-4">
        <div class="grid lg:grid-cols-3 gap-12">
          <!-- Left Column - Profile Card -->
          <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-primary/10 to-secondary/10 rounded-2xl border border-gray-200 p-8 text-center sticky top-24">
              <!-- Profile Image -->
              <div class="w-48 h-48 mx-auto mb-8 rounded-full overflow-hidden border-4 border-primary/30 shadow-lg">
                    <img 
                      src="/profile.png" 
                      alt="Dr. Ir. H. AGUS AMBO DJIWA, M.P."
                      class="w-full h-full object-cover"
                    />
              </div>
              
              <!-- Profile Info -->
              <h2 class="text-2xl font-bold text-gray-900 mb-2">
                Dr. Ir. H. AGUS AMBO DJIWA, M.P.
              </h2>
              <p class="text-primary font-medium mb-4">
                Anggota DPR RI Dapil Sulawesi Barat
              </p>
              <p class="text-sm text-muted-foreground">
                Fraksi Partai Demokrasi Indonesia Perjuangan (PDI-P)
              </p>
            </div>
          </div>

          <!-- Right Column - Detailed Profile -->
          <div class="lg:col-span-2 space-y-8">
            <!-- Biografi Section -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8">
              <div class="flex items-center gap-3 mb-6">
                <BookOpen class="w-6 h-6 text-primary" />
                <h3 class="text-2xl font-bold text-gray-900">Biografi</h3>
              </div>
              <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-4">
                <p>
                  Dr. Ir. H. AGUS AMBO DJIWA, M.P. adalah seorang politisi dan tokoh masyarakat yang telah berdedikasi dalam mengabdi untuk kemajuan Sulawesi Barat. Lahir dan besar di daerah Pasangkayu, beliau memiliki pemahaman mendalam tentang tantangan dan peluang pembangunan di wilayah tersebut.
                </p>
                <p>
                  Sebagai Anggota DPR-RI Dapil Sulawesi Barat periode 2024-2029, beliau berkomitmen untuk menjadi jembatan antara aspirasi masyarakat dengan kebijakan nasional. Dengan latar belakang pendidikan teknik dan pengalaman di berbagai organisasi, beliau membawa pendekatan yang sistematis dan berorientasi pada hasil dalam setiap program pembangunan.
                </p>
                <p>
                  Visi beliau adalah mewujudkan Sulawesi Barat yang maju, mandiri, dan sejahtera melalui pembangunan infrastruktur yang berkualitas, peningkatan kualitas sumber daya manusia, dan pengembangan ekonomi kerakyatan yang berkelanjutan.
                </p>
              </div>
            </div>

            <!-- Riwayat Pendidikan Section -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8">
              <div class="flex items-center gap-3 mb-6">
                <GraduationCap class="w-6 h-6 text-primary" />
                <h3 class="text-2xl font-bold text-gray-900">Riwayat Pendidikan</h3>
              </div>
              
              <!-- Pendidikan Formal -->
              <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Pendidikan Formal</h4>
                <div class="space-y-4">
                  <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                      <GraduationCap class="w-6 h-6 text-primary" />
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-900 mb-1">S3 - Doktor Teknik Sipil</h5>
                      <p class="text-gray-600 mb-1">Institut Teknologi Bandung (ITB)</p>
                      <p class="text-sm text-muted-foreground">2015 - 2018</p>
                    </div>
                  </div>
                  
                  <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                      <GraduationCap class="w-6 h-6 text-primary" />
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-900 mb-1">S2 - Magister Perencanaan</h5>
                      <p class="text-gray-600 mb-1">Universitas Hasanuddin</p>
                      <p class="text-sm text-muted-foreground">2008 - 2010</p>
                    </div>
                  </div>
                  
                  <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                      <GraduationCap class="w-6 h-6 text-primary" />
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-900 mb-1">S1 - Teknik Sipil</h5>
                      <p class="text-gray-600 mb-1">Universitas Hasanuddin</p>
                      <p class="text-sm text-muted-foreground">2000 - 2004</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Pendidikan Non Formal -->
              <div>
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Pendidikan Non Formal</h4>
                <div class="space-y-4">
                  <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                      <Award class="w-6 h-6 text-blue-600" />
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-900 mb-1">Leadership Training</h5>
                      <p class="text-gray-600 mb-1">Harvard Kennedy School</p>
                      <p class="text-sm text-muted-foreground">2019</p>
                    </div>
                  </div>
                  
                  <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                      <Award class="w-6 h-6 text-blue-600" />
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-900 mb-1">Public Policy Workshop</h5>
                      <p class="text-gray-600 mb-1">Universitas Indonesia</p>
                      <p class="text-sm text-muted-foreground">2018</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Karir Politik Section -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8">
              <div class="flex items-center gap-3 mb-6">
                <Award class="w-6 h-6 text-primary" />
                <h3 class="text-2xl font-bold text-gray-900">Karir Politik</h3>
              </div>
              <div class="space-y-6">
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                  <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <Award class="w-6 h-6 text-primary" />
                  </div>
                  <div>
                    <h5 class="font-semibold text-gray-900 mb-1">Anggota DPR-RI</h5>
                    <p class="text-gray-600 mb-1">Dapil Sulawesi Barat</p>
                    <p class="text-sm text-muted-foreground">2024 - 2029</p>
                    <p class="text-sm text-primary font-medium mt-2">Komisi V - Infrastruktur dan Transportasi</p>
                  </div>
                </div>
                
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                  <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <Users class="w-6 h-6 text-primary" />
                  </div>
                  <div>
                    <h5 class="font-semibold text-gray-900 mb-1">Ketua DPC PDI-P</h5>
                    <p class="text-gray-600 mb-1">Kabupaten Pasangkayu</p>
                    <p class="text-sm text-muted-foreground">2020 - 2024</p>
                    <p class="text-sm text-primary font-medium mt-2">Mengkoordinasikan 15 kecamatan</p>
                  </div>
                </div>
                
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                  <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <BookOpen class="w-6 h-6 text-primary" />
                  </div>
                  <div>
                    <h5 class="font-semibold text-gray-900 mb-1">Anggota Komisi DPRD</h5>
                    <p class="text-gray-600 mb-1">Sulawesi Barat</p>
                    <p class="text-sm text-muted-foreground">2019 - 2024</p>
                    <p class="text-sm text-primary font-medium mt-2">Komisi C - Pembangunan</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Karier dan Organisasi Section -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8">
              <div class="flex items-center gap-3 mb-6">
                <Users class="w-6 h-6 text-primary" />
                <h3 class="text-2xl font-bold text-gray-900">Karier dan Organisasi</h3>
              </div>
              <div class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                  <!-- Organisasi Ekonomi & Bisnis -->
                  <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Organisasi Ekonomi & Bisnis</h4>
                    <div class="space-y-3">
                      <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                          <Users class="w-4 h-4 text-primary" />
                        </div>
                        <div>
                          <h5 class="font-medium text-gray-900 text-sm">Ketua Kadin Sulawesi Barat</h5>
                          <p class="text-xs text-muted-foreground">2018 - 2022</p>
                        </div>
                      </div>
                      
                      <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                          <Users class="w-4 h-4 text-primary" />
                        </div>
                        <div>
                          <h5 class="font-medium text-gray-900 text-sm">Ketua HIPMI Sulawesi Barat</h5>
                          <p class="text-xs text-muted-foreground">2015 - 2018</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Organisasi Pemuda & Sosial -->
                  <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Organisasi Pemuda & Sosial</h4>
                    <div class="space-y-3">
                      <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                          <Users class="w-4 h-4 text-primary" />
                        </div>
                        <div>
                          <h5 class="font-medium text-gray-900 text-sm">Ketua KNPI Sulawesi Barat</h5>
                          <p class="text-xs text-muted-foreground">2012 - 2015</p>
                        </div>
                      </div>
                      
                      <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                          <Users class="w-4 h-4 text-primary" />
                        </div>
                        <div>
                          <h5 class="font-medium text-gray-900 text-sm">Ketua Karang Taruna</h5>
                          <p class="text-xs text-muted-foreground">2010 - 2012</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Penghargaan Section -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8">
              <div class="flex items-center gap-3 mb-6">
                <Award class="w-6 h-6 text-primary" />
                <h3 class="text-2xl font-bold text-gray-900">Penghargaan</h3>
              </div>
              <div class="space-y-4">
                <div class="flex items-start gap-4 p-4 rounded-xl border from-yellow-50 to-orange-50 border-yellow-200">
                  <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <Award class="w-6 h-6 text-yellow-600" />
                  </div>
                  <div>
                    <h5 class="font-semibold text-gray-900 mb-1">Tokoh Muda Inspiratif</h5>
                    <p class="text-gray-600 mb-1">Kategori Pembangunan Daerah</p>
                    <p class="text-sm text-muted-foreground">2023</p>
                  </div>
                </div>
                
                <div class="flex items-start gap-4 p-4 rounded-xl border from-blue-50 to-indigo-50 border-blue-200">
                  <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <Award class="w-6 h-6 text-blue-600" />
                  </div>
                  <div>
                    <h5 class="font-semibold text-gray-900 mb-1">Penghargaan Pembangunan Infrastruktur</h5>
                    <p class="text-gray-600 mb-1">Kementerian PUPR</p>
                    <p class="text-sm text-muted-foreground">2022</p>
                  </div>
                </div>
                
                <div class="flex items-start gap-4 p-4 rounded-xl border from-green-50 to-emerald-50 border-green-200">
                  <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <Award class="w-6 h-6 text-green-600" />
                  </div>
                  <div>
                    <h5 class="font-semibold text-gray-900 mb-1">Lembaga Swadaya Masyarakat Terbaik</h5>
                    <p class="text-gray-600 mb-1">Kategori Pemberdayaan Masyarakat</p>
                    <p class="text-sm text-muted-foreground">2021</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Kontak Section -->
            <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-2xl p-8 border border-primary/10">
              <h3 class="text-xl font-semibold text-gray-900 mb-4">Hubungi Saya</h3>
              <p class="text-muted-foreground mb-6">
                Untuk aspirasi, saran, atau pertanyaan terkait program pembangunan daerah
              </p>
              <div class="flex flex-col sm:flex-row gap-4">
                <button @click="openSubscriptionModal" class="inline-flex items-center gap-2 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-medium px-6 py-3 rounded-[30px] transition-all duration-300 hover:shadow-lg hover:shadow-red-500/25">
                  <Bell class="w-5 h-5" />
                  Ikuti
                </button>
                <button class="inline-flex items-center gap-2 border border-primary text-primary hover:bg-primary hover:text-white font-medium px-6 py-3 rounded-[30px] transition-all duration-300">
                  <Calendar class="w-5 h-5" />
                  Lihat Jadwal
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Footer -->
    <Footer />

    <!-- Subscription Modal -->
    <SubscriptionModal 
      :is-open="isSubscriptionModalOpen" 
      @close="closeSubscriptionModal"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Users, BookOpen, GraduationCap, Award, Calendar, Bell } from 'lucide-vue-next';
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import SubscriptionModal from '@/components/SubscriptionModal.vue';

// State
const isSubscriptionModalOpen = ref(false);

// Methods
const openSubscriptionModal = () => {
  isSubscriptionModalOpen.value = true;
};

const closeSubscriptionModal = () => {
  isSubscriptionModalOpen.value = false;
};

</script>
