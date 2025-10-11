import { ref, reactive, watch } from 'vue';

// Theme colors interface
interface ThemeColors {
  primary: string;
  primaryDark: string;
  accent: string;
  accentDark: string;
  success: string;
  successDark: string;
  warning: string;
  gold: string;
  goldLight: string;
}

// Default theme colors
const defaultTheme: ThemeColors = {
  primary: '#dc2626',
  primaryDark: '#991b1b',
  accent: '#f59e0b',
  accentDark: '#d97706',
  success: '#10b981',
  successDark: '#059669',
  warning: '#f59e0b',
  gold: '#fbbf24',
  goldLight: '#fde68a'
};

// Reactive theme state
const themeColors = reactive<ThemeColors>({ ...defaultTheme });
const isDarkMode = ref(false);

// Apply theme to CSS variables
const applyTheme = () => {
  const root = document.documentElement;
  
  // Apply colors
  Object.entries(themeColors).forEach(([key, value]) => {
    const cssVarName = `--color-${key.replace(/([A-Z])/g, '-$1').toLowerCase()}`;
    root.style.setProperty(cssVarName, value);
  });

  // Apply dark mode
  if (isDarkMode.value) {
    root.classList.add('dark');
  } else {
    root.classList.remove('dark');
  }
};

// Load theme from localStorage
const loadTheme = () => {
  try {
    const savedColors = localStorage.getItem('theme-colors');
    if (savedColors) {
      const parsedColors = JSON.parse(savedColors);
      Object.assign(themeColors, parsedColors);
    }

    const savedDarkMode = localStorage.getItem('dark-mode');
    if (savedDarkMode) {
      isDarkMode.value = savedDarkMode === 'true';
    }

    applyTheme();
  } catch (error) {
    console.error('Error loading theme:', error);
  }
};

// Save theme to localStorage
const saveTheme = () => {
  try {
    localStorage.setItem('theme-colors', JSON.stringify(themeColors));
    localStorage.setItem('dark-mode', isDarkMode.value.toString());
  } catch (error) {
    console.error('Error saving theme:', error);
  }
};

// Watch for theme changes and apply automatically
watch(themeColors, () => {
  applyTheme();
}, { deep: true });

watch(isDarkMode, () => {
  applyTheme();
});

// Export composable
export const useTheme = () => {
  return {
    themeColors,
    isDarkMode,
    applyTheme,
    loadTheme,
    saveTheme,
    defaultTheme
  };
};
