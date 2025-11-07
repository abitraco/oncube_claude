# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a design system based on zahnarzt-wernitz.de, featuring wavy curved backgrounds and a modern, clean aesthetic. The project is built with pure HTML, CSS, and vanilla JavaScript - no build tools or frameworks required.

## Key Design Principles

1. **Wavy Curved Backgrounds**: The signature feature of this design system. SVG-based wave patterns create elegant section dividers and backgrounds.
2. **Color System**: Primary blue (#002748), accent yellow (#FFEC2D), and warm neutral tones create the visual hierarchy.
3. **Fluid Typography**: All text uses `clamp()` for responsive sizing without media queries.
4. **Modern CSS**: Heavy use of CSS custom properties, Grid, Flexbox, and pseudo-elements for wave effects.

## Development Commands

### Running the Project
```bash
# Option 1: Open index.html directly in browser
# Option 2: Use live server
npm run dev
```

### Project Structure
- `index.html` - Main demo page showcasing all components
- `css/design-system.css` - Core design tokens and utilities
- `css/waves.css` - Wavy background patterns and SVG configurations
- `css/components.css` - Component styles (buttons, cards, navigation)
- `js/animations.js` - Scroll animations and interactive effects

## Architecture

### CSS Organization

The CSS is split into three main files following a clear separation of concerns:

1. **design-system.css**: Foundation layer
   - CSS custom properties (colors, spacing, shadows, typography)
   - Reset and base styles
   - Layout utilities (container, grid, flexbox)
   - Utility classes for common patterns

2. **waves.css**: Wave pattern layer
   - All wavy background implementations
   - SVG-based wave dividers using data URIs
   - Pseudo-element wave patterns
   - Animation keyframes for animated waves
   - Classes: `.wave-background-top`, `.wave-background-bottom`, `.wave-divider`, etc.

3. **components.css**: Component layer
   - Navigation, buttons, cards, sections
   - Feature cards, hero sections, footers
   - Color palette display components
   - All interactive component states

### Wave Pattern System

Waves are implemented using three techniques:

1. **Inline SVG Data URIs**: Embedded directly in CSS `background-image` for performance
2. **Pseudo-elements**: `::before` and `::after` create wave layers without extra markup
3. **Positioned Dividers**: `.wave-divider` elements can be placed at section boundaries

Key wave classes:
- `.wave-background-top` - Section with wave at top
- `.wave-background-bottom` - Section with wave at bottom
- `.wave-background-full` - Full section with light blue background
- `.wave-divider.wave-top` - Top wave divider element
- `.wave-divider.wave-bottom` - Bottom wave divider element

### Color System

All colors are defined as CSS custom properties in `:root`. The naming convention follows:
- `--{color}-{shade}` pattern (e.g., `--primary-900`, `--secondary-500`)
- Primary: Blues (100, 200, 800, 900, 950)
- Secondary: Yellows (500, 600)
- Tertiary: Warm neutrals (100, 200)
- Grays: Full scale (50-900)
- Functional: Success greens, accent pink

### JavaScript Architecture

`animations.js` uses vanilla JavaScript with modern APIs:
- **IntersectionObserver** for scroll-triggered animations
- **Event delegation** for efficient event handling
- **No dependencies** - pure vanilla JS only

Key features:
- Fade-in animations on scroll
- Smooth scroll for anchor links
- Navbar scroll effects
- Optional card tilt effects
- Button ripple effects
- Lazy image loading
- Keyboard navigation detection

## Making Changes

### Adding New Wave Patterns

1. Create SVG in editor or use existing pattern from waves.css
2. Encode SVG for data URI: URL-encode special characters (`#` → `%23`, `<` → `%3C`, etc.)
3. Add new class in waves.css with background-image data URI
4. Position using pseudo-elements or .wave-divider structure

### Adding New Components

1. Add HTML structure to index.html or new page
2. Add component styles to components.css
3. Follow existing naming conventions (BEM-like: `.component-element`)
4. Use design tokens (CSS variables) instead of hard-coded values
5. Ensure responsive behavior with fluid typography and flexible layouts

### Modifying Colors

1. Update CSS custom property in design-system.css `:root`
2. Color changes automatically cascade through all components
3. Maintain WCAG contrast ratios (primary-900 on white, white on primary-900)

## Important Conventions

- **No Build Step**: This is intentional. Files are meant to be used directly.
- **CSS Custom Properties**: Always use variables, never hard-code colors/spacing
- **Responsive**: Mobile-first approach, uses clamp() for fluid scaling
- **Accessibility**: Focus states, ARIA attributes, semantic HTML
- **Performance**: Lazy loading, optimized animations, minimal JS

## Wave Pattern Reference

Common wave SVG path (used throughout):
```
M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z
```

This creates the signature smooth wave curve. Rotate 180deg for bottom waves, use as-is for top waves.

## Browser Support

- Modern browsers with CSS Grid and Custom Properties support
- ES6+ JavaScript features (IntersectionObserver, arrow functions, template literals)
- No IE11 support

## Tips

- Use browser DevTools to inspect wave SVGs and adjust viewBox/paths
- Test animations with reduced motion preference: `prefers-reduced-motion`
- Wave heights are responsive - check all breakpoints
- Color contrast validated against WCAG AA standards
