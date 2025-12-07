# DERMOND Style Guide

A comprehensive design system documentation for the DERMOND Premium Intimate Care website.

---

## 1. Overview

DERMOND is a premium men's intimate care brand with a modern, dark-themed, tech-inspired aesthetic. The design language draws inspiration from gaming/tech brands like Logitech G, featuring:

- **Dark Mode First**: Deep navy/black backgrounds with high contrast elements
- **Electric Blue Accents**: Primary accent color for CTAs and highlights
- **Bold Typography**: Heavy use of black/bold weights with italic styling for brand identity
- **Glassmorphism**: Backdrop blur effects with semi-transparent backgrounds
- **Micro-interactions**: Hover effects, scroll animations, and custom cursors
- **Premium Feel**: Subtle gradients, glows, and elevation through shadows

---

## 2. Color Palette

### Primary Colors (Custom Dermond Theme)

| Token | Hex Value | Usage |
|-------|-----------|-------|
| `dermond-dark` | `#050a14` | Main background, body |
| `dermond-nav` | `#0a1226` | Navigation, cards, elevated surfaces |
| `dermond-accent` | `#2563eb` | Primary accent (Electric Blue) |
| `dermond-accentHover` | `#1d4ed8` | Accent hover state |
| `dermond-text` | `#e2e8f0` | Primary text color |
| `dermond-dim` | `#64748b` | Muted/secondary text |

### Extended Blue Palette (Tailwind)

| Class | Usage |
|-------|-------|
| `blue-400` | Accent text, highlights, links |
| `blue-500` | Primary buttons, active states |
| `blue-600` | Button backgrounds, borders |
| `blue-700` | Button hover states |
| `blue-900/30` | Subtle background tints |


### Gray Scale (Slate/Gray)

| Class | Hex | Usage |
|-------|-----|-------|
| `white` | `#ffffff` | Headlines, important text |
| `slate-200` | `#e2e8f0` | Body text |
| `gray-300` | `#d1d5db` | Secondary text on hover |
| `gray-400` | `#9ca3af` | Descriptions, paragraphs |
| `gray-500` | `#6b7280` | Section labels, muted text |
| `gray-600` | `#4b5563` | Dividers, subtle elements |
| `gray-700` | `#374151` | Input borders |

### Background Variations

```css
/* Main backgrounds */
bg-[#050a14]          /* Primary dark background */
bg-[#0a1226]          /* Elevated surfaces (nav, cards) */
bg-[#0f172a]          /* Card backgrounds */
bg-[#131c33]          /* Card hover state */
bg-[#020611]          /* Footer background */
bg-black/20           /* Section overlay */
bg-black/40           /* Image overlays */
bg-gray-900           /* Hero section */

/* Glassmorphism */
bg-dermond-nav/80     /* 80% opacity for blur effect */
bg-white/5            /* Subtle white tint */
bg-white/10           /* Light surface */
bg-blue-600/10        /* Blue tinted backgrounds */
bg-blue-900/30        /* Badge backgrounds */
```

### Gradient Usage

```css
/* Text gradients */
bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600

/* Background gradients */
bg-gradient-to-t from-black/90 via-black/50 to-transparent  /* Image overlays */
bg-gradient-to-tr from-blue-900/40 to-transparent           /* Decorative glows */
bg-gradient-to-r from-blue-900/10 to-transparent            /* Hover effects */
```

---

## 3. Typography

### Font Family

```css
font-family: 'Inter', sans-serif;
```

The project uses **Inter** as the primary sans-serif font, configured in Tailwind.

### Font Weights

| Weight | Class | Usage |
|--------|-------|-------|
| Regular (400) | `font-normal` | Body text (default) |
| Medium (500) | `font-medium` | Navigation links, labels |
| Semi-bold (600) | `font-semibold` | Emphasized inline text |
| Bold (700) | `font-bold` | Headings, buttons, card titles |
| Black (900) | `font-black` | Brand name, hero headlines |

### Typography Scale

#### Headlines

