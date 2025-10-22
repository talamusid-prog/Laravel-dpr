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
              {{ isEdit ? 'Edit Artikel' : 'Buat Artikel Baru' }}
            </h1>
            <p class="text-muted-foreground">
              {{ isEdit ? 'Edit artikel yang sudah ada' : 'Tulis artikel menarik dengan editor yang mudah digunakan' }}
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
import { ref, onMounted, onUnmounted, nextTick, markRaw } from 'vue';
import { ArrowLeft, Eye, EyeOff, Save, X, Upload, Plus } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
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
  imageFile?: File;
}

// Props
const props = defineProps<{
  article?: any;
}>();

// State
const isEdit = ref(!!props.article);
const editor = ref<any>(null);


const formData = ref<FormData>({
  title: props.article?.title || '',
  excerpt: props.article?.excerpt || '',
  content: props.article?.content || '',
  featured_image: props.article?.featured_image ? `/storage/${props.article.featured_image}` : null,
  image_alt: props.article?.image_alt || '',
  tags: props.article?.tags || [],
  status: props.article?.status || 'draft'
});


const newTag = ref('');
const isUploading = ref(false);
const previewMode = ref(false);
const isSaving = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);

// Methods
const navigateToAdmin = () => {
  router.visit('/admin');
};

const togglePreview = () => {
  previewMode.value = !previewMode.value;
};

