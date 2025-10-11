<template>
  <div class="min-h-screen">
    <Header />
    <HeroSection />
    <ArticleSection :articles="props.articles" />
    <ServiceSection />
    <AspirationSection :aspirations="props.aspirations" />
    <BlogSection :posts="props.posts" />
    <Footer />
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
  aspirations: Array<{
    id: number;
    title: string;
    description: string;
    category: string;
    status: string;
    created_at: string;
  }>;
}

const props = defineProps<Props>();
</script>