```css
/* Hero Headlines */
text-5xl md:text-7xl font-black italic tracking-tighter  /* Main page titles */
text-5xl md:text-6xl font-black                          /* Product detail titles */
text-4xl md:text-6xl font-black tracking-tighter uppercase /* Section headers */
text-4xl md:text-5xl lg:text-6xl font-black              /* Blog post titles */

/* Section Headlines */
text-3xl md:text-5xl font-bold                           /* Product showcase */
text-3xl md:text-4xl font-bold                           /* Feature sections */
text-2xl md:text-3xl font-black uppercase italic         /* Category cards */
```

#### Body & UI Text

```css
/* Large body */
text-xl leading-relaxed                                   /* Intro paragraphs */

/* Regular body */
text-base                                                 /* Default body text */
text-sm leading-relaxed                                   /* Card descriptions */

/* Small/Labels */
text-xs font-bold tracking-widest uppercase              /* Category labels */
text-xs font-bold tracking-[0.2em] uppercase             /* Section subtitles */
```


### Letter Spacing (Tracking)

| Class | Usage |
|-------|-------|
| `tracking-tighter` | Large headlines for compact look |
| `tracking-tight` | Subheadings |
| `tracking-normal` | Body text |
| `tracking-wide` | Footer headings |
| `tracking-wider` | Button text, labels |
| `tracking-widest` | Category badges, uppercase labels |
| `tracking-[0.2em]` | Section subtitles |
| `tracking-[0.25em]` | Brand name "DERMOND" |

### Text Styles Combinations

```css
/* Brand Name */
text-3xl font-black italic tracking-[0.25em] text-white

/* Section Label */
text-gray-500 font-bold tracking-[0.2em] text-lg uppercase

/* Category Badge */
text-blue-400 text-xs font-bold tracking-widest uppercase

/* Button Text */
text-sm uppercase tracking-widest font-bold

/* Navigation Links */
text-sm font-medium text-gray-400
```

---

## 4. Spacing System

The project uses Tailwind's default spacing scale (4px base unit).

### Common Spacing Patterns

#### Container & Layout

```css
/* Max widths */
max-w-7xl mx-auto px-6          /* Standard container */
max-w-[1400px] mx-auto px-4 md:px-8  /* Wide container */
max-w-4xl mx-auto               /* Content container (blog) */
max-w-2xl mx-auto               /* Narrow content */

/* Section padding */
py-20                           /* Standard section */
py-24                           /* Large section */
pt-32 pb-20                     /* Page with navbar offset */
```

#### Component Spacing

```css
/* Cards */
p-6                             /* Small card padding */
p-8                             /* Standard card padding */
p-10                            /* Large card padding */

/* Gaps */
gap-2                           /* Tight (buttons with icons) */
gap-4                           /* Standard */
gap-6                           /* Cards, features */
gap-8                           /* Grid items */
gap-12                          /* Footer columns */
gap-16                          /* Large sections */

/* Margins */
mb-2                            /* Tight spacing */
mb-4                            /* Standard */
mb-6                            /* Between elements */
mb-8                            /* Section elements */
mb-12                           /* Large spacing */
mb-16                           /* Section separators */
mb-20                           /* Major sections */
```

#### Navbar Height

```css
h-20                            /* 80px navbar height */
pt-24                           /* Content offset for fixed nav */
pt-32                           /* Page content offset */
scroll-mt-24                    /* Scroll margin for anchors */
```

---

## 5. Component Styles

### Buttons

#### Primary Button (Filled)

```tsx
<button className="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded transition-all hover:-translate-y-1 flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20">
  <ShoppingBag size={20} />
  BUY NOW
</button>
```

#### Secondary Button (Outlined)

```tsx
<button className="px-8 py-4 border border-gray-600 text-gray-300 hover:border-blue-500 hover:text-white font-bold rounded transition-all hover:-translate-y-1 flex items-center gap-2 group">
  MORE DETAILS
  <ArrowRight size={18} className="transition-transform group-hover:translate-x-1" />
</button>
```

