# Progress: Dermond

## Session Goal
- Jadikan flow pembayaran Xendit-only dan singkirkan Midtrans.

## Current State
- ✅ Binding gateway ke `XenditService` (factory default xendit); checkout pakai gateway `xendit` dan redirect `payment_url`.
- ✅ Midtrans webhook route/handler dihapus; CSRF exemption hanya untuk Xendit; view order/pending/payment hanya render link Xendit dengan fallback jika `payment_url` kosong.
- ✅ Config default `PAYMENT_GATEWAY=xendit` (`config/cart.php`, `.env.example`); OrderSeeder ikut default baru.
- ⚠️ Midtrans package/config masih ada tapi tidak dipakai; belum ada test dijalankan setelah perubahan.

## Active Context (touched today)
- app/Providers/AppServiceProvider.php
- app/Services/Payment/PaymentGatewayFactory.php
- app/Http/Controllers/CheckoutController.php
- app/Http/Controllers/PaymentWebhookController.php
- app/Http/Middleware/VerifyCsrfToken.php
- config/cart.php
- routes/web.php
- resources/views/checkout/payment.blade.php
- resources/views/checkout/pending.blade.php
- resources/views/orders/show.blade.php
- app/Contracts/PaymentGatewayInterface.php
- app/Services/Payment/XenditService.php
- database/seeders/OrderSeeder.php
- .env.example
- README.md
- CHANGELOG.md

## Next Steps
1) Uji checkout sandbox Xendit end-to-end, pastikan redirect `payment_url` bekerja.
2) Trigger webhook Xendit sandbox ke `/payment/xendit/notification` dan verifikasi status order ter-update.
3) (Opsional) Bersihkan Midtrans: hapus `midtrans/midtrans-php`, `config/midtrans.php`, dan kode/panel terkait jika tidak diperlukan lagi.
