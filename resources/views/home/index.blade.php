@extends('layouts.app')

@section('title', 'Home - Dermond')

@section('content')

{{-- 1. HERO SECTION --}}
<section id="home" class="relative h-screen min-h-[800px] flex items-center overflow-hidden scroll-mt-24 bg-gray-900" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
    {{-- Background Elements - Static across slides --}}
    <div class="absolute top-1/4 right-0 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none transition-opacity duration-1000" :class="loaded ? 'opacity-100' : 'opacity-0'"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-indigo-600/10 rounded-full blur-[100px] pointer-events-none transition-opacity duration-1000 delay-300" :class="loaded ? 'opacity-100' : 'opacity-0'"></div>

    <div id="hero-swiper" class="swiper w-full h-full">
        <div class="swiper-wrapper">
            @forelse($sliders as $slider)
            <div class="swiper-slide">
                <div class="w-full h-full flex items-center">
                    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center w-full relative z-10">
                        {{-- Left Content --}}
                        <div class="space-y-8">
                            <div class="reveal" :class="loaded ? 'active' : ''">
                                <span class="font-bold italic tracking-[0.2em] text-sm uppercase mb-2 block animate-pulse-slow text-blue-500">
                                    {{ $slider->getDisplaySubtitle() ?? 'Premium Men Care' }}
                                </span>
                                <h1 class="text-5xl md:text-7xl font-bold leading-tight text-white mb-4 tracking-tight">
                                    {{ $slider->getDisplayTitle() }}
                                </h1>
                                @if($slider->description)
                                <p class="text-lg text-gray-400 leading-relaxed">{{ $slider->description }}</p>
                                @endif
                            </div>
                            @if($slider->getDisplayPrice())
                            <div class="flex items-baseline gap-4 reveal reveal-delay-200" :class="loaded ? 'active' : ''">
                                @if($slider->hasDiscount())
                                    <span class="text-3xl font-bold text-blue-400">Rp {{ number_format($slider->getDisplayPrice(), 0, ',', '.') }}</span>
                                    <span class="text-lg text-gray-500 line-through">Rp {{ number_format($slider->getOriginalPrice(), 0, ',', '.') }}</span>
                                @else
                                    <span class="text-3xl font-bold text-white">Rp {{ number_format($slider->getDisplayPrice(), 0, ',', '.') }}</span>
                                @endif
                            </div>
                            @endif
                            @if($slider->getCtaLink())
                            <div class="flex flex-col sm:flex-row gap-4 reveal reveal-delay-300" :class="loaded ? 'active' : ''">
                                <a href="{{ $slider->getCtaLink() }}" class="px-8 py-4 border border-gray-600 text-gray-300 hover:border-blue-500 hover:text-white font-bold rounded transition-all hover:-translate-y-1 flex items-center gap-2 group">
                                    {{ $slider->getCtaText() }}
                                    <svg class="w-[18px] h-[18px] transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                            @endif
                        </div>

                        {{-- Right Content - Slider/Product Image --}}
                        <div class="relative group reveal reveal-delay-500" :class="loaded ? 'active' : ''">
                            {{-- Vertical Text Decoration --}}
                            <div class="absolute -right-2 top-0 h-full hidden xl:flex items-center justify-center pointer-events-none select-none">
                                <span class="vertical-text text-8xl font-bold italic text-white/5 tracking-widest whitespace-nowrap">DERMOND</span>
                            </div>

                            <div class="relative z-10">
                                {{-- Abstract Circle behind product --}}
                                <div class="absolute inset-0 bg-gradient-to-tr from-blue-900/40 to-transparent rounded-full scale-90 blur-xl animate-pulse-slow"></div>

                                {{-- Image with Float Animation --}}
                                <div class="relative aspect-square w-full max-w-lg mx-auto flex items-center justify-center animate-float">
                                    @if($slider->hasDisplayImage())
                                    <img src="{{ $slider->getDisplayImageUrl() }}" alt="{{ $slider->getDisplayTitle() }}" class="w-full h-full object-contain drop-shadow-2xl rounded-3xl opacity-90 transform transition-transform duration-700 hover:scale-110" style="mask-image: linear-gradient(to bottom, black 85%, transparent 100%)">
                                    @else
                                    <div class="w-full h-full bg-gray-800 rounded-3xl flex items-center justify-center"><span class="text-gray-500">No Image</span></div>
                                    @endif

                                    {{-- Floating Badge --}}
                                    @if($slider->badge_title || $slider->badge_subtitle)
                                    <div class="absolute -bottom-4 -left-4 bg-gray-900/90 backdrop-blur-md border border-blue-500/30 p-4 rounded-xl shadow-2xl transform transition-transform duration-300 hover:scale-105 hover:border-blue-500/60 cursor-default">
                                        @if($slider->badge_title)
                                        <p class="text-xs text-blue-400 uppercase tracking-wider font-bold mb-1">{{ $slider->badge_title }}</p>
                                        @endif
                                        @if($slider->badge_subtitle)
                                        <p class="text-white font-bold text-lg">{{ $slider->badge_subtitle }}</p>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="swiper-slide">
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-center">
                        <h1 class="text-5xl md:text-7xl font-bold text-white mb-4">DERMOND</h1>
                        <p class="text-gray-400 text-xl">Premium Men's Intimate Care</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        {{-- Swiper Navigation --}}
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        {{-- Swiper Pagination --}}
        <div class="swiper-pagination"></div>
    </div>
