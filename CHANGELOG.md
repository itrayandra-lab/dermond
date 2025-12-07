# Changelog

## 2025-12-08

### Added

-   Product features (JSON column) - dynamic key benefits displayed on product detail page
-   Hybrid hero slider system - can link to products or create custom banners
-   Hero slider shows product price with discount strikethrough
-   Admin slider form redesigned with product-first approach

### Changed

-   Homepage hero section now uses sliders table instead of featured products
-   Homepage "THE ULTIMATE COLLECTION" section uses featured products
-   Homepage "PRODUCTS" section shows all published products (limit 6)
-   Slider admin card shows product image fallback when no custom image uploaded

### Database

-   Migration: `add_features_to_products_table` - JSON features column
-   Migration: `add_hybrid_fields_to_sliders_table` - title, subtitle, description, cta_text, cta_link, product_id, badge_title, badge_subtitle

## 2025-12-07

### Changed

-   Beautylatory → Dermond rebrand complete (config, emails, seeders, controllers)
