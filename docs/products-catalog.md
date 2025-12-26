# Products & Catalog

Dokumentasi sistem product catalog di Dermond.

## Overview

Product catalog terdiri dari:
- **Products** - Item yang dijual
- **Categories** - Pengelompokan products
- **Media** - Product images via Spatie Media Library

## Product Model

File: `app/Models/Product.php`

### Attributes

| Field | Type | Description |
| ----- | ---- | ----------- |
| `name` | string | Nama product |
| `slug` | string | URL-friendly name (auto-generated) |
| `category_id` | int | Foreign key ke Category |
| `price` | int | Harga normal (dalam Rupiah) |
| `discount_price` | int/null | Harga diskon (optional) |
| `stock` | int | Stok tersedia |
| `weight` | int | Berat dalam gram (untuk ongkir) |
| `status` | string | `published` atau `draft` |
| `is_featured` | bool | Tampil di featured section |
| `description` | text | Deskripsi product |
| `features` | json | Array fitur product |
| `lynk_id_link` | string/null | External link (optional) |

### Features JSON Structure

Product features disimpan sebagai JSON array:

```php
$product->features = [
    ['icon' => 'shield', 'text' => 'Dermatologically tested'],
    ['icon' => 'leaf', 'text' => 'Natural ingredients'],
    ['icon' => 'droplet', 'text' => 'pH balanced formula'],
];
```

### Key Methods

```php
// Get current selling price (considers discount)
$product->getCurrentPrice();

// Check if product has discount
$product->hasDiscount();

// Get discount percentage
$product->getDiscountPercentage(); // Returns 20 for 20% off

// Check stock availability
$product->isInStock($quantity = 1);

// Get product image URL
$product->getImageUrl();

// Check if product has image
$product->hasImage();
```

### Query Scopes

```php
// Published products only
Product::published()->get();

// Featured products only
Product::featured()->get();

// Order by newest
Product::orderedByNewest()->get();

// Combine scopes
Product::published()->featured()->get();
```

### Soft Deletes

Product menggunakan soft deletes untuk menjaga integritas order history:

```php
use SoftDeletes;
```

Ketika product dihapus:
- Record tetap ada di database dengan `deleted_at` timestamp
- Order history tetap bisa menampilkan nama product
- Product otomatis dihapus dari semua cart

```php
protected static function booted(): void
{
    static::deleted(function (Product $product) {
        // Auto-remove from carts when product is soft-deleted
        CartItem::where('product_id', $product->id)->delete();
    });
}
```

### Slug Generation

Slug otomatis di-generate dari nama menggunakan `cviebrock/eloquent-sluggable`:

```php
use Sluggable;

public function sluggable(): array
{
    return [
        'slug' => [
            'source' => 'name',
            'onUpdate' => false, // Slug tidak berubah saat update
        ],
    ];
}
```

## Category Model

File: `app/Models/Category.php`

### Attributes

| Field | Type | Description |
| ----- | ---- | ----------- |
| `name` | string | Nama category |
| `slug` | string | URL-friendly name |
| `status` | string | `active` atau `inactive` |

### Relationships

```php
// Get all products in category
$category->products;

// Get published products only
$category->products()->where('status', 'published')->get();
```

## Media Library

Project ini menggunakan [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary) untuk image management.

### Media Collection

Product images menggunakan single file collection:

```php
public function registerMediaCollections(): void
{
    $this->addMediaCollection('product_images')
        ->singleFile(); // Only one image per product
}
```

### Upload Image

```php
// From request file
$product->addMediaFromRequest('image')
    ->toMediaCollection('product_images');

// From path
$product->addMedia('/path/to/image.jpg')
    ->toMediaCollection('product_images');

// From URL
$product->addMediaFromUrl('https://example.com/image.jpg')
    ->toMediaCollection('product_images');
```

### Get Image

```php
// Get URL
$url = $product->getImageUrl();

// Get responsive HTML img tag
$html = $product->getImage();

// Check if has image
if ($product->hasImage()) {
    // ...
}
```

### In Blade

```blade
{{-- Simple image --}}
@if($product->hasImage())
    <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}">
@else
    <img src="/images/placeholder.jpg" alt="No image">
@endif

{{-- Responsive image with srcset --}}
{!! $product->getImage() !!}
```

## Admin CRUD

### Controller

File: `app/Http/Controllers/Admin/ProductController.php`

### Routes

```php
Route::resource('products', ProductController::class);
```

| Method | URI | Action |
| ------ | --- | ------ |
| GET | /admin/products | index |
| GET | /admin/products/create | create |
| POST | /admin/products | store |
| GET | /admin/products/{product}/edit | edit |
| PUT | /admin/products/{product} | update |
| DELETE | /admin/products/{product} | destroy |

### Create Product

```php
$product = Product::create([
    'name' => 'Product Name',
    'category_id' => 1,
    'price' => 150000,
    'discount_price' => 120000,
    'stock' => 100,
    'weight' => 200,
    'status' => 'published',
    'is_featured' => true,
    'description' => 'Product description',
    'features' => [
        ['icon' => 'shield', 'text' => 'Feature 1'],
    ],
]);

// Add image
if ($request->hasFile('image')) {
    $product->addMediaFromRequest('image')
        ->toMediaCollection('product_images');
}
```

### Update Product

```php
$product->update([
    'name' => 'Updated Name',
    'price' => 175000,
]);

// Replace image
if ($request->hasFile('image')) {
    $product->clearMediaCollection('product_images');
    $product->addMediaFromRequest('image')
        ->toMediaCollection('product_images');
}
```

### Delete Product

```php
$product->delete(); // Soft delete
```

Untuk permanent delete (jarang dibutuhkan):

```php
$product->forceDelete();
```

## Frontend Display

### Product List

```php
// Controller
$products = Product::query()
    ->published()
    ->with('category', 'media')
    ->orderedByNewest()
    ->paginate(12);
```

### Product Detail

```php
// Controller
$product = Product::query()
    ->published()
    ->where('slug', $slug)
    ->with('category', 'media')
    ->firstOrFail();
```

### Featured Products (Homepage)

```php
$featured = Product::query()
    ->published()
    ->featured()
    ->with('media')
    ->limit(4)
    ->get();
```

## Next Steps

- [Cart & Checkout](cart-checkout.md) - Shopping cart flow
- [Orders](orders.md) - Order management
- [Content Management](content-management.md) - Articles & sliders
