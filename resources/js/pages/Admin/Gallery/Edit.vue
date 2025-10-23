<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Edit Gallery</h1>
          <p class="text-gray-600">Ubah informasi dokumentasi kegiatan</p>
        </div>
        <button
          @click="$router.visit('/admin/gallery')"
          class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
        >
          <ArrowLeft class="w-4 h-4 inline mr-2" />
          Kembali
        </button>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form @submit.prevent="updateGallery" class="space-y-6">
          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
              Judul <span class="text-red-500">*</span>
            </label>
            <input
              v-model="formData.title"
              type="text"
              id="title"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
              placeholder="Masukkan judul dokumentasi"
            />
          </div>

          <!-- Description -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
              Deskripsi
            </label>
            <textarea
              v-model="formData.description"
              id="description"
              rows="4"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
              placeholder="Masukkan deskripsi dokumentasi"
            ></textarea>
          </div>

          <!-- Category -->
          <div>
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
              Kategori <span class="text-red-500">*</span>
            </label>
            <select
              v-model="formData.category"
              id="category"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
            >
              <option value="">Pilih Kategori</option>
              <option value="Kegiatan">Kegiatan</option>
              <option value="Pembangunan">Pembangunan</option>
              <option value="Sosial">Sosial</option>
              <option value="Pendidikan">Pendidikan</option>
              <option value="Kesehatan">Kesehatan</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>

          <!-- Current Image -->
          <div v-if="gallery.image_url">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Gambar Saat Ini
            </label>
            <div class="relative">
              <img
                :src="gallery.image_url"
                :alt="gallery.title"
                class="w-full h-48 object-cover rounded-lg border border-gray-200"
              />
              <button
                type="button"
                @click="removeImage"
                class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition-colors"
              >
                <X class="w-4 h-4" />
              </button>
            </div>
          </div>

          <!-- New Image Upload -->
          <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
              {{ gallery.image_url ? 'Ganti Gambar' : 'Upload Gambar' }}
            </label>
            <input
              ref="imageInput"
              type="file"
              id="image"
              accept="image/*"
              @change="handleImageChange"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
            />
            <p class="text-sm text-gray-500 mt-1">
              Format yang didukung: JPG, PNG, WEBP. Maksimal 5MB.
            </p>
          </div>

          <!-- Image Preview -->
          <div v-if="imagePreview" class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Preview Gambar Baru
            </label>
            <img
              :src="imagePreview"
              alt="Preview"
              class="w-full h-48 object-cover rounded-lg border border-gray-200"
            />
          </div>

          <!-- Is Active -->
          <div class="flex items-center">
            <input
              v-model="formData.is_active"
              type="checkbox"
              id="is_active"
              class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
            />
            <label for="is_active" class="ml-2 block text-sm text-gray-700">
              Tampilkan di halaman publik
            </label>
          </div>

          <!-- Submit Buttons -->
          <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <button
              type="button"
              @click="$router.visit('/admin/gallery')"
              class="px-6 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
            >
              Batal
            </button>
            <button
              type="submit"
              :disabled="loading"
              class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
            >
              <div v-if="loading" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
              {{ loading ? 'Menyimpan...' : 'Simpan Perubahan' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { ArrowLeft, X } from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';
import Swal from 'sweetalert2';

// Types
interface Gallery {
  id: number;
  title: string;
  description: string;
  category: string;
  image: string;
  image_url: string;
  is_active: boolean;
  created_at: string;
  updated_at: string;
}

// Props
interface Props {
  gallery: Gallery;
}

const props = defineProps<Props>();

// Reactive data
const loading = ref(false);
const imageInput = ref<HTMLInputElement | null>(null);
const imagePreview = ref<string | null>(null);
const formData = ref({
  title: props.gallery.title,
  description: props.gallery.description,
  category: props.gallery.category,
  image: null as File | null,
  is_active: props.gallery.is_active,
});

// Methods
const handleImageChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  const file = target.files?.[0];
  
  if (file) {
    // Validate file size (5MB max)
    if (file.size > 5 * 1024 * 1024) {
      Swal.fire({
        title: 'Error',
        text: 'Ukuran file terlalu besar. Maksimal 5MB.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
      return;
    }
    
    // Validate file type
    if (!file.type.startsWith('image/')) {
      Swal.fire({
        title: 'Error',
        text: 'File harus berupa gambar.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
      return;
    }
    
    formData.value.image = file;
    
    // Create preview
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target?.result as string;
    };
    reader.readAsDataURL(file);
  }
};

const removeImage = () => {
  formData.value.image = null;
  imagePreview.value = null;
  if (imageInput.value) {
    imageInput.value.value = '';
  }
};

const updateGallery = async () => {
  if (!formData.value.title.trim()) {
    Swal.fire({
      title: 'Error',
      text: 'Judul harus diisi.',
      icon: 'error',
      confirmButtonText: 'OK'
    });
    return;
  }

  if (!formData.value.category) {
    Swal.fire({
      title: 'Error',
      text: 'Kategori harus dipilih.',
      icon: 'error',
      confirmButtonText: 'OK'
    });
    return;
  }

  loading.value = true;

  try {
    const formDataToSend = new FormData();
    formDataToSend.append('title', formData.value.title);
    formDataToSend.append('description', formData.value.description);
    formDataToSend.append('category', formData.value.category);
    formDataToSend.append('is_active', formData.value.is_active ? '1' : '0');
    
    if (formData.value.image) {
      formDataToSend.append('image', formData.value.image);
    }

    formDataToSend.append('_method', 'PUT');

    await router.post(`/admin/gallery/${props.gallery.id}`, formDataToSend, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      onSuccess: () => {
        Swal.fire({
          title: 'Berhasil',
          text: 'Gallery berhasil diperbarui.',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          router.visit('/admin/gallery');
        });
      },
      onError: (errors) => {
        console.error('Update error:', errors);
        Swal.fire({
          title: 'Error',
          text: 'Terjadi kesalahan saat memperbarui gallery.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    });
  } catch (error) {
    console.error('Update error:', error);
    Swal.fire({
      title: 'Error',
      text: 'Terjadi kesalahan saat memperbarui gallery.',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  } finally {
    loading.value = false;
  }
};

// Lifecycle
onMounted(() => {
  // Any initialization logic
});
</script>