#### Ghost Button (Minimal)

```tsx
<button className="px-8 py-4 border border-white/10 text-white hover:bg-white/5 font-bold rounded transition-all hover:-translate-y-1">
  CONTACT SUPPORT
</button>
```

#### Sign In Button (Accent Outlined)

```tsx
<button className="flex items-center gap-2 px-4 py-2 border border-blue-600/30 rounded text-blue-500 hover:bg-blue-600/10 transition-all text-sm uppercase tracking-widest font-bold">
  Sign In
</button>
```


### Cards

#### Feature Card

```tsx
<div className="bg-[#0f172a]/80 backdrop-blur-sm border border-white/5 p-8 rounded-2xl flex items-start gap-6 hover:border-blue-500/30 hover:bg-[#131c33] transition-all duration-300 group">
  <div className="shrink-0 w-16 h-16 bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-500 group-hover:text-blue-400 group-hover:scale-110 transition-all duration-300 shadow-[0_0_15px_rgba(37,99,235,0)] group-hover:shadow-[0_0_15px_rgba(37,99,235,0.2)]">
    <Shield size={32} />
  </div>
  <div>
    <h4 className="text-xl font-bold text-white mb-2 group-hover:text-blue-100 transition-colors">Title</h4>
    <p className="text-gray-400 text-sm leading-relaxed group-hover:text-gray-300 transition-colors">
      Description text
    </p>
  </div>
</div>
```

#### Product Card

```tsx
<div className="group relative bg-[#0f172a] rounded-2xl p-8 border border-white/5 hover:border-blue-500/50 transition-all duration-500 hover:bg-[#131c33] hover:-translate-y-2">
  {/* Image container */}
  <div className="relative h-64 mb-8 flex items-center justify-center overflow-hidden rounded-xl bg-black/40 group-hover:shadow-[inset_0_0_40px_rgba(37,99,235,0.1)] transition-all duration-500">
    <div className="absolute inset-0 bg-blue-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
    <img className="h-full w-full object-contain opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700 ease-out" />
  </div>
  {/* Content */}
  <div className="text-center">
    <h4 className="text-1xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">Name</h4>
    <p className="text-xs font-bold uppercase tracking-widest mb-4 text-blue-400 opacity-80">Tagline</p>
    <p className="text-gray-400 text-sm mb-8 line-clamp-2 leading-relaxed group-hover:text-gray-300 transition-colors">Description</p>
  </div>
</div>
```

#### Blog Card

```tsx
<div className="group relative bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-blue-500/50 transition-all duration-300 h-full flex flex-col">
  <div className="aspect-[16/9] overflow-hidden">
    <img className="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" />
  </div>
  <div className="p-6 flex flex-col flex-grow">
    <div className="flex items-center gap-4 mb-4 text-xs font-bold tracking-wider text-blue-400 uppercase">
      <span>Category</span>
      <span className="w-1 h-1 rounded-full bg-gray-600"></span>
      <span className="text-gray-500">Date</span>
    </div>
    <h3 className="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors">Title</h3>
    <p className="text-gray-400 mb-6 line-clamp-2 flex-grow">Excerpt</p>
    <a className="inline-flex items-center gap-2 text-sm font-bold text-white hover:text-blue-400 transition-colors mt-auto">
      READ ARTICLE <ArrowRight size={16} />
    </a>
  </div>
</div>
```

### Navigation

#### Fixed Navbar with Glassmorphism

```tsx
<nav className="fixed top-0 left-0 right-0 z-50 backdrop-blur-md bg-dermond-nav/80 border-b border-white/5">
  <div className="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
    {/* Content */}
  </div>
</nav>
```

#### Navigation Links

```tsx
<a className="hover:text-blue-500 transition-colors">HOME</a>
```

### Badges & Labels

#### Category Badge

```tsx
<div className="inline-block mb-4 px-4 py-1 rounded-full bg-blue-900/30 border border-blue-500/30 text-blue-400 text-sm font-bold tracking-widest uppercase">
  HIGHLIGHT ARTICLES
</div>
```

