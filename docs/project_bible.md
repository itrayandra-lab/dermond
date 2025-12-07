# Project Bible - Dermond

## Project Identity

-   **Name**: Dermond
-   **Purpose**: E-commerce platform for men's intimate care products
-   **Theme**: Dark, tech-inspired UI (converted from Beautylatory light/feminine theme)
-   **User Persona**: Modern men seeking premium intimate hygiene products
-   **Source Reference**: React source at `temp/dermond-intimate-care (1)/` for design matching

## Tech Stack

### Backend

-   PHP 8.4.13
-   Laravel 12 (streamlined structure since Laravel 11)
-   MySQL (database-backed sessions/auth)

### Frontend

-   Blade templates
-   Tailwind CSS v4 (CSS-first config with `@theme`, `@import "tailwindcss"`)
-   Alpine.js v3 (with collapse plugin)
-   Swiper JS (hero slider - fade effect, autoplay, navigation, pagination)
-   Vite (bundler)
-   Inter font (Google Fonts) - NO custom fonts

### Key Packages

-   `laravel/pint` - code formatting
-   `phpunit/phpunit` v11 - testing
-   `cviebrock/eloquent-sluggable` - product slugs

## Architecture & Patterns

### File Structure

-   `app/` - Controllers, Models, Form Requests, Services
-   `resources/views/` - Blade templates
-   `resources/js/app.js` - JS entry (Alpine, Swiper modules exposed to window)
-   `resources/css/app.css` - Tailwind theme + custom styles
-   `routes/web.php`, `routes/api.php` - routing
-   `bootstrap/app.php` - middleware registration

### Data Flow

-   Form Requests for validation
-   Eloquent relationships (no raw queries)
-   Factories for test data
-   Named routes with `route()` helper

### Component Structure

-   `resources/views/components/` - Blade components
    -   `header.blade.php` - Dermond dark nav
    -   `footer.blade.php` - Dermond dark footer
    -   `floating-chat.blade.php` - AI chatbot (dark theme)
    -   `product-card.blade.php` - Dark card with blue accents
    -   `article-card.blade.php` - Dark card matching React BlogCard

## Design System (Dermond Theme)

### Colors (defined in @theme)

```css
--color-dermond-dark: #050a14      /* Main background */
--color-dermond-nav: #0a1226       /* Nav/chat container */
--color-dermond-card: #0f172a      /* Card backgrounds */
--color-dermond-card-hover: #131c33
--color-dermond-accent: #2563eb    /* Blue primary */
--color-dermond-text: #e2e8f0      /* Light text */
```

### Fonts

-   Primary: Inter (Google Fonts)
-   Fallbacks: ui-sans-serif, system-ui, sans-serif
-   NO Milliard/Roden fonts (removed)

## THE RULES (Anti-Patterns)

### Laravel

-   NEVER use `env()` outside config files - use `config()`
-   NEVER use raw `DB::` queries - use Eloquent
-   ALWAYS use Form Requests for validation
-   ALWAYS run `vendor/bin/pint --dirty` before committing

### Tailwind v4

-   NO `tailwind.config.js` - use `@theme` in CSS
-   NO deprecated utilities (`bg-opacity-*` → `bg-black/*`)
-   Use `@import "tailwindcss"` not `@tailwind` directives

### Frontend

-   NO Splide.js - use Swiper JS (migrated)
-   NO custom fonts (Milliard/Roden removed) - use Inter only
-   NO `public/css`, `public/js`, `public/fonts` directories (deleted)
-   Swiper config: fade effect, crossFade, 1000ms speed, 5s autoplay
-   Alpine.js for interactivity (x-data, x-show, etc.)
-   Swiper modules must be exposed to window: `window.SwiperModules`

### Testing

-   Use PHPUnit (not Pest)
-   Use factories, not raw inserts
-   Run `php artisan test --filter=MethodName` for focused tests

## Key Files Reference

### Homepage

-   `resources/views/home/index.blade.php` - 5 sections (Hero, Category Grid, Blog, Products, Features)
-   Controller passes: `$heroProducts`, `$phytosyncProducts`, `$editorialArticles`, `$products`

### JS Entry

-   `resources/js/app.js` - imports Alpine, Swiper modules, exposes to window

### CSS

-   `resources/css/app.css` - Tailwind theme, animations, Swiper styles (cleaned up, no font-face)

### React Source (for reference)

-   `temp/dermond-intimate-care (1)/src/pages/` - HomePage, BlogPage, ProductDetailPage
-   `temp/dermond-intimate-care (1)/components/` - BlogCard, ProductShowcase, Hero
-   `temp/dermond-intimate-care (1)/STYLE_GUIDE.md` - Comprehensive design system documentation

## Styling Patterns (Learned)

### Dark Theme Form Elements

```blade
{{-- Input/Select --}}
class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"

{{-- Checkbox --}}
class="w-4 h-4 rounded border-white/20 bg-dermond-dark text-blue-500 focus:ring-blue-500"
```

### Dark Theme Cards/Panels

```blade
{{-- Card --}}
class="bg-dermond-card border border-white/10 rounded-2xl p-6"

{{-- Selected State --}}
class="border-blue-500/50 bg-blue-900/20"

{{-- Hover State --}}
class="hover:border-blue-500/50 transition-colors"
```

### Alert/Message Boxes

```blade
{{-- Success --}}
class="bg-green-900/30 text-green-400 border border-green-500/30"

{{-- Error --}}
class="bg-red-900/30 text-red-400 border border-red-500/30"

{{-- Warning/Pending --}}
class="bg-yellow-900/30 text-yellow-400 border border-yellow-500/30"
```

### Text Formatting

-   Long descriptions: use `whitespace-pre-line` to preserve line breaks
-   NEVER use `text-align: justify` on long text - causes readability issues
-   Use `text-lg` or `text-base` for body text, not `text-xl`

### Email Templates

-   Located in `resources/views/emails/`
-   Use inline CSS only (email clients don't support external CSS/Tailwind)
-   Dark theme colors: `#050a14` (body bg), `#0f172a` (card bg), `#0a1226` (nav/footer)
-   Blue accent: `#2563eb`, `#3b82f6`
-   Text: `#ffffff` (headings), `#e2e8f0` (body), `#94a3b8` (muted), `#64748b` (labels)

## Conversion Status

### ✅ Customer-Facing Pages (All Dark Theme)

-   Homepage, Header, Footer, Floating Chat
-   Products (index, show, card)
-   Articles (index, show, category, card)
-   Cart (index, cart-item)
-   Checkout (form, payment, confirmation, pending, error)
-   Auth (login, register)
-   Customer (dashboard, profile/show, profile/edit)
-   Orders (index, show)
-   Addresses (index)
-   Contact, Terms
-   Email templates (5 files)

### ✅ Admin Panel (Converted to Dark Theme)

-   `admin/layouts/app.blade.php` - Master layout (sidebar dark, blue accent)
-   `admin/dashboard.blade.php` - Stats cards, quick actions
-   `admin/orders/index.blade.php`, `show.blade.php` - Order management
-   `admin/products/index.blade.php`, `form.blade.php`, `trash.blade.php` - Product CRUD
-   `admin/articles/index.blade.php`, `form.blade.php`, `show.blade.php` - Article CRUD
-   `admin/profile/show.blade.php`, `edit.blade.php` - Admin profile

### 🗑️ Deleted (Unused)

-   `admin/auth/login.blade.php` - Auth is unified at `/login` for all users

### ⏭️ Admin Panel (Skipped - Light Theme)

-   `admin/expert-quotes/` - create, edit, form (3 files) - skipped per user request

## Admin Panel Styling Patterns

### Layout Structure

```blade
{{-- Body --}}
class="bg-dermond-dark text-dermond-text"

{{-- Sidebar --}}
class="bg-dermond-nav border-r border-white/5"

{{-- Active nav item --}}
class="bg-gradient-to-r from-blue-500/10 to-transparent text-blue-400 border-l-2 border-blue-500"

{{-- Main content area --}}
class="lg:pl-72 bg-dermond-dark"
```

### Admin Table Pattern

```blade
{{-- Table container --}}
class="bg-dermond-card border border-white/10 rounded-2xl overflow-hidden"

{{-- Table header --}}
class="border-b border-white/10 bg-white/5"
class="text-xs font-bold text-gray-500 uppercase tracking-widest"

{{-- Table row hover --}}
class="hover:bg-white/5 transition-colors"

{{-- Table dividers --}}
class="divide-y divide-white/5"
```

### Admin Form Pattern

```blade
{{-- Form card --}}
class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8"

{{-- Input --}}
class="bg-dermond-dark border border-white/10 rounded-xl text-white placeholder-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"

{{-- Select --}}
class="bg-dermond-dark border border-white/10 rounded-xl text-gray-300 appearance-none"

{{-- Radio/Checkbox selected state --}}
class="bg-blue-500/10 border-blue-500/30"
```

### Admin Button Pattern

```blade
{{-- Primary --}}
class="bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs shadow-lg shadow-blue-900/30"

{{-- Secondary --}}
class="bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:border-white/20 rounded-xl"

{{-- Action icon --}}
class="w-10 h-10 rounded-xl text-gray-400 hover:text-blue-400 hover:bg-blue-500/10"
```
