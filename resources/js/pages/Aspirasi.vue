<template>
  <div class="min-h-screen">
    <!-- Header -->
    <Header />
    
    <!-- Main Content -->
    <main class="bg-gradient-to-b from-background to-muted min-h-screen pt-20">
      <!-- Form Section -->
      <section class="max-w-4xl mx-auto px-4 py-12">
        <!-- Header Section -->
        <div class="text-center mb-8">
          <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
            Sampaikan Aspirasi Anda
          </h1>
          <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
            Suara Anda penting untuk kemajuan daerah. Mari bersama-sama membangun masa depan yang lebih baik.
          </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl border border-gray-200 p-8 lg:p-12">
          <form @submit.prevent="submitAspirasi" class="space-y-6">
            <!-- 1. Personal Information Section -->
            <div>
              <div class="flex items-center gap-2 mb-6">
                <User class="w-5 h-5 text-primary" />
                <h2 class="text-xl font-semibold text-gray-900">Informasi Pribadi</h2>
              </div>
              
              <div class="grid md:grid-cols-2 gap-6">
                <!-- Name Field -->
                <div>
                  <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                  </label>
                  <input
                    type="text"
                    id="nama"
                    name="nama"
                    v-model="formData.nama"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                    placeholder="Masukkan nama lengkap Anda"
                  />
                </div>

                <!-- Email Field -->
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                  </label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    v-model="formData.email"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                    placeholder="Masukkan email Anda"
                  />
                </div>
              </div>
            </div>

            <!-- 2. Category Section -->
            <div>
              <div class="flex items-center gap-2 mb-6">
                <Tag class="w-5 h-5 text-primary" />
                <h2 class="text-xl font-semibold text-gray-900">Kategori Aspirasi</h2>
              </div>
              
              <div class="space-y-4">
                <div>
                  <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Kategori <span class="text-red-500">*</span>
                  </label>
                  <select
                    id="kategori"
                    name="kategori"
                    v-model="formData.kategori"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                  >
                    <option value="">Pilih kategori aspirasi</option>
                    <option value="pendidikan">Pendidikan</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="infrastruktur">Infrastruktur</option>
                    <option value="ekonomi">Ekonomi & UMKM</option>
                    <option value="sosial">Sosial & Budaya</option>
                    <option value="lingkungan">Lingkungan</option>
                    <option value="pemuda">Pemuda & Olahraga</option>
                    <option value="perempuan">Perempuan & Anak</option>
                    <option value="lainnya">Lainnya</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- 3. Aspiration Content Section -->
            <div>
              <div class="flex items-center gap-2 mb-6">
                <FileText class="w-5 h-5 text-primary" />
                <h2 class="text-xl font-semibold text-gray-900">Aspirasi Anda</h2>
              </div>
              
              <div class="space-y-4">
                <div>
                  <label for="aspirasi" class="block text-sm font-medium text-gray-700 mb-2">
                    Tuliskan Aspirasi Anda <span class="text-red-500">*</span>
                  </label>
                  <textarea
                    id="aspirasi"
                    name="aspirasi"
                    v-model="formData.aspirasi"
                    required
                    rows="8"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 resize-none"
                    placeholder="Tuliskan aspirasi, saran, atau masukan Anda untuk kemajuan daerah. Jelaskan dengan detail dan berikan solusi yang konstruktif..."
                  ></textarea>
                  <p class="text-sm text-gray-500 mt-2">
                    Minimal 50 karakter. Jelaskan dengan detail dan berikan solusi yang konstruktif.
                  </p>
                </div>
              </div>
            </div>

            <!-- 4. Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center pt-6">
              <button
                type="submit"
                :disabled="isSubmitting"
                class="bg-gradient-to-r from-red-500 to-orange-500 text-white hover:from-red-600 hover:to-orange-600 hover:shadow-glow transition-all duration-300 text-base px-8 py-3 rounded-[30px] flex items-center gap-2 justify-center disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <Send v-if="!isSubmitting" class="w-5 h-5" />
                <div v-else class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                {{ isSubmitting ? 'Mengirim...' : 'Kirim Aspirasi' }}
              </button>
            </div>
          </form>
        </div>
      </section>
    </main>

    <!-- Back to Top Button -->
    <BackToTop />

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { 
  User, 
  Tag, 
  FileText, 
  Send
} from 'lucide-vue-next';
import Swal from 'sweetalert2';
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import BackToTop from '../components/BackToTop.vue';

// Form data
const formData = reactive({
  nama: '',
  email: '',
  kategori: '',
  aspirasi: ''
});

// State
const isSubmitting = ref(false);

// Methods
const submitAspirasi = async () => {
  try {
    isSubmitting.value = true;
    
    // Validate form
    if (!formData.nama || !formData.email || !formData.kategori || !formData.aspirasi) {
      alert('Mohon lengkapi semua field yang wajib diisi.');
      return;
    }

    if (formData.aspirasi.length < 50) {
      alert('Aspirasi minimal 50 karakter.');
      return;
    }

    // Submit to API
    const response = await fetch('/aspirasi', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify(formData)
    });

    const result = await response.json();

    if (result.success) {
      await Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: result.message || 'Aspirasi Anda telah berhasil dikirim.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ef4444'
      });
      
      // Reset form
      Object.assign(formData, {
        nama: '',
        email: '',
        kategori: '',
        aspirasi: ''
      });
    } else {
      if (result.errors) {
        // Handle validation errors
        const errorMessages = Object.values(result.errors).flat();
        await Swal.fire({
          icon: 'error',
          title: 'Validasi Gagal',
          html: errorMessages.join('<br>'),
          confirmButtonText: 'OK',
          confirmButtonColor: '#ef4444'
        });
      } else {
        await Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: result.message || 'Terjadi kesalahan saat mengirim aspirasi.',
          confirmButtonText: 'OK',
          confirmButtonColor: '#ef4444'
        });
      }
    }
    
  } catch (error) {
    console.error('Error submitting aspirasi:', error);
    await Swal.fire({
      icon: 'error',
      title: 'Kesalahan',
      text: 'Terjadi kesalahan saat mengirim aspirasi. Silakan coba lagi.',
      confirmButtonText: 'OK',
      confirmButtonColor: '#ef4444'
    });
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
.bg-gradient-primary {
  background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
}

.hover\:shadow-glow:hover {
  box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.3), 0 10px 10px -5px rgba(239, 68, 68, 0.1);
}
</style>
