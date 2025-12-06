@php
    $supportEmail = \App\Models\SiteSetting::getValue('contact.support_email', 'support@beautylatory.com');
    $siteUrl = config('app.url');
    $siteName = \App\Models\SiteSetting::getValue('general.site_name', 'Beautylatory');
    $businessAddress = \App\Models\SiteSetting::getValue('contact.address', '');
    $contactPhone = \App\Models\SiteSetting::getValue('contact.phone', '');
@endphp

@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - Beautylatory')

@section('content')
    <div class="pt-28 pb-20 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-6 md:px-8 max-w-4xl">
            <div class="mb-8">
                <p class="text-xs font-bold tracking-widest text-primary uppercase mb-2">Kebijakan</p>
                <h1 class="text-4xl font-display font-medium text-gray-900">Syarat & Ketentuan</h1>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 prose prose-gray max-w-none">
                <p class="text-sm text-gray-500 mb-6">Terakhir diperbarui: 4 Desember 2025</p>

                <h2 class="text-xl font-display font-medium text-gray-900 mt-0">Refund Policy — Beautylatory</h2>
                <p>Di Beautylatory, kami berkomitmen memberikan produk berkualitas dan pengalaman belanja terbaik untuk
                    setiap pelanggan. Kebijakan refund ini dibuat untuk memastikan proses pengembalian dana dan produk
                    berjalan dengan jelas, aman, dan transparan.</p>

                <h3 class="text-lg font-display font-medium text-gray-900">1. Ketentuan Umum Refund</h3>
                <p>Beautylatory menerima permintaan refund hanya jika terjadi kondisi berikut:</p>
                <ul>
                    <li>Produk yang diterima rusak, cacat produksi, atau tidak berfungsi.</li>
                    <li>Produk yang diterima tidak sesuai dengan pesanan, misalnya salah warna, salah varian, atau salah
                        jumlah.</li>
                    <li>Produk yang diterima tidak asli/terindikasi palsu (berlaku untuk produk yang memiliki brand
                        authenticity).</li>
                </ul>
                <p>Refund tidak berlaku jika:</p>
                <ul>
                    <li>Kesalahan pembelian dari pihak customer (contoh: salah memilih varian, salah alamat).</li>
                    <li>Produk sudah digunakan, dibuka segelnya, atau tidak dalam kondisi original.</li>
                    <li>Customer melewati batas waktu pengajuan refund.</li>
                </ul>

                <h3 class="text-lg font-display font-medium text-gray-900">2. Batas Waktu Pengajuan</h3>
                <ul>
                    <li>Pengajuan refund harus dilakukan maksimal 2×24 jam (2 hari) setelah barang diterima.</li>
                    <li>Setelah batas waktu tersebut, refund tidak dapat diproses.</li>
                </ul>

                <h3 class="text-lg font-display font-medium text-gray-900">3. Bukti yang Harus Disiapkan oleh Customer</h3>
                <p>Untuk memproses permintaan refund, customer wajib mengirimkan:</p>
                <ul>
                    <li>Foto/video kondisi produk yang diterima (kerusakan/cacat).</li>
                    <li>Foto kemasan luar & dalam.</li>
                    <li>Foto label resi pengiriman.</li>
                    <li>Nomor invoice atau bukti pembelian lainnya.</li>
                </ul>
                <p>Bukti lengkap dikirimkan melalui:</p>
                <ul>
                    <li>Email: <a href="mailto:{{ $supportEmail }}" class="text-primary hover:underline">{{ $supportEmail }}</a></li>
                    <li>WhatsApp/Customer Service: @if($contactPhone)<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactPhone) }}" class="text-primary hover:underline" target="_blank">{{ $contactPhone }}</a>@else<span class="text-gray-500">-</span>@endif</li>
                </ul>

                <h3 class="text-lg font-display font-medium text-gray-900">4. Proses Verifikasi</h3>
                <p>Setelah customer mengirimkan bukti:</p>
                <ul>
                    <li>Tim Beautylatory akan memeriksa dan memverifikasi dalam waktu 1–3 hari kerja.</li>
                    <li>Jika permintaan refund disetujui, customer akan menerima konfirmasi via email/WhatsApp.</li>
                    <li>Jika ditolak, Beautylatory akan menginformasikan alasan penolakan secara jelas.</li>
                </ul>

                <h3 class="text-lg font-display font-medium text-gray-900">5. Pengembalian Produk</h3>
                <p>Dalam kasus tertentu, Beautylatory dapat meminta customer untuk mengembalikan produk yang bermasalah ke alamat kami:</p>
                <div class="bg-gray-50 p-4 rounded-xl my-4">
                    <p class="font-semibold text-gray-900 mb-2">{{ $siteName }} — Pengembalian Produk</p>
                    <p class="text-gray-600 text-sm">Alamat: {{ $businessAddress ?: '-' }}</p>
                    <p class="text-gray-600 text-sm">WhatsApp: @if($contactPhone)<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactPhone) }}" class="text-primary hover:underline" target="_blank">{{ $contactPhone }}</a>@else - @endif</p>
                </div>
                <p>Ketentuan pengembalian:</p>
                <ul>
                    <li>Produk harus dikirim kembali dalam kondisi original & lengkap.</li>
                    <li>Beautylatory menanggung ongkir pengembalian jika kesalahan berasal dari pihak kami.</li>
                    <li>Jika kesalahan berasal dari customer, biaya ongkir tidak ditanggung.</li>
                </ul>

                <h3 class="text-lg font-display font-medium text-gray-900">6. Metode Pengembalian Dana</h3>
                <p>Refund akan dikembalikan sesuai metode pembayaran:</p>
                <ul>
                    <li>Pembayaran via transfer bank → refund ke rekening bank customer.</li>
                    <li>Pembayaran via e-wallet → refund ke e-wallet customer.</li>
                    <li>Pembayaran via payment gateway → refund melalui gateway sesuai kebijakan provider.</li>
                </ul>
                <p>Estimasi waktu refund: 2–7 hari kerja setelah verifikasi disetujui.</p>

                <h3 class="text-lg font-display font-medium text-gray-900">7. Pertukaran Produk (Exchange)</h3>
                <p>Jika customer ingin menukar produk (bukan refund), Beautylatory dapat memberikan opsi exchange jika stok
                    tersedia. Ketentuan exchange mengikuti syarat dan bukti klaim sama seperti refund.</p>

                <h3 class="text-lg font-display font-medium text-gray-900">8. Kontak Customer Service</h3>
                <p>Jika memiliki pertanyaan atau ingin mengajukan refund, hubungi tim kami:</p>
                <ul>
                    <li>📧 Email: <a href="mailto:{{ $supportEmail }}" class="text-primary hover:underline">{{ $supportEmail }}</a></li>
                    <li>📱 WhatsApp: @if($contactPhone)<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactPhone) }}" class="text-primary hover:underline" target="_blank">{{ $contactPhone }}</a>@else - @endif</li>
                    <li>🌐 Website: <a href="{{ $siteUrl }}" class="text-primary hover:underline">{{ $siteUrl }}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
