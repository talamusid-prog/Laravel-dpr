<template>
  <AdminLayout>
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
      <!-- Header Section -->
      <div class="flex items-center justify-between mb-8">
        <!-- Left Side -->
        <div class="flex items-center gap-4">
          <button 
            @click="navigateToGallery"
            class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
          >
            <ArrowLeft class="w-4 h-4 text-gray-600" />
          </button>
          
          <div>
            <h1 class="text-3xl font-bold text-black">
              Tambah Gambar Gallery
            </h1>
            <p class="text-muted-foreground">
              Upload gambar baru untuk dokumentasi kegiatan
            </p>
          </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center gap-3">
          <!-- Save Button -->
          <button 
            @click="saveGallery"
            :disabled="isSaving"
            class="inline-flex items-center gap-2 px-6 py-2 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors disabled:opacity-50"
          >
            <span v-if="isSaving" class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></span>
            <Save v-else class="w-4 h-4" />
            <span>{{ isSaving ? 'Menyimpan...' : 'Simpan' }}</span>
          </button>
        </div>
      </div>

      <!-- Grid Layout -->
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content Section (Left Column) -->
        <div class="lg:col-span-3 space-y-6">
          <!-- Image Upload Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Gambar</h3>
              
              <!-- With Image -->
              <div v-if="formData.image" class="space-y-4">
                <div class="aspect-video rounded-lg overflow-hidden border">
                  <img 
                    :src="formData.image" 
                    :alt="formData.title"
                    class="w-full h-full object-cover"
                  />
                </div>
                
                <button 
                  @click="removeImage"
                  class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                >
                  <X class="w-4 h-4" />
                  Hapus Gambar
                </button>
              </div>

              <!-- Without Image -->
              <div v-else>
                <input
                  ref="fileInput"
                  type="file"
                  accept="image/*"
                  @change="handleFileUpload"
                  class="hidden"
                />
                
                <button 
                  @click="() => fileInput?.click()"
                  :disabled="isUploading"
                  class="w-full h-32 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center gap-2 hover:border-gray-400 transition-colors disabled:opacity-50"
                >
                  <span v-if="isUploading" class="animate-spin rounded-full h-6 w-6 border-2 border-primary border-t-transparent"></span>
                  <Upload v-else class="w-8 h-8 text-gray-400" />
                  <span class="text-sm text-gray-600">Upload Gambar</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Details Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Gambar</h3>
              
              <div class="space-y-4">
                <!-- Title -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Gambar
                  </label>
                  <input
                    v-model="formData.title"
                    type="text"
                    placeholder="Masukkan judul gambar..."
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                  />
                </div>

                <!-- Description -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                  </label>
                  <textarea
                    v-model="formData.description"
                    placeholder="Masukkan deskripsi gambar..."
                    rows="4"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                  ></textarea>
                </div>

                <!-- Category -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori
                  </label>
                  <select
                    v-model="formData.category"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                  >
                    <option value="">Pilih Kategori</option>
                    <option value="Politik">Politik</option>
                    <option value="Kegiatan">Kegiatan</option>
                    <option value="Sosialisasi">Sosialisasi</option>
                    <option value="Kerjasama">Kerjasama</option>
                    <option value="Acara">Acara</option>
                    <option value="Masyarakat">Masyarakat</option>
                    <option value="Pendidikan">Pendidikan</option>
                    <option value="Ekonomi">Ekonomi</option>
                  </select>
                </div>

                <!-- Location -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Lokasi
                  </label>
                  <input
                    v-model="formData.location"
                    type="text"
                    placeholder="Masukkan lokasi..."
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                  />
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar Section (Right Column) -->
        <div class="lg:col-span-1 space-y-6">
          <!-- Status Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
              
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                  </label>
                  <select
                    v-model="formData.is_active"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                  >
                    <option :value="true">Aktif</option>
                    <option :value="false">Tidak Aktif</option>
                  </select>
                </div>

                <div>
                  <label class="flex items-center">
                    <input
                      v-model="formData.is_featured"
                      type="checkbox"
                      class="rounded border-gray-300 text-primary focus:ring-primary"
                    />
                    <span class="ml-2 text-sm text-gray-700">Tampilkan sebagai Featured</span>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Image Info Card -->
          <div v-if="formData.image" class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Gambar</h3>
              
              <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                  <span>Ukuran:</span>
                  <span>{{ imageInfo.size || 'Unknown' }}</span>
                </div>
                <div class="flex justify-between">
                  <span>Format:</span>
                  <span>{{ imageInfo.format || 'Unknown' }}</span>
                </div>
                <div class="flex justify-between">
                  <span>Dimensi:</span>
                  <span>{{ imageInfo.dimensions || 'Unknown' }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { ArrowLeft, Save, X, Upload } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';

// Types
interface FormData {
  title: string;
  description: string;
  image: string | null;
  category: string;
  location: string;
  is_active: boolean;
  is_featured: boolean;
}

interface ImageInfo {
  size?: string;
  format?: string;
  dimensions?: string;
}

// State
const formData = ref<FormData>({
  title: '',
  description: '',
  image: null,
  category: '',
  location: '',
  is_active: true,
  is_featured: false
});

const imageInfo = ref<ImageInfo>({});
const isUploading = ref(false);
const isSaving = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);

