# Getting Started

Panduan setup project Dermond dari nol sampai running di local environment.

## Requirements

- PHP >= 8.4
- Composer
- Node.js >= 18
- MySQL (atau SQLite untuk development cepat)

## Installation

### 1. Clone & Install Dependencies

```bash
git clone <repo-url>
cd dermond

composer install
npm install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dan set konfigurasi berikut:

```env
# Database (pilih salah satu)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dermond
DB_USERNAME=root
DB_PASSWORD=secret

# Atau pakai SQLite untuk development cepat
DB_CONNECTION=sqlite
```

### 3. Database Migration & Seeding

```bash
php artisan migrate --seed
```

Seeder akan create:
- Admin account: `admin@dermond.local` / `password`
- Customer account: `customer@dermond.local` / `password`
- Sample products, categories, articles

### 4. Indonesia Location Data

Project ini pakai [Laravolt Indonesia](https://github.com/laravolt/indonesia) untuk data provinsi, kota, dan kecamatan:

```bash
php artisan laravolt:indonesia:seed
```

### 5. Storage Link

Untuk menampilkan uploaded images:

```bash
php artisan storage:link
```

### 6. Build Assets & Run

```bash
# Production build
npm run build

# Start server
php artisan serve
```

Atau untuk development dengan hot reload:

```bash
composer run dev
```

Command ini menjalankan PHP server, queue worker, log viewer, dan Vite dev server secara bersamaan.

## Environment Variables

### Core Application

| Variable | Description | Example |
| -------- | ----------- | ------- |
| `APP_NAME` | Nama aplikasi | `Dermond` |
| `APP_ENV` | Environment | `local`, `production` |
| `APP_URL` | Base URL | `http://localhost:8000` |

### Payment Gateway (Xendit)

| Variable | Description | Notes |
| -------- | ----------- | ----- |
| `PAYMENT_GATEWAY` | Active gateway | `xendit` |
| `XENDIT_ENVIRONMENT` | Mode | `sandbox` atau `production` |
| `XENDIT_SECRET_KEY` | API secret key | Dari Xendit dashboard |
| `XENDIT_PUBLIC_KEY` | Public key | Dari Xendit dashboard |
| `XENDIT_WEBHOOK_TOKEN` | Webhook verification | Untuk validasi callback |
| `XENDIT_INVOICE_DURATION` | Invoice expiry (seconds) | Default: `86400` (24 jam) |

### Shipping (RajaOngkir)

| Variable | Description | Notes |
| -------- | ----------- | ----- |
| `RAJAONGKIR_API_KEY` | API key | Dari RajaOngkir |
| `RAJAONGKIR_BASE_URL` | API endpoint | `https://rajaongkir.komerce.id/api/v1` |
| `RAJAONGKIR_ORIGIN_CITY_NAME` | Kota asal pengiriman | `BANDUNG` |

### Chatbot

| Variable | Description | Notes |
| -------- | ----------- | ----- |
| `CHATBOT_ACTIVE` | Enable/disable chatbot | `true` atau `false` |
| `CHATBOT_WEBHOOK_URL` | AI chatbot endpoint | URL webhook AI service |

### Cart & Checkout

| Variable | Description | Default |
| -------- | ----------- | ------- |
| `CART_TAX_RATE` | Tax percentage | `0.11` (11%) |
| `CART_PAYMENT_EXPIRY_HOURS` | Order expiry | `24` |
| `CART_CURRENCY` | Currency code | `IDR` |

## Xendit Sandbox Testing

Untuk testing payment di development:

1. Buat akun di [Xendit Dashboard](https://dashboard.xendit.co)
2. Aktifkan mode Sandbox
3. Copy API keys ke `.env`
4. Set webhook URL di Xendit dashboard: `{APP_URL}/webhooks/xendit`
5. Copy webhook verification token ke `XENDIT_WEBHOOK_TOKEN`

## Troubleshooting

### Vite Manifest Error

```
Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest
```

**Solusi:** Jalankan `npm run build` atau restart `npm run dev`.

### Images/Media Not Showing

**Solusi:** Pastikan sudah menjalankan `php artisan storage:link`.

### Queue Jobs Not Processing

Kalau pakai `QUEUE_CONNECTION=database`, pastikan queue worker running:

```bash
php artisan queue:work
```

Atau pakai `composer run dev` yang sudah include queue worker.

### Indonesia Data Missing

Error saat checkout karena data provinsi/kota kosong:

```bash
php artisan laravolt:indonesia:seed
```

## Next Steps

Setelah setup selesai:

- Baca [Architecture](architecture.md) untuk memahami struktur project
- Baca [Authentication](authentication.md) untuk memahami sistem login
- Baca [Payment](payment.md) untuk setup Xendit production
