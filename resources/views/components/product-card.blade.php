{{-- Product Card Component - Dermond Dark Theme --}}
{{-- Props: $product (required), $index (optional, for animation delay) --}}

<a href="{{ route('products.show', $product->slug) }}"
   class="group relative bg-dermond-card rounded-2xl p-8 border border-white/5 hover:border-blue-500/50 transition-all duration-500 hover:bg-dermond-card-hover hover:-translate-y-2 block animate-fade-in-up"
   style="{{ isset($index) ? 'animation-delay: ' . ($index * 150) . 'ms' : '' }}">

    {{-- Image Area --}}
    <div class="relative h-64 mb-8 flex items-center justify-center overflow-hidden rounded-xl bg-black/40 group-hover:shadow-[inset_0_0_40px_rgba(37,99,235,0.1)] transition-all duration-500">
        {{-- Blue overlay on hover --}}
        <div class="absolute inset-0 bg-blue-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"></div>

        @if ($product->hasImage())
            <div class="h-full w-full [&_img]:h-full [&_img]:w-full [&_img]:object-contain [&_img]:opacity-80 group-hover:[&_img]:opacity-100 group-hover:[&_img]:scale-110 [&_img]:transition-all [&_img]:duration-700 [&_img]:ease-out z-10">
                {!! $product->getImage() !!}
            </div>
        @else
            <div class="h-full w-full flex items-center justify-center z-10">
                <span class="text-gray-600 text-xs font-bold tracking-widest uppercase">No Image</span>
            </div>
        @endif

        {{-- Discount Badge --}}
        @if ($product->discount_price && $product->discount_price < $product->price)
            <div class="absolute top-4 right-4 z-20">
                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-[10px] font-bold tracking-wide uppercase shadow-lg shadow-blue-600/30">
                    {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                </span>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="text-center">
        <h4 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors line-clamp-2">
            {{ $product->name }}
        </h4>

        @if ($product->category)
            <p class="text-xs font-bold uppercase tracking-widest mb-4 text-blue-500 opacity-80">
                {{ $product->category->name }}
            </p>
        @endif

        {{-- Price --}}
        <div class="flex items-center justify-center gap-3 mb-6">
            @if ($product->discount_price && $product->discount_price < $product->price)
                <span class="line-through text-gray-500 text-sm">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
                <span class="text-blue-400 font-bold text-lg">
                    Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                </span>
            @else
                <span class="text-white font-bold text-lg">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            @endif
        </div>

        {{-- CTA --}}
        <span class="text-sm font-bold text-white flex items-center justify-center gap-2 group-hover:text-blue-400 transition-colors">
            VIEW DETAILS
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </span>
    </div>
</a>