</section>

{{-- 2. CATEGORY GRID --}}
<section class="py-20 bg-[#050a14]" x-data="{ activeIndex: 0 }">
    <div class="max-w-[1400px] mx-auto px-4 md:px-8">
        <div class="mb-12 text-center md:text-left">
            <h2 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase mb-4">
                THE ULTIMATE <span class="text-blue-600">COLLECTION</span>
            </h2>
            <p class="text-gray-400 max-w-xl text-lg">Professional grade intimate care engineered for performance.</p>
        </div>
        <div class="flex flex-col md:flex-row gap-4 h-auto md:h-[600px]">
            @foreach($featuredProducts as $index => $product)
            <div @mouseenter="activeIndex = {{ $index }}" class="relative group overflow-hidden rounded-sm cursor-pointer transition-all duration-500 ease-out aspect-[4/5] md:aspect-auto md:min-h-0" :class="activeIndex === {{ $index }} ? 'md:flex-[2]' : 'md:flex-[1]'">
                @if($product->hasImage())
                <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105">
                @else
                <div class="w-full h-full bg-gray-800"></div>
                @endif
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors duration-500 z-10"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 z-20 bg-gradient-to-t from-black/90 via-black/50 to-transparent">
                    <h3 class="text-2xl md:text-3xl font-black text-white uppercase italic tracking-wider mb-2">{{ $product->name }}</h3>
                    <p class="text-blue-400 font-bold tracking-widest uppercase text-sm mb-4">{{ $product->category->name ?? 'Premium Care' }}</p>
                    <div class="h-0 opacity-0 overflow-hidden transition-all duration-500" :class="activeIndex === {{ $index }} ? 'group-hover:h-auto group-hover:opacity-100' : ''">
                        <p class="text-gray-300 text-sm mb-4 max-w-md">{{ Str::limit(strip_tags($product->description), 150) }}</p>
                        <a href="{{ route('products.show', $product->slug) }}" class="text-white font-bold text-sm flex items-center gap-2 border-b-2 border-blue-600 w-max pb-1">
                            EXPLORE <svg class="w-[14px] h-[14px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
                <div class="absolute inset-0 border-2 border-transparent transition-colors duration-300 z-30 pointer-events-none" :class="activeIndex === {{ $index }} ? 'border-indigo-500' : 'group-hover:border-indigo-500'"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- 4. PRODUCT SHOWCASE --}}
