<template>
  <AdminLayout>
    <!-- Main Content -->
    <div class="max-w-6xl mx-auto p-6 space-y-6">
      <!-- Header Section -->
      <div class="text-center mb-8">
        <div class="flex items-center justify-center mb-4">
          <Palette class="w-8 h-8 text-primary mr-3" />
          <h1 class="text-3xl font-bold text-gray-900">Pengaturan Warna</h1>
        </div>
        <p class="text-gray-600">
          Kustomisasi warna aplikasi sesuai dengan preferensi Anda
        </p>
      </div>

      <!-- Tab Navigation -->
      <div class="grid w-full grid-cols-3">
        <button
          v-for="tab in tabs"
          :key="tab.value"
          @click="activeTab = tab.value"
          :class="[
            'px-4 py-2 text-sm font-medium rounded-t-lg border-b-2 transition-colors',
            activeTab === tab.value
              ? 'border-primary text-primary bg-primary/5'
              : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
          ]"
        >
          {{ tab.label }}
        </button>
      </div>

      <!-- Tab Content -->
      <div class="bg-white rounded-lg shadow-lg">
        <!-- Tab 1: Kustomisasi -->
        <div v-if="activeTab === 'customize'" class="p-6 space-y-6">
          <!-- Preview & Kontrol Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <div class="flex items-center gap-3 mb-4">
                <Eye class="w-5 h-5 text-primary" />
                <div>
                  <h3 class="text-lg font-semibold text-gray-900">Preview & Kontrol</h3>
                  <p class="text-sm text-gray-600">Aktifkan preview untuk melihat perubahan secara real-time</p>
                </div>
              </div>
              
              <div class="space-y-4">
                <!-- Preview Mode Switch -->
                <div class="flex items-center justify-between">
                  <div>
                    <label class="text-sm font-medium text-gray-900">Mode Preview</label>
                    <p class="text-xs text-gray-500">Tampilkan perubahan warna secara langsung</p>
                  </div>
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input
                      id="preview-mode"
                      v-model="previewMode"
                      type="checkbox"
                      class="sr-only peer"
                    />
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                  </label>
                </div>

                <!-- Dark Mode Switch -->
                <div class="flex items-center justify-between">
                  <div>
                    <label class="text-sm font-medium text-gray-900">Mode Gelap</label>
                    <p class="text-xs text-gray-500">Aktifkan tema gelap untuk aplikasi</p>
                  </div>
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input
                      id="dark-mode"
                      v-model="isDarkMode"
                      @change="updateDarkMode"
                      type="checkbox"
                      class="sr-only peer"
                    />
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Warna Utama Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Warna Utama</h3>
                <p class="text-sm text-gray-600">Sesuaikan warna-warna utama yang digunakan di seluruh aplikasi</p>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <ColorInput
                  v-model="themeColors.primary"
                  label="Primary"
                  @update="updateColor('primary', $event)"
                />
                <ColorInput
                  v-model="themeColors.primaryDark"
                  label="Primary Dark"
                  @update="updateColor('primaryDark', $event)"
                />
                <ColorInput
                  v-model="themeColors.accent"
                  label="Accent"
                  @update="updateColor('accent', $event)"
                />
                <ColorInput
                  v-model="themeColors.accentDark"
                  label="Accent Dark"
                  @update="updateColor('accentDark', $event)"
                />
              </div>
            </div>
          </div>

          <!-- Warna Status Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Warna Status</h3>
                <p class="text-sm text-gray-600">Warna untuk indikator status dan notifikasi</p>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <ColorInput
                  v-model="themeColors.success"
                  label="Success"
                  @update="updateColor('success', $event)"
                />
                <ColorInput
                  v-model="themeColors.successDark"
                  label="Success Dark"
                  @update="updateColor('successDark', $event)"
                />
                <ColorInput
                  v-model="themeColors.warning"
                  label="Warning"
                  @update="updateColor('warning', $event)"
                />
                <ColorInput
                  v-model="themeColors.gold"
                  label="Gold"
                  @update="updateColor('gold', $event)"
                />
                <ColorInput
                  v-model="themeColors.goldLight"
                  label="Gold Light"
                  @update="updateColor('goldLight', $event)"
                />
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex justify-between">
            <button
              @click="handleResetTheme"
              class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
            >
              <RotateCcw class="w-4 h-4" />
              Reset
            </button>
            <button
                @click="handleSaveTheme"
              class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors"
            >
              <Save class="w-4 h-4" />
              Simpan Tema
            </button>
          </div>
        </div>

        <!-- Tab 2: Tema Siap Pakai -->
        <div v-if="activeTab === 'presets'" class="p-6">
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tema Siap Pakai</h3>
                <p class="text-sm text-gray-600">Pilih dari koleksi tema yang telah disiapkan</p>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div
                  v-for="preset in presetThemes"
                  :key="preset.name"
                  @click="applyPreset(preset)"
                  class="cursor-pointer hover:shadow-md transition-shadow border border-gray-200 rounded-lg p-4"
                >
                  <div class="flex items-center gap-2 mb-3">
                    <div class="flex gap-1">
                      <div
                        v-for="color in preset.colors"
                        :key="color"
                        class="w-6 h-6 rounded-full"
                        :style="{ backgroundColor: color }"
                      ></div>
                    </div>
                    <h4 class="font-semibold text-gray-900">{{ preset.name }}</h4>
                  </div>
                  <button class="w-full text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-3 rounded-md transition-colors">
                    Pilih Tema
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab 3: Import/Export -->
        <div v-if="activeTab === 'import-export'" class="p-6">
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Import & Export Tema</h3>
                <p class="text-sm text-gray-600">Simpan atau muat konfigurasi tema dari file</p>
              </div>
              
              <div class="space-y-4">
                <!-- Export Button -->
                <div class="flex flex-col sm:flex-row gap-4">
                  <button
                    @click="handleExportTheme"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors"
                  >
                    <Download class="w-4 h-4" />
                    Export Tema
                  </button>
                </div>

                <!-- Import Input -->
                <div>
                  <input
                    ref="importInput"
                    type="file"
                    accept=".json"
                    @change="handleImportTheme"
                    class="cursor-pointer block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary file:text-white hover:file:bg-primary/90"
                  />
                  <p class="text-xs text-gray-500 mt-2">
                    File tema akan disimpan dalam format JSON yang dapat dibagikan dengan pengguna lain.
                  </p>
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
import { ref, onMounted } from 'vue';
import { Palette, Eye, RotateCcw, Save, Download } from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useTheme } from '@/composables/useTheme';

