<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-4">
        <button
          @click="goBack"
          class="p-2 text-gray-600 hover:text-gray-900 transition-colors"
        >
          <ArrowLeft class="w-5 h-5" />
        </button>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Detail Pendaftaran</h1>
          <p class="text-gray-600">{{ registration.name }}</p>
        </div>
      </div>
      
      <!-- Status Badge -->
      <span 
        :class="[
          'inline-flex px-3 py-1 text-sm font-semibold rounded-full',
          registration.status === 'approved' ? 'bg-green-100 text-green-800' :
          registration.status === 'rejected' ? 'bg-red-100 text-red-800' :
          'bg-yellow-100 text-yellow-800'
        ]"
      >
        {{ getStatusText(registration.status) }}
      </span>
    </div>

    <!-- Action Buttons -->
    <div v-if="registration.status === 'pending'" class="flex gap-3">
      <button
        @click="approveRegistration"
        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
      >
        <CheckCircle class="w-4 h-4" />
        Setujui
      </button>
      
      <button
        @click="rejectRegistration"
        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
      >
        <XCircle class="w-4 h-4" />
        Tolak
      </button>
    </div>

    <!-- Registration Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Personal Information -->
      <div class="bg-white p-6 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
        
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <p class="mt-1 text-sm text-gray-900">{{ registration.name }}</p>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <p class="mt-1 text-sm text-gray-900">{{ registration.email }}</p>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <p class="mt-1 text-sm text-gray-900">{{ registration.phone }}</p>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
            <p class="mt-1 text-sm text-gray-900">{{ formatDate(registration.birthdate) }}</p>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
            <p class="mt-1 text-sm text-gray-900">{{ registration.gender }}</p>
          </div>
        </div>
      </div>

      <!-- Professional Information -->
      <div class="bg-white p-6 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Profesional</h3>
        
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
            <p class="mt-1 text-sm text-gray-900">{{ registration.education || '-' }}</p>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
            <p class="mt-1 text-sm text-gray-900">{{ registration.occupation || '-' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Address -->
    <div class="bg-white p-6 rounded-lg border border-gray-200">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Alamat</h3>
      <p class="text-sm text-gray-900">{{ registration.address }}</p>
    </div>

    <!-- Registration Info -->
    <div class="bg-white p-6 rounded-lg border border-gray-200">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pendaftaran</h3>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Tanggal Daftar</label>
          <p class="mt-1 text-sm text-gray-900">{{ formatDateTime(registration.submitted_at) }}</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Status</label>
          <p class="mt-1 text-sm text-gray-900">{{ getStatusText(registration.status) }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { ArrowLeft, CheckCircle, XCircle } from 'lucide-vue-next';
import Swal from 'sweetalert2';

interface Registration {
  id: number;
  name: string;
  email: string;
  phone: string;
  birthdate: string;
  gender: string;
  education: string;
  occupation: string;
  address: string;
  status: 'pending' | 'approved' | 'rejected';
  submitted_at: string;
}

interface Props {
  registration: Registration;
}

const props = defineProps<Props>();

// Methods
const goBack = () => {
  router.visit('/admin/member-registrations');
};

const getStatusText = (status: string) => {
  const statusMap = {
    pending: 'Menunggu',
    approved: 'Disetujui',
    rejected: 'Ditolak'
  };
  return statusMap[status as keyof typeof statusMap] || status;
};

const formatDate = (dateString: string) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });
};

const formatDateTime = (dateString: string) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const approveRegistration = async () => {
  const result = await Swal.fire({
    title: 'Setujui Pendaftaran?',
    text: 'Apakah Anda yakin ingin menyetujui pendaftaran ini?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Setujui',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#10b981',
    cancelButtonColor: '#6b7280'
  });

  if (result.isConfirmed) {
    try {
      // Here you would make API call to approve
      await Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Pendaftaran telah disetujui.',
        confirmButtonColor: '#10b981'
      });
      
      // Refresh the page or update status
      router.reload();
    } catch (error) {
      await Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Gagal menyetujui pendaftaran.',
        confirmButtonColor: '#ef4444'
      });
    }
  }
};

const rejectRegistration = async () => {
  const result = await Swal.fire({
    title: 'Tolak Pendaftaran?',
    text: 'Apakah Anda yakin ingin menolak pendaftaran ini?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Tolak',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280'
  });

  if (result.isConfirmed) {
    try {
      // Here you would make API call to reject
      await Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Pendaftaran telah ditolak.',
        confirmButtonColor: '#ef4444'
      });
      
      // Refresh the page or update status
      router.reload();
    } catch (error) {
      await Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Gagal menolak pendaftaran.',
        confirmButtonColor: '#ef4444'
      });
    }
  }
};
</script>