<section id="products" class="py-24 bg-black/20 scroll-mt-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-gray-500 font-bold tracking-[0.2em] text-lg uppercase mb-2">PRODUCTS</h2>
            <h3 class="text-3xl md:text-5xl font-bold text-white">Which gear suits you?</h3>
            <div class="w-20 h-1 bg-blue-600 mx-auto mt-8 rounded-full"></div>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($products as $product)
            <div class="group relative bg-[#0f172a] rounded-2xl p-8 border border-white/5 hover:border-blue-500/50 transition-all duration-500 hover:bg-[#131c33] hover:-translate-y-2">
                <div class="relative h-64 mb-8 flex items-center justify-center overflow-hidden rounded-xl bg-black/40 group-hover:shadow-[inset_0_0_40px_rgba(37,99,235,0.1)] transition-all duration-500">
                    <div class="absolute inset-0 bg-blue-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"></div>
                    @if($product->hasImage())
                    <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="h-full w-full object-contain opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700 ease-out z-10">
                    @else
                    <div class="w-full h-full bg-gray-800 flex items-center justify-center"><span class="text-gray-500">No Image</span></div>
                    @endif
                </div>
                <div class="text-center relative z-10">
                    <h4 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">{{ $product->name }}</h4>
                    <p class="text-xs font-bold uppercase tracking-widest mb-4 text-blue-400 opacity-80">{{ $product->category->name ?? 'Premium Care' }}</p>
                    <p class="text-gray-400 text-sm mb-8 line-clamp-2 leading-relaxed group-hover:text-gray-300 transition-colors">{{ Str::limit(strip_tags($product->description), 80) }}</p>
                    <a href="{{ route('products.show', $product->slug) }}" class="text-sm font-bold text-white flex items-center justify-center gap-2 mx-auto hover:text-blue-500 transition-colors group/btn">
                        SPECIFICATIONS <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 3. BLOG SECTION --}}
@if(isset($editorialArticles) && $editorialArticles->count() > 0)
<section id="blog" class="py-20 px-6 max-w-7xl mx-auto">
    <div class="text-center mb-20">
        <div class="inline-block mb-4 px-4 py-1 rounded-full bg-blue-900/30 border border-blue-500/30 text-blue-400 text-sm font-bold tracking-widest uppercase">HIGHLIGHT ARTICLES</div>
        <h2 class="text-5xl md:text-7xl font-black italic tracking-tighter text-white mb-8">DERMOND <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-blue-600 pr-3">INSIGHTS</span></h2>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto leading-relaxed">Deep dive into <span class="text-white font-semibold">Intimate Care</span>, men's health, and modern lifestyle.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($editorialArticles->take(3) as $article)
        <a href="{{ route('articles.show', $article->slug) }}" class="group relative bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-blue-500/50 transition-all duration-300 h-full flex flex-col">
            <div class="aspect-[16/9] overflow-hidden">
                @if($article->hasImage())
                <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                @else
                <div class="w-full h-full bg-gray-800"></div>
                @endif
            </div>
            <div class="p-6 flex flex-col flex-grow">
                <div class="flex items-center gap-4 mb-4 text-xs font-bold tracking-wider text-blue-400 uppercase">
                    <span>{{ $article->categories->first()->name ?? 'Article' }}</span>
                    <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                    <span class="text-gray-500">{{ $article->created_at->format('M d, Y') }}</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors">{{ $article->title }}</h3>
                <p class="text-gray-400 mb-6 line-clamp-2 flex-grow">{{ $article->excerpt ?: Str::limit(strip_tags($article->body), 100) }}</p>
                <span class="inline-flex items-center gap-2 text-sm font-bold text-white hover:text-blue-400 transition-colors mt-auto">READ ARTICLE <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></span>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- 5. FEATURES SECTION --}}
