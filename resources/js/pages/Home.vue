<template>
  <div class="min-h-screen">
    <Header />
    <HeroSection />
    <ArticleSection :articles="props.articles" />
    <ServiceSection />
    <AspirationSection :gallery-items="props.galleryItems" />
    <BlogSection :posts="props.posts" />
    <Footer />
    <BackToTop />
    <NewsNotification />
  </div>
</template>

<script setup lang="ts">
import Header from '@/components/Header.vue';
import HeroSection from '@/components/HeroSection.vue';
import ArticleSection from '@/components/ArticleSection.vue';
import ServiceSection from '@/components/ServiceSection.vue';
import AspirationSection from '@/components/AspirationSection.vue';
import BlogSection from '@/components/BlogSection.vue';
import Footer from '@/components/Footer.vue';
import BackToTop from '@/components/BackToTop.vue';
import NewsNotification from '@/components/NewsNotification.vue';

// Props from controller
interface Props {
  articles: Array<{
    id: number;
    title: string;
    excerpt: string;
    slug: string;
    published_at: string;
  }>;
  posts: Array<{
    id: number;
    title: string;
    slug: string;
    published_at: string;
  }>;
  galleryItems?: Array<{
    id: number;
    title: string;
    description: string;
    image: string;
    category: string;
    created_at: string;
  }>;
}

const props = defineProps<Props>();
</script>
