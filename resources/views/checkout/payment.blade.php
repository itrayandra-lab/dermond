@extends('layouts.app')

@section('title', 'Pembayaran - Dermond')

@section('content')
    <div class="pt-32 pb-20 px-6 min-h-screen bg-dermond-dark">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <span class="text-blue-500 font-bold italic tracking-widest text-sm uppercase mb-2 block">Pembayaran</span>
                <h1 class="text-4xl font-black text-white">Selesaikan Pembayaran</h1>
                <p class="text-gray-500 mt-2">Order: {{ $order->order_number }}</p>
            </div>

            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 space-y-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                        <p class="text-3xl font-black text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                    @if($snapToken)
                        <button id="pay-button"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded font-bold transition-all hover:-translate-y-1 shadow-lg shadow-blue-900/20">
                            Bayar Sekarang
                        </button>
                    @else
                        <span class="text-sm text-red-400">Token pembayaran tidak tersedia. Silakan ulangi checkout.</span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-white/10">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-widest mb-2">Alamat Pengiriman</p>
                        <p class="text-gray-300 text-sm">
                            {{ $order->shipping_address }},
                            {{ $order->shipping_village ? $order->shipping_village.', ' : '' }}
                            {{ $order->shipping_district ? $order->shipping_district.', ' : '' }}
                            {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-widest mb-2">Kontak</p>
                        <p class="text-gray-300 text-sm">{{ $order->phone }}</p>
                        <p class="text-gray-300 text-sm">{{ $order->user?->email }}</p>
                    </div>
                </div>

                <p class="text-xs text-gray-500">
                    Snap by Midtrans akan muncul sebagai popup. Jangan tutup halaman ini sampai pembayaran selesai.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if($snapToken)
        <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
        <script>
            document.getElementById('pay-button').addEventListener('click', function () {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function () {
                        window.location.href = '{{ route('checkout.confirmation', ['order' => $order->id]) }}';
                    },
                    onPending: function () {
                        window.location.href = '{{ route('checkout.pending', ['order' => $order->id]) }}';
                    },
                    onError: function () {
                        window.location.href = '{{ route('checkout.error') }}';
                    },
                    onClose: function () {
                        window.showToast?.('Pembayaran belum selesai. Kamu bisa coba lagi dari riwayat pesanan.', 'error');
                    }
                });
            });
        </script>
    @endif
@endsection
