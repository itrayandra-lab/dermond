# Dermond

E-commerce platform for men's intimate care products. Built with Laravel 12 and a dark, tech-inspired UI.

## Tech Stack

-   **Backend:** Laravel 12 / PHP 8.4
-   **Frontend:** Blade, Tailwind CSS v4, Alpine.js
-   **Database:** MySQL
-   **Payment:** Xendit Invoice (redirect)
-   **Media:** Spatie Media Library

## Requirements

-   PHP >= 8.4
-   Composer
-   Node.js >= 18
-   MySQL

## Installation

```bash
# Clone repository
git clone <repo-url>
cd dermond

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure database in .env, then:
php artisan migrate --seed

# Build assets
npm run build
```

## Development

```bash
# Start dev server with hot reload
composer run dev
```

This runs PHP server, queue listener, log viewer, and Vite dev server concurrently.

## Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TestName
```

## Features

-   Product catalog with categories & features
-   Shopping cart & checkout flow
-   Xendit payment gateway integration
-   Order management with status tracking
-   Customer account (profile, addresses, order history)
-   Admin panel (dark theme)
-   Article/blog system with categories
-   AI chatbot / WhatsApp toggle
-   Voucher system
-   RajaOngkir shipping integration

## Default Accounts

After seeding:

| Role     | Email                  | Password |
| -------- | ---------------------- | -------- |
| Admin    | admin@dermond.local    | password |
| Customer | customer@dermond.local | password |

## Project Structure

```
app/
├── Http/Controllers/     # Web & API controllers
├── Models/               # Eloquent models
├── Mail/                 # Email classes
└── Services/             # Business logic

resources/
├── views/                # Blade templates
│   ├── admin/            # Admin panel views
│   ├── components/       # Reusable components
│   └── ...               # Customer-facing views
├── js/                   # JavaScript (Alpine, Swiper)
└── css/                  # Tailwind CSS

database/
├── migrations/           # Database schema
├── seeders/              # Sample data
└── factories/            # Test factories
```

## Documentation

Dokumentasi lengkap untuk developer yang akan maintain project ini:

| Document | Deskripsi |
| -------- | --------- |
| [Getting Started](docs/getting-started.md) | Setup project dari nol, environment variables |
| [Architecture](docs/architecture.md) | Project structure, design patterns, database design |
| [Authentication](docs/authentication.md) | Dual guard system (customer & admin) |
| [Products & Catalog](docs/products-catalog.md) | Product management, categories, media library |
| [Cart & Checkout](docs/cart-checkout.md) | Shopping cart, checkout flow, shipping calculation |
| [Orders](docs/orders.md) | Order lifecycle, statuses, stock management |
| [Payment](docs/payment.md) | Xendit integration, webhooks, troubleshooting |
| [Vouchers](docs/vouchers.md) | Voucher/discount system |
| [Content Management](docs/content-management.md) | Articles, sliders, rich text |
| [Integrations](docs/integrations.md) | RajaOngkir, chatbot configuration |
| [Frontend](docs/frontend.md) | Tailwind v4, Alpine.js, Blade components |
| [Testing](docs/testing.md) | Test suite, factories, coverage |
| [Troubleshooting](docs/troubleshooting.md) | Common issues & solutions |

## License

Proprietary - All rights reserved.
