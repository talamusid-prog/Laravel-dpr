<template>
  <AdminLayout>
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
      <!-- Header Section -->
      <div class="flex items-center justify-between mb-8">
        <!-- Left Side -->
        <div class="flex items-center gap-4">
          <button 
            @click="navigateToAdmin"
            class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
          >
            <ArrowLeft class="w-4 h-4 text-gray-600" />
          </button>
          
          <div>
            <h1 class="text-3xl font-bold text-black">
              Buat Artikel Baru
            </h1>
            <p class="text-muted-foreground">
              Tulis artikel menarik dengan editor yang mudah digunakan
            </p>
          </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center gap-3">
          <!-- Preview Toggle -->
          <button 
            @click="togglePreview"
            class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
          >
            <Eye v-if="!previewMode" class="w-4 h-4 text-gray-600" />
            <EyeOff v-else class="w-4 h-4 text-gray-600" />
          </button>

          <!-- Save Button -->
          <button 
            @click="saveArticle"
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
          <!-- Title Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Judul Artikel
              </label>
              <input
                v-model="formData.title"
                type="text"
                placeholder="Masukkan judul artikel..."
                class="w-full text-xl font-semibold border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              />
            </div>
          </div>

          <!-- Excerpt Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Ringkasan Artikel
              </label>
              <textarea
                v-model="formData.excerpt"
                placeholder="Tulis ringkasan singkat artikel..."
                rows="3"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              ></textarea>
            </div>
          </div>

          <!-- Content Editor Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                  {{ previewMode ? 'Preview Artikel' : 'Konten Artikel' }}
                </h3>
              </div>

              <!-- Preview Mode -->
              <div v-if="previewMode" class="prose prose-lg max-w-none">
                <div class="leading-loose text-gray-800" v-html="formatContentWithHeadings(formData.content)"></div>
              </div>

              <!-- Editor Mode -->
              <div v-else>
                <div id="editor"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar Section (Right Column) -->
        <div class="lg:col-span-1 space-y-6">
          <!-- Featured Image Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Gambar Utama</h3>
              
              <!-- With Image -->
              <div v-if="formData.featured_image" class="space-y-4">
                <div class="aspect-video rounded-lg overflow-hidden border">
                  <img 
                    :src="formData.featured_image" 
                    :alt="formData.image_alt"
                    class="w-full h-full object-cover"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Alt Text (Deskripsi Gambar)
                  </label>
                  <input
                    v-model="formData.image_alt"
                    type="text"
                    placeholder="Masukkan deskripsi gambar untuk aksesibilitas..."
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                  />
                  <p class="text-xs text-gray-500 mt-1">
                    Alt text membantu pengguna dengan screen reader dan SEO
                  </p>
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

          <!-- Tags Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags</h3>
              
              <!-- Tag Input -->
              <div class="relative mb-4">
                <input
                  v-model="newTag"
                  @keyup.enter="addTag"
                  type="text"
                  placeholder="Tambah tag..."
                  class="w-full border border-gray-300 rounded-md px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                />
                <button 
                  @click="addTag"
                  class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex items-center justify-center w-6 h-6 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors"
                >
                  <Plus class="w-4 h-4" />
                </button>
              </div>

              <!-- Tag Display -->
              <div class="flex flex-wrap gap-2">
                <span 
                  v-for="(tag, index) in formData.tags"
                  :key="index"
                  class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs sm:text-sm"
                >
                  <span class="truncate max-w-20 sm:max-w-32">{{ tag }}</span>
                  <button 
                    @click="removeTag(index)"
                    class="hover:text-red-600 transition-colors flex-shrink-0"
                  >
                    <X class="w-3 h-3" />
                  </button>
                </span>
              </div>
            </div>
          </div>

          <!-- Publish Settings Card -->
          <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Publikasi</h3>
              
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                  </label>
                  <select
                    v-model="formData.status"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                  >
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                  </select>
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
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import { ArrowLeft, Eye, EyeOff, Save, X, Upload, Plus } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
// @ts-expect-error - CKEditor types not available
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

