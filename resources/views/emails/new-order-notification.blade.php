<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Baru Masuk</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #050a14; -webkit-font-smoothing: antialiased;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #050a14;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #0f172a; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4); border: 1px solid rgba(255,255,255,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0a1226 0%, #1e3a5f 50%, #2563eb 100%); padding: 50px 40px; text-align: center;">
                            <div style="width: 70px; height: 70px; background-color: rgba(255,255,255,0.1); border-radius: 50%; margin: 0 auto 20px; display: inline-block; line-height: 70px;">
                                <span style="font-size: 28px; color: #ffffff;">🔔</span>
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">DERMOND</h1>
                            <p style="margin: 12px 0 0; color: rgba(255,255,255,0.85); font-size: 14px; font-weight: 400;">Order Baru Masuk!</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 45px 40px 35px;">
                            <p style="margin: 0 0 25px; font-size: 15px; color: #94a3b8; line-height: 1.7;">
                                Ada pesanan baru yang sudah dibayar dan perlu diproses.
                            </p>

                            <!-- Order & Customer Info -->
                            <table role="presentation" style="width: 100%; margin-bottom: 25px; border-collapse: collapse;">
                                <tr>
                                    <td style="width: 50%; padding-right: 10px; vertical-align: top;">
                                        <div style="padding: 20px; background: rgba(34, 197, 94, 0.1); border-radius: 16px; border: 1px solid rgba(34, 197, 94, 0.3); height: 100%;">
                                            <p style="margin: 0 0 5px; font-size: 11px; color: #22c55e; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Nomor Pesanan</p>
                                            <p style="margin: 0; font-size: 18px; color: #ffffff; font-weight: 700;">{{ $order->order_number }}</p>
                                        </div>
                                    </td>
                                    <td style="width: 50%; padding-left: 10px; vertical-align: top;">
                                        <div style="padding: 20px; background: rgba(37, 99, 235, 0.1); border-radius: 16px; border: 1px solid rgba(37, 99, 235, 0.3); height: 100%;">
                                            <p style="margin: 0 0 5px; font-size: 11px; color: #3b82f6; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Total Pembayaran</p>
                                            <p style="margin: 0; font-size: 18px; color: #ffffff; font-weight: 700;">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Customer Info -->
                            <p style="margin: 0 0 15px; font-size: 11px; color: #3b82f6; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Informasi Customer</p>
                            <table role="presentation" style="width: 100%; margin-bottom: 25px; background-color: #0a1226; border-radius: 12px;">
                                <tr>
                                    <td style="padding: 15px 20px;">
                                        <table role="presentation" style="width: 100%;">
                                            <tr>
                                                <td style="padding: 5px 0; font-size: 14px; color: #64748b; width: 120px;">Nama</td>
                                                <td style="padding: 5px 0; font-size: 14px; color: #ffffff; font-weight: 500;">{{ $order->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; font-size: 14px; color: #64748b;">Email</td>
                                                <td style="padding: 5px 0; font-size: 14px; color: #e2e8f0;">{{ $order->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; font-size: 14px; color: #64748b;">Telepon</td>
                                                <td style="padding: 5px 0; font-size: 14px; color: #e2e8f0;">{{ $order->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; font-size: 14px; color: #64748b;">Dibayar</td>
                                                <td style="padding: 5px 0; font-size: 14px; color: #e2e8f0;">{{ $order->paid_at?->format('d M Y, H:i') }} WIB</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Order Items -->
                            <p style="margin: 0 0 15px; font-size: 11px; color: #3b82f6; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Produk Dipesan</p>
                            <table role="presentation" style="width: 100%; margin-bottom: 20px; border-collapse: collapse;">
                                @foreach($order->items as $item)
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                        <p style="margin: 0; font-size: 14px; color: #ffffff; font-weight: 500;">{{ $item->product_name }}</p>
                                        <p style="margin: 4px 0 0; font-size: 13px; color: #64748b;">{{ $item->quantity }}x @ Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
                                    </td>
                                    <td style="padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: right;">
                                        <p style="margin: 0; font-size: 14px; color: #ffffff; font-weight: 600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- Shipping Info -->
                            <p style="margin: 0 0 15px; font-size: 11px; color: #3b82f6; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Pengiriman</p>
                            <table role="presentation" style="width: 100%; margin-bottom: 25px; background-color: #0a1226; border-radius: 12px;">
                                <tr>
                                    <td style="padding: 15px 20px;">
                                        <p style="margin: 0 0 8px; font-size: 14px; color: #ffffff; line-height: 1.6;">
                                            <strong>{{ strtoupper($order->shipping_courier ?? '-') }}</strong> - {{ $order->shipping_service ?? '-' }} (Est: {{ $order->shipping_etd ?? '-' }} hari)
                                        </p>
                                        <p style="margin: 0; font-size: 13px; color: #94a3b8; line-height: 1.6;">
                                            {{ $order->shipping_address }}<br>
                                            {{ $order->shipping_village ? $order->shipping_village.', ' : '' }}{{ $order->shipping_district ? $order->shipping_district.', ' : '' }}<br>
                                            {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%; margin-bottom: 30px;">
                                <tr>
                                    <td style="text-align: center;">
                                        <a href="{{ route('admin.orders.show', $order) }}" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; border-radius: 50px; letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);">
                                            Proses Pesanan
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #0a1226; text-align: center; border-top: 1px solid rgba(255,255,255,0.1);">
                            <p style="margin: 0 0 8px; font-size: 13px; color: rgba(255,255,255,0.9); font-weight: 500;">Dermond Admin</p>
                            <p style="margin: 0; font-size: 12px; color: rgba(255,255,255,0.5); line-height: 1.6;">
                                Email ini dikirim otomatis saat ada order baru yang sudah dibayar.
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
