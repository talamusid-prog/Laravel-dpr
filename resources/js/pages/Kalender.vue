<template>
  <div class="min-h-screen">
    <!-- Header -->
    <Header />
    
    <!-- Main Content -->
    <div class="bg-gray-50 min-h-screen pt-20 md:pt-24">
      <!-- Container -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                Kalender Kegiatan
              </h1>
              <p class="text-gray-600 mt-1">
                Jadwal kegiatan DPRD Sulawesi Barat
              </p>
            </div>
            
            <!-- Admin Link Button -->
            <div class="flex gap-3">
              <a 
                href="/admin/events"
                class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm font-medium"
              >
                <Settings class="w-4 h-4 mr-2" />
                Kelola Jadwal
              </a>
            </div>
          </div>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Calendar Section (Left Column) -->
          <div class="lg:col-span-2">
            <!-- Calendar Card -->
            <div class="bg-white rounded-lg shadow-lg">
              <!-- Card Header -->
              <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                  <Calendar class="w-5 h-5 text-primary" />
                  <h2 class="text-xl font-semibold text-gray-900">
                    {{ formatMonthYear(currentDate) }}
                  </h2>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="flex items-center gap-2">
                  <button 
                    @click="previousMonth"
                    class="inline-flex items-center justify-center w-8 h-8 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                  >
                    <ChevronLeft class="w-4 h-4 text-gray-600" />
                  </button>
                  <button 
                    @click="nextMonth"
                    class="inline-flex items-center justify-center w-8 h-8 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                  >
                    <ChevronRight class="w-4 h-4 text-gray-600" />
                  </button>
                </div>
              </div>

              <!-- Calendar Grid -->
              <div class="p-6">
                <!-- Day Headers -->
                <div class="grid grid-cols-7 gap-1 mb-4">
                  <div 
                    v-for="day in dayHeaders" 
                    :key="day"
                    class="p-2 text-center text-sm font-medium text-gray-500"
                  >
                    {{ day }}
                  </div>
                </div>

                <!-- Calendar Days -->
                <div class="grid grid-cols-7 gap-1">
                  <button
                    v-for="(day, index) in calendarDays"
                    :key="index"
                    @click="selectDate(day)"
                    :class="[
                      'p-2 text-center text-sm rounded-lg transition-colors',
                      day === null ? 'invisible' : '',
                      isToday(day) ? 'bg-red-100 text-red-700 font-semibold' : '',
                      isSelected(day) ? 'bg-blue-100 text-blue-700' : '',
                      day !== null && !isToday(day) && !isSelected(day) ? 'hover:bg-gray-100' : ''
                    ]"
                  >
                    <div class="flex flex-col items-center">
                      <span>{{ day }}</span>
                      
                      <!-- Activity Indicators -->
                      <div v-if="day !== null" class="flex gap-1 mt-1">
                        <div 
                          v-for="(activity, activityIndex) in getActivitiesForDay(day).slice(0, 2)"
                          :key="activityIndex"
                          class="w-2 h-2 rounded-full"
                          :class="getActivityColor(activity.type)"
                        ></div>
                        <div 
                          v-if="getActivitiesForDay(day).length > 2"
                          class="w-2 h-2 rounded-full bg-gray-400"
                        ></div>
                      </div>
                    </div>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar Section (Right Column) -->
          <div class="lg:col-span-1 space-y-6">
            <!-- Selected Date Info Card -->
            <div v-if="selectedDate" class="bg-white rounded-lg shadow-lg">
              <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                  {{ formatSelectedDate(selectedDate) }}
                </h3>
                
                <div v-if="getActivitiesForSelectedDate().length > 0" class="space-y-3">
                  <div 
                    v-for="activity in getActivitiesForSelectedDate()"
                    :key="activity.id"
                    class="border rounded-lg p-3"
                  >
                    <div class="p-3">
                      <!-- Header -->
                      <div class="flex items-start justify-between mb-2">
                        <h4 class="font-medium text-gray-900 line-clamp-1">
                          {{ activity.title }}
                        </h4>
                        <span 
                          class="text-xs px-2 py-1 rounded-full"
                          :class="getStatusClasses(activity.status)"
                        >
                          {{ activity.status }}
                        </span>
                      </div>
                      
                      <!-- Description -->
                      <p class="text-sm text-gray-600 line-clamp-2 mb-2">
                        {{ activity.description }}
                      </p>
                      
                      <!-- Details -->
                      <div class="space-y-1 text-xs text-gray-500">
                        <!-- Time -->
                        <div class="flex items-center gap-1">
                          <Clock class="w-3 h-3" />
                          <span>{{ formatTime(activity.start_time) }} - {{ formatTime(activity.end_time) }}</span>
                        </div>
                        
                        <!-- Location -->
                        <div class="flex items-center gap-1">
                          <MapPin class="w-3 h-3" />
                          <span class="line-clamp-1">{{ activity.location }}</span>
                        </div>
                        
                        <!-- Participants -->
                        <div v-if="activity.participants" class="flex items-center gap-1">
                          <Users class="w-3 h-3" />
                          <span>{{ activity.participants }} peserta</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div v-else class="text-center py-4">
                  <p class="text-gray-500">Tidak ada kegiatan pada tanggal ini</p>
                </div>
              </div>
            </div>

            <!-- Legend Card -->
            <div class="bg-white rounded-lg shadow-lg">
              <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                  Kategori Kegiatan
                </h3>
                
                <div class="space-y-2">
                  <div 
                    v-for="category in categories"
                    :key="category.type"
                    class="flex items-center gap-2"
                  >
                    <div 
                      class="w-3 h-3 rounded-full"
                      :class="category.color"
                    ></div>
                    <span class="text-sm text-gray-700">{{ category.label }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Calendar, ChevronLeft, ChevronRight, Clock, MapPin, Users, Settings } from 'lucide-vue-next';
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';