// Color Input Component
const ColorInput = {
  props: {
    modelValue: String,
    label: String
  },
  emits: ['update:modelValue', 'update'],
  template: `
    <div class="space-y-2">
      <label class="text-sm font-medium text-gray-900">{{ label }}</label>
      <div class="flex items-center space-x-3">
        <input
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          type="color"
          class="w-12 h-12 rounded border border-gray-300 cursor-pointer"
        />
        <input
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          type="text"
          class="flex-1 text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
          placeholder="#000000"
        />
      </div>
      <p class="text-xs text-gray-500">Format HSL: hue saturation% lightness%</p>
    </div>
  `
};

// Use theme composable
const { themeColors, isDarkMode, applyTheme, loadTheme, saveTheme, defaultTheme } = useTheme();

// State
const activeTab = ref('customize');
const previewMode = ref(false);
const importInput = ref<HTMLInputElement | null>(null);

// Tabs
const tabs = [
  { label: 'Kustomisasi', value: 'customize' },
  { label: 'Tema Siap Pakai', value: 'presets' },
  { label: 'Import/Export', value: 'import-export' }
];

// Preset Themes
const presetThemes = [
  {
    name: 'Default (Merah)',
    colors: ['#dc2626', '#991b1b', '#f59e0b', '#d97706'],
    theme: {
      primary: '#dc2626',
      primaryDark: '#800000',
      accent: '#F1B62D',
      accentDark: '#CE8D0B'
    }
  },
  {
    name: 'Biru Profesional',
    colors: ['#3b82f6', '#1d4ed8', '#7dd3fc', '#0ea5e9'],
    theme: {
      primary: '#3b82f6',
      primaryDark: '#1d4ed8',
      accent: '#7dd3fc',
      accentDark: '#0ea5e9'
    }
  },
  {
    name: 'Hijau Alam',
    colors: ['#059669', '#047857', '#84cc16', '#65a30d'],
    theme: {
      primary: '#059669',
      primaryDark: '#047857',
      accent: '#84cc16',
      accentDark: '#65a30d'
    }
  },
  {
    name: 'Ungu Kreatif',
    colors: ['#7c3aed', '#5b21b6', '#a78bfa', '#8b5cf6'],
    theme: {
      primary: '#7c3aed',
      primaryDark: '#5b21b6',
      accent: '#a78bfa',
      accentDark: '#8b5cf6'
    }
  }
];

// Methods
const updateColor = (key: string, value: string) => {
  (themeColors as any)[key] = value;
  if (previewMode.value) {
    applyTheme();
  }
};

const updateDarkMode = () => {
  // Apply dark mode logic
  document.documentElement.classList.toggle('dark', isDarkMode.value);
};

// applyTheme is now provided by useTheme composable

const applyPreset = (preset: any) => {
  Object.assign(themeColors, preset.theme);
  if (previewMode.value) {
    applyTheme();
  }
};

const handleResetTheme = () => {
  // Reset to default theme
  Object.assign(themeColors, defaultTheme);
  if (previewMode.value) {
    applyTheme();
  }
};

const handleSaveTheme = () => {
  // Save theme to localStorage or API
  saveTheme();
  alert('Tema berhasil disimpan!');
};

const handleExportTheme = () => {
  const themeData = {
    colors: themeColors,
    darkMode: isDarkMode.value,
    exportedAt: new Date().toISOString()
  };
  
  const blob = new Blob([JSON.stringify(themeData, null, 2)], { type: 'application/json' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'theme-config.json';
  a.click();
  URL.revokeObjectURL(url);
};

const handleImportTheme = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = (e) => {
    try {
      const themeData = JSON.parse(e.target?.result as string);
      if (themeData.colors) {
        Object.assign(themeColors, themeData.colors);
      }
      if (themeData.darkMode !== undefined) {
        isDarkMode.value = themeData.darkMode;
        updateDarkMode();
      }
      if (previewMode.value) {
        applyTheme();
      }
      alert('Tema berhasil diimpor!');
    } catch (error) {
      console.error('Error importing theme:', error);
      alert('Gagal mengimpor tema. Pastikan file format JSON yang valid.');
    }
  };
  reader.readAsText(file);
};

// Lifecycle
onMounted(() => {
  // Load saved theme
  loadTheme();
});
</script>

<style scoped>
/* Custom styles for color inputs */
input[type="color"] {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background: none;
  border: none;
  cursor: pointer;
}

input[type="color"]::-webkit-color-swatch-wrapper {
  padding: 0;
}

input[type="color"]::-webkit-color-swatch {
  border: none;
  border-radius: 4px;
}

input[type="color"]::-moz-color-swatch {
  border: none;
  border-radius: 4px;
}
</style>
