@extends('layouts.app')

@section('title', 'Products - Dermond')

@section('content')
    <div class="pt-32 pb-20 px-6 max-w-7xl mx-auto min-h-screen">
        {{-- Page Header --}}
        <div class="text-center mb-16">
            <h2 class="text-gray-500 font-bold tracking-[0.2em] text-lg uppercase mb-2">
                PRODUCTS
            </h2>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">
                Which gear suits you?
            </h1>
            <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto leading-relaxed mt-8">
                Produk intimate care premium untuk pria modern. Diformulasikan khusus untuk kebutuhan <span class="text-white font-semibold">kesehatan intim pria</span>.
            </p>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16" x-data="productLoader()" x-init="init()">
            @forelse($products as $product)
                <x-product-card :product="$product" :index="$loop->index" />
            @empty
                <div class="col-span-full text-center py-24">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/5 border border-white/10 mb-6">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white uppercase mb-2">NO PRODUCTS FOUND</h3>
                    <p class="text-gray-500 mb-8">We couldn't find any products matching your selection.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-blue-400 font-bold tracking-widest uppercase text-xs hover:text-blue-300 transition-colors">
                        Clear All Filters
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
            @endforelse

            {{-- AJAX-loaded Products Container --}}
            <template x-for="(product, index) in ajaxProducts" :key="product.id">
                <div x-html="renderProductCard(product, index + initialProductCount)" class="animate-fade-in-up"></div>
            </template>
        </div>

        {{-- Load More Button --}}
        <template x-if="hasMorePages && initialProductCount > 0">
            <div class="text-center pb-12">
                <button @click="loadMore()"
                        :disabled="loading"
                        class="group relative inline-flex items-center justify-center px-12 py-4 overflow-hidden font-bold text-white transition-all duration-300 bg-blue-600 rounded-full hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/30 focus:outline-none disabled:opacity-60 disabled:cursor-not-allowed gap-2">
                    <span class="relative flex items-center gap-2 text-xs tracking-widest uppercase">
                        <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span x-text="loading ? 'Loading...' : 'Load More Products'"></span>
                    </span>
                </button>
            </div>
        </template>

        {{-- End of Collection Message --}}
        <template x-if="!hasMorePages && ajaxProducts.length > 0">
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-xs font-bold tracking-widest uppercase">You've reached the end of the collection</p>
            </div>
        </template>
    </div>

    <script>
        function productLoader() {
            return {
                ajaxProducts: [],
                currentPage: {{ $products->currentPage() }},
                initialProductCount: {{ $products->count() }},
                categoryFilter: '{{ request()->get('category') ?? '' }}',
                loading: false,
                hasMorePages: {{ $products->hasMorePages() ? 'true' : 'false' }},

                init() {},

                async loadMore() {
                    if (this.loading || !this.hasMorePages) return;
                    this.loading = true;

                    try {
                        const response = await axios.post('{{ route('products.load-more') }}', {
                            page: this.currentPage + 1,
                            category: this.categoryFilter
                        });

                        if (response.data.products && response.data.products.length > 0) {
                            this.ajaxProducts.push(...response.data.products);
                            this.hasMorePages = response.data.hasMorePages;
                            this.currentPage++;
                        }
                    } catch (error) {
                        console.error('Failed to load more products:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                renderProductCard(product, index) {
                    const productUrl = product.url ?? `/products/${product.slug}`;
                    const formatPrice = (price) => new Intl.NumberFormat('id-ID').format(price);
                    const animationDelay = (index * 150);

                    const imageHtml = product.has_image
                        ? `<img src="${product.image_url}" alt="${this.escapeHtml(product.name)}" loading="lazy" class="h-full w-full object-contain opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700 ease-out">`
                        : `<div class="h-full w-full flex items-center justify-center"><span class="text-gray-600 text-xs font-bold tracking-widest uppercase">No Image</span></div>`;

                    return `
                        <a href="${productUrl}" class="group relative bg-dermond-card rounded-2xl p-8 border border-white/5 hover:border-blue-500/50 transition-all duration-500 hover:bg-dermond-card-hover hover:-translate-y-2 block" style="animation-delay: ${animationDelay}ms">
                            <div class="relative h-64 mb-8 flex items-center justify-center overflow-hidden rounded-xl bg-black/40 group-hover:shadow-[inset_0_0_40px_rgba(37,99,235,0.1)] transition-all duration-500">
                                <div class="absolute inset-0 bg-blue-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"></div>
                                ${imageHtml}
                            </div>
                            <div class="text-center">
                                <h4 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">${this.escapeHtml(product.name)}</h4>
                                ${product.category ? `<p class="text-xs font-bold uppercase tracking-widest mb-4 text-blue-500 opacity-80">${this.escapeHtml(product.category.name)}</p>` : ''}
                                <div class="flex items-center justify-center gap-3 mb-6">
                                    ${product.discount_price && product.discount_price < product.price
                                        ? `<span class="line-through text-gray-500 text-sm">Rp ${formatPrice(product.price)}</span><span class="text-blue-400 font-bold text-lg">Rp ${formatPrice(product.discount_price)}</span>`
                                        : `<span class="text-white font-bold text-lg">Rp ${formatPrice(product.price)}</span>`
                                    }
                                </div>
                                <span class="text-sm font-bold text-white flex items-center justify-center gap-2 group-hover:text-blue-400 transition-colors">
                                    VIEW DETAILS
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    `;
                },

                escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }
            };
        }
    </script>
@endsection
