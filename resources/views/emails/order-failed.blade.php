<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran {{ $reason === 'expired' ? 'Kedaluwarsa' : 'Gagal' }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #050a14; -webkit-font-smoothing: antialiased;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #050a14;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #0f172a; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4); border: 1px solid rgba(255,255,255,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 50%, #ef4444 100%); padding: 50px 40px; text-align: center;">
                            <div style="width: 70px; height: 70px; background-color: rgba(255,255,255,0.15); border-radius: 50%; margin: 0 auto 20px; display: inline-block; line-height: 70px;">
                                <span style="font-size: 28px; color: #ffffff;">{{ $reason === 'expired' ? '⏰' : '✕' }}</span>
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">DERMOND</h1>
                            <p style="margin: 12px 0 0; color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 400;">Pembayaran {{ $reason === 'expired' ? 'Kedaluwarsa' : 'Gagal' }}</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 45px 40px 35px;">
                            <p style="margin: 0 0 20px; font-size: 16px; color: #ffffff; line-height: 1.6;">
                                Halo <strong>{{ $order->user->name }}</strong>,
                            </p>
                            
                            @if($reason === 'expired')
                            <p style="margin: 0 0 25px; font-size: 15px; color: #94a3b8; line-height: 1.7;">
                                Mohon maaf, pembayaran untuk pesanan kamu telah melewati batas waktu. Pesanan dibatalkan secara otomatis dan stok produk telah dikembalikan.
                            </p>
                            @else
                            <p style="margin: 0 0 25px; font-size: 15px; color: #94a3b8; line-height: 1.7;">
                                Mohon maaf, pembayaran untuk pesanan kamu tidak dapat diproses. Pesanan dibatalkan dan stok produk telah dikembalikan.
                            </p>
                            @endif

                            <!-- Order Info Card -->
                            <table role="presentation" style="width: 100%; margin-bottom: 25px; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 20px; background: rgba(239, 68, 68, 0.1); border-radius: 16px; border: 1px solid rgba(239, 68, 68, 0.3);">
                                        <p style="margin: 0 0 5px; font-size: 11px; color: #ef4444; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Nomor Pesanan (Dibatalkan)</p>
                                        <p style="margin: 0; font-size: 22px; color: #ffffff; font-weight: 700;">{{ $order->order_number }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Order Summary -->
                            <p style="margin: 0 0 15px; font-size: 11px; color: #3b82f6; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Ringkasan Pesanan</p>
                            <table role="presentation" style="width: 100%; margin-bottom: 25px; background-color: #0a1226; border-radius: 12px;">
                                <tr>
                                    <td style="padding: 15px 20px;">
                                        <table role="presentation" style="width: 100%;">
                                            <tr>
                                                <td style="padding: 5px 0; font-size: 14px; color: #64748b;">Jumlah Item</td>
                                                <td style="padding: 5px 0; font-size: 14px; color: #e2e8f0; text-align: right;">{{ $order->items->sum('quantity') }} produk</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; font-size: 14px; color: #64748b;">Total</td>
                                                <td style="padding: 5px 0; font-size: 14px; color: #e2e8f0; text-align: right;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Info Box -->
                            <div style="padding: 20px; background: rgba(234, 179, 8, 0.1); border-radius: 12px; margin-bottom: 30px; border-left: 4px solid #eab308;">
                                <p style="margin: 0; font-size: 14px; color: #eab308; line-height: 1.6;">
                                    <strong>Ingin memesan lagi?</strong><br>
                                    Produk yang kamu pilih mungkin masih tersedia. Silakan kunjungi website kami untuk membuat pesanan baru.
                                </p>
                            </div>

                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%; margin-bottom: 30px;">
                                <tr>
                                    <td style="text-align: center;">
                                        <a href="{{ route('products.index') }}" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; border-radius: 50px; letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);">
                                            Belanja Lagi
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #0a1226; text-align: center; border-top: 1px solid rgba(255,255,255,0.1);">
                            <p style="margin: 0 0 8px; font-size: 13px; color: rgba(255,255,255,0.9); font-weight: 500;">Dermond</p>
                            <p style="margin: 0; font-size: 12px; color: rgba(255,255,255,0.5); line-height: 1.6;">
                                Butuh bantuan? Hubungi kami di support@dermond.com
                            </p>
                        </td>
                    </tr>
                </table>

                <table role="presentation" style="max-width: 600px; margin: 25px auto 0;">
                    <tr>
                        <td style="text-align: center;">
                            <p style="margin: 0; font-size: 11px; color: #64748b;">© {{ date('Y') }} Dermond. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
