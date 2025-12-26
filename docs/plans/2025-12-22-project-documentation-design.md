# Project Documentation Design

## Overview

Dokumentasi handover untuk project Dermond - e-commerce platform men's intimate care products. Target audience: semua level developer (backend, full-stack, dan yang baru kenal Laravel).

**Bahasa:** Mix (Indonesia untuk penjelasan, English untuk technical terms)

---

## Documentation Structure

```
README.md                          # Main index & quick start
docs/
├── getting-started.md             # Setup dari nol
├── architecture.md                # Project structure & patterns
├── authentication.md              # Dual guard system (web + admin)
├── products-catalog.md            # Products, categories, media library
├── cart-checkout.md               # Cart flow & checkout process
├── orders.md                      # Order lifecycle & statuses
├── payment.md                     # Xendit integration & webhooks
├── vouchers.md                    # Voucher/discount system
├── content-management.md          # Articles & sliders
├── integrations.md                # RajaOngkir, chatbot
├── frontend.md                    # Tailwind v4, Alpine.js, Blade components
├── testing.md                     # Test suite & coverage
└── troubleshooting.md             # Common issues & solutions
```

---

## Document Contents

### README.md (Main Index)

- Project overview (apa itu Dermond)
- Tech stack summary (PHP 8.4, Laravel 12, Tailwind v4, Alpine.js, Xendit, RajaOngkir)
- Quick start (3-5 commands untuk jalanin project)
- Default accounts table (admin & customer)
- Links ke semua docs detail

### docs/getting-started.md

- Requirements (PHP 8.4+, Composer, Node.js, MySQL)
- Installation steps:
  1. Clone & install (composer install, npm install)
  2. Environment setup (.env, app key, database, API keys)
  3. Database migrations & seeders
  4. Laravolt Indonesia seeder
  5. Build assets & run server
- Environment variables yang penting (Xendit, RajaOngkir, Chatbot mode)
- Troubleshooting setup (Vite manifest, storage link)

### docs/architecture.md

- Laravel 12 streamlined structure explanation
- Key directories breakdown (Services, Contracts, Controllers, Models)
- Design patterns:
  - Factory Pattern (Payment Gateway)
  - Service Layer (business logic separation)
  - Form Request Validation
- Database design notes (soft deletes, JSON columns, polymorphic relations)
- Dual authentication overview

### docs/authentication.md

- Dual guard system explanation (web vs admin)
- User roles (admin, content_manager, customer)
- Key middleware files
- Route protection examples
- Login flow & redirect logic

### docs/products-catalog.md

- Product model & relationships
- Category hierarchy
- Spatie Media Library untuk images
- Product features (JSON column structure)
- Soft deletes & reasoning

### docs/cart-checkout.md

- Cart implementation: session-based (guest) vs database (authenticated)
- Checkout flow steps: address → shipping → payment → voucher
- Shipping cost calculation via RajaOngkir
- Double-submit prevention mechanism

### docs/orders.md

- Order lifecycle diagram
- Order statuses (pending_payment, confirmed, shipped, delivered, cancelled, expired)
- OrderItem relationship
- Stock management (atomic updates untuk prevent race conditions)
- Order expiration (scheduled command)

### docs/payment.md

- Current gateway: Xendit Invoice API
- Payment flow (create invoice → redirect → webhook)
- Key files (XenditService, PaymentGatewayFactory, WebhookController)
- Webhook handling (signature verification, idempotency, atomic stock updates)
- Order statuses reference
- Legacy Midtrans note (code exists but disabled)

### docs/vouchers.md

- Voucher model & VoucherUsage tracking
- VoucherService validation logic
- Voucher application di checkout

### docs/content-management.md

- Articles system: categories, tags, scheduled publishing, rich text
- Sliders: hybrid system (product-linked atau custom banner)
- Trix editor usage

### docs/integrations.md

- RajaOngkir: shipping cost API, service class
- Chatbot: WhatsApp vs AI mode toggle, configuration

### docs/frontend.md

- Tailwind v4 CSS-first config (@theme directive)
- Dark theme color palette (dermond-dark, dermond-nav, dermond-card, etc.)
- Alpine.js patterns used
- Blade components location & examples
- Swiper.js untuk carousels

### docs/testing.md

- How to run tests (`php artisan test`, filters)
- Existing test coverage (Cart, Chatbot, Checkout, Orders)
- Factory usage in tests

### docs/troubleshooting.md

- Vite manifest error → npm run build
- Media/images not showing → storage link
- Payment webhook debugging tips
- Common development issues

---

## Implementation Notes

- Setiap doc harus bisa dibaca standalone
- Cross-reference antar docs pake relative links
- Code examples harus verified working
- Keep updated kalau ada perubahan significant
