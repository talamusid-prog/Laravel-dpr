<template>
  <button
    v-show="isVisible"
    @click="scrollToTop"
    class="fixed bottom-6 right-6 z-50 bg-primary text-white p-3 rounded-full shadow-lg hover:bg-primary-dark transition-all duration-300 hover:scale-110"
    aria-label="Kembali ke atas"
  >
    <ChevronUp class="w-5 h-5" />
  </button>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { ChevronUp } from 'lucide-vue-next';

// State
const isVisible = ref(false);

// Methods
const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
};

const handleScroll = () => {
  isVisible.value = window.scrollY > 300;
};

// Lifecycle
onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>
