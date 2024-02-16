/** @type {import('tailwindcss').Config} */

const colors = {
  "border-secondary": "#E5E7EB",
  "background-primary": "#FFFFFF",
  "content-primary": "#111827",
  "content-secondary": "#374151",
  "border-primary": "#D1D5DB",
  "content-accent-A": "#3B82F6",
  "content-tertiary": "#6B7280",
  "background-accent-B": "#0D9488",
  "content-inverse-primary": "#FFFFFF",
  "border-danger": "#EF4444",
  "background-danger-light": "#FEF2F2",
  "content-danger": "#EF4444",
  "sidebar-background-dark": "#1F2937",
  "sidebar-border-primary": "#4B5563",
  "sidebar-background-accent-A": "#3B82F6",
  "border-inverse-selected": "#9CA3AF",
  "border-primary": "#D1D5DB",
  "background-accent-A": "#2563EB",
  "background-secondary": "#F9FAFB",
  "background-tertiary": "#F3F4F6"
}


const spacing = {
  "xxs": "1px",
  "xs": "2px",
  "sm": "4px",
  "md": "8px",
  "lg": "12px",
  "xl": "16px",
  "2xl": "24px",
  "3xl": "32px",
  "4xl": "48px",
  "5xl": "64px",
  "6xl": "96px",
}

const borderRadius = {
  "sm": "2px",
  "md": "4px",
  "lg": "8px",
  "xl": "16px",
  "2xl": "24px",
  "circular": "9999px",
}

const fontSize = {
  "xs": "12px",
  "sm": "14px",
  "md": "16px",
  "lg": "18px",
  "xl": "20px",
  "2xl": "24px",
  "3xl": "30px",
  "4xl": "36px"
}

const fontWeight =
{
  "regular": 400,
  "medium": 500,
  "semibold": 600,
  "bold": 700,
  "extrabold": 800
}

const gap = spacing;

// tailwind.config.js
module.exports = {
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors,
      spacing,
      borderRadius,
      fontSize,
      gap
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}