const handleFileUpload = async (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (!file) return;

  isUploading.value = true;
  
  try {
    // Create object URL for immediate preview
    const objectUrl = URL.createObjectURL(file);
    formData.value.featured_image = objectUrl;
    
    // Store the file for upload
    formData.value.imageFile = file;
    
    console.log('File selected:', file.name, 'Size:', file.size);
    
  } catch (error) {
    console.error('File upload error:', error);
    alert('Gagal memproses file');
  } finally {
    isUploading.value = false;
  }
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
  
  // Convert markdown-style headings
  let formatted = content
    .replace(/^### (.*$)/gim, '<h3 class="text-lg font-bold text-secondary mb-3">$1</h3>')
    .replace(/^## (.*$)/gim, '<h2 class="text-xl font-bold text-secondary mb-4">$1</h2>')
    .replace(/^# (.*$)/gim, '<h1 class="text-2xl font-bold text-secondary mb-6">$1</h1>');
  
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
  // Get latest content from editor before validation
  if (editor.value) {
    formData.value.content = editor.value.getData();
  }
  
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
  
  // Check if content is empty or only contains whitespace/HTML tags
  const contentText = formData.value.content.replace(/<[^>]*>/g, '').trim();
  if (!contentText) {
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
    // Prepare base data
    const baseData = {
      title: formData.value.title,
      excerpt: formData.value.excerpt,
      content: formData.value.content,
      image_alt: formData.value.image_alt,
      tags: formData.value.tags,
      status: formData.value.status
    };

    // Debug: Log data being sent
    console.log('Data being sent:', baseData);
    console.log('Has image file:', !!formData.value.imageFile);

    // Handle image upload if there's a new image
    if (formData.value.imageFile) {
      // Create FormData manually to ensure proper encoding
      const formDataToSend = new FormData();
      
      // Add all text fields
      formDataToSend.append('title', baseData.title);
      formDataToSend.append('excerpt', baseData.excerpt);
      formDataToSend.append('content', baseData.content);
      formDataToSend.append('image_alt', baseData.image_alt);
      
      // Handle tags array - append each tag individually
      if (baseData.tags && baseData.tags.length > 0) {
        baseData.tags.forEach((tag, index) => {
          formDataToSend.append(`tags[${index}]`, tag);
        });
      }
      
      formDataToSend.append('status', baseData.status);
      
      // Add the file
      formDataToSend.append('featured_image', formData.value.imageFile);

      console.log('Submitting with FormData:');
      console.log('Title:', formDataToSend.get('title'));
      console.log('Content:', formDataToSend.get('content'));
      console.log('Status:', formDataToSend.get('status'));
      console.log('File:', formDataToSend.get('featured_image'));

      // Submit with file using Inertia.js
      // Add _method field for Laravel to recognize as PUT
      formDataToSend.append('_method', 'PUT');
      
      router.post(`/admin/articles/${props.article?.id}`, formDataToSend, {
        forceFormData: true,
        onSuccess: async () => {
          await Swal.fire({
            title: 'Berhasil!',
            text: 'Artikel berhasil disimpan!',
            icon: 'success',
            confirmButtonColor: '#ef4444'
          });
          router.visit('/admin/articles');
        },
        onError: async (errors) => {
          console.error('Server error:', errors);
          await Swal.fire({
            title: 'Gagal!',
            text: 'Gagal menyimpan artikel: ' + (Object.values(errors).flat().join(', ')),
            icon: 'error',
            confirmButtonColor: '#ef4444'
          });
        }
      });
    } else {
      // No new image, submit regular data
      console.log('Submitting without file:', baseData);
      
      router.put(`/admin/articles/${props.article?.id}`, baseData, {
        onSuccess: async () => {
          await Swal.fire({
            title: 'Berhasil!',
            text: 'Artikel berhasil disimpan!',
            icon: 'success',
            confirmButtonColor: '#ef4444'
          });
          router.visit('/admin/articles');
        },
        onError: async (errors) => {
          console.error('Server error:', errors);
          await Swal.fire({
            title: 'Gagal!',
            text: 'Gagal menyimpan artikel: ' + (Object.values(errors).flat().join(', ')),
            icon: 'error',
            confirmButtonColor: '#ef4444'
          });
        }
      });
    }
  } catch (error) {
    console.error('Error saving article:', error);
    await Swal.fire({
      title: 'Gagal!',
      text: 'Gagal menyimpan artikel',
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

    // Wait for DOM to be ready
    await nextTick();
    
    const editorElement = document.getElementById('editor');
    if (!editorElement) {
      throw new Error('Editor element not found');
    }
    
    // Clear any existing content
    editorElement.innerHTML = '';
    
    const editorInstance = markRaw(await ClassicEditor.create(editorElement, {
      toolbar: {
        items: [
          'heading',
          '|',
          'bold',
          'italic',
          'underline',
          '|',
          'bulletedList',
          'numberedList',
          '|',
          'outdent',
          'indent',
          '|',
          'blockQuote',
          'insertTable',
          '|',
          'link',
          '|',
          'undo',
          'redo'
        ],
        shouldNotGroupWhenFull: true
      },
      heading: {
        options: [
          { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
          { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
          { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
          { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
        ]
      },
      table: {
        contentToolbar: [
          'tableColumn',
          'tableRow',
          'mergeTableCells'
        ]
      },
      language: 'id',
      placeholder: 'Tulis konten artikel di sini...'
    }));

    // Mark the editor instance as raw to avoid Vue proxy conflicts
    editor.value = markRaw(editorInstance);

    // Set data after editor is ready
    setTimeout(() => {
      if (editor.value && formData.value.content) {
        editor.value.setData(formData.value.content);
      }
    }, 100);

    // Set up event listeners
    editor.value.model.document.on('change:data', () => {
      if (editor.value) {
        formData.value.content = editor.value.getData();
      }
    });

    console.log('CKEditor initialized successfully');

  } catch (error) {
    console.error('Error initializing CKEditor:', error);
  }
};

// Lifecycle
onMounted(async () => {
  await nextTick();
  
  // Wait a bit to ensure DOM is ready and data is loaded
  setTimeout(async () => {
    await initEditor();
  }, 200);
});

onUnmounted(() => {
  if (editor.value) {
    try {
      editor.value.destroy();
    } catch (error) {
      console.error('Error destroying editor:', error);
    }
    editor.value = null;
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
  min-height: 400px;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  padding: 1rem;
  font-size: 1rem;
  line-height: 1.6;
}

:deep(.ck-editor__editable:focus) {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

:deep(.ck-editor__editable h1) {
  font-size: 1.875rem;
  font-weight: 700;
  color: #111827;
  margin-bottom: 1rem;
  margin-top: 1.5rem;
  line-height: 1.2;
}

:deep(.ck-editor__editable h2) {
  font-size: 1.5rem;
  font-weight: 600;
  color: #111827;
  margin-bottom: 0.75rem;
  margin-top: 1.25rem;
  line-height: 1.3;
}

:deep(.ck-editor__editable h3) {
  font-size: 1.25rem;
  font-weight: 600;
  color: #111827;
  margin-bottom: 0.5rem;
  margin-top: 1rem;
  line-height: 1.4;
}

:deep(.ck-editor__editable p) {
  margin-bottom: 1rem;
  color: #374151;
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
  margin-bottom: 0.5rem;
}

:deep(.ck-editor__editable li strong) {
  font-weight: 600;
  color: #111827;
}

:deep(.ck-editor__editable blockquote) {
  border-left: 4px solid #3b82f6;
  padding-left: 1rem;
  margin: 1rem 0;
  font-style: italic;
  color: #6b7280;
}

:deep(.ck-editor__editable a) {
  color: #3b82f6;
  text-decoration: underline;
}

:deep(.ck-editor__editable a:hover) {
  color: #1d4ed8;
}

:deep(.ck-editor__editable table) {
  border-collapse: collapse;
  width: 100%;
  margin: 1rem 0;
}

:deep(.ck-editor__editable th),
:deep(.ck-editor__editable td) {
  border: 1px solid #d1d5db;
  padding: 0.5rem;
  text-align: left;
}

:deep(.ck-editor__editable th) {
  background-color: #f9fafb;
  font-weight: 600;
}
</style>
