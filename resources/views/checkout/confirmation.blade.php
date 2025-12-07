@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan - Dermond')

@section('content')
    <div class="pt-32 pb-20 px-6 min-h-screen bg-dermond-dark">
        <div class="max-w-3xl mx-auto">
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-8 space-y-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 text-green-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-black text-white mb-2">Pesanan Berhasil</h1>
                    <p class="text-gray-400">Order {{ $order->order_number }} telah tercatat.</p>
                    <p class="text-sm text-gray-500 mt-1">Status pembayaran: <span class="text-blue-400 font-medium">{{ ucfirst($order->payment_status) }}</span></p>
                </div>

                <div class="border border-white/10 rounded-xl p-4 bg-white/5">
                    <div class="flex justify-between text-sm mb-3">
                        <span class="text-gray-400">Total</span>
                        <span class="font-bold text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-sm text-gray-400">
                        <span class="text-gray-500 text-xs uppercase tracking-widest block mb-1">Alamat Pengiriman</span>
                        {{ $order->shipping_address }},
                        {{ $order->shipping_village ? $order->shipping_village.', ' : '' }}
                        {{ $order->shipping_district ? $order->shipping_district.', ' : '' }}
                        {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('customer.dashboard') }}" 
                       class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded font-bold transition-all hover:-translate-y-1 shadow-lg shadow-blue-900/20">
                        Dashboard
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="flex-1 text-center border border-white/10 text-white px-6 py-4 rounded font-bold hover:bg-white/5 transition-all hover:-translate-y-1">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