// Types
interface Kegiatan {
  id: number;
  title: string;
  description: string;
  type: 'sidang' | 'rapat' | 'kunjungan' | 'acara' | 'lainnya';
  status: 'terjadwal' | 'berlangsung' | 'selesai' | 'dibatalkan';
  start_time: string;
  end_time: string;
  location: string;
  participants?: number;
  date: string;
}

// State
const currentDate = ref(new Date());
const selectedDate = ref<Date | null>(null);
const kegiatan = ref<Kegiatan[]>([]);

// Day headers
const dayHeaders = ['Ming', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

// Categories
const categories = [
  { type: 'sidang', label: 'Sidang', color: 'bg-blue-500' },
  { type: 'rapat', label: 'Rapat', color: 'bg-green-500' },
  { type: 'kunjungan', label: 'Kunjungan', color: 'bg-orange-500' },
  { type: 'acara', label: 'Acara', color: 'bg-purple-500' },
  { type: 'lainnya', label: 'Lainnya', color: 'bg-gray-500' }
];

// Computed
const calendarDays = computed(() => {
  const year = currentDate.value.getFullYear();
  const month = currentDate.value.getMonth();
  
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const daysInMonth = lastDay.getDate();
  const startingDayOfWeek = firstDay.getDay();
  
  const days = [];
  
  // Empty cells for days before the month starts
  for (let i = 0; i < startingDayOfWeek; i++) {
    days.push(null);
  }
  
  // Days of the month
  for (let day = 1; day <= daysInMonth; day++) {
    days.push(day);
  }
  
  return days;
});

// Methods
const formatMonthYear = (date: Date): string => {
  return date.toLocaleDateString('id-ID', { 
    month: 'long', 
    year: 'numeric' 
  });
};

const formatSelectedDate = (date: Date): string => {
  return date.toLocaleDateString('id-ID', { 
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

const formatTime = (time: string): string => {
  return new Date(`2000-01-01T${time}`).toLocaleTimeString('id-ID', {
    hour: '2-digit',
    minute: '2-digit'
  });
};

const isToday = (day: number | null): boolean => {
  if (day === null) return false;
  const today = new Date();
  return (
    day === today.getDate() &&
    currentDate.value.getMonth() === today.getMonth() &&
    currentDate.value.getFullYear() === today.getFullYear()
  );
};

const isSelected = (day: number | null): boolean => {
  if (day === null || !selectedDate.value) return false;
  return (
    day === selectedDate.value.getDate() &&
    currentDate.value.getMonth() === selectedDate.value.getMonth() &&
    currentDate.value.getFullYear() === selectedDate.value.getFullYear()
  );
};

const selectDate = (day: number | null) => {
  if (day === null) return;
  selectedDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth(), day);
};

const previousMonth = () => {
  currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() - 1);
};

const nextMonth = () => {
  currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() + 1);
};

const getActivitiesForDay = (day: number): Kegiatan[] => {
  const date = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth(), day);
  const dateString = date.toISOString().split('T')[0];
  return kegiatan.value.filter(activity => activity.date === dateString);
};

