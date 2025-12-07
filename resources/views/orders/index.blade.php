@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="pt-28 pb-16 bg-dermond-dark min-h-screen">
        <div class="container mx-auto px-6 md:px-8">
            <div class="mb-8">
                <p class="text-xs font-bold tracking-widest text-blue-400 uppercase mb-2">Orders</p>
                <h1 class="text-4xl font-bold text-white">Riwayat Pesanan</h1>
            </div>

            @if($orders->isEmpty())
                <div class="bg-dermond-card border border-white/10 rounded-2xl p-8 text-center">
                    <p class="text-gray-400">Belum ada pesanan.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-4 text-blue-400 font-semibold hover:text-blue-300">Mulai Belanja</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <a href="{{ route('orders.show', $order) }}" class="block bg-dermond-card border border-white/10 rounded-2xl p-6 hover:border-blue-500/50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-widest">#{{ $order->order_number }}</p>
                                    <p class="text-lg font-bold text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($order->payment_status === 'paid') bg-green-900/30 text-green-400
                                        @elseif($order->payment_status === 'unpaid') bg-yellow-900/30 text-yellow-400
                                        @elseif($order->payment_status === 'expired') bg-gray-700/50 text-gray-400
                                        @else bg-red-900/30 text-red-400
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-gray-300">
                                        {{ ucwords(str_replace('_',' ',$order->status)) }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
