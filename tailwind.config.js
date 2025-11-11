/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Dark/Techy palette
        cyber: {
          dark: '#0B0F10',      // Very dark navy
          darker: '#070A0B',    // Even darker
          bg: '#0D1117',        // Background
          card: '#161B22',      // Card background
          border: '#30363D',    // Border
          text: '#E5E7EB',      // Light text
          muted: '#8B949E',     // Muted text
          accent: '#58A6FF',    // Cyan accent
          success: '#3FB950',   // Green
          warning: '#D29922',   // Orange
          error: '#F85149',     // Red
          glow: '#00D9FF',      // Neon cyan
          neon: '#00FF41',      // Neon green
        }
      },
      fontFamily: {
        sans: ['Inter', 'Roboto', 'sans-serif'],
        mono: ['JetBrains Mono', 'Courier New', 'monospace'],
      },
      boxShadow: {
        glow: '0 0 20px rgba(0, 217, 255, 0.3)',
        'glow-lg': '0 0 40px rgba(0, 217, 255, 0.5)',
        'glow-cyan': '0 0 15px rgba(88, 166, 255, 0.3)',
        'glow-green': '0 0 15px rgba(0, 255, 65, 0.3)',
      },
      animation: {
        'pulse-glow': 'pulse-glow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        'flicker': 'flicker 3s linear infinite',
      },
      keyframes: {
        'pulse-glow': {
          '0%, 100%': { 
            opacity: 1,
            boxShadow: '0 0 20px rgba(0, 217, 255, 0.3)'
          },
          '50%': {
            opacity: 0.8,
            boxShadow: '0 0 40px rgba(0, 217, 255, 0.5)'
          }
        },
        'flicker': {
          '0%, 100%': { opacity: 1 },
          '50%': { opacity: 0.8 }
        }
      },
      backdropBlur: {
        xs: '2px',
      },
      spacing: {
        '128': '32rem',
        '144': '36rem',
      }
    },
  },
  plugins: [],
  darkMode: 'class',
}