#### Small Tag Badge

```tsx
<div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-900/30 border border-blue-500/30 text-blue-400 text-xs font-bold tracking-widest uppercase">
  <Tag size={12} />
  Category
</div>
```


### Form Elements

#### Text Input

```tsx
<input 
  type="text" 
  placeholder="Ask about Freshcore Mist..."
  className="flex-1 bg-[#050a14] border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500"
/>
```

#### Icon Button

```tsx
<button className="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white p-2 rounded-lg transition-colors">
  <Send size={18} />
</button>
```

### Social Icons

```tsx
<a className="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all hover:-translate-y-1">
  <Facebook size={18} />
</a>
```

---

## 6. Shadows & Elevation

### Box Shadows

```css
/* Standard drop shadow */
drop-shadow-2xl

/* Button shadow */
shadow-lg shadow-blue-900/20
shadow-lg shadow-blue-600/30

/* Glow effects */
shadow-[0_0_15px_rgba(37,99,235,0)]      /* No glow (default) */
shadow-[0_0_15px_rgba(37,99,235,0.2)]    /* Subtle blue glow (hover) */
shadow-[0_0_30px_rgba(37,99,235,0.4)]    /* Strong blue glow */

/* Inset shadows */
shadow-[inset_0_0_40px_rgba(37,99,235,0.1)]  /* Inner glow on hover */

/* Card elevation */
shadow-2xl                               /* Floating elements */
```

### Blur Effects (Background Glows)

```css
/* Decorative background blurs */
blur-[100px]                             /* Large ambient glow */
blur-[120px]                             /* Hero background glow */
blur-3xl                                 /* Product detail glow */
blur-xl                                  /* Card background glow */

/* Glassmorphism */
backdrop-blur-md                         /* Navigation bar */
backdrop-blur-sm                         /* Cards */
```

### Elevation Hierarchy

1. **Base Layer**: `bg-[#050a14]` - Main background
2. **Surface Layer**: `bg-[#0a1226]` or `bg-[#0f172a]` - Cards, nav
3. **Elevated Layer**: `bg-[#131c33]` - Hover states
4. **Floating Layer**: Modals, tooltips with `shadow-2xl`

---

## 7. Animations & Transitions

### Transition Durations

```css
transition-colors                        /* Color changes only */
transition-all                           /* All properties */
transition-transform                     /* Transform only */
transition-opacity                       /* Opacity only */

duration-300                             /* Fast (default) */
duration-500                             /* Medium */
duration-700                             /* Slow */
duration-1000                            /* Very slow */
```

### Custom Keyframe Animations

#### Float Animation

```css
@keyframes float {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-15px); }
  100% { transform: translateY(0px); }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}
```

#### Slow Pulse

```css
animation: 'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite'
```

#### Glitch Effect (Hover)

```css
@keyframes glitch-anim {
  0% { transform: translate(0); }
  20% { transform: translate(-2px, 2px); }
  40% { transform: translate(-2px, -2px); }
  60% { transform: translate(2px, 2px); }
  80% { transform: translate(2px, -2px); }
  100% { transform: translate(0); }
}

.glitch-hover:hover {
  animation: glitch-anim 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both infinite;
  color: #2563eb;
}
```

### Scroll Reveal Animation

```css
.reveal {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.reveal.active {
  opacity: 1;
  transform: translateY(0);
}

/* Staggered delays */
.reveal-delay-100 { transition-delay: 100ms; }
.reveal-delay-200 { transition-delay: 200ms; }
.reveal-delay-300 { transition-delay: 300ms; }
.reveal-delay-400 { transition-delay: 400ms; }
.reveal-delay-500 { transition-delay: 500ms; }
```


### Hover Transforms