const getActivitiesForSelectedDate = (): Kegiatan[] => {
  if (!selectedDate.value) return [];
  const dateString = selectedDate.value.toISOString().split('T')[0];
  return kegiatan.value.filter(activity => activity.date === dateString);
};

const getActivityColor = (type: string): string => {
  const colorMap: Record<string, string> = {
    'sidang': 'bg-blue-500',
    'rapat': 'bg-green-500',
    'kunjungan': 'bg-orange-500',
    'acara': 'bg-purple-500',
    'lainnya': 'bg-gray-500'
  };
  return colorMap[type] || 'bg-gray-500';
};

const getStatusClasses = (status: string): string => {
  const statusMap: Record<string, string> = {
    'terjadwal': 'text-primary bg-primary/10 border border-primary/20',
    'berlangsung': 'text-yellow-600 bg-yellow-100 border border-yellow-200',
    'selesai': 'text-green-600 bg-green-100 border border-green-200',
    'dibatalkan': 'text-red-600 bg-red-100 border border-red-200'
  };
  return statusMap[status] || 'text-gray-600 bg-gray-100 border border-gray-200';
};

// Sample data
const loadKegiatan = () => {
  kegiatan.value = [
    {
      id: 1,
      title: "Sidang Paripurna DPRD",
      description: "Sidang paripurna untuk membahas RAPBD 2024",
      type: "sidang",
      status: "terjadwal",
      start_time: "09:00",
      end_time: "12:00",
      location: "Gedung DPRD Sulawesi Barat",
      participants: 45,
      date: "2024-01-15"
    },
    {
      id: 2,
      title: "Rapat Komisi A",
      description: "Rapat komisi untuk membahas program pendidikan",
      type: "rapat",
      status: "berlangsung",
      start_time: "14:00",
      end_time: "16:00",
      location: "Ruang Komisi A",
      participants: 12,
      date: "2024-01-15"
    },
    {
      id: 3,
      title: "Kunjungan ke Desa Pasangkayu",
      description: "Kunjungan kerja ke desa untuk melihat kondisi infrastruktur",
      type: "kunjungan",
      status: "terjadwal",
      start_time: "08:00",
      end_time: "17:00",
      location: "Desa Pasangkayu",
      participants: 8,
      date: "2024-01-16"
    },
    {
      id: 4,
      title: "Acara Sosialisasi Program",
      description: "Sosialisasi program bantuan UMKM kepada masyarakat",
      type: "acara",
      status: "selesai",
      start_time: "19:00",
      end_time: "21:00",
      location: "Aula Kecamatan",
      participants: 150,
      date: "2024-01-14"
    },
    {
      id: 5,
      title: "Rapat Koordinasi",
      description: "Rapat koordinasi dengan dinas terkait",
      type: "rapat",
      status: "terjadwal",
      start_time: "10:00",
      end_time: "11:30",
      location: "Kantor Gubernur",
      participants: 20,
      date: "2024-01-17"
    }
  ];
};

// Lifecycle
onMounted(() => {
  loadKegiatan();
});
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
