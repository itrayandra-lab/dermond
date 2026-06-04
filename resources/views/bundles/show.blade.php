@extends('layouts.app')

@section('title', $bundle->name . ' - Dermond')

@section('content')
<div class="min-h-screen bg-dermond-dark"
     x-data="{
        activeImage: 0,
        addingToCart: false,
        added: false,
        async addAllToCart() {
            this.addingToCart = true;
            try {
                await axios.post('{{ route('cart.add-bundle', $bundle->slug) }}');
                this.added = true;
                window.dispatchEvent(new CustomEvent('cart-updated'));
                window.showToast?.('Bundle ditambahkan ke keranjang!');
            } catch (error) {
                if (error?.response?.status === 401 || error?.response?.status === 403) {
                    window.location.href = '{{ route('login') }}?redirect={{ urlencode(url()->current()) }}';
                    return;
                }
                window.showToast?.(error?.response?.data?.message ?? 'Gagal menambahkan bundle.', 'error');
            } finally {
                this.addingToCart = false;
            }
        }
     }">

    {{-- HERO --}}
    <div class="relative bg-[#020811] pt-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/10 to-transparent pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 py-12 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Text side --}}
                <div>
                    <span class="inline-flex items-center gap-2 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold tracking-[0.2em] uppercase px-4 py-2 rounded-full mb-6">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        Bundle Eksklusif
                    </span>
                    <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tight leading-tight mb-4">
                        {{ $bundle->name }}
                    </h1>
                    @if($bundle->subtitle)
                    <p class="text-gray-400 text-base mb-8 max-w-md">{{ $bundle->subtitle }}</p>
                    @endif

                    <div class="mb-8">
                        <p class="text-3xl font-black text-white">Rp {{ number_format($bundle->price, 0, ',', '.') }}</p>
                        @if($bundle->hasSavings())
                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-gray-500 line-through text-sm">Rp {{ number_format($bundle->original_price, 0, ',', '.') }}</span>
                            <span class="bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-bold px-3 py-1 rounded-full">Hemat Rp {{ number_format($bundle->getSavingsAmount(), 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-3">
                        @if($products->count() > 0)
                        <button @click="addAllToCart()" :disabled="addingToCart"
                                class="px-8 py-3.5 bg-blue-600 hover:bg-blue-500 disabled:opacity-60 text-white rounded-xl font-bold uppercase tracking-wider text-sm transition-all flex items-center gap-2 shadow-lg shadow-blue-900/30">
                            <svg class="w-4 h-4 shrink-0" x-show="!addingToCart" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <svg class="w-4 h-4 animate-spin shrink-0" x-show="addingToCart" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            <span x-text="addingToCart ? 'Menambahkan...' : (added ? 'Ditambahkan ✓' : 'Tambah ke Keranjang')"></span>
                        </button>
                        @endif
                        <a href="{{ route('products.index') }}" class="px-6 py-3.5 border border-white/10 hover:border-white/20 text-gray-400 hover:text-white rounded-xl font-bold uppercase tracking-wider text-sm transition-all">
                            Produk Lain
                        </a>
                    </div>
                </div>

                {{-- Image side --}}
                @if($bundle->hasImages())
                @php $images = $bundle->getMedia('bundle_images'); @endphp
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden bg-[#0a1628] border border-white/5 aspect-[4/3] flex items-center justify-center">
                        @foreach($images as $i => $media)
                        <img src="{{ $media->getUrl() }}" alt="{{ $bundle->name }}"
                             class="w-full h-full object-cover transition-opacity duration-500"
                             :class="activeImage === {{ $i }} ? 'block' : 'hidden'">
                        @endforeach
                    </div>
                    @if($images->count() > 1)
                    <div class="flex gap-2 mt-3 justify-center">
                        @foreach($images as $i => $media)
                        <button @click="activeImage = {{ $i }}"
                                class="w-10 h-10 rounded-lg overflow-hidden border-2 transition-all"
                                :class="activeImage === {{ $i }} ? 'border-blue-500' : 'border-white/10 opacity-40 hover:opacity-80'">
                            <img src="{{ $media->getUrl() }}" alt="" class="w-full h-full object-cover">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- LEFT: Details --}}
            <div class="lg:col-span-2 space-y-14">

                {{-- Included Products --}}
                @if($products->count() > 0)
                <div>
                    <p class="text-xs font-bold tracking-[0.3em] text-blue-400 uppercase mb-2">ISI BUNDLE</p>
                    <h2 class="text-2xl font-black text-white uppercase mb-6">{{ $products->count() }} Produk dalam Paket</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($products as $product)
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="group flex items-center gap-4 p-4 rounded-xl bg-white/5 border border-white/5 hover:border-blue-500/30 hover:bg-white/[0.08] transition-all">
                            <div class="w-14 h-14 rounded-xl bg-black/40 overflow-hidden shrink-0 flex items-center justify-center">
                                @if($product->hasImage())
                                <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform">
                                @else
                                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-bold text-sm group-hover:text-blue-400 transition-colors truncate">{{ $product->name }}</p>
                                <p class="text-xs text-blue-400/70 uppercase tracking-wider mt-0.5">{{ $product->category->name ?? '' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 font-mono">Rp {{ number_format($product->getCurrentPrice(), 0, ',', '.') }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-600 group-hover:text-blue-400 transition-colors shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Benefits --}}
                @if(!empty($bundle->benefits))
                <div>
                    <p class="text-xs font-bold tracking-[0.3em] text-blue-400 uppercase mb-2">KEUNGGULAN</p>
                    <h2 class="text-2xl font-black text-white uppercase mb-6">Kenapa Pilih Bundle Ini?</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($bundle->benefits as $benefit)
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-white/5 border border-white/5">
                            <div class="w-9 h-9 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                @if(($benefit['icon'] ?? '') === 'shield')
                                    <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                @elseif(($benefit['icon'] ?? '') === 'droplet')
                                    <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3C12 3 6 9 6 14a6 6 0 0012 0c0-5-6-11-6-11z"/></svg>
                                @elseif(($benefit['icon'] ?? '') === 'sparkles')
                                    <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                @elseif(($benefit['icon'] ?? '') === 'star')
                                    <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                @else
                                    <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                @endif
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">{{ $benefit['text'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Description --}}
                @if($bundle->description)
                <div class="border-t border-white/5 pt-10">
                    <p class="text-xs font-bold tracking-[0.3em] text-blue-400 uppercase mb-4">TENTANG BUNDLE</p>
                    <p class="text-gray-400 leading-relaxed text-base">{{ $bundle->description }}</p>
                </div>
                @endif

            </div>

            {{-- RIGHT: Order Card --}}
            <div>
                <div class="lg:sticky lg:top-24 space-y-4">
                    <div class="bg-[#0f172a] border border-white/10 rounded-2xl p-6">

                        <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-5">Ringkasan Pesanan</p>

                        {{-- Price summary --}}
                        <div class="space-y-2 mb-5 pb-5 border-b border-white/5">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">{{ $products->count() > 0 ? $products->count() : count($bundle->included_products ?? []) }} produk</span>
                                @if($bundle->hasSavings())
                                <span class="text-gray-500 line-through text-sm font-mono">Rp {{ number_format($bundle->original_price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-white font-bold">Total Bundle</span>
                                <span class="text-xl font-black text-white font-mono">Rp {{ number_format($bundle->price, 0, ',', '.') }}</span>
                            </div>
                            @if($bundle->hasSavings())
                            <div class="bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-bold px-3 py-2 rounded-lg text-center">
                                Hemat Rp {{ number_format($bundle->getSavingsAmount(), 0, ',', '.') }}
                            </div>
                            @endif
                        </div>

                        {{-- CTA --}}
                        @if($products->count() > 0)
                        <button @click="addAllToCart()" :disabled="addingToCart"
                                class="w-full py-3.5 bg-blue-600 hover:bg-blue-500 disabled:opacity-60 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all flex items-center justify-center gap-2 mb-3">
                            <svg class="w-4 h-4" x-show="!addingToCart" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span x-text="addingToCart ? 'Menambahkan...' : (added ? 'Ditambahkan ✓' : 'Tambah ke Keranjang')"></span>
                        </button>
                        @endif

                        <a href="{{ route('cart.index') }}"
                           class="block w-full py-3 border border-white/10 hover:border-white/20 text-gray-400 hover:text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all text-center">
                            Lihat Keranjang
                        </a>
                    </div>

                    <div class="flex items-start gap-3 p-4 rounded-xl bg-white/5 border border-white/5">
                        <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <p class="text-xs text-gray-400 leading-relaxed">Satu set lengkap untuk rutinitas harian pria aktif.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
