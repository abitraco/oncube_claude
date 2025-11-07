# Design System Usage Guide

Complete guide for using the Zahnarzt Design System in your projects.

## Quick Start

1. **Include CSS Files**
```html
<link rel="stylesheet" href="css/design-system.css">
<link rel="stylesheet" href="css/waves.css">
<link rel="stylesheet" href="css/components.css">
```

2. **Include JavaScript**
```html
<script src="js/animations.js"></script>
```

3. **Start Building**
Use the components and patterns from this guide.

---

## Color System

### Available Colors

#### Primary Colors (Blues)
```css
var(--primary-900)  /* #002748 - Dark blue */
var(--primary-800)  /* #003B5C - Medium dark blue */
var(--primary-100)  /* #EDF3F6 - Light blue */
var(--primary-200)  /* #DBEAF1 - Lighter blue */
```

#### Secondary Colors (Yellows)
```css
var(--secondary-500)  /* #FFEC2D - Bright yellow */
var(--secondary-600)  /* #EBD82D - Muted yellow */
```

#### Tertiary Colors (Neutrals)
```css
var(--tertiary-100)  /* #F6F4F3 - Warm off-white */
var(--tertiary-200)  /* #EFEBEA - Warm light gray */
```

#### Success Colors (Greens)
```css
var(--success-500)  /* #19BD0A - Bright green */
var(--success-600)  /* #15A509 - Dark green */
```

### Using Colors

```html
<!-- Background colors -->
<div class="bg-primary-900"></div>
<div class="bg-secondary-500"></div>

<!-- Text colors -->
<p class="text-primary-900">Dark blue text</p>
<p class="text-white">White text</p>
```

---

## Typography

### Heading Sizes
```html
<h1>Largest heading - 2.5rem to 5.375rem (fluid)</h1>
<h2>Large heading - 2rem to 3.5rem (fluid)</h2>
<h3>Medium heading - 1.5rem to 2.5rem (fluid)</h3>
<h4>Small heading - 1.25rem to 1.75rem (fluid)</h4>
```

All typography uses `clamp()` for fluid responsive sizing - no media queries needed!

### Font Weights
- Regular: 400
- Medium: 500
- Bold: 700
- Extra Bold: 800

---

## Wavy Backgrounds - The Star Feature

### Method 1: Background Sections

```html
<!-- Section with wave at top -->
<section class="wave-background-top">
    <div class="container">
        <h2>Your Content</h2>
    </div>
    <div class="wave-divider wave-bottom"></div>
</section>

<!-- Section with wave at bottom -->
<section class="wave-background-bottom">
    <div class="wave-divider wave-top"></div>
    <div class="container">
        <h2>Your Content</h2>
    </div>
</section>

<!-- Full wavy section -->
<section class="wave-background-full">
    <div class="wave-divider wave-top"></div>
    <div class="container">
        <h2>Your Content</h2>
    </div>
    <div class="wave-divider wave-bottom"></div>
</section>
```

### Method 2: Standalone Wave Dividers

```html
<section>
    <!-- Wave at top of section -->
    <div class="wave-divider wave-top"></div>

    <div class="container">
        <h2>Content here</h2>
    </div>

    <!-- Wave at bottom of section -->
    <div class="wave-divider wave-bottom"></div>
</section>
```

### Alternative Wave Styles

```html
<!-- Layered waves -->
<section class="wave-layered">
    <!-- Content -->
</section>

<!-- Smooth curve -->
<section class="wave-smooth">
    <!-- Content -->
</section>

<!-- Animated waves -->
<section class="wave-animated">
    <!-- Content -->
</section>

<!-- Diagonal wave -->
<section class="wave-diagonal">
    <!-- Content -->
</section>
```

---

## Buttons

### Button Types

```html
<!-- Primary button (dark blue) -->
<button class="btn btn-primary">Primary</button>

<!-- Secondary button (yellow) -->
<button class="btn btn-secondary">Secondary</button>

<!-- Success button (green) -->
<button class="btn btn-success">Success</button>

<!-- Outline button -->
<button class="btn btn-outline">Outline</button>

<!-- White outline (for dark backgrounds) -->
<button class="btn btn-outline-white">Outline White</button>
```

