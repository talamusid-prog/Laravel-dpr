<template>
  <div class="relative">
    <button
      @click="toggleShareMenu"
      class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90 transition-all duration-300 shadow-lg hover:shadow-xl"
      :class="{ 'bg-primary/90 shadow-xl': isOpen }"
    >
      <Share2 class="w-4 h-4" />
      {{ buttonText }}
    </button>

    <!-- Share Menu Dropdown -->
    <Transition
      enter-active-class="transition-all duration-200 ease-out"
      enter-from-class="opacity-0 scale-95 translate-y-1"
      enter-to-class="opacity-100 scale-100 translate-y-0"
      leave-active-class="transition-all duration-150 ease-in"
      leave-from-class="opacity-100 scale-100 translate-y-0"
      leave-to-class="opacity-0 scale-95 translate-y-1"
    >
      <div
        v-if="isOpen"
        class="absolute top-full right-0 mt-2 w-64 bg-white border-2 border-primary/20 rounded-xl shadow-2xl z-[9999]"
        @click.stop
        style="position: fixed; transform: translateX(-100%);"
      >
        <div class="p-4 bg-gradient-to-br from-white to-gray-50">
          <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
            <Share2 class="w-4 h-4 text-primary" />
            Bagikan artikel ini
          </h3>
          
          <!-- Share Options -->
          <div class="space-y-2">
            <!-- WhatsApp -->
            <button
              @click="shareToWhatsApp"
              class="w-full flex items-center gap-3 p-2 text-left hover:bg-green-50 rounded-md transition-colors"
            >
              <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <MessageCircle class="w-4 h-4 text-white" />
              </div>
              <span class="text-sm text-gray-700">WhatsApp</span>
            </button>

            <!-- Facebook -->
            <button
              @click="shareToFacebook"
              class="w-full flex items-center gap-3 p-2 text-left hover:bg-blue-50 rounded-md transition-colors"
            >
              <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                <Facebook class="w-4 h-4 text-white" />
              </div>
              <span class="text-sm text-gray-700">Facebook</span>
            </button>

            <!-- Twitter -->
            <button
              @click="shareToTwitter"
              class="w-full flex items-center gap-3 p-2 text-left hover:bg-blue-50 rounded-md transition-colors"
            >
              <div class="w-8 h-8 bg-blue-400 rounded-full flex items-center justify-center">
                <Twitter class="w-4 h-4 text-white" />
              </div>
              <span class="text-sm text-gray-700">Twitter</span>
            </button>

            <!-- LinkedIn -->
            <button
              @click="shareToLinkedIn"
              class="w-full flex items-center gap-3 p-2 text-left hover:bg-blue-50 rounded-md transition-colors"
            >
              <div class="w-8 h-8 bg-blue-700 rounded-full flex items-center justify-center">
                <Linkedin class="w-4 h-4 text-white" />
              </div>
              <span class="text-sm text-gray-700">LinkedIn</span>
            </button>

            <!-- Copy Link -->
            <button
              @click="copyLink"
              class="w-full flex items-center gap-3 p-2 text-left hover:bg-gray-50 rounded-md transition-colors"
            >
              <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                <Copy class="w-4 h-4 text-white" />
              </div>
              <span class="text-sm text-gray-700">Salin Link</span>
            </button>
          </div>

          <!-- Copy Success Message -->
          <div
            v-if="copySuccess"
            class="mt-3 p-2 bg-green-100 text-green-800 text-xs rounded-md text-center"
          >
            Link berhasil disalin!
          </div>
        </div>
      </div>
    </Transition>

    <!-- Backdrop -->
    <div
      v-if="isOpen"
      @click="closeShareMenu"
      class="fixed inset-0 z-[9998]"
    ></div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { 
  Share2, 
  MessageCircle, 
  Facebook, 
  Twitter, 
  Linkedin, 
  Copy 
} from 'lucide-vue-next';

interface Props {
  title?: string;
  url?: string;
  description?: string;
  buttonText?: string;
}

const props = withDefaults(defineProps<Props>(), {
  title: '',
  url: '',
  description: '',
  buttonText: 'Bagikan'
});

const isOpen = ref(false);
const copySuccess = ref(false);

const toggleShareMenu = () => {
  isOpen.value = !isOpen.value;
};

const closeShareMenu = () => {
  isOpen.value = false;
};

const getShareUrl = () => {
  return props.url || window.location.href;
};

const getShareTitle = () => {
  return props.title || document.title;
};

const getShareText = () => {
  return props.description || props.title || document.title;
};

const shareToWhatsApp = () => {
  const url = `https://wa.me/?text=${encodeURIComponent(getShareTitle() + ' - ' + getShareUrl())}`;
  window.open(url, '_blank');
  closeShareMenu();
};

const shareToFacebook = () => {
  const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(getShareUrl())}`;
  window.open(url, '_blank');
  closeShareMenu();
};

const shareToTwitter = () => {
  const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(getShareText())}&url=${encodeURIComponent(getShareUrl())}`;
  window.open(url, '_blank');
  closeShareMenu();
};

const shareToLinkedIn = () => {
  const url = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(getShareUrl())}`;
  window.open(url, '_blank');
  closeShareMenu();
};

const copyLink = async () => {
  try {
    await navigator.clipboard.writeText(getShareUrl());
    copySuccess.value = true;
    setTimeout(() => {
      copySuccess.value = false;
    }, 2000);
    closeShareMenu();
  } catch (err) {
    console.error('Failed to copy link:', err);
    // Fallback for older browsers
    const textArea = document.createElement('textarea');
    textArea.value = getShareUrl();
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand('copy');
    document.body.removeChild(textArea);
    copySuccess.value = true;
    setTimeout(() => {
      copySuccess.value = false;
    }, 2000);
    closeShareMenu();
  }
};
</script>
