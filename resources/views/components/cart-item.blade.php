@props([
    'item',
])

<div class="flex items-start gap-4 p-4 bg-dermond-card border border-white/10 rounded-2xl hover:border-blue-500/30 transition-all js-cart-item" data-item-id="{{ $item->id }}">
    <div class="w-24 h-24 rounded-xl overflow-hidden bg-white/5 shrink-0">
        @if($item->product?->hasImage())
            <img src="{{ $item->product->getImageUrl() }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-xs text-gray-600">No Image</div>
        @endif
    </div>

    <div class="flex-1 space-y-1">
        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">
            {{ $item->product?->category?->name ?? 'Dermond' }}
        </p>
        <h3 class="text-lg font-bold text-white">{{ $item->product?->name ?? 'Produk tidak tersedia' }}</h3>
        <div class="flex items-center gap-3">
            @if($item->product?->hasDiscount())
                <span class="text-blue-400 font-semibold">Rp {{ number_format($item->product->discount_price, 0, ',', '.') }}</span>
                <span class="text-sm text-gray-500 line-through">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
            @else
                <span class="text-white font-semibold">Rp {{ number_format($item->product?->price ?? 0, 0, ',', '.') }}</span>
            @endif
        </div>
        <div class="text-xs text-gray-500">Stok: {{ $item->product?->stock ?? 0 }}</div>
    </div>

    <div class="flex flex-col items-end gap-3">
        <form method="POST" action="{{ route('cart.items.update', $item) }}" class="flex items-center gap-2 js-cart-update" data-item-id="{{ $item->id }}">
            @csrf
            @method('PATCH')
            <input type="number"
                   name="quantity"
                   value="{{ $item->quantity }}"
                   min="1"
                   class="w-16 px-3 py-2 text-sm rounded-lg bg-dermond-dark border border-white/10 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="submit" class="text-sm text-blue-400 hover:text-blue-300 font-medium">Update</button>
        </form>

        <form method="POST" action="{{ route('cart.items.remove', $item) }}" class="js-cart-remove" data-item-id="{{ $item->id }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm text-red-400 hover:text-red-300 font-medium">Hapus</button>
        </form>
    </div>
</div>
