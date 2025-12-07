# Dermond

E-commerce platform for men's intimate care products. Built with Laravel 12 and a dark, tech-inspired UI.

## Tech Stack

-   **Backend:** Laravel 12 / PHP 8.4
-   **Frontend:** Blade, Tailwind CSS v4, Alpine.js
-   **Database:** MySQL
-   **Payment:** Midtrans Snap
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
-   Midtrans payment gateway integration
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

## License

Proprietary - All rights reserved.
