<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Pendaftaran Anggota</h1>
        <p class="text-gray-600">Kelola pendaftaran anggota Relawan baGUS</p>
      </div>
      
      <!-- Action Buttons -->
      <div class="flex flex-wrap gap-2">
        <a 
          href="/pendaftaran-anggota"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          target="_blank"
        >
          <Eye class="w-4 h-4 mr-2" />
          Lihat Form
        </a>
        <button 
          @click="exportData"
          class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
        >
          <Download class="w-4 h-4 mr-2" />
          Export
        </button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="bg-white p-4 rounded-lg border border-gray-200">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <Users class="w-6 h-6 text-blue-600" />
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-600">Total Pendaftar</p>
            <p class="text-2xl font-bold text-gray-900">{{ registrations.length }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-4 rounded-lg border border-gray-200">
        <div class="flex items-center">
          <div class="p-2 bg-yellow-100 rounded-lg">
            <Clock class="w-6 h-6 text-yellow-600" />
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-600">Menunggu</p>
            <p class="text-2xl font-bold text-gray-900">{{ pendingCount }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-4 rounded-lg border border-gray-200">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 rounded-lg">
            <CheckCircle class="w-6 h-6 text-green-600" />
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-600">Disetujui</p>
            <p class="text-2xl font-bold text-gray-900">{{ approvedCount }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-4 rounded-lg border border-gray-200">
        <div class="flex items-center">
          <div class="p-2 bg-red-100 rounded-lg">
            <XCircle class="w-6 h-6 text-red-600" />
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-600">Ditolak</p>
            <p class="text-2xl font-bold text-gray-900">{{ rejectedCount }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg border border-gray-200">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-48">
          <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Cari nama atau email..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"
          />
        </div>
        
        <div class="min-w-32">
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select
            v-model="statusFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"
          >
            <option value="">Semua Status</option>
            <option value="pending">Menunggu</option>
            <option value="approved">Disetujui</option>
            <option value="rejected">Ditolak</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Pendaftar
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Kontak
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Pendidikan
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr 
              v-for="registration in filteredRegistrations" 
              :key="registration.id"
              class="hover:bg-gray-50"
            >
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                      <User class="w-5 h-5 text-primary" />
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ registration.name }}</div>
                    <div class="text-sm text-gray-500">{{ registration.gender }}</div>
                  </div>
                </div>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ registration.email }}</div>
                <div class="text-sm text-gray-500">{{ registration.phone }}</div>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ registration.education || '-' }}</div>
                <div class="text-sm text-gray-500">{{ registration.occupation || '-' }}</div>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap">
                <span 
                  :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    registration.status === 'approved' ? 'bg-green-100 text-green-800' :
                    registration.status === 'rejected' ? 'bg-red-100 text-red-800' :
                    'bg-yellow-100 text-yellow-800'
                  ]"
                >
                  {{ getStatusText(registration.status) }}
                </span>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(registration.submitted_at) }}
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="viewRegistration(registration.id)"
                    class="text-primary hover:text-primary/80 transition-colors"
                    title="Lihat Detail"
                  >
                    <Eye class="w-4 h-4" />
                  </button>
                  
                  <button
                    v-if="registration.status === 'pending'"
                    @click="approveRegistration(registration.id)"
                    class="text-green-600 hover:text-green-800 transition-colors"
                    title="Setujui"
                  >
                    <CheckCircle class="w-4 h-4" />
                  </button>
                  
                  <button
                    v-if="registration.status === 'pending'"
                    @click="rejectRegistration(registration.id)"
                    class="text-red-600 hover:text-red-800 transition-colors"
                    title="Tolak"
                  >
                    <XCircle class="w-4 h-4" />
                  </button>
                  
                  <button
                    @click="deleteRegistration(registration.id)"
                    class="text-red-600 hover:text-red-800 transition-colors"
                    title="Hapus"
                  >
                    <Trash2 class="w-4 h-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="filteredRegistrations.length === 0" class="text-center py-12">
      <Users class="w-12 h-12 text-gray-400 mx-auto mb-4" />
      <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pendaftaran</h3>
      <p class="text-gray-500">Belum ada pendaftaran anggota yang ditemukan.</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { 
  Users, 
  Eye, 
  Download, 
  Clock, 
  CheckCircle, 
  XCircle, 
  User, 
  Trash2 
} from 'lucide-vue-next';
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
  registrations: Registration[];
}

const props = defineProps<Props>();

// State
const searchQuery = ref('');
const statusFilter = ref('');

// Computed
const filteredRegistrations = computed(() => {
  let filtered = props.registrations;

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(reg => 
      reg.name.toLowerCase().includes(query) ||
      reg.email.toLowerCase().includes(query)
    );
  }

  if (statusFilter.value) {
    filtered = filtered.filter(reg => reg.status === statusFilter.value);
  }

  return filtered;
});

const pendingCount = computed(() => 
  props.registrations.filter(reg => reg.status === 'pending').length
);

const approvedCount = computed(() => 
  props.registrations.filter(reg => reg.status === 'approved').length
);

const rejectedCount = computed(() => 
  props.registrations.filter(reg => reg.status === 'rejected').length
);

// Methods
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
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const viewRegistration = (id: number) => {
  router.visit(`/admin/member-registrations/${id}`);
};

const approveRegistration = async (id: number) => {
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

const rejectRegistration = async (id: number) => {
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

const deleteRegistration = async (id: number) => {
  const result = await Swal.fire({
    title: 'Hapus Pendaftaran?',
    text: 'Apakah Anda yakin ingin menghapus pendaftaran ini? Tindakan ini tidak dapat dibatalkan.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Hapus',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280'
  });

  if (result.isConfirmed) {
    try {
      // Here you would make API call to delete
      await Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Pendaftaran telah dihapus.',
        confirmButtonColor: '#ef4444'
      });
    } catch (error) {
      await Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Gagal menghapus pendaftaran.',
        confirmButtonColor: '#ef4444'
      });
    }
  }
};

const exportData = async () => {
  await Swal.fire({
    icon: 'success',
    title: 'Export Berhasil!',
    text: 'Data pendaftaran telah diekspor.',
    confirmButtonColor: '#10b981'
  });
};
</script>