<section id="features" class="py-24 relative overflow-hidden scroll-mt-24">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-3xl h-full bg-blue-900/5 blur-[100px] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-gray-500 font-bold tracking-[0.2em] text-lg uppercase mb-2">WHY CHOOSE US</h2>
            <h3 class="text-3xl md:text-4xl font-bold text-white mb-6">The Dermond Difference</h3>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            {{-- Feature 1 --}}
            <div class="bg-[#0f172a]/80 backdrop-blur-sm border border-white/5 p-8 rounded-2xl flex items-start gap-6 hover:border-blue-500/30 hover:bg-[#131c33] transition-all duration-300 group">
                <div class="shrink-0 w-16 h-16 bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-500 group-hover:text-blue-400 group-hover:scale-110 transition-all duration-300 shadow-[0_0_15px_rgba(37,99,235,0)] group-hover:shadow-[0_0_15px_rgba(37,99,235,0.2)]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-white mb-2 group-hover:text-blue-100 transition-colors">Dermatologically Tested</h4>
                    <p class="text-gray-400 text-sm leading-relaxed group-hover:text-gray-300 transition-colors">Safe for sensitive skin types, ensuring no irritation.</p>
                </div>
            </div>
            {{-- Feature 2 --}}
            <div class="bg-[#0f172a]/80 backdrop-blur-sm border border-white/5 p-8 rounded-2xl flex items-start gap-6 hover:border-blue-500/30 hover:bg-[#131c33] transition-all duration-300 group">
                <div class="shrink-0 w-16 h-16 bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-500 group-hover:text-blue-400 group-hover:scale-110 transition-all duration-300 shadow-[0_0_15px_rgba(37,99,235,0)] group-hover:shadow-[0_0_15px_rgba(37,99,235,0.2)]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-white mb-2 group-hover:text-blue-100 transition-colors">pH Balanced Formula</h4>
                    <p class="text-gray-400 text-sm leading-relaxed group-hover:text-gray-300 transition-colors">Optimized for intimate areas to maintain healthy flora.</p>
                </div>
            </div>
            {{-- Feature 3 --}}
            <div class="bg-[#0f172a]/80 backdrop-blur-sm border border-white/5 p-8 rounded-2xl flex items-start gap-6 hover:border-blue-500/30 hover:bg-[#131c33] transition-all duration-300 group">
                <div class="shrink-0 w-16 h-16 bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-500 group-hover:text-blue-400 group-hover:scale-110 transition-all duration-300 shadow-[0_0_15px_rgba(37,99,235,0)] group-hover:shadow-[0_0_15px_rgba(37,99,235,0.2)]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-white mb-2 group-hover:text-blue-100 transition-colors">Long Lasting Freshness</h4>
                    <p class="text-gray-400 text-sm leading-relaxed group-hover:text-gray-300 transition-colors">Active ingredients that keep you confident all day.</p>
                </div>
            </div>
            {{-- Feature 4 --}}
            <div class="bg-[#0f172a]/80 backdrop-blur-sm border border-white/5 p-8 rounded-2xl flex items-start gap-6 hover:border-blue-500/30 hover:bg-[#131c33] transition-all duration-300 group">
                <div class="shrink-0 w-16 h-16 bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-500 group-hover:text-blue-400 group-hover:scale-110 transition-all duration-300 shadow-[0_0_15px_rgba(37,99,235,0)] group-hover:shadow-[0_0_15px_rgba(37,99,235,0.2)]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-white mb-2 group-hover:text-blue-100 transition-colors">Expert Support</h4>
                    <p class="text-gray-400 text-sm leading-relaxed group-hover:text-gray-300 transition-colors">24/7 guidance on men's hygiene and care.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Swiper !== 'undefined' && document.getElementById('hero-swiper')) {
        const { Autoplay, EffectFade, Pagination, Navigation } = window.SwiperModules;
        new Swiper('#hero-swiper', {
            modules: [Autoplay, EffectFade, Pagination, Navigation],
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 1000,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
});
</script>
@endsection
