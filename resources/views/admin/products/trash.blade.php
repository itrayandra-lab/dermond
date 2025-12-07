@extends('admin.layouts.app')

@section('title', 'Trash - Products')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold uppercase text-white mb-2 tracking-wide">
                    Trash
                </h1>
                <p class="text-gray-400 text-lg">
                    Deleted products. Restore or permanently delete them.
                </p>
            </div>
            <a href="{{ route('admin.products.index') }}"
                class="px-4 py-2.5 bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:border-white/20 rounded-xl text-xs font-bold uppercase tracking-wider transition-all inline-flex items-center gap-2 group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Back to Products</span>
            </a>
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
            <form method="GET" action="{{ route('admin.products.trash') }}" class="flex gap-4">
                <div class="relative group flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500 group-focus-within:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search trashed products..."
                        class="block w-full pl-11 pr-4 py-3 bg-dermond-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all shadow-lg shadow-blue-900/30">
                    Search
                </button>
                @if (!empty($filters['search']))
                    <a href="{{ route('admin.products.trash') }}" class="px-4 py-3 flex items-center justify-center text-gray-400 hover:text-red-400 transition-colors bg-white/5 rounded-xl border border-white/10" title="Reset">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-dermond-card border border-white/10 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-8 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Product</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Category</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Deleted At</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($products as $product)
                            <tr class="group hover:bg-white/5 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-5">
                                        <div class="w-16 h-16 rounded-2xl overflow-hidden bg-dermond-dark flex-shrink-0 border border-white/10">
                                            @if ($product->hasImage())
                                                <img src="{{ $product->getImageUrl() }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-600">
                                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-base font-bold text-white">{{ $product->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="text-gray-400 text-sm">{{ $product->deleted_at->format('d M Y, H:i') }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-emerald-400 hover:bg-emerald-500/10 transition-all" title="Restore">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all" title="Delete Permanently">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6 border border-white/10">
                                            <svg class="w-10 h-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-white mb-2">Trash is Empty</h3>
                                        <p class="text-gray-500">No deleted products found.</p>
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
