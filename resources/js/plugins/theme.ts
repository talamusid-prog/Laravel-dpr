import { useTheme } from '@/composables/useTheme';

// Initialize theme on app startup
export const initializeTheme = () => {
  const { loadTheme } = useTheme();
  
  // Load theme immediately when app starts
  loadTheme();
  
  // Also load theme when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadTheme);
  } else {
    loadTheme();
  }
};

// Export theme composable for use in components
export { useTheme } from '@/composables/useTheme';
