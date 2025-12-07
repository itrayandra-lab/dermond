@extends('admin.layouts.app')

@section('title', 'Products Management')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold uppercase text-white mb-2 tracking-wide">
                    Products
                </h1>
                <p class="text-gray-400 text-lg">
                    Manage your product catalog, prices, and inventory.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.trash') }}"
                    class="px-4 py-2.5 bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:border-white/20 rounded-xl text-xs font-bold uppercase tracking-wider transition-all inline-flex items-center gap-2 group relative">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Trash</span>
                    @php $trashedCount = \App\Models\Product::onlyTrashed()->count(); @endphp
                    @if ($trashedCount > 0)
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                            {{ $trashedCount > 99 ? '99+' : $trashedCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.products.create') }}"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-blue-900/30 inline-flex items-center gap-2 group">
                    <span>Add Product</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-emerald-900/30 border border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-dermond-card border border-white/10 rounded-2xl p-4 mb-8">
            <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col gap-4">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="relative group col-span-1 md:col-span-2">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500 group-focus-within:text-blue-400 transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                            placeholder="Search products..."
                            class="block w-full pl-11 pr-4 py-3 bg-dermond-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div>

                    <div class="relative">
                        <select name="category_id"
                            class="block w-full pl-4 pr-10 py-3 bg-dermond-dark border border-white/10 rounded-xl text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 appearance-none cursor-pointer">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(($filters['category_id'] ?? null) == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="status"
                            class="block w-full pl-4 pr-10 py-3 bg-dermond-dark border border-white/10 rounded-xl text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 appearance-none cursor-pointer">
                            <option value="">All Status</option>
                            <option value="draft" @selected(($filters['status'] ?? '') === 'draft')>Draft</option>
                            <option value="published" @selected(($filters['status'] ?? '') === 'published')>Published</option>
                            <option value="archived" @selected(($filters['status'] ?? '') === 'archived')>Archived</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-center">
                    <div class="relative">
                        <select name="has_image"
                            class="block w-full pl-4 pr-10 py-3 bg-dermond-dark border border-white/10 rounded-xl text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 appearance-none cursor-pointer">
                            <option value="">Image Status</option>
                            <option value="with" @selected(($filters['has_image'] ?? '') === 'with')>Has Image</option>
                            <option value="without" @selected(($filters['has_image'] ?? '') === 'without')>No Image</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="sort"
                            class="block w-full pl-4 pr-10 py-3 bg-dermond-dark border border-white/10 rounded-xl text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 appearance-none cursor-pointer">
                            <option value="">Sort: Newest</option>
                            <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Price: Low to High</option>
                            <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Price: High to Low</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <label class="flex items-center gap-3 px-5 py-3 bg-white/5 rounded-xl cursor-pointer hover:bg-white/10 transition-all duration-300 select-none border border-white/10 hover:border-red-500/30">
                        <input type="checkbox" name="low_stock" value="1" @checked(!empty($filters['low_stock']))
                            class="w-5 h-5 rounded border-white/20 bg-dermond-dark text-red-500 focus:ring-red-500 transition-colors">
                        <span class="text-gray-300 font-medium">Low Stock (< 5)</span>
                    </label>

                    <label class="flex items-center gap-3 px-5 py-3 bg-white/5 rounded-xl cursor-pointer hover:bg-white/10 transition-all duration-300 select-none border border-white/10 hover:border-amber-500/30">
                        <input type="checkbox" name="is_featured" value="1" @checked(!empty($filters['is_featured']))
                            class="w-5 h-5 rounded border-white/20 bg-dermond-dark text-amber-500 focus:ring-amber-500 transition-colors">
                        <span class="text-gray-300 font-medium">Featured Only</span>
                    </label>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all duration-300 shadow-lg shadow-blue-900/30">
                            Apply
                        </button>

                        @if (
                            !empty($filters['search']) ||
                                !empty($filters['category_id']) ||
                                !empty($filters['has_image']) ||
                                !empty($filters['sort']) ||
                                !empty($filters['status']) ||
                                !empty($filters['low_stock']) ||
                                !empty($filters['is_featured']))
                            <a href="{{ route('admin.products.index') }}"
                                class="px-4 py-3 flex items-center justify-center text-gray-400 hover:text-red-400 transition-colors bg-white/5 rounded-xl border border-white/10"
                                title="Reset Filters">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-dermond-card border border-white/10 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-8 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Product Details</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Category</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Stock</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Price</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Link</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($products as $product)
                            <tr class="group hover:bg-white/5 transition-colors duration-300">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-5">
                                        <div class="w-16 h-16 rounded-2xl overflow-hidden bg-dermond-dark flex-shrink-0 relative border border-white/10 group-hover:border-blue-500/30 transition-all duration-300">
                                            @if ($product->hasImage())
                                                <img src="{{ $product->getImageUrl() }}"
                                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                                    alt="{{ $product->name }}">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-600">
                                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-base font-bold text-white mb-1 flex items-center gap-2">
                                                {{ $product->name }}
                                                @if ($product->is_featured)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-amber-500/10 text-amber-400 border border-amber-500/20" title="Featured on Homepage">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                        Featured
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-6">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <td class="px-6 py-6">
                                    @if ($product->status === 'published')
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                            Published
                                        </span>
                                    @elseif($product->status === 'draft')
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                            <span class="h-2 w-2 rounded-full bg-gray-500"></span>
                                            Draft
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                            Archived
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-gray-300">{{ $product->stock }}</span>
                                        @if ($product->stock < 5)
                                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse" title="Low Stock"></span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-6">
                                    <div class="flex flex-col">
                                        @if ($product->discount_price && $product->discount_price < $product->price)
                                            <span class="font-bold text-emerald-400">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                            <span class="text-xs text-gray-500 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @else
                                            <span class="font-bold text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-6">
                                    @if ($product->lynk_id_link)
                                        <a href="{{ $product->lynk_id_link }}" target="_blank"
                                            class="text-cyan-400 hover:text-cyan-300 transition-colors p-2 hover:bg-cyan-500/10 rounded-lg inline-flex"
                                            title="Open Link">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-gray-600">-</span>
                                    @endif
                                </td>

                                <td class="px-8 py-6 text-right">
                                    <div class="inline-flex items-center gap-1 opacity-60 group-hover:opacity-100 transition-all duration-300">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-blue-400 hover:bg-blue-500/10 transition-all"
                                            title="Edit Product">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all"
                                                title="Delete Product">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6 border border-white/10">
                                            <svg class="w-10 h-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-white mb-2">No Products Found</h3>
                                        <p class="text-gray-500 mb-8 max-w-sm mx-auto">Start building your catalog by adding your first product.</p>
                                        <a href="{{ route('admin.products.create') }}"
                                            class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all shadow-lg shadow-blue-900/30">
                                            Add First Product
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="px-8 py-6 border-t border-white/10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