// Types
interface FormData {
  title: string;
  excerpt: string;
  content: string;
  featured_image: string | null;
  image_alt: string;
  tags: string[];
  status: 'draft' | 'published';
}

// State
const formData = ref<FormData>({
  title: '',
  excerpt: '',
  content: '',
  featured_image: null,
  image_alt: '',
  tags: [],
  status: 'draft'
});

const newTag = ref('');
const isUploading = ref(false);
const previewMode = ref(false);
const isSaving = ref(false);
const editor = ref<any>(null);
const fileInput = ref<HTMLInputElement | null>(null);

// Methods
const navigateToAdmin = () => {
  router.visit('/admin');
};

const togglePreview = () => {
  previewMode.value = !previewMode.value;
};

const handleFileUpload = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (!file) return;

  isUploading.value = true;
  
  const reader = new FileReader();
  reader.onload = (e) => {
    formData.value.featured_image = e.target?.result as string;
    isUploading.value = false;
  };
  reader.onerror = () => {
    console.error('Error reading file');
    isUploading.value = false;
  };
  reader.readAsDataURL(file);
};

const removeImage = () => {
  formData.value.featured_image = null;
  formData.value.image_alt = '';
};

const addTag = () => {
  const tag = newTag.value.trim();
  if (tag && !formData.value.tags.includes(tag)) {
    formData.value.tags.push(tag);
    newTag.value = '';
  }
};

const removeTag = (index: number) => {
  formData.value.tags.splice(index, 1);
};

