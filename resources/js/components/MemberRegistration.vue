<template>
  <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl border border-gray-200 mt-8">
    <!-- Header Section -->
    <div class="text-center mb-8">
      <!-- Badge -->
      <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium mb-4">
        <Users class="w-4 h-4" />
        Pendaftaran Anggota
      </div>
      
      <!-- Title -->
      <h1 class="text-3xl font-bold text-black mb-4">
        Formulir Pendaftaran Relawan bAGUS
      </h1>
      
      <!-- Description -->
      <p class="text-muted-foreground">
        Silakan lengkapi formulir di bawah ini untuk mendaftar sebagai anggota Relawan baGUS
      </p>
    </div>

    <!-- Form -->
    <form @submit.prevent="submitForm" class="space-y-6">
      <!-- Form Fields Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Name Field -->
        <div class="space-y-2">
          <label for="name" class="block text-sm font-medium text-gray-700">
            Nama Lengkap <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            id="name"
            name="name"
            v-model="formData.name"
            required
            :class="[
              'w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-primary focus:border-primary',
              errors.name ? 'border-red-500' : 'border-gray-300'
            ]"
            placeholder="Masukkan nama lengkap"
          />
          <p v-if="errors.name" class="text-red-500 text-sm mt-1">
            {{ errors.name[0] }}
          </p>
        </div>

        <!-- Email Field -->
        <div class="space-y-2">
          <label for="email" class="block text-sm font-medium text-gray-700">
            Email <span class="text-red-500">*</span>
          </label>
          <input
            type="email"
            id="email"
            name="email"
            v-model="formData.email"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"
            placeholder="contoh@email.com"
          />
          <p v-if="errors.email" class="text-red-500 text-sm mt-1">
            {{ errors.email[0] }}
          </p>
        </div>

        <!-- Phone Field -->
        <div class="space-y-2">
          <label for="phone" class="block text-sm font-medium text-gray-700">
            Nomor Telepon <span class="text-red-500">*</span>
          </label>
          <input
            type="tel"
            id="phone"
            name="phone"
            v-model="formData.phone"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"
            placeholder="08xxxxxxxxxx"
          />
          <p v-if="errors.phone" class="text-red-500 text-sm mt-1">
            {{ errors.phone[0] }}
          </p>
        </div>

        <!-- Birthdate Field -->
        <div class="space-y-2">
          <label for="birthdate" class="block text-sm font-medium text-gray-700">
            Tanggal Lahir <span class="text-red-500">*</span>
          </label>
          <input
            type="date"
            id="birthdate"
            name="birthdate"
            v-model="formData.birthdate"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"
          />
          <p v-if="errors.birthdate" class="text-red-500 text-sm mt-1">
            {{ errors.birthdate[0] }}
          </p>
        </div>

        <!-- Gender Field -->
        <div class="space-y-2">
          <label for="gender" class="block text-sm font-medium text-gray-700">
            Jenis Kelamin <span class="text-red-500">*</span>
          </label>
          <select
            id="gender"
            name="gender"
            v-model="formData.gender"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"
          >
            <option value="">Pilih Jenis Kelamin</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
          <p v-if="errors.gender" class="text-red-500 text-sm mt-1">
            {{ errors.gender[0] }}
          </p>
        </div>

        <!-- Education Field -->
        <div class="space-y-2">
          <label for="education" class="block text-sm font-medium text-gray-700">
            Pendidikan Terakhir
          </label>
          <select
            id="education"
            name="education"
            v-model="formData.education"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"
          >
            <option value="">Pilih Pendidikan Terakhir</option>
            <option value="SD">SD</option>
            <option value="SMP">SMP</option>
            <option value="SMA/SMK">SMA/SMK</option>
            <option value="D3">D3</option>
            <option value="S1">S1</option>
            <option value="S2">S2</option>
            <option value="S3">S3</option>
          </select>
          <p v-if="errors.education" class="text-red-500 text-sm mt-1">
            {{ errors.education[0] }}
          </p>
        </div>

        <!-- Occupation Field -->
        <div class="space-y-2">
          <label for="occupation" class="block text-sm font-medium text-gray-700">
            Pekerjaan
          </label>
          <input
            type="text"
            id="occupation"
            name="occupation"
            v-model="formData.occupation"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"
            placeholder="Masukkan pekerjaan"
          />
          <p v-if="errors.occupation" class="text-red-500 text-sm mt-1">
            {{ errors.occupation[0] }}
          </p>
        </div>
      </div>

      <!-- Address Field (Full Width) -->
      <div class="space-y-2">
        <label for="address" class="block text-sm font-medium text-gray-700">
          Alamat <span class="text-red-500">*</span>
        </label>
        <textarea
          id="address"
          name="address"
          v-model="formData.address"
          required
          rows="3"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"
          placeholder="Masukkan alamat lengkap"
        ></textarea>
        <p v-if="errors.address" class="text-red-500 text-sm mt-1">
          {{ errors.address[0] }}
        </p>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-center pt-4">
        <button
          type="submit"
          :disabled="isSubmitting"
          class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <!-- Loading State -->
          <div v-if="isSubmitting" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
          <span v-if="isSubmitting">Mengirim...</span>
          
          <!-- Normal State -->
          <template v-else>
            <Send class="w-4 h-4" />
            Kirim Pendaftaran
          </template>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { Users, Send } from 'lucide-vue-next';
import Swal from 'sweetalert2';

// Form data
const formData = reactive({
  name: '',
  email: '',
  phone: '',
  birthdate: '',
  gender: '',
  education: '',
  occupation: '',
  address: ''
});

// State
const isSubmitting = ref(false);
const errors = ref<Record<string, string[]>>({});

// Submit form
const submitForm = async () => {
  isSubmitting.value = true;
  errors.value = {};

  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 2000));
    
    // Show success message
    await Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Pendaftaran Anda telah berhasil dikirim. Terima kasih telah bergabung dengan Relawan baGUS!',
      confirmButtonText: 'OK',
      confirmButtonColor: '#ef4444'
    });

    // Reset form
    Object.keys(formData).forEach(key => {
      formData[key as keyof typeof formData] = '';
    });

  } catch (error: any) {
    console.error('Registration error:', error);
    
    // Show error message
    await Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: 'Terjadi kesalahan saat mengirim pendaftaran. Silakan coba lagi.',
      confirmButtonText: 'OK',
      confirmButtonColor: '#ef4444'
    });
  } finally {
    isSubmitting.value = false;
  }
};
</script>
