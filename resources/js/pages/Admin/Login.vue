<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <div class="mx-auto h-12 w-12 bg-primary rounded-lg flex items-center justify-center">
          <Shield class="h-6 w-6 text-white" />
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Admin Login
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Masuk ke panel administrasi
        </p>
      </div>
      
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="email" class="sr-only">Email address</label>
            <input 
              id="email" 
              name="email" 
              type="email" 
              autocomplete="email" 
              required 
              v-model="form.email"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" 
              placeholder="Email address" 
            />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input 
              id="password" 
              name="password" 
              type="password" 
              autocomplete="current-password" 
              required 
              v-model="form.password"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" 
              placeholder="Password" 
            />
          </div>
        </div>

        <div v-if="errors.email" class="text-red-600 text-sm">
          {{ errors.email }}
        </div>

        <div>
          <button 
            type="submit" 
            :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50"
          >
            <span v-if="loading" class="absolute left-0 inset-y-0 flex items-center pl-3">
              <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
            </span>
            {{ loading ? 'Memproses...' : 'Masuk' }}
          </button>
        </div>

        <!-- Demo Credentials -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
          <h3 class="text-sm font-medium text-blue-800 mb-2">Demo Credentials:</h3>
          <div class="text-xs text-blue-700 space-y-1">
            <div><strong>Super Admin:</strong> admin@dpr-ri.com / admin123</div>
            <div><strong>Dr. AGUS:</strong> agus.ambo@dpr-ri.com / agus123</div>
            <div><strong>Tim Admin:</strong> tim.admin@dpr-ri.com / tim123</div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Shield } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

// State
const form = ref({
  email: '',
  password: ''
});

const loading = ref(false);
const errors = ref<Record<string, string>>({});

// Methods
const handleLogin = () => {
  loading.value = true;
  errors.value = {};

  router.post('/admin/login', form.value, {
    onSuccess: () => {
      loading.value = false;
    },
    onError: (errs) => {
      loading.value = false;
      errors.value = errs;
    }
  });
};
</script>