// Methods
const navigateToGallery = () => {
  router.visit('/admin/gallery');
};

const handleFileUpload = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (!file) return;

  isUploading.value = true;
  
  const reader = new FileReader();
  reader.onload = (e) => {
    formData.value.image = e.target?.result as string;
    
    // Get image info
    const img = new Image();
    img.onload = () => {
      imageInfo.value = {
        size: formatFileSize(file.size),
        format: file.type,
        dimensions: `${img.width} x ${img.height}`
      };
    };
    img.src = e.target?.result as string;
    
    isUploading.value = false;
  };
  reader.onerror = () => {
    console.error('Error reading file');
    isUploading.value = false;
  };
  reader.readAsDataURL(file);
};

const removeImage = () => {
  formData.value.image = null;
  imageInfo.value = {};
};

const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

const saveGallery = async () => {
  // Validation
  if (!formData.value.title.trim()) {
    await Swal.fire({
      title: 'Validasi Gagal',
      text: 'Judul gambar harus diisi',
      icon: 'error',
      confirmButtonColor: '#ef4444'
    });
    return;
  }
  
  if (!formData.value.image) {
    await Swal.fire({
      title: 'Validasi Gagal',
      text: 'Gambar harus diupload',
      icon: 'error',
      confirmButtonColor: '#ef4444'
    });
    return;
  }

  if (!formData.value.category) {
    await Swal.fire({
      title: 'Validasi Gagal',
      text: 'Kategori harus dipilih',
      icon: 'error',
      confirmButtonColor: '#ef4444'
    });
    return;
  }

  isSaving.value = true;
  
  try {
    // Prepare form data
    const formDataToSend = new FormData();
    
    // Append all text fields
    formDataToSend.append('title', formData.value.title);
    formDataToSend.append('description', formData.value.description);
    formDataToSend.append('category', formData.value.category);
    formDataToSend.append('location', formData.value.location);
    formDataToSend.append('is_active', formData.value.is_active ? '1' : '0');
    formDataToSend.append('is_featured', formData.value.is_featured ? '1' : '0');
    
    // Convert base64 to file
    const response = await fetch(formData.value.image);
    const blob = await response.blob();
    const file = new File([blob], 'gallery_image.jpg', { type: 'image/jpeg' });
    formDataToSend.append('image', file);

    // Submit with file using Inertia.js
    router.post('/admin/gallery', formDataToSend, {
      forceFormData: true,
      onSuccess: async () => {
        await Swal.fire({
          title: 'Berhasil!',
          text: 'Gambar gallery berhasil ditambahkan!',
          icon: 'success',
          confirmButtonColor: '#ef4444'
        });
        router.visit('/admin/gallery');
      },
      onError: async (errors) => {
        console.error('Server error:', errors);
        await Swal.fire({
          title: 'Gagal!',
          text: 'Gagal menambahkan gambar: ' + (Object.values(errors).flat().join(', ')),
          icon: 'error',
          confirmButtonColor: '#ef4444'
        });
      }
    });
  } catch (error) {
    console.error('Error creating gallery:', error);
    await Swal.fire({
      title: 'Gagal!',
      text: 'Gagal menambahkan gambar',
      icon: 'error',
      confirmButtonColor: '#ef4444'
    });
  } finally {
    isSaving.value = false;
  }
};
</script>

<style scoped>
/* Custom styles for the gallery create page */
.upload-area {
  transition: all 0.3s ease;
}

.upload-area:hover {
  border-color: #3b82f6;
  background-color: #f8fafc;
}
</style>