### Button Sizes

```html
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary">Default</button>
<button class="btn btn-primary btn-lg">Large</button>
```

### Button as Link

```html
<a href="#" class="btn btn-primary">Link Button</a>
```

---

## Cards

### Basic Card

```html
<div class="card">
    <div class="card-header">
        <h4>Card Title</h4>
    </div>
    <div class="card-body">
        <p>Card content goes here.</p>
    </div>
    <div class="card-footer">
        <a href="#" class="card-link">Learn More</a>
    </div>
</div>
```

### Highlighted Card

```html
<div class="card card-highlight">
    <div class="card-header">
        <h4>Featured Card</h4>
    </div>
    <div class="card-body">
        <p>This card stands out with accent colors.</p>
    </div>
</div>
```

### Card Grid

```html
<div class="cards-grid">
    <div class="card"><!-- Card 1 --></div>
    <div class="card"><!-- Card 2 --></div>
    <div class="card"><!-- Card 3 --></div>
</div>
```

---

## Feature Cards

```html
<div class="features-grid">
    <div class="feature-card">
        <div class="feature-icon">
            <!-- SVG icon here -->
            <svg width="48" height="48" viewBox="0 0 24 24">
                <!-- SVG path -->
            </svg>
        </div>
        <h3 class="feature-title">Feature Name</h3>
        <p class="feature-text">Feature description</p>
    </div>
</div>
```

---

## Layouts

### Container

```html
<!-- Standard container -->
<div class="container">
    <!-- Max-width with responsive padding -->
</div>

<!-- Narrow container -->
<div class="container container-narrow">
    <!-- Max-width: 800px -->
</div>

<!-- Wide container -->
<div class="container container-wide">
    <!-- Max-width: 1600px -->
</div>
```

### Grid System

```html
<!-- Basic grid -->
<div class="grid grid-cols-3">
    <div>Column 1</div>
    <div>Column 2</div>
    <div>Column 3</div>
</div>

<!-- Responsive grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
</div>
```

### Flexbox

```html
<!-- Flex row with center alignment -->
<div class="flex flex-row items-center justify-center">
    <div>Item 1</div>
    <div>Item 2</div>
</div>

<!-- Flex column -->
<div class="flex flex-col">
    <div>Item 1</div>
    <div>Item 2</div>
</div>
```

---

## Sections

### Hero Section

```html
<section class="hero-section wave-background-top">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title fade-in-up">Welcome</h1>
            <p class="hero-subtitle fade-in-up delay-1">Subtitle text</p>
            <div class="hero-buttons fade-in-up delay-2">
                <a href="#" class="btn btn-primary">Get Started</a>
                <a href="#" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </div>
    <div class="wave-divider wave-bottom"></div>
</section>
```

### Features Section

```html
<section class="features-section">
    <div class="container">
        <h2 class="section-title">Our Features</h2>
        <p class="section-subtitle">Description text</p>

        <div class="features-grid">
            <!-- Feature cards here -->
        </div>
    </div>
</section>
```

### Contact Section

```html
<section class="contact-section wave-background-bottom">
    <div class="wave-divider wave-top"></div>
    <div class="container">
        <div class="contact-content">
            <h2 class="section-title text-white">Get In Touch</h2>
            <p class="section-subtitle text-white">Contact description</p>
            <div class="contact-buttons">
                <a href="#" class="btn btn-secondary">Contact Us</a>
            </div>
        </div>
    </div>
</section>
```

---

## Animations

### Fade In on Scroll

```html
<!-- Fade in from bottom -->
<div class="fade-in-up">Content</div>

<!-- Fade in from left -->
<div class="fade-in-left">Content</div>

<!-- Fade in from right -->
<div class="fade-in-right">Content</div>

<!-- Just fade in -->
<div class="fade-in">Content</div>
```

### Animation Delays

