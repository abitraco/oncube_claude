# Zahnarzt Design System

A complete design system replicated from zahnarzt-wernitz.de, featuring wavy curved backgrounds and modern dental practice aesthetics.

## Quick Start

1. Open `index.html` in your browser
2. Or run with live server: `npm run dev`

## What's Included

- **Color System**: Complete color palette with primary blues, accent yellows, and neutral grays
- **Typography**: Fluid responsive typography system
- **Wavy Backgrounds**: SVG-based curved wave patterns
- **Components**: Buttons, cards, navigation, hero sections
- **Animations**: Fade-in and scroll-triggered effects
- **Responsive**: Mobile-first design with breakpoints

## File Structure

```
├── index.html          # Main demo page
├── css/
│   ├── design-system.css   # Core design system
│   ├── waves.css          # Wavy background patterns
│   └── components.css     # Component styles
└── assets/
    └── waves/            # SVG wave files
```

## Usage

Include the CSS files in your HTML:

```html
<link rel="stylesheet" href="css/design-system.css">
<link rel="stylesheet" href="css/waves.css">
<link rel="stylesheet" href="css/components.css">
```

## Color Variables

- `--primary-900`: #002748 (Dark blue)
- `--primary-100`: #EDF3F6 (Light blue)
- `--secondary-500`: #FFEC2D (Bright yellow)
- `--tertiary-100`: #F6F4F3 (Warm off-white)

## Browser Support

Modern browsers with CSS Grid and Custom Properties support.
