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
