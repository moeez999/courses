/**
 * Application Configuration
 * 
 * Centralized configuration for the Latingles Student Home application
 */

const AppConfig = {
  // Application metadata
  app: {
    name: 'Latingles Student Home',
    version: '2.0.0',
    author: 'Latingles Development Team',
    environment: 'production' // 'development' | 'staging' | 'production'
  },

  // Debug and logging settings
  debug: {
    enabled: true,
    logLevel: 'info', // 'info' | 'warn' | 'error'
    showPerformanceMetrics: false
  },

  // UI Configuration
  ui: {
    defaultProgress: 100,
    animationDuration: 300,
    modalTransitionSpeed: 200,
    debounceDelay: 250
  },

  // API Configuration (if needed)
  api: {
    baseUrl: '',
    timeout: 5000,
    retryAttempts: 3
  },

  // Feature flags
  features: {
    enableNotifications: true,
    enableProgressTracking: true,
    enableCalendar: true,
    enableMessaging: true,
    enableSubscriptionTransfer: true
  },

  // Validation rules
  validation: {
    cardNumberLength: 16,
    expiryFormat: 'MM/YY',
    maxMessageLength: 500,
    minLessonCount: 1,
    maxLessonCount: 50
  },

  // Default values
  defaults: {
    lessonCount: 1,
    progressValue: 0,
    language: 'English',
    currency: 'EUR'
  }
};

export default AppConfig;

