@extends('layouts.app')

@section('title', $bundle->name . ' - Dermond')

@section('content')
<div class="min-h-screen bg-dermond-dark pt-24 pb-20">

    {{-- Hero Section --}}
    <div class="relative bg-[#050a14] border-b border-white/5 py-16 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/10 via-transparent to-transparent pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <p class="text-blue-400 text-xs font-bold tracking-[0.3em] uppercase mb-4">DERMOND ✦ BUNDLE EKSKLUSIF</p>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white uppercase tracking-tight mb-4">
                {{ $bundle->name }}
            </h1>
            @if($bundle->subtitle)
                <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto">{{ $bundle->subtitle }}</p>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-16">

        {{-- Image Gallery --}}
        @if($bundle->hasImages())
        <div class="mb-16" x-data="{ activeImage: 0 }">
            @php $images = $bundle->getMedia('bundle_images'); @endphp

            {{-- Main Image --}}
            <div class="relative rounded-2xl overflow-hidden bg-[#050a14] border border-white/5 mb-4" style="max-height: 600px;">
                @foreach($images as $i => $media)
                <img src="{{ $media->getUrl() }}"
                     alt="{{ $bundle->name }}"
                     class="w-full object-contain transition-opacity duration-500"
                     :class="activeImage === {{ $i }} ? 'block' : 'hidden'"
                     style="max-height: 600px; margin: auto;">
                @endforeach
            </div>

            {{-- Thumbnails --}}
            @if($images->count() > 1)
            <div class="flex gap-3 justify-center flex-wrap">
                @foreach($images as $i => $media)
                <button @click="activeImage = {{ $i }}"
                        class="w-16 h-16 rounded-xl overflow-hidden border-2 transition-all"
                        :class="activeImage === {{ $i }} ? 'border-blue-500' : 'border-white/10 opacity-50 hover:opacity-100'">
                    <img src="{{ $media->getUrl() }}" alt="" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

            {{-- Left: Products & Benefits --}}
            <div class="space-y-10">

                {{-- Included Products --}}
                @if(!empty($bundle->included_products))
                <div>
                    <h2 class="text-xs font-bold tracking-[0.3em] text-blue-400 uppercase mb-6">ISI BUNDLE</h2>
                    <div class="space-y-3">
                        @foreach($bundle->included_products as $product)
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-white/5 border border-white/5">
                            <div class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 shrink-0 font-bold text-sm">
                                {{ $loop->iteration }}
                            </div>
                            <span class="text-white font-semibold">{{ $product }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Benefits --}}
                @if(!empty($bundle->benefits))
                <div>
                    <h2 class="text-xs font-bold tracking-[0.3em] text-blue-400 uppercase mb-6">KEUNGGULAN</h2>
                    <div class="space-y-4">
                        @foreach($bundle->benefits as $benefit)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0">
                                @if(($benefit['icon'] ?? '') === 'shield')
                                    <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                @elseif(($benefit['icon'] ?? '') === 'droplet')
                                    <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2.25c-5.385 0-9 3.888-9 8.25 0 4.455 3.75 8.25 9 8.25s9-3.795 9-8.25c0-4.362-3.615-8.25-9-8.25z"/></svg>
                                @elseif(($benefit['icon'] ?? '') === 'sparkles')
                                    <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                @elseif(($benefit['icon'] ?? '') === 'star')
                                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                @endif
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed pt-2">{{ $benefit['text'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Description --}}
                @if($bundle->description)
                <div>
                    <h2 class="text-xs font-bold tracking-[0.3em] text-blue-400 uppercase mb-4">TENTANG BUNDLE</h2>
                    <p class="text-gray-400 leading-relaxed">{{ $bundle->description }}</p>
                </div>
                @endif

            </div>

            {{-- Right: Price & CTA --}}
            <div class="lg:sticky lg:top-28">
                <div class="bg-[#0f172a] border border-white/10 rounded-2xl p-8 hover:border-blue-500/30 transition-colors">

                    <div class="mb-8">
                        <p class="text-gray-500 text-sm uppercase tracking-widest font-bold mb-2">Harga Bundle</p>
                        <div class="flex items-end gap-4">
                            <span class="text-4xl md:text-5xl font-black text-white">
                                Rp {{ number_format($bundle->price, 0, ',', '.') }}
                            </span>
                            @if($bundle->hasSavings())
                                <span class="text-gray-500 line-through text-lg mb-1">
                                    Rp {{ number_format($bundle->original_price, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                        @if($bundle->hasSavings())
                        <div class="mt-3 inline-flex items-center gap-2 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-2 rounded-full text-sm font-bold">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            Hemat Rp {{ number_format($bundle->getSavingsAmount(), 0, ',', '.') }}
                        </div>
                        @endif
                    </div>

                    @if(!empty($bundle->included_products))
                    <div class="mb-8 p-4 rounded-xl bg-white/5 border border-white/5">
                        <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Termasuk</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($bundle->included_products as $product)
                            <span class="text-xs text-gray-300 bg-white/5 px-3 py-1 rounded-full border border-white/10">{{ $product }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="text-center py-4 border-t border-white/5">
                        <p class="text-xs text-gray-500">Hubungi kami untuk info pembelian bundle</p>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('products.index') }}"
                           class="block w-full text-center py-3 px-6 rounded-xl border border-white/10 text-gray-400 hover:text-white hover:border-white/20 transition-all text-sm font-bold uppercase tracking-widest">
                            ← Lihat Semua Produk
                        </a>
                    </div>
                </div>

                {{-- Tagline --}}
                <div class="mt-4 flex items-center gap-3 p-4 rounded-xl bg-white/5 border border-white/5">
                    <svg class="w-5 h-5 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <p class="text-xs text-gray-400">Satu set praktis untuk rutin harian pria.</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