```css
/* Lift effect */
hover:-translate-y-1                     /* Subtle lift */
hover:-translate-y-2                     /* Card lift */

/* Scale effects */
hover:scale-105                          /* Subtle zoom */
hover:scale-110                          /* Image zoom */
group-hover:scale-110                    /* Icon scale */

/* Arrow slide */
group-hover:translate-x-1               /* Arrow icon slide */
group-hover:-translate-x-1              /* Back arrow slide */
```

### Easing Functions

```css
ease-out                                 /* Standard deceleration */
ease-in-out                              /* Smooth both ways */
cubic-bezier(0.16, 1, 0.3, 1)           /* Custom reveal easing */
cubic-bezier(0.25, 0.46, 0.45, 0.94)    /* Glitch easing */
```

---

## 8. Border Radius

### Border Radius Scale

```css
rounded                                  /* 4px - Buttons, inputs */
rounded-lg                               /* 8px - Input fields */
rounded-xl                               /* 12px - Image containers */
rounded-2xl                              /* 16px - Cards, modals */
rounded-3xl                              /* 24px - Large cards, product images */
rounded-full                             /* 9999px - Badges, avatars, icons */
rounded-sm                               /* 2px - Category grid items */
```

### Common Usage

| Element | Border Radius |
|---------|---------------|
| Buttons | `rounded` |
| Input fields | `rounded-lg` |
| Cards | `rounded-2xl` |
| Blog card images | `rounded-2xl` |
| Product images | `rounded-3xl` |
| Badges | `rounded-full` |
| Social icons | `rounded-full` |
| Chat bubbles | `rounded-2xl` with corner override |

### Chat Bubble Corners

```css
/* User message */
rounded-2xl rounded-tr-none

/* Bot message */
rounded-2xl rounded-tl-none
```

---

## 9. Opacity & Transparency

### Opacity Values

```css
opacity-0                                /* Hidden */
opacity-50                               /* Half visible */
opacity-80                               /* Slightly transparent */
opacity-90                               /* Nearly opaque */
opacity-100                              /* Fully visible */

/* Disabled state */
disabled:opacity-50
```

### Background Opacity Patterns

```css
/* White overlays */
bg-white/5                               /* Very subtle */
bg-white/10                              /* Light surface */

/* Black overlays */
bg-black/20                              /* Light overlay */
bg-black/40                              /* Medium overlay */
bg-black/90                              /* Heavy overlay */

/* Blue tints */
bg-blue-600/10                           /* Subtle blue */
bg-blue-600/20                           /* Light blue */
bg-blue-900/5                            /* Very subtle blue */
bg-blue-900/30                           /* Badge background */

/* Border opacity */
border-white/5                           /* Very subtle border */
border-white/10                          /* Light border */
border-blue-500/30                       /* Accent border */
border-blue-500/50                       /* Hover accent border */
```

### Text Opacity

```css
text-white/5                             /* Decorative text (watermark) */
text-white/80                            /* Slightly muted white */
```

---

## 10. Common Tailwind CSS Usage Patterns

### Layout Patterns

#### Centered Container

```tsx
<div className="max-w-7xl mx-auto px-6">
  {/* Content */}
</div>
```

#### Full-Height Page

```tsx
<div className="min-h-screen pt-32 pb-20 px-6">
  {/* Page content */}
</div>
```

#### Responsive Grid

```tsx
<div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
  {/* Grid items */}
</div>
```

#### Two-Column Layout

```tsx
<div className="grid lg:grid-cols-2 gap-16 items-center">
  {/* Left column */}
  {/* Right column */}
</div>
```


### Flexbox Patterns

#### Centered Content

```tsx
<div className="flex items-center justify-center">
  {/* Centered content */}
</div>
```

#### Space Between

```tsx
<div className="flex items-center justify-between">
  {/* Left content */}
  {/* Right content */}
</div>
```

#### Flex Column with Gap

```tsx
<div className="flex flex-col gap-4">
  {/* Stacked items */}
</div>
```

### Positioning Patterns

#### Fixed Navbar

```tsx
<nav className="fixed top-0 left-0 right-0 z-50">
```

#### Floating Action Button

