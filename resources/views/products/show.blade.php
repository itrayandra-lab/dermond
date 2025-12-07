@extends('layouts.app')

@section('title', $product->name . ' - Dermond')

@section('content')
    <div class="pt-32 pb-20 px-6 min-h-screen bg-dermond-dark"
         x-data="{
            quantity: 1,
            productId: {{ $product->id }},
            stock: {{ $product->stock }},
            addingToCart: false,
            decreaseQty() { this.quantity = Math.max(1, this.quantity - 1); },
            increaseQty() { this.quantity = Math.min(this.stock, this.quantity + 1); },
            async addToCart() {
                this.addingToCart = true;
                try {
                    await axios.post('{{ route('cart.add') }}', {
                        product_id: this.productId,
                        quantity: this.quantity,
                    });
                    this.quantity = 1;
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    window.showToast?.('Produk ditambahkan ke keranjang.');
                } catch (error) {
                    window.showToast?.(error?.response?.data?.message ?? 'Gagal menambahkan ke keranjang.', 'error');
                } finally {
                    this.addingToCart = false;
                }
            }
         }">
        
        <div class="max-w-7xl mx-auto">
            {{-- Back Link --}}
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center gap-2 text-gray-400 hover:text-blue-400 transition-colors mb-12 group">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="font-medium">Back to Shop</span>
            </a>

            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Product Image --}}
                <div class="relative group h-[600px] w-full flex items-center justify-center">
                    <div class="absolute inset-0 bg-linear-to-tr from-blue-900/20 to-transparent rounded-full blur-3xl opacity-50"></div>
                    <div class="relative bg-white/5 border border-white/10 rounded-3xl p-8 flex items-center justify-center overflow-hidden h-full w-full">
                        <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors duration-500"></div>
                        @if($product->hasImage())
                            <img src="{{ $product->getImageUrl() }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-contain drop-shadow-2xl transform transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-gray-500 font-medium">No Image Available</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Product Details --}}
                <div class="space-y-8">
                    <div>
                        <span class="font-bold italic tracking-widest text-sm uppercase mb-2 block text-blue-500">
                            {{ $product->category->name ?? 'Premium Care' }}
                        </span>
                        <h1 class="text-5xl md:text-6xl font-black text-white mb-6 leading-tight">
                            {{ $product->name }}
                        </h1>
                        <p class="text-lg text-gray-400 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                    </div>

                    {{-- Price --}}
                    <div class="flex items-baseline gap-4">
                        @if($product->discount_price && $product->discount_price < $product->price)
                            <span class="text-3xl font-bold text-blue-400">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            <span class="text-lg text-gray-500 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @else
                            <span class="text-3xl font-bold text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    {{-- Key Benefits --}}
                    @if($product->features && count($product->features) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-8 border-y border-white/10">
                        @foreach($product->features as $feature)
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-full bg-blue-900/30 flex items-center justify-center text-blue-400">
                                @switch($feature['icon'] ?? 'shield')
                                    @case('shield')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        @break
                                    @case('droplet')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                        @break
                                    @case('bolt')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        @break
                                    @case('sparkles')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                        @break
                                    @case('leaf')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                        @break
                                    @case('heart')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        @break
                                    @default
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                @endswitch
                            </div>
                            <h3 class="font-bold text-white">{{ $feature['title'] ?? '' }}</h3>
                            @if(!empty($feature['description']))
                                <p class="text-sm text-gray-500">{{ $feature['description'] }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Quantity & Actions --}}
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-lg px-4 py-3">
                                <button @click="decreaseQty()" class="text-gray-400 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <span class="text-sm font-bold text-white w-6 text-center" x-text="quantity"></span>
                                <button @click="increaseQty()" class="text-gray-400 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/>
                                    </svg>
                                </button>
                            </div>
                            <span class="text-sm text-gray-500">
                                @if($product->stock > 0)
                                    <span class="text-green-400">●</span> In Stock ({{ $product->stock }} available)
                                @else
                                    <span class="text-red-400">●</span> Out of Stock
                                @endif
                            </span>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button @click="addToCart()" :disabled="addingToCart || {{ $product->stock }} === 0"
                                    class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded transition-all hover:-translate-y-1 flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span x-text="addingToCart ? 'ADDING...' : 'BUY NOW'"></span>
                            </button>
                            @if($product->lynk_id_link)
                                <a href="{{ $product->lynk_id_link }}" target="_blank"
                                   class="px-8 py-4 border border-white/10 text-white hover:bg-white/5 font-bold rounded transition-all hover:-translate-y-1 text-center">
                                    BUY ON LYNK
                                </a>
                            @else
                                <a href="{{ route('contact') }}"
                                   class="px-8 py-4 border border-white/10 text-white hover:bg-white/5 font-bold rounded transition-all hover:-translate-y-1 text-center">
                                    CONTACT SUPPORT
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products Section --}}
    @if($product->category && $product->category->products()->where('id', '!=', $product->id)->count() > 0)
    <section class="py-20 bg-dermond-nav">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-blue-500 font-bold italic tracking-widest text-sm uppercase mb-2 block">You May Also Like</span>
                <h2 class="text-4xl md:text-5xl font-black text-white">RELATED PRODUCTS</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($product->category->products()->where('id', '!=', $product->id)->take(4)->get() as $related)
                    <a href="{{ route('products.show', $related->slug) }}" class="group">
                        <div class="relative aspect-square rounded-2xl overflow-hidden bg-white/5 border border-white/10 mb-4 transition-all duration-300 group-hover:border-blue-500/30 group-hover:-translate-y-2">
                            @if($related->hasImage())
                                <img src="{{ $related->getImageUrl() }}" alt="{{ $related->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-gray-600 text-xs">No Image</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-white font-bold text-sm group-hover:text-blue-400 transition-colors">{{ $related->name }}</h3>
                        <p class="text-gray-500 text-sm mt-1">
                            @if($related->discount_price && $related->discount_price < $related->price)
                                <span class="line-through mr-2">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                <span class="text-blue-400">Rp {{ number_format($related->discount_price, 0, ',', '.') }}</span>
                            @else
                                Rp {{ number_format($related->price, 0, ',', '.') }}
                            @endif
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection
