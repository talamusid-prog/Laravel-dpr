<template>
  <div class="min-h-screen bg-gradient-to-br from-primary/5 to-secondary/5">
    <!-- Header -->
    <Header />
    
    <!-- Main Content -->
    <main class="py-12">
      <div class="max-w-6xl mx-auto px-4">
        <MemberRegistration />
      </div>
    </main>

    <!-- Footer -->
    <Footer />
    
    <!-- Back to Top Button -->
    <BackToTop />
  </div>
</template>

<script setup lang="ts">
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import BackToTop from '@/components/BackToTop.vue';
import MemberRegistration from '@/components/MemberRegistration.vue';
</script>