const formatContentWithHeadings = (content: string): string => {
  if (!content) return '';
  
  // Check if content already contains HTML tags
  const hasHtmlTags = /<[^>]+>/.test(content);
  
  if (hasHtmlTags) {
    // Content already has HTML, apply styling classes
    return content
      .replace(/<h1([^>]*)>/g, '<h1$1 class="text-3xl font-bold text-gray-900 mb-6">')
      .replace(/<h2([^>]*)>/g, '<h2$1 class="text-2xl font-bold text-gray-900 mb-4">')
      .replace(/<h3([^>]*)>/g, '<h3$1 class="text-xl font-bold text-gray-900 mb-3">')
      .replace(/<p([^>]*)>/g, '<p$1 class="text-gray-700 leading-relaxed mb-4">')
      .replace(/<ul([^>]*)>/g, '<ul$1 class="list-disc list-inside mb-4 space-y-2">')
      .replace(/<ol([^>]*)>/g, '<ol$1 class="list-decimal list-inside mb-4 space-y-2">')
      .replace(/<li([^>]*)>/g, '<li$1 class="text-gray-700">')
      .replace(/<blockquote([^>]*)>/g, '<blockquote$1 class="border-l-4 border-primary pl-4 italic text-gray-600 mb-4">')
      .replace(/<a([^>]*)>/g, '<a$1 class="text-primary hover:text-primary/80 underline">')
      .replace(/<strong([^>]*)>/g, '<strong$1 class="font-bold">')
      .replace(/<table([^>]*)>/g, '<table$1 class="w-full border-collapse border border-gray-300 mb-4">')
      .replace(/<th([^>]*)>/g, '<th$1 class="border border-gray-300 px-4 py-2 bg-gray-100 font-bold">')
      .replace(/<td([^>]*)>/g, '<td$1 class="border border-gray-300 px-4 py-2">');
  }
  
  // Convert markdown-style headings
  let formatted = content
    .replace(/^### (.*$)/gim, '<h3 class="text-lg font-bold text-gray-900 mb-3">$1</h3>')
    .replace(/^## (.*$)/gim, '<h2 class="text-xl font-bold text-gray-900 mb-4">$1</h2>')
    .replace(/^# (.*$)/gim, '<h1 class="text-2xl font-bold text-gray-900 mb-6">$1</h1>');
  
  // Convert numbered lists
  formatted = formatted.replace(/^(\d+)\. (.*$)/gim, '<li class="mb-1"><strong>$1.</strong> $2</li>');
  
  // Convert bullet lists
  formatted = formatted.replace(/^[-*•] (.*$)/gim, '<li class="mb-1">• <strong>$1</strong></li>');
  
  // Wrap in paragraphs
  const paragraphs = formatted.split('\n\n');
  formatted = paragraphs.map(p => {
    if (p.trim().startsWith('<h') || p.trim().startsWith('<li')) {
      return p;
    }
    return `<p class="mb-6">${p.trim()}</p>`;
  }).join('');
  
  return formatted;
};

const saveArticle = async () => {
  // Validation
  if (!formData.value.title.trim()) {
    await Swal.fire({
      title: 'Validasi Gagal',
      text: 'Judul artikel harus diisi',
      icon: 'error',
      confirmButtonColor: '#ef4444'
    });
    return;
  }
  
  if (!formData.value.content.trim()) {
    await Swal.fire({
      title: 'Validasi Gagal',
      text: 'Konten artikel harus diisi',
      icon: 'error',
      confirmButtonColor: '#ef4444'
    });
    return;
  }

  isSaving.value = true;
  
  try {
    // Prepare form data
    const baseData = {
      title: formData.value.title,
      excerpt: formData.value.excerpt,
      content: formData.value.content,
      tags: formData.value.tags,
      status: formData.value.status,
      image_alt: formData.value.image_alt
    };

    if (formData.value.featured_image) {
      // Has image, use FormData for file upload
      const formDataToSend = new FormData();
      
      // Append all text fields
      formDataToSend.append('title', formData.value.title);
      formDataToSend.append('excerpt', formData.value.excerpt);
      formDataToSend.append('content', formData.value.content);
      formDataToSend.append('status', formData.value.status);
      formDataToSend.append('image_alt', formData.value.image_alt);
      
      // Append tags individually
      formData.value.tags.forEach((tag, index) => {
        formDataToSend.append(`tags[${index}]`, tag);
      });
      
      // Convert base64 to file
      const response = await fetch(formData.value.featured_image);
      const blob = await response.blob();
      const file = new File([blob], 'featured_image.jpg', { type: 'image/jpeg' });
      formDataToSend.append('featured_image', file);

      // Submit with file using Inertia.js
      router.post('/admin/articles', formDataToSend, {
        forceFormData: true,
        onSuccess: async () => {
          await Swal.fire({
            title: 'Berhasil!',
            text: 'Artikel berhasil dibuat!',
            icon: 'success',
            confirmButtonColor: '#ef4444'
          });
          router.visit('/admin/articles');
        },
        onError: async (errors) => {
          console.error('Server error:', errors);
          await Swal.fire({
            title: 'Gagal!',
            text: 'Gagal membuat artikel: ' + (Object.values(errors).flat().join(', ')),
            icon: 'error',
            confirmButtonColor: '#ef4444'
          });
        }
      });
    } else {
      // No image, submit regular data
      router.post('/admin/articles', baseData, {
        onSuccess: async () => {
          await Swal.fire({
            title: 'Berhasil!',
            text: 'Artikel berhasil dibuat!',
            icon: 'success',
            confirmButtonColor: '#ef4444'
          });
          router.visit('/admin/articles');
        },
        onError: async (errors) => {
          console.error('Server error:', errors);
          await Swal.fire({
            title: 'Gagal!',
            text: 'Gagal membuat artikel: ' + (Object.values(errors).flat().join(', ')),
            icon: 'error',
            confirmButtonColor: '#ef4444'
          });
        }
      });
    }
  } catch (error) {
    console.error('Error creating article:', error);
    await Swal.fire({
      title: 'Gagal!',
      text: 'Gagal membuat artikel',
      icon: 'error',
      confirmButtonColor: '#ef4444'
    });
  } finally {
    isSaving.value = false;
  }
};


// Initialize CKEditor
const initEditor = async () => {
  try {
    // Destroy existing editor if any
    if (editor.value) {
      editor.value.destroy();
      editor.value = null;
    }

    await nextTick();
    
    const editorElement = document.getElementById('editor');
    if (!editorElement) {
      console.error('Editor element not found');
      return;
    }

    // Clear editor content
    editorElement.innerHTML = '';

    // Wait a bit more for DOM to be ready
    await new Promise(resolve => setTimeout(resolve, 100));

    editor.value = await ClassicEditor.create(editorElement, {
      toolbar: {
        items: [
          'heading', '|',
          'bold', 'italic', 'underline', '|',
          'bulletedList', 'numberedList', '|',
          'outdent', 'indent', '|',
          'blockQuote', '|',
          'link', '|',
          'insertTable', '|',
          'undo', 'redo'
        ]
      },
      table: {
        contentToolbar: [
          'tableColumn', 'tableRow', 'mergeTableCells'
        ]
      },
      language: 'id',
      placeholder: 'Tulis konten artikel Anda di sini...',
      heading: {
        options: [
          { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
          { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
          { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
          { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
        ]
      }
    });

    // Set initial data after a short delay
    setTimeout(() => {
      if (editor.value) {
        editor.value.setData(formData.value.content);
      }
    }, 200);

    // Listen for data changes
    editor.value.model.document.on('change:data', () => {
      formData.value.content = editor.value.getData();
    });

  } catch (error) {
    console.error('Error initializing CKEditor:', error);
  }
};

// Lifecycle
onMounted(async () => {
  await nextTick();
  await initEditor();
});

onUnmounted(() => {
  if (editor.value) {
    editor.value.destroy();
  }
});
</script>

<style scoped>
/* Custom list styling */
.prose ul {
  margin-bottom: 0.75rem;
  padding-left: 1.5rem;
}

.prose ol {
  margin-bottom: 0.75rem;
  padding-left: 1.5rem;
}

.prose li {
  margin-bottom: 0.25rem;
}

/* CKEditor custom styles */
:deep(.ck-editor__editable) {
  min-height: 300px;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  padding: 1rem;
}

:deep(.ck-editor__editable h1) {
  font-size: 2rem;
  font-weight: bold;
  color: #1f2937;
  margin-bottom: 1.5rem;
  line-height: 1.2;
}

:deep(.ck-editor__editable h2) {
  font-size: 1.5rem;
  font-weight: bold;
  color: #1f2937;
  margin-bottom: 1rem;
  line-height: 1.3;
}

:deep(.ck-editor__editable h3) {
  font-size: 1.25rem;
  font-weight: bold;
  color: #1f2937;
  margin-bottom: 0.75rem;
  line-height: 1.4;
}

:deep(.ck-editor__editable p) {
  color: #374151;
  line-height: 1.7;
  margin-bottom: 1rem;
}

:deep(.ck-editor__editable ul) {
  list-style-type: disc;
  padding-left: 1.5rem;
  margin-bottom: 1rem;
}

:deep(.ck-editor__editable ol) {
  list-style-type: decimal;
  padding-left: 1.5rem;
  margin-bottom: 1rem;
}

:deep(.ck-editor__editable li) {
  margin-bottom: 0.25rem;
  color: #374151;
}

:deep(.ck-editor__editable blockquote) {
  border-left: 4px solid #3b82f6;
  padding-left: 1rem;
  font-style: italic;
  color: #6b7280;
  margin-bottom: 1rem;
}

:deep(.ck-editor__editable a) {
  color: #3b82f6;
  text-decoration: underline;
}

:deep(.ck-editor__editable a:hover) {
  color: #2563eb;
}

:deep(.ck-editor__editable table) {
  width: 100%;
  border-collapse: collapse;
  border: 1px solid #d1d5db;
  margin-bottom: 1rem;
}

:deep(.ck-editor__editable th) {
  border: 1px solid #d1d5db;
  padding: 0.5rem;
  background-color: #f9fafb;
  font-weight: bold;
}

:deep(.ck-editor__editable td) {
  border: 1px solid #d1d5db;
  padding: 0.5rem;
}
</style>