```tsx
<div className="fixed bottom-6 right-6 z-50">
```

#### Absolute Overlay

```tsx
<div className="absolute inset-0 bg-black/40 z-10">
```

#### Centered Absolute

```tsx
<div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
```

### Responsive Breakpoints

| Breakpoint | Min Width | Usage |
|------------|-----------|-------|
| `sm:` | 640px | Small tablets |
| `md:` | 768px | Tablets |
| `lg:` | 1024px | Laptops |
| `xl:` | 1280px | Desktops |

#### Common Responsive Patterns

```tsx
/* Hide on mobile, show on desktop */
className="hidden md:flex"

/* Different grid columns */
className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3"

/* Responsive text size */
className="text-5xl md:text-7xl"

/* Responsive padding */
className="px-4 md:px-8"

/* Responsive flex direction */
className="flex flex-col md:flex-row"
```

### Z-Index Scale

| Value | Usage |
|-------|-------|
| `z-0` | Base layer |
| `z-10` | Overlays |
| `z-20` | Content above overlays |
| `z-30` | Borders, decorative |
| `z-40` | Mobile menu |
| `z-50` | Fixed elements (nav, FAB, modals) |

---

## 11. Icons

The project uses **Lucide React** for icons.

### Icon Sizes

```tsx
size={12}                                /* Tiny (badges) */
size={14}                                /* Small (inline) */
size={16}                                /* Default (buttons) */
size={18}                                /* Medium (nav, inputs) */
size={20}                                /* Standard (buttons) */
size={24}                                /* Large (nav icons) */
size={32}                                /* Feature icons */
```

### Common Icons Used

```tsx
import { 
  Menu, X,                               // Navigation
  ShoppingBag,                           // Cart
  ArrowRight, ArrowLeft,                 // Navigation arrows
  Shield, Zap, RefreshCcw, UserCheck,    // Features
  Facebook, Twitter, Instagram,          // Social
  MessageSquare, Send, Sparkles,         // Chat
  Calendar, Tag, Clock,                  // Blog metadata
  Droplet                                // Product features
} from 'lucide-react';
```

### Icon Button Pattern

```tsx
<button className="text-white hover:text-blue-500 transition-colors">
  <ShoppingBag size={24} />
</button>
```

---

## 12. Special Effects

### Glassmorphism

```tsx
<div className="backdrop-blur-md bg-dermond-nav/80 border border-white/5">
  {/* Content */}
</div>
```

### Glow Effects

```tsx
/* Background glow */
<div className="absolute w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none"></div>

/* Element glow on hover */
<div className="shadow-[0_0_15px_rgba(37,99,235,0)] group-hover:shadow-[0_0_15px_rgba(37,99,235,0.2)]">
```

### Vertical Text

```css
.vertical-text {
  writing-mode: vertical-rl;
  text-orientation: mixed;
}
```

```tsx
<span className="vertical-text text-8xl font-bold italic text-white/5 tracking-widest">
  DERMOND
</span>
```

### Custom Scrollbar

```css
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-track {
  background: #050a14;
}
::-webkit-scrollbar-thumb {
  background: #1e293b;
  border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
  background: #2563eb;
}
```

### Text Selection

```tsx
<div className="selection:bg-blue-500 selection:text-white">
  {/* Selectable content */}
</div>
```


### Line Clamping

```tsx
<p className="line-clamp-2">
  {/* Text will be truncated after 2 lines */}
</p>
```

### Mask Image Gradient

```tsx
<img 
  style={{ maskImage: 'linear-gradient(to bottom, black 85%, transparent 100%)' }}
  className="..."
/>
```

---

## 13. Scroll Animation Hook

The project uses a custom `useScrollAnimation` hook for reveal animations:

```tsx
import { useEffect, useRef, useState } from 'react';

export const useScrollAnimation = (threshold = 0.1) => {
  const ref = useRef<HTMLDivElement>(null);
  const [isVisible, setIsVisible] = useState(false);

  useEffect(() => {
    const element = ref.current;
    if (!element) return;

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setIsVisible(true);
          observer.disconnect();
        }
      },
      { threshold }
    );

    observer.observe(element);

    return () => {
      if (element) observer.unobserve(element);
    };
  }, [threshold]);

  return { ref, isVisible };
};
```

