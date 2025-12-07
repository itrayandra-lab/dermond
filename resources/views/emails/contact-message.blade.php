<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru dari Contact Form</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #050a14; -webkit-font-smoothing: antialiased;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #050a14;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #0f172a; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4); border: 1px solid rgba(255,255,255,0.1);">
                    
                    <!-- Header with Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0a1226 0%, #1e3a5f 50%, #2563eb 100%); padding: 50px 40px; text-align: center;">
                            <table role="presentation" style="width: 100%;">
                                <tr>
                                    <td style="text-align: center;">
                                        <div style="width: 70px; height: 70px; background-color: rgba(255,255,255,0.1); border-radius: 50%; margin: 0 auto 20px; display: inline-block; line-height: 70px;">
                                            <span style="font-size: 28px; color: #ffffff;">✉</span>
                                        </div>
                                        <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">DERMOND</h1>
                                        <p style="margin: 12px 0 0; color: rgba(255,255,255,0.85); font-size: 14px; font-weight: 400; letter-spacing: 0.5px;">Pesan Baru dari Contact Form</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 45px 40px 35px;">
                            
                            <!-- Sender Card -->
                            <table role="presentation" style="width: 100%; margin-bottom: 30px; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 25px; background-color: #0a1226; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                                        <table role="presentation" style="width: 100%;">
                                            <tr>
                                                <td style="width: 55px; vertical-align: top;">
                                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); border-radius: 50%; text-align: center; line-height: 50px;">
                                                        <span style="color: #ffffff; font-size: 20px; font-weight: 600;">{{ strtoupper(substr($contactMessage->name, 0, 1)) }}</span>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <p style="margin: 0 0 2px; font-size: 11px; color: #3b82f6; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Pengirim</p>
                                                    <p style="margin: 0; font-size: 18px; color: #ffffff; font-weight: 700;">{{ $contactMessage->name }}</p>
                                                    <p style="margin: 6px 0 0; font-size: 14px;">
                                                        <a href="mailto:{{ $contactMessage->email }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;">{{ $contactMessage->email }}</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Subject -->
                            <table role="presentation" style="width: 100%; margin-bottom: 25px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 10px; font-size: 11px; color: #3b82f6; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Subjek</p>
                                        <p style="margin: 0; font-size: 20px; color: #ffffff; font-weight: 700; line-height: 1.4;">{{ $contactMessage->subject }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <table role="presentation" style="width: 100%; margin-bottom: 25px;">
                                <tr>
                                    <td style="height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.1), transparent);"></td>
                                </tr>
                            </table>

                            <!-- Message -->
                            <table role="presentation" style="width: 100%; margin-bottom: 35px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 15px; font-size: 11px; color: #3b82f6; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">Isi Pesan</p>
                                        <div style="padding: 25px; background-color: #0a1226; border-radius: 16px; border-left: 4px solid #2563eb;">
                                            <p style="margin: 0; font-size: 15px; color: #e2e8f0; line-height: 1.8; white-space: pre-wrap;">{{ $contactMessage->message }}</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%; margin-bottom: 35px;">
                                <tr>
                                    <td style="text-align: center;">
                                        <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ $contactMessage->subject }}" 
                                           style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; border-radius: 50px; letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);">
                                            Balas Pesan Ini
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Meta Info -->
                            <table role="presentation" style="width: 100%; background-color: #0a1226; border-radius: 12px; padding: 0;">
                                <tr>
                                    <td style="padding: 18px 20px;">
                                        <table role="presentation" style="width: 100%;">
                                            <tr>
                                                <td style="width: 50%;">
                                                    <p style="margin: 0; font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Waktu</p>
                                                    <p style="margin: 4px 0 0; font-size: 13px; color: #94a3b8; font-weight: 500;">{{ $contactMessage->created_at->format('d M Y, H:i') }} WIB</p>
                                                </td>
                                                @if($contactMessage->ip_address)
                                                <td style="width: 50%; text-align: right;">
                                                    <p style="margin: 0; font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">IP Address</p>
                                                    <p style="margin: 4px 0 0; font-size: 13px; color: #94a3b8; font-weight: 500;">{{ $contactMessage->ip_address }}</p>
                                                </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #0a1226; text-align: center; border-top: 1px solid rgba(255,255,255,0.1);">
                            <p style="margin: 0 0 8px; font-size: 13px; color: rgba(255,255,255,0.9); font-weight: 500;">
                                Dermond
                            </p>
                            <p style="margin: 0; font-size: 12px; color: rgba(255,255,255,0.5); line-height: 1.6;">
                                Email ini dikirim otomatis dari website.<br>
                                Klik tombol di atas atau balas email ini untuk merespons.
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Bottom Branding -->
                <table role="presentation" style="max-width: 600px; margin: 25px auto 0;">
                    <tr>
                        <td style="text-align: center;">
                            <p style="margin: 0; font-size: 11px; color: #64748b;">
                                © {{ date('Y') }} Dermond. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
