@extends('layouts.app')

@section('title', 'Keranjang Belanja - Dermond')

@section('content')
    <div class="pt-32 pb-20 min-h-screen bg-dermond-dark px-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span class="text-blue-500 font-bold italic tracking-widest text-sm uppercase mb-2 block">Shopping Bag</span>
                    <h1 class="text-4xl md:text-5xl font-black text-white">Keranjang Kamu</h1>
                </div>
                <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-blue-400 transition-colors font-medium">
                    Lanjut Belanja →
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 px-4 py-3 rounded-xl bg-green-900/30 text-green-400 border border-green-500/30">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 px-4 py-3 rounded-xl bg-red-900/30 text-red-400 border border-red-500/30">
                    {{ session('error') }}
                </div>
            @endif

            @php $items = $cart->items ?? collect(); @endphp

            @if ($items->isEmpty())
                <div class="text-center py-32 bg-white/5 border border-white/10 rounded-3xl">
                    <div class="w-24 h-24 bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m4-9l2 9" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-3">Keranjang masih kosong</h2>
                    <p class="text-gray-400 mb-8">Ayo tambahkan produk favoritmu.</p>
                    <a href="{{ route('products.index') }}"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded font-bold transition-all hover:-translate-y-1 shadow-lg shadow-blue-900/20">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10" id="cart-page">
                    <div class="lg:col-span-2 space-y-4" id="cart-items">
                        @foreach ($items as $item)
                            <x-cart-item :item="$item" />
                        @endforeach
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-dermond-card border border-white/10 p-8 rounded-2xl sticky top-28">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-white">Ringkasan Pesanan</h3>
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold text-red-400 uppercase tracking-widest hover:text-red-300">
                                        Kosongkan
                                    </button>
                                </form>
                            </div>

                            <div class="space-y-3 text-sm text-gray-400 mb-6">
                                <div class="flex items-center justify-between">
                                    <span>Subtotal</span>
                                    <span class="text-white font-medium" id="cart-subtotal">Rp {{ number_format($cart->getSubtotal(), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Pengiriman</span>
                                    <span class="text-gray-500 text-xs">Dihitung saat checkout</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xl font-bold text-white border-t border-white/10 pt-4 mb-8">
                                <span>Total</span>
                                <span id="cart-total">Rp {{ number_format($cart->getTotal(), 0, ',', '.') }}</span>
                            </div>

                            @auth('web')
                                <a href="{{ route('checkout.form') }}"
                                   class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded font-bold transition-all hover:-translate-y-1 shadow-lg shadow-blue-900/20">
                                    Lanjut Checkout
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded font-bold transition-all hover:-translate-y-1 shadow-lg shadow-blue-900/20">
                                    Login untuk Checkout
                                </a>
                            @endauth

                            <p class="text-xs text-gray-500 text-center mt-4">Ongkir dihitung berdasarkan alamat</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