### Usage

```tsx
const { ref, isVisible } = useScrollAnimation(0.2);

return (
  <section ref={ref}>
    <div className={`reveal ${isVisible ? 'active' : ''}`}>
      {/* Content animates in when scrolled into view */}
    </div>
  </section>
);
```

---

## 14. Example Component Reference Designs

### Complete Feature Card Component

```tsx
import React from 'react';
import { Shield } from 'lucide-react';
import { useScrollAnimation } from '../hooks/useScrollAnimation';

interface FeatureCardProps {
  icon: React.ReactNode;
  title: string;
  description: string;
  index: number;
}

export const FeatureCard: React.FC<FeatureCardProps> = ({ 
  icon, 
  title, 
  description, 
  index 
}) => {
  const { ref, isVisible } = useScrollAnimation(0.2);

  return (
    <div 
      ref={ref}
      className={`
        bg-[#0f172a]/80 
        backdrop-blur-sm 
        border border-white/5 
        p-8 
        rounded-2xl 
        flex items-start gap-6 
        hover:border-blue-500/30 
        hover:bg-[#131c33] 
        transition-all duration-300 
        group 
        reveal ${isVisible ? 'active' : ''}
      `}
      style={{ transitionDelay: `${index * 100}ms` }}
    >
      {/* Icon Container */}
      <div className="
        shrink-0 
        w-16 h-16 
        bg-blue-600/10 
        rounded-2xl 
        flex items-center justify-center 
        text-blue-500 
        group-hover:text-blue-400 
        group-hover:scale-110 
        transition-all duration-300 
        shadow-[0_0_15px_rgba(37,99,235,0)] 
        group-hover:shadow-[0_0_15px_rgba(37,99,235,0.2)]
      ">
        {icon}
      </div>
      
      {/* Content */}
      <div>
        <h4 className="
          text-xl font-bold 
          text-white mb-2 
          group-hover:text-blue-100 
          transition-colors
        ">
          {title}
        </h4>
        <p className="
          text-gray-400 
          text-sm leading-relaxed 
          group-hover:text-gray-300 
          transition-colors
        ">
          {description}
        </p>
      </div>
    </div>
  );
};
```


### Complete Section Header Component

```tsx
import React from 'react';
import { ArrowRight } from 'lucide-react';

interface SectionHeaderProps {
  label: string;
  title: string;
  showLink?: boolean;
  linkText?: string;
  linkHref?: string;
  isVisible?: boolean;
}

export const SectionHeader: React.FC<SectionHeaderProps> = ({
  label,
  title,
  showLink = false,
  linkText = 'LEARN MORE',
  linkHref = '#',
  isVisible = true
}) => {
  return (
    <div className={`text-center mb-16 reveal ${isVisible ? 'active' : ''}`}>
      {/* Section Label */}
      <h2 className="text-gray-500 font-bold tracking-[0.2em] text-lg uppercase mb-2">
        {label}
      </h2>
      
      {/* Section Title */}
      <h3 className="text-3xl md:text-4xl font-bold text-white mb-6">
        {title}
      </h3>
      
      {/* Optional Link */}
      {showLink && (
        <a 
          href={linkHref} 
          className="
            inline-flex items-center gap-2 
            text-blue-500 text-sm font-bold tracking-wider 
            hover:text-blue-400 transition-colors 
            group
          "
        >
          {linkText} 
          <ArrowRight 
            size={16} 
            className="transition-transform group-hover:translate-x-1" 
          />
        </a>
      )}
    </div>
  );
};
```

### Complete CTA Banner Component

```tsx
import React from 'react';
import { useScrollAnimation } from '../hooks/useScrollAnimation';

interface CTABannerProps {
  label: string;
  title: string;
}

export const CTABanner: React.FC<CTABannerProps> = ({ label, title }) => {
  const { ref, isVisible } = useScrollAnimation(0.1);

  return (
    <div 
      ref={ref}
      className={`
        bg-[#0f172a] 
        rounded-2xl 
        p-10 
        flex flex-col md:flex-row items-center justify-between gap-8 
        border border-white/5 
        relative overflow-hidden 
        group 
        hover:border-blue-500/30 
        transition-colors 
        reveal ${isVisible ? 'active' : ''}
      `}
    >
      {/* Hover Gradient Overlay */}
      <div className="
        absolute inset-0 
        bg-gradient-to-r from-blue-900/10 to-transparent 
        opacity-0 group-hover:opacity-100 
        transition-opacity duration-700
      "></div>
      
      {/* Content */}
      <div className="relative z-10 text-center md:text-left">
        <p className="text-blue-500 text-xs font-bold tracking-[0.2em] uppercase mb-2">
          {label}
        </p>
        <h3 className="text-2xl font-bold text-white">
          {title}
        </h3>
      </div>
      
      {/* Decorative Elements */}
      <div className="flex gap-4 grayscale opacity-50 relative z-10">
        <div className="w-12 h-12 bg-white/10 rounded-full animate-pulse-slow"></div>
        <div className="w-12 h-12 bg-white/10 rounded-full animate-pulse-slow delay-75"></div>
        <div className="w-12 h-12 bg-white/10 rounded-full animate-pulse-slow delay-150"></div>
      </div>
    </div>
  );
};
```

---

## 15. Swiper Carousel Styling

The project uses Swiper.js for the hero carousel with custom styling:

```css
/* Pagination bullets */
.swiper-pagination-bullet {
  background: white;
  opacity: 0.5;
}
.swiper-pagination-bullet-active {
  background: #3b82f6 !important;
  opacity: 1;
}

/* Navigation arrows */
.swiper-button-next, .swiper-button-prev {
  color: white;
  opacity: 0.5;
  transition: opacity 0.3s;
}
.swiper-button-next:hover, .swiper-button-prev:hover {
  opacity: 1;
}
```

### Swiper Configuration

```tsx
<Swiper
  modules={[Autoplay, EffectFade, Pagination, Navigation]}
  effect={'fade'}
  fadeEffect={{ crossFade: true }}
  speed={1000}
  autoplay={{
    delay: 5000,
    disableOnInteraction: false,
  }}
  pagination={{
    clickable: true,
  }}
  navigation={true}
  loop={true}
>
  {/* Slides */}
</Swiper>
```

---

## 16. Prose Styling (Blog Content)

For rich text content, the project uses Tailwind Typography plugin classes:

```tsx
<div className="
  prose prose-lg prose-invert mx-auto 
  prose-headings:font-bold 
  prose-headings:text-white 
  prose-p:text-gray-300 
  prose-a:text-blue-400 
  hover:prose-a:text-blue-300 
  prose-strong:text-white 
  prose-li:text-gray-300
">
  {/* Rich HTML content */}
</div>
```

---

## 17. Aspect Ratios

```css
aspect-square                            /* 1:1 - Product images */
aspect-[16/9]                            /* 16:9 - Blog card images */
aspect-[21/9]                            /* 21:9 - Blog post hero */
```

---

## 18. Summary of Design Tokens

### Quick Reference

| Category | Primary Value |
|----------|---------------|
| Background | `#050a14` |
| Surface | `#0f172a` |
| Accent | `#2563eb` (blue-600) |
| Text Primary | `#ffffff` (white) |
| Text Secondary | `#9ca3af` (gray-400) |
| Text Muted | `#6b7280` (gray-500) |
| Border | `border-white/5` |
| Border Hover | `border-blue-500/30` |
| Font | Inter |
| Border Radius | `rounded-2xl` (cards) |
| Transition | `duration-300` |
| Navbar Height | `h-20` (80px) |

---

*This style guide was generated from the DERMOND Premium Intimate Care project codebase.*
