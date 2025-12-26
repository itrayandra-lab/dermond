# Architecture

Overview arsitektur dan design patterns yang dipakai di project Dermond.

## Laravel 12 Streamlined Structure

Project ini menggunakan Laravel 12 yang punya struktur lebih streamlined dibanding versi sebelumnya:

| Aspek | Laravel 12 |
| ----- | ---------- |
| Middleware | Didaftarkan di `bootstrap/app.php`, bukan di folder `app/Http/Middleware/Kernel.php` |
| Console Kernel | Tidak ada `app/Console/Kernel.php` - commands auto-register |
| Providers | Didaftarkan di `bootstrap/providers.php` |
| Routes | Didefinisikan di `bootstrap/app.php` dengan `withRouting()` |

### bootstrap/app.php

File ini adalah pusat konfigurasi aplikasi:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'customer.auth' => \App\Http\Middleware\CustomerAuth::class,
            'chatbot.access' => \App\Http\Middleware\ChatbotAccessMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

## Project Structure

```
app/
├── Console/Commands/       # Custom artisan commands
├── Contracts/              # Interfaces
│   └── PaymentGatewayInterface.php
├── Http/
│   ├── Controllers/        # Web controllers
│   │   └── Admin/          # Admin panel controllers
│   ├── Middleware/         # Custom middleware
│   └── Requests/           # Form Request validation
├── Mail/                   # Email classes (Mailable)
├── Models/                 # Eloquent models (20+ models)
└── Services/               # Business logic layer
    ├── Payment/            # Payment gateway services
    ├── RajaOngkirService.php
    ├── VoucherService.php
    └── ChatbotWebhookService.php

resources/
├── views/
│   ├── admin/              # Admin panel views
│   ├── components/         # Reusable Blade components
│   ├── layouts/            # Master layouts
│   └── ...                 # Customer-facing views
├── js/                     # JavaScript (Alpine.js)
└── css/                    # Tailwind CSS

database/
├── migrations/             # 38+ migration files
├── seeders/                # Database seeders
└── factories/              # Model factories untuk testing
```

## Design Patterns

### 1. Factory Pattern - Payment Gateway

Project ini menggunakan Factory pattern untuk payment gateway, memudahkan switch antar provider tanpa mengubah controller code.

**Interface:** `app/Contracts/PaymentGatewayInterface.php`

```php
interface PaymentGatewayInterface
{
    public function createTransaction(Order $order): array;
    public function verifyNotification(array $data): bool;
    public function parseNotification(array $data): array;
    public function getTransactionStatus(string $orderId): ?array;
}
```

**Factory:** `app/Services/Payment/PaymentGatewayFactory.php`

```php
class PaymentGatewayFactory
{
    public function make(?string $gateway = null): PaymentGatewayInterface
    {
        $selected = $gateway ?? config('cart.default_gateway', 'xendit');

        return match ($selected) {
            'xendit', default => app(XenditService::class),
        };
    }
}
```

**Usage di Controller:**

```php
$gateway = app(PaymentGatewayFactory::class)->make();
$result = $gateway->createTransaction($order);
```

### 2. Service Layer Pattern

Business logic yang kompleks dipisahkan ke dalam Service classes, bukan di controller:

| Service | Purpose |
| ------- | ------- |
| `XenditService` | Payment processing via Xendit API |
| `MidtransService` | Payment processing via Midtrans (legacy, disabled) |
| `VoucherService` | Voucher validation & application |
| `RajaOngkirService` | Shipping cost calculation |
| `ChatbotWebhookService` | AI chatbot integration |

**Contoh VoucherService:**

```php
class VoucherService
{
    public function validate(string $code, float $subtotal): ValidationResult
    {
        // Validate voucher eligibility, usage limits, etc.
    }

    public function apply(Order $order, Voucher $voucher): void
    {
        // Apply discount and track usage
    }
}
```

### 3. Form Request Validation

Semua validation logic ada di Form Request classes, bukan inline di controller:

```
app/Http/Requests/
├── Auth/
│   └── LoginRequest.php
├── Checkout/
│   └── ProcessCheckoutRequest.php
├── StoreContactRequest.php
└── ...
```

**Contoh:**

```php
class ProcessCheckoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address_id' => ['required', 'exists:user_addresses,id'],
            'shipping_service' => ['required', 'string'],
            'payment_method' => ['required', 'in:bank_transfer,ewallet'],
        ];
    }
}
```

## Database Design

### Soft Deletes

Product model menggunakan soft deletes agar order history tetap intact meskipun product dihapus:

```php
class Product extends Model
{
    use SoftDeletes;
}
```

### JSON Columns

Product features disimpan sebagai JSON untuk flexibility:

```php
// Migration
$table->json('features')->nullable();

// Usage
$product->features = [
    ['icon' => 'shield', 'text' => 'Dermatologically tested'],
    ['icon' => 'leaf', 'text' => 'Natural ingredients'],
];
```

### Polymorphic Relations

Media (images) menggunakan Spatie Media Library dengan polymorphic relations:

```php
class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-images');
    }
}
```

## Key Models & Relationships

| Model | Key Relationships |
| ----- | ----------------- |
| `User` | hasMany: orders, addresses, carts |
| `Product` | belongsTo: category; morphMany: media |
| `Order` | belongsTo: user; hasMany: orderItems |
| `OrderItem` | belongsTo: order, product |
| `Cart` | belongsTo: user; hasMany: cartItems |
| `Article` | belongsTo: articleCategory; belongsToMany: tags |
| `Voucher` | hasMany: voucherUsages |

## Next Steps

- [Authentication](authentication.md) - Detail sistem dual guard
- [Payment](payment.md) - Detail integrasi Xendit
- [Products & Catalog](products-catalog.md) - Detail product management
