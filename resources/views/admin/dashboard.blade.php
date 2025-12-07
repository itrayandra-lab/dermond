@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    
    @php
        $adminUser = Auth::guard('admin')->user();
        $isAdmin = $adminUser?->role === 'admin';
        $isContentManager = $adminUser?->role === 'content_manager';
        // Get recent products for admin
        $recentProducts = $isAdmin ? \App\Models\Product::latest()->take(3)->get() : collect();
        // Get recent articles for content manager
        $recentArticles = $isContentManager ? \App\Models\Article::with('category')->latest()->take(3)->get() : collect();
        // Get orders and customers count for admin
        $orderCount = $isAdmin ? \App\Models\Order::count() : 0;
        $customerCount = $isAdmin ? \App\Models\User::where('role', 'user')->count() : 0;
    @endphp

    <!-- Welcome Header -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 tracking-tight">
                Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-500">{{ $adminUser?->username }}</span>
            </h1>
            <p class="text-gray-400 text-lg">
                {{ $isAdmin ? "Overview of your store's performance & activity." : 'Manage your articles and content strategy.' }}
            </p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-sm font-bold uppercase tracking-widest text-gray-500">{{ now()->format('l, d F Y') }}</p>
        </div>
    </div>

    @if($isAdmin)
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            
            <!-- Products Card -->
            <div class="bg-dermond-card border border-white/10 p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 hover:border-blue-500/30 transition-all duration-300">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10 flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 border border-blue-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        Active
                    </span>
                </div>
                
                <div class="relative z-10">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Total Products</h3>
                    <p class="text-4xl font-bold text-white">{{ $productCount }}</p>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="bg-dermond-card border border-white/10 p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 hover:border-indigo-500/30 transition-all duration-300">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10 flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
                
                <div class="relative z-10">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Categories</h3>
                    <p class="text-4xl font-bold text-white">{{ $categoryCount }}</p>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="bg-dermond-card border border-white/10 p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 hover:border-emerald-500/30 transition-all duration-300">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10 flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 border border-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                
                <div class="relative z-10">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Total Orders</h3>
                    <p class="text-4xl font-bold text-white">{{ $orderCount }}</p>
                </div>
            </div>

            <!-- Customers Card -->
            <div class="bg-dermond-card border border-white/10 p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 hover:border-cyan-500/30 transition-all duration-300">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-cyan-500/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10 flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 flex items-center justify-center text-cyan-400 border border-cyan-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                
                <div class="relative z-10">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Customers</h3>
                    <p class="text-4xl font-bold text-white">{{ $customerCount }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Quick Actions Panel -->
        <div class="bg-dermond-card border border-white/10 p-8 rounded-2xl h-full">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white">Quick Actions</h2>
            </div>

            @if($isAdmin)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('admin.products.create') }}" class="group flex items-center p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-blue-500/10 hover:border-blue-500/30 transition-all duration-300">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-sm group-hover:text-blue-400 transition-colors">Add Product</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Create new inventory item</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.categories.create') }}" class="group flex items-center p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-indigo-500/10 hover:border-indigo-500/30 transition-all duration-300">
                        <div class="w-10 h-10 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-400 mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-sm group-hover:text-indigo-400 transition-colors">Add Category</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Organize your catalog</p>
                        </div>
                    </a>
                </div>
            @endif

            @if($isContentManager)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('admin.articles.create') }}" class="group flex items-center p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-blue-500/10 hover:border-blue-500/30 transition-all duration-300">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-sm group-hover:text-blue-400 transition-colors">Write Article</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Publish new content</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.article-categories.index') }}" class="group flex items-center p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-indigo-500/10 hover:border-indigo-500/30 transition-all duration-300">
                        <div class="w-10 h-10 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-400 mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-sm group-hover:text-indigo-400 transition-colors">Manage Taxonomy</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Article categories</p>
                        </div>
                    </a>
                </div>
            @endif
        </div>

        @if($isAdmin)
        <!-- Recent Products Panel -->
        <div class="bg-dermond-card border border-white/10 p-8 rounded-2xl h-full flex flex-col">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white">New Arrivals</h2>
            </div>

            <div class="flex-1 space-y-4">
                @forelse($recentProducts as $product)
                    <div class="flex items-center gap-4 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-blue-500/30 transition-all duration-300 group">
                        <div class="h-12 w-12 rounded-lg bg-dermond-dark overflow-hidden flex-shrink-0 border border-white/10">
                            @if($product->hasImage())
                                <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-500">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-white truncate group-hover:text-blue-400 transition-colors">{{ $product->name }}</h3>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider truncate">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-white font-mono">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            @if($product->stock < 5)
                                <p class="text-[10px] text-red-400 font-bold uppercase tracking-wider">Low Stock</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 text-sm">
                        <p>No products available yet.</p>
                        <a href="{{ route('admin.products.create') }}" class="text-blue-400 hover:underline mt-1 inline-block text-xs uppercase tracking-widest font-bold">Add One</a>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-6 pt-4 border-t border-white/10 text-center">
                <a href="{{ route('admin.products.index') }}" class="text-[10px] font-bold text-gray-500 hover:text-blue-400 uppercase tracking-widest transition-colors flex items-center justify-center gap-1 group">
                    View All Products
                    <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
        @endif

        @if($isContentManager)
        <!-- Recent Articles Panel -->
        <div class="bg-dermond-card border border-white/10 p-8 rounded-2xl h-full flex flex-col">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white">Recent Articles</h2>
            </div>

            <div class="flex-1 space-y-4">
                @forelse($recentArticles as $article)
                    <a href="{{ route('admin.articles.edit', $article) }}" class="flex items-center gap-4 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-blue-500/30 transition-all duration-300 group">
                        <div class="h-12 w-12 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400 flex-shrink-0 border border-blue-500/20">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-white truncate group-hover:text-blue-400 transition-colors">{{ $article->title }}</h3>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider truncate">
                                {{ $article->category->name ?? 'Uncategorized' }}
                            </p>
                        </div>
                        <div class="text-right">
                            @if($article->status === 'published')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Published</span>
                            @elseif($article->status === 'draft')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-500/10 text-gray-400 border border-gray-500/20">Draft</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-500/10 text-amber-400 border border-amber-500/20">Scheduled</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="text-center py-8 text-gray-500 text-sm">
                        <p>No articles yet.</p>
                        <a href="{{ route('admin.articles.create') }}" class="text-blue-400 hover:underline mt-1 inline-block text-xs uppercase tracking-widest font-bold">Write One</a>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-6 pt-4 border-t border-white/10 text-center">
                <a href="{{ route('admin.articles.index') }}" class="text-[10px] font-bold text-gray-500 hover:text-blue-400 uppercase tracking-widest transition-colors flex items-center justify-center gap-1 group">
                    View All Articles
                    <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
