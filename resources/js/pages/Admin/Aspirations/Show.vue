<template>
  <AdminLayout page-title="Detail Aspirasi">
    <!-- Header -->
    <div class="mb-6">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          <a 
            href="/admin/aspirations"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
          >
            <ArrowLeft class="w-4 h-4 mr-2" />
            Kembali
          </a>
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Aspirasi</h1>
            <p class="text-gray-600">ID: #{{ aspiration.id }}</p>
          </div>
        </div>
        
        <!-- Status Actions -->
        <div class="flex items-center gap-3">
          <!-- Status Badge -->
          <span 
            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
            :class="getStatusClasses(aspiration.status)"
          >
            {{ getStatusLabel(aspiration.status) }}
          </span>
          
          <!-- Status Change Dropdown -->
          <div class="relative">
            <select 
              v-model="newStatus"
              @change="updateStatus"
              class="appearance-none bg-white border border-gray-300 rounded-md px-3 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
            >
              <option value="baru">Baru</option>
              <option value="diproses">Diproses</option>
              <option value="selesai">Selesai</option>
            </select>
            <ChevronDown class="absolute right-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main Content -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Aspiration Details -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
          <div class="p-6">
            <div class="flex items-start justify-between mb-4">
              <h2 class="text-xl font-semibold text-gray-900">{{ aspiration.title }}</h2>
              <span 
                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                :class="getCategoryClasses()"
              >
                {{ aspiration.category }}
              </span>
            </div>
            
            <div class="prose max-w-none">
              <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ aspiration.description }}</p>
            </div>
          </div>
        </div>

        <!-- Admin Response Section -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tanggapan Admin</h3>
            
            <div v-if="aspiration.admin_response" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
              <p class="text-blue-800 whitespace-pre-wrap">{{ aspiration.admin_response }}</p>
              <p class="text-xs text-blue-600 mt-2">
                Direspons pada {{ formatDate(aspiration.responded_at || '') }}
              </p>
            </div>
            
            <div v-else class="text-center py-8">
              <MessageSquare class="w-12 h-12 text-gray-400 mx-auto mb-4" />
              <p class="text-gray-500 mb-4">Belum ada tanggapan</p>
              <button 
                @click="showResponseModal = true"
                class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
              >
                <MessageSquare class="w-4 h-4 mr-2" />
                Berikan Tanggapan
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="space-y-6">
        <!-- Submitter Info -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengirim</h3>
            
            <div class="space-y-3">
              <div class="flex items-center gap-3">
                <User class="w-5 h-5 text-gray-400" />
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ aspiration.submitter_name }}</p>
                  <p class="text-xs text-gray-500">Nama Lengkap</p>
                </div>
              </div>
              
              <div class="flex items-center gap-3">
                <Mail class="w-5 h-5 text-gray-400" />
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ aspiration.submitter_email }}</p>
                  <p class="text-xs text-gray-500">Email</p>
                </div>
              </div>
              
              <div v-if="aspiration.submitter_phone" class="flex items-center gap-3">
                <Phone class="w-5 h-5 text-gray-400" />
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ aspiration.submitter_phone }}</p>
                  <p class="text-xs text-gray-500">Telepon</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
            
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                <div>
                  <p class="text-sm font-medium text-gray-900">Aspirasi Dikirim</p>
                  <p class="text-xs text-gray-500">{{ formatDate(aspiration.created_at) }}</p>
                </div>
              </div>
              
              <div v-if="aspiration.responded_at" class="flex items-start gap-3">
                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                <div>
                  <p class="text-sm font-medium text-gray-900">Direspons Admin</p>
                  <p class="text-xs text-gray-500">{{ formatDate(aspiration.responded_at) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Response Modal -->
    <div v-if="showResponseModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Berikan Tanggapan</h3>
            <button 
              @click="showResponseModal = false"
              class="text-gray-400 hover:text-gray-600"
            >
              <X class="w-5 h-5" />
            </button>
          </div>
          
          <form @submit.prevent="submitResponse">
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Tanggapan
              </label>
              <textarea 
                v-model="responseText"
                rows="6"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="Tulis tanggapan Anda..."
                required
              ></textarea>
            </div>
            
            <div class="flex justify-end gap-3">
              <button 
                type="button"
                @click="showResponseModal = false"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
              >
                Batal
              </button>
              <button 
                type="submit"
                :disabled="isSubmitting"
                class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-md hover:bg-primary/90 transition-colors disabled:opacity-50"
              >
                <span v-if="isSubmitting">Mengirim...</span>
                <span v-else>Kirim Tanggapan</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { 
  ArrowLeft, 
  User, 
  Mail, 
  Phone, 
  MessageSquare, 
  ChevronDown,
  X
} from 'lucide-vue-next';
import Swal from 'sweetalert2';
import AdminLayout from '@/layouts/AdminLayout.vue';

// Props
interface Props {
  aspiration: {
    id: number;
    title: string;
    description: string;
    category: string;
    status: string;
    submitter_name: string;
    submitter_email: string;
    submitter_phone?: string;
    admin_response?: string;
    responded_at?: string;
    created_at: string;
  };
}

const props = defineProps<Props>();

// State
const newStatus = ref(props.aspiration.status);
const showResponseModal = ref(false);
const responseText = ref('');
const isSubmitting = ref(false);

// Methods
const formatDate = (dateString: string): string => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const getStatusClasses = (status: string): string => {
  const statusMap: Record<string, string> = {
    'baru': 'bg-red-100 text-red-800',
    'diproses': 'bg-yellow-100 text-yellow-800',
    'selesai': 'bg-green-100 text-green-800'
  };
  return statusMap[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status: string): string => {
  const labelMap: Record<string, string> = {
    'baru': 'Baru',
    'diproses': 'Diproses',
    'selesai': 'Selesai'
  };
  return labelMap[status] || status;
};

const getCategoryClasses = (): string => {
  return 'bg-blue-100 text-blue-800';
};

const updateStatus = async () => {
  if (newStatus.value === props.aspiration.status) return;
  
  const result = await Swal.fire({
    title: 'Ubah Status',
    text: `Apakah Anda yakin ingin mengubah status menjadi "${getStatusLabel(newStatus.value)}"?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, Ubah!',
    cancelButtonText: 'Batal'
  });

  if (result.isConfirmed) {
    router.patch(`/admin/aspirations/${props.aspiration.id}/status`, {
      status: newStatus.value
    }, {
      onSuccess: async () => {
        await Swal.fire({
          title: 'Berhasil!',
          text: 'Status aspirasi berhasil diubah.',
          icon: 'success',
          confirmButtonColor: '#ef4444'
        });
      },
      onError: async (errors) => {
        console.error('Error updating status:', errors);
        await Swal.fire({
          title: 'Gagal!',
          text: 'Gagal mengubah status aspirasi.',
          icon: 'error',
          confirmButtonColor: '#ef4444'
        });
      }
    });
  } else {
    // Reset to original status if cancelled
    newStatus.value = props.aspiration.status;
  }
};

const submitResponse = async () => {
  if (!responseText.value.trim()) return;
  
  isSubmitting.value = true;
  
  try {
    router.post(`/admin/aspirations/${props.aspiration.id}/respond`, {
      response: responseText.value
    }, {
      onSuccess: async () => {
        showResponseModal.value = false;
        responseText.value = '';
        await Swal.fire({
          title: 'Berhasil!',
          text: 'Tanggapan berhasil dikirim.',
          icon: 'success',
          confirmButtonColor: '#ef4444'
        });
      },
      onError: async (errors) => {
        console.error('Error submitting response:', errors);
        await Swal.fire({
          title: 'Gagal!',
          text: 'Gagal mengirim tanggapan.',
          icon: 'error',
          confirmButtonColor: '#ef4444'
        });
      }
    });
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
.prose {
  color: inherit;
}
</style>
