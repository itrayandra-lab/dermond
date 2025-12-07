@php
    $supportEmail = \App\Models\SiteSetting::getValue('contact.support_email', 'support@dermond.com');
    $siteUrl = config('app.url');
    $siteName = \App\Models\SiteSetting::getValue('general.site_name', 'Dermond');
    $businessAddress = \App\Models\SiteSetting::getValue('contact.address', '');
    $contactPhone = \App\Models\SiteSetting::getValue('contact.phone', '');
@endphp

@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - Dermond')

@section('content')
    <div class="pt-28 pb-20 bg-dermond-dark min-h-screen">
        <div class="container mx-auto px-6 md:px-8 max-w-4xl">
            <div class="mb-8">
                <p class="text-xs font-bold tracking-widest text-blue-400 uppercase mb-2">Kebijakan</p>
                <h1 class="text-4xl font-bold text-white">Syarat & Ketentuan</h1>
            </div>

            <div class="bg-dermond-card border border-white/10 p-6 md:p-8 rounded-2xl prose prose-invert max-w-none">
                <p class="text-sm text-gray-500 mb-6">Terakhir diperbarui: 4 Desember 2025</p>

                <h2 class="text-xl font-bold text-white mt-0">Refund Policy — Dermond</h2>
                <p class="text-gray-300">Di Dermond, kami berkomitmen memberikan produk berkualitas dan pengalaman belanja terbaik untuk
                    setiap pelanggan. Kebijakan refund ini dibuat untuk memastikan proses pengembalian dana dan produk
                    berjalan dengan jelas, aman, dan transparan.</p>

                <h3 class="text-lg font-bold text-white">1. Ketentuan Umum Refund</h3>
                <p class="text-gray-300">Dermond menerima permintaan refund hanya jika terjadi kondisi berikut:</p>
                <ul class="text-gray-300">
                    <li>Produk yang diterima rusak, cacat produksi, atau tidak berfungsi.</li>
                    <li>Produk yang diterima tidak sesuai dengan pesanan, misalnya salah warna, salah varian, atau salah
                        jumlah.</li>
                    <li>Produk yang diterima tidak asli/terindikasi palsu (berlaku untuk produk yang memiliki brand
                        authenticity).</li>
                </ul>
                <p class="text-gray-300">Refund tidak berlaku jika:</p>
                <ul class="text-gray-300">
                    <li>Kesalahan pembelian dari pihak customer (contoh: salah memilih varian, salah alamat).</li>
                    <li>Produk sudah digunakan, dibuka segelnya, atau tidak dalam kondisi original.</li>
                    <li>Customer melewati batas waktu pengajuan refund.</li>
                </ul>

                <h3 class="text-lg font-bold text-white">2. Batas Waktu Pengajuan</h3>
                <ul class="text-gray-300">
                    <li>Pengajuan refund harus dilakukan maksimal 2×24 jam (2 hari) setelah barang diterima.</li>
                    <li>Setelah batas waktu tersebut, refund tidak dapat diproses.</li>
                </ul>

                <h3 class="text-lg font-bold text-white">3. Bukti yang Harus Disiapkan oleh Customer</h3>
                <p class="text-gray-300">Untuk memproses permintaan refund, customer wajib mengirimkan:</p>
                <ul class="text-gray-300">
                    <li>Foto/video kondisi produk yang diterima (kerusakan/cacat).</li>
                    <li>Foto kemasan luar & dalam.</li>
                    <li>Foto label resi pengiriman.</li>
                    <li>Nomor invoice atau bukti pembelian lainnya.</li>
                </ul>
                <p class="text-gray-300">Bukti lengkap dikirimkan melalui:</p>
                <ul class="text-gray-300">
                    <li>Email: <a href="mailto:{{ $supportEmail }}" class="text-blue-400 hover:underline">{{ $supportEmail }}</a></li>
                    <li>WhatsApp/Customer Service: @if($contactPhone)<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactPhone) }}" class="text-blue-400 hover:underline" target="_blank">{{ $contactPhone }}</a>@else<span class="text-gray-500">-</span>@endif</li>
                </ul>

                <h3 class="text-lg font-bold text-white">4. Proses Verifikasi</h3>
                <p class="text-gray-300">Setelah customer mengirimkan bukti:</p>
                <ul class="text-gray-300">
                    <li>Tim Dermond akan memeriksa dan memverifikasi dalam waktu 1–3 hari kerja.</li>
                    <li>Jika permintaan refund disetujui, customer akan menerima konfirmasi via email/WhatsApp.</li>
                    <li>Jika ditolak, Dermond akan menginformasikan alasan penolakan secara jelas.</li>
                </ul>

                <h3 class="text-lg font-bold text-white">5. Pengembalian Produk</h3>
                <p class="text-gray-300">Dalam kasus tertentu, Dermond dapat meminta customer untuk mengembalikan produk yang bermasalah ke alamat kami:</p>
                <div class="bg-dermond-dark border border-white/10 p-4 rounded-xl my-4">
                    <p class="font-semibold text-white mb-2">{{ $siteName }} — Pengembalian Produk</p>
                    <p class="text-gray-400 text-sm">Alamat: {{ $businessAddress ?: '-' }}</p>
                    <p class="text-gray-400 text-sm">WhatsApp: @if($contactPhone)<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactPhone) }}" class="text-blue-400 hover:underline" target="_blank">{{ $contactPhone }}</a>@else - @endif</p>
                </div>
                <p class="text-gray-300">Ketentuan pengembalian:</p>
                <ul class="text-gray-300">
                    <li>Produk harus dikirim kembali dalam kondisi original & lengkap.</li>
                    <li>Dermond menanggung ongkir pengembalian jika kesalahan berasal dari pihak kami.</li>
                    <li>Jika kesalahan berasal dari customer, biaya ongkir tidak ditanggung.</li>
                </ul>

                <h3 class="text-lg font-bold text-white">6. Metode Pengembalian Dana</h3>
                <p class="text-gray-300">Refund akan dikembalikan sesuai metode pembayaran:</p>
                <ul class="text-gray-300">
                    <li>Pembayaran via transfer bank → refund ke rekening bank customer.</li>
                    <li>Pembayaran via e-wallet → refund ke e-wallet customer.</li>
                    <li>Pembayaran via payment gateway → refund melalui gateway sesuai kebijakan provider.</li>
                </ul>
                <p class="text-gray-300">Estimasi waktu refund: 2–7 hari kerja setelah verifikasi disetujui.</p>

                <h3 class="text-lg font-bold text-white">7. Pertukaran Produk (Exchange)</h3>
                <p class="text-gray-300">Jika customer ingin menukar produk (bukan refund), Dermond dapat memberikan opsi exchange jika stok
                    tersedia. Ketentuan exchange mengikuti syarat dan bukti klaim sama seperti refund.</p>

                <h3 class="text-lg font-bold text-white">8. Kontak Customer Service</h3>
                <p class="text-gray-300">Jika memiliki pertanyaan atau ingin mengajukan refund, hubungi tim kami:</p>
                <ul class="text-gray-300">
                    <li>📧 Email: <a href="mailto:{{ $supportEmail }}" class="text-blue-400 hover:underline">{{ $supportEmail }}</a></li>
                    <li>📱 WhatsApp: @if($contactPhone)<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactPhone) }}" class="text-blue-400 hover:underline" target="_blank">{{ $contactPhone }}</a>@else - @endif</li>
                    <li>🌐 Website: <a href="{{ $siteUrl }}" class="text-blue-400 hover:underline">{{ $siteUrl }}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
