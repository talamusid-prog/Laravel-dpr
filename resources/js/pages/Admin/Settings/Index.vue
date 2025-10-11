<template>
  <AdminLayout page-title="Pengaturan Website">
    <!-- Header -->
    <div class="mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Pengaturan Website</h1>
          <p class="text-gray-600">Kelola konfigurasi dan pengaturan website</p>
        </div>
      </div>
    </div>

    <form @submit.prevent="handleSubmit" class="space-y-8">
      <!-- Site Information -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-medium text-gray-900">Informasi Website</h2>
          <p class="text-sm text-gray-600">Konfigurasi dasar website</p>
        </div>
        <div class="p-6 space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Nama Website</label>
              <input 
                v-model="form.site_name"
                type="text" 
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="Nama website Anda"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Warna Primer</label>
              <div class="flex items-center space-x-3">
                <input 
                  v-model="form.primary_color"
                  type="color" 
                  class="w-12 h-10 border border-gray-300 rounded-md"
                />
                <input 
                  v-model="form.primary_color"
                  type="text" 
                  required
                  class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                  placeholder="#3B82F6"
                />
              </div>
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Website</label>
            <textarea 
              v-model="form.site_description"
              rows="3"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              placeholder="Deskripsi singkat tentang website Anda"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Contact Information -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-medium text-gray-900">Informasi Kontak</h2>
          <p class="text-sm text-gray-600">Detail kontak yang akan ditampilkan di website</p>
        </div>
        <div class="p-6 space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Email Kontak</label>
              <input 
                v-model="form.contact_email"
                type="email" 
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="contact@example.com"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
              <input 
                v-model="form.contact_phone"
                type="tel" 
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="+62 123 456 7890"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Social Media -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-medium text-gray-900">Media Sosial</h2>
          <p class="text-sm text-gray-600">Link ke akun media sosial</p>
        </div>
        <div class="p-6 space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
              <input 
                v-model="form.social_facebook"
                type="url" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="https://facebook.com/yourpage"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
              <input 
                v-model="form.social_instagram"
                type="url" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="https://instagram.com/yourpage"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Twitter</label>
              <input 
                v-model="form.social_twitter"
                type="url" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="https://twitter.com/yourpage"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- SEO Settings -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-medium text-gray-900">Pengaturan SEO</h2>
          <p class="text-sm text-gray-600">Optimasi untuk mesin pencari</p>
        </div>
        <div class="p-6 space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
            <input 
              v-model="form.meta_title"
              type="text" 
              maxlength="60"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              placeholder="Judul yang akan muncul di hasil pencarian"
            />
            <p class="text-xs text-gray-500 mt-1">{{ form.meta_title?.length || 0 }}/60 karakter</p>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
            <textarea 
              v-model="form.meta_description"
              rows="3"
              maxlength="160"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              placeholder="Deskripsi yang akan muncul di hasil pencarian"
            ></textarea>
            <p class="text-xs text-gray-500 mt-1">{{ form.meta_description?.length || 0 }}/160 karakter</p>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
            <input 
              v-model="form.meta_keywords"
              type="text" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              placeholder="kata kunci, dipisahkan dengan koma"
            />
            <p class="text-xs text-gray-500 mt-1">Pisahkan kata kunci dengan koma</p>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-end space-x-4">
        <button 
          type="button"
          @click="resetForm"
          class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors"
        >
          Reset
        </button>
        <button 
          type="submit"
          :disabled="loading"
          class="px-6 py-2 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors disabled:opacity-50"
        >
          {{ loading ? 'Menyimpan...' : 'Simpan Pengaturan' }}
        </button>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

// Props
interface Props {
  settings: Record<string, {
    key: string;
    value: string;
    type: string;
    description: string;
  }>;
}

const props = defineProps<Props>();

// State
const loading = ref(false);

const form = reactive({
  site_name: props.settings.site_name?.value || '',
  site_description: props.settings.site_description?.value || '',
  primary_color: props.settings.primary_color?.value || '#3B82F6',
  contact_email: props.settings.contact_email?.value || '',
  contact_phone: props.settings.contact_phone?.value || '',
  social_facebook: props.settings.social_facebook?.value || '',
  social_instagram: props.settings.social_instagram?.value || '',
  social_twitter: props.settings.social_twitter?.value || '',
  meta_title: props.settings.meta_title?.value || '',
  meta_description: props.settings.meta_description?.value || '',
  meta_keywords: props.settings.meta_keywords?.value || '',
});

// Methods
const handleSubmit = () => {
  loading.value = true;
  
  // Simulate API call
  setTimeout(() => {
    loading.value = false;
    alert('Pengaturan berhasil disimpan!');
  }, 1000);
};

const resetForm = () => {
  Object.assign(form, {
    site_name: props.settings.site_name?.value || '',
    site_description: props.settings.site_description?.value || '',
    primary_color: props.settings.primary_color?.value || '#3B82F6',
    contact_email: props.settings.contact_email?.value || '',
    contact_phone: props.settings.contact_phone?.value || '',
    social_facebook: props.settings.social_facebook?.value || '',
    social_instagram: props.settings.social_instagram?.value || '',
    social_twitter: props.settings.social_twitter?.value || '',
    meta_title: props.settings.meta_title?.value || '',
    meta_description: props.settings.meta_description?.value || '',
    meta_keywords: props.settings.meta_keywords?.value || '',
  });
};
</script>