```html
<div class="fade-in-up">First (no delay)</div>
<div class="fade-in-up delay-1">Second (0.1s delay)</div>
<div class="fade-in-up delay-2">Third (0.2s delay)</div>
<div class="fade-in-up delay-3">Fourth (0.3s delay)</div>
```

### Counter Animation

```html
<!-- Auto-animates when scrolled into view -->
<span data-count="1500">0</span>
```

### Lazy Loading Images

```html
<img data-src="path/to/image.jpg" alt="Description">
```

---

## Spacing Utilities

### Margin

```css
.mt-2, .mt-4, .mt-6, .mt-8, .mt-12, .mt-16, .mt-20  /* margin-top */
.mb-2, .mb-4, .mb-6, .mb-8, .mb-12                  /* margin-bottom */
```

### Padding

```css
.py-8, .py-12, .py-16, .py-20  /* padding-top and bottom */
.px-3, .px-4, .px-6             /* padding-left and right */
```

---

## Shadows

```html
<!-- Standard shadows -->
<div class="shadow-sm">Small shadow</div>
<div class="shadow-md">Medium shadow</div>
<div class="shadow-lg">Large shadow</div>
<div class="shadow-xl">Extra large shadow</div>

<!-- Fancy multi-layer shadows -->
<div class="shadow-fancy-small">Fancy small</div>
<div class="shadow-fancy-medium">Fancy medium</div>
```

---

## Border Radius

```html
<div class="rounded-md">0.375rem</div>
<div class="rounded-lg">0.5rem</div>
<div class="rounded-xl">0.75rem</div>
<div class="rounded-2xl">1rem</div>
<div class="rounded-full">9999px (pill shape)</div>
```

---

## Badges

```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-secondary">Secondary</span>
<span class="badge badge-success">Success</span>
```

---

## Navigation

```html
<nav class="nav">
    <div class="container">
        <div class="nav-content">
            <a href="#" class="logo">Brand</a>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
```

---

## Customization

### Changing Primary Color

1. Open `css/design-system.css`
2. Find `:root` section
3. Update `--primary-900`, `--primary-800`, etc.
4. All components update automatically!

### Changing Wave Color

In `css/waves.css`, find the wave SVG and update the `fill` parameter:
```
fill='%23002748'  /* %23 = # symbol, then hex color */
```

### Adding Custom Spacing

In `css/design-system.css`:
```css
:root {
    --space-32: 8rem;  /* Add custom spacing */
}
```

Then use:
```html
<div style="margin-top: var(--space-32)">Content</div>
```

---

## Best Practices

1. **Always use the container**: Wrap content in `.container` for proper responsive padding
2. **Use design tokens**: Reference CSS variables instead of hard-coding values
3. **Mobile-first**: Design for mobile, enhance for desktop
4. **Accessibility**: Include proper ARIA labels and semantic HTML
5. **Performance**: Use lazy loading for images below the fold
6. **Wave placement**: Ensure waves connect properly between sections (test at all breakpoints)

---

## Common Patterns

### Hero + Features + Contact

```html
<section class="hero-section wave-background-top">
    <!-- Hero content -->
    <div class="wave-divider wave-bottom"></div>
</section>

<section class="features-section">
    <!-- Features -->
</section>

<section class="contact-section wave-background-bottom">
    <div class="wave-divider wave-top"></div>
    <!-- Contact content -->
</section>
```

### Card Grid with Fade In

```html
<div class="cards-grid">
    <div class="card fade-in-up">Card 1</div>
    <div class="card fade-in-up delay-1">Card 2</div>
    <div class="card fade-in-up delay-2">Card 3</div>
</div>
```

---

## Troubleshooting

### Waves not showing?
- Check that parent section has `position: relative`
- Ensure `.wave-divider` has proper `position: absolute`
- Verify SVG fill color matches your needs

### Animations not triggering?
- Check that `js/animations.js` is loaded
- Verify IntersectionObserver is supported (modern browsers only)
- Check browser console for errors

### Colors not applying?
- Ensure CSS files are loaded in correct order
- Check that you're using the correct class names
- Verify CSS custom properties are supported

---

## Examples

See `index.html` for complete working examples of all components and patterns!
