/**
 * Zahnarzt Design System - Animations
 * Scroll-triggered animations and interactive effects
 * Based on zahnarzt-wernitz.de
 */

// ==================
// Fade-in on Scroll Observer
// ==================

const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const fadeInObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            // Optional: unobserve after animation completes
            // fadeInObserver.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe all fade-in elements
document.addEventListener('DOMContentLoaded', () => {
    const fadeElements = document.querySelectorAll('.fade-in-up, .fade-in, .fade-in-left, .fade-in-right');
    fadeElements.forEach(el => fadeInObserver.observe(el));
});

// ==================
// Smooth Scroll for Anchor Links
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');

    anchorLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');

            // Ignore empty anchors
            if (href === '#' || href === '#!') return;

            const target = document.querySelector(href);

            if (target) {
                e.preventDefault();

                const offsetTop = target.offsetTop - 80; // Account for fixed nav

                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });

                // Update URL without scrolling
                history.pushState(null, null, href);
            }
        });
    });
});

// ==================
// Navbar Scroll Effect
// ==================

let lastScroll = 0;

window.addEventListener('scroll', () => {
    const nav = document.querySelector('.nav');
    const currentScroll = window.pageYOffset;

    if (currentScroll > 100) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }

    // Optional: Hide nav on scroll down, show on scroll up
    // if (currentScroll > lastScroll && currentScroll > 200) {
    //     nav.style.transform = 'translateY(-100%)';
    // } else {
    //     nav.style.transform = 'translateY(0)';
    // }

    lastScroll = currentScroll;
});

// Add scrolled class styles via CSS
const style = document.createElement('style');
style.textContent = `
    .nav.scrolled {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
`;
document.head.appendChild(style);

// ==================
// Parallax Wave Effect
// ==================

window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.wave-parallax');

    parallaxElements.forEach((el, index) => {
        const speed = 0.5 + (index * 0.1);
        const yPos = -(scrolled * speed);
        el.style.transform = `translateY(${yPos}px)`;
    });
});

// ==================
// Card Tilt Effect (Optional)
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.feature-card, .card');

    cards.forEach(card => {
        card.addEventListener('mousemove', handleTilt);
        card.addEventListener('mouseleave', resetTilt);
    });

    function handleTilt(e) {
        const card = e.currentTarget;
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = (y - centerY) / 20;
        const rotateY = (centerX - x) / 20;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-4px)`;
    }

    function resetTilt(e) {
        const card = e.currentTarget;
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
    }
});

// ==================
// Typing Animation for Hero
// ==================

function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.textContent = '';

    function type() {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }

    type();
}

// Optional: Activate typing animation
// document.addEventListener('DOMContentLoaded', () => {
//     const heroTitle = document.querySelector('.hero-title');
//     if (heroTitle) {
//         const originalText = heroTitle.textContent;
//         typeWriter(heroTitle, originalText, 80);
//     }
// });

// ==================
// Counter Animation
// ==================

function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = Math.round(target);
            clearInterval(timer);
        } else {
            element.textContent = Math.round(current);
        }
    }, 16);
}

// Observe and animate counters when in view
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
            const target = parseInt(entry.target.getAttribute('data-count'));
            animateCounter(entry.target, target);
            entry.target.classList.add('counted');
        }
    });
}, { threshold: 0.5 });

document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('[data-count]');
    counters.forEach(counter => counterObserver.observe(counter));
});

// ==================
// Lazy Loading Images
// ==================

const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            const src = img.getAttribute('data-src');

            if (src) {
                img.src = src;
                img.removeAttribute('data-src');
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const lazyImages = document.querySelectorAll('img[data-src]');
    lazyImages.forEach(img => imageObserver.observe(img));
});

// ==================
// Button Ripple Effect
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.btn');

    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });
});

// Add ripple CSS
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    .btn {
        position: relative;
        overflow: hidden;
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple-animation 600ms ease-out;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Fade-in Animations */
    .fade-in-up,
    .fade-in,
    .fade-in-left,
    .fade-in-right {
        opacity: 0;
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-in-up {
        transform: translateY(30px);
    }

    .fade-in-left {
        transform: translateX(-30px);
    }

    .fade-in-right {
        transform: translateX(30px);
    }

    .fade-in-up.is-visible,
    .fade-in.is-visible,
    .fade-in-left.is-visible,
    .fade-in-right.is-visible {
        opacity: 1;
        transform: translate(0, 0);
    }

    /* Animation Delays */
    .delay-1 {
        transition-delay: 0.1s;
    }

    .delay-2 {
        transition-delay: 0.2s;
    }

    .delay-3 {
        transition-delay: 0.3s;
    }

    .delay-4 {
        transition-delay: 0.4s;
    }

    .delay-5 {
        transition-delay: 0.5s;
    }

    /* Loaded Image Fade */
    img[data-src] {
        opacity: 0;
        transition: opacity 0.3s ease-in;
    }

    img.loaded {
        opacity: 1;
    }
`;
document.head.appendChild(rippleStyle);

// ==================
// Keyboard Navigation Detection
// ==================

let isTabbing = false;

document.addEventListener('keydown', (e) => {
    if (e.key === 'Tab') {
        isTabbing = true;
        document.documentElement.classList.add('user-is-tabbing');
    }
});

document.addEventListener('mousedown', () => {
    isTabbing = false;
    document.documentElement.classList.remove('user-is-tabbing');
});

// Focus outline only when tabbing
const focusStyle = document.createElement('style');
focusStyle.textContent = `
    html:not(.user-is-tabbing) *:focus {
        outline: none;
    }
`;
document.head.appendChild(focusStyle);

// ==================
// Console Welcome Message
// ==================

console.log(
    '%c Zahnarzt Design System ',
    'background: #002748; color: #FFEC2D; font-size: 16px; padding: 10px; font-weight: bold;'
);
console.log(
    '%c Built with modern CSS and vanilla JavaScript ',
    'background: #EDF3F6; color: #002748; font-size: 12px; padding: 5px;'
);
