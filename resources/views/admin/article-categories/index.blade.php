@extends('admin.layouts.app')

@section('title', 'Article Categories')

@section('content')
<div class="section-container section-padding">
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-display font-medium uppercase text-white mb-2 tracking-wide">
                Article Categories
            </h1>
            <p class="text-gray-400 font-light text-lg">
                Organize your articles and blog posts.
            </p>
        </div>
        <a href="{{ route('admin.article-categories.create') }}"
            class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold uppercase tracking-wider text-xs inline-flex items-center gap-2 group shadow-lg shadow-blue-900/30 transition-all">
            <span>Add Category</span>
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-900/30 border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 animate-fade-in-up">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-dermond-card border border-white/10 rounded-2xl p-4 mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
        <form method="GET" action="{{ route('admin.article-categories.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1 group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500 group-focus-within:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Search article categories..."
                    class="block w-full pl-11 pr-4 py-3 bg-dermond-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300"
                >
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all duration-300 shadow-lg shadow-blue-900/30">
                    Filter
                </button>
                
                @if (! empty($filters['search']))
                    <a href="{{ route('admin.article-categories.index') }}" class="px-4 py-3 flex items-center justify-center text-gray-400 hover:text-blue-400 transition-colors bg-white/5 hover:bg-white/10 rounded-xl border border-white/10" title="Reset">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-dermond-card border border-white/10 rounded-2xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Name</th>
                        <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Slug</th>
                        <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Description</th>
                        <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Articles</th>
                        <th class="px-8 py-6 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($categories as $category)
                        <tr class="group hover:bg-white/5 transition-colors duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white shadow-sm">
                                        <span class="font-bold text-lg">{{ substr($category->name, 0, 1) }}</span>
                                    </div>
                                    <div class="text-base font-bold text-white">{{ $category->name }}</div>
                                </div>
                            </td>

                            <td class="px-6 py-6">
                                <div class="text-sm text-gray-500 font-mono">/{{ $category->slug }}</div>
                            </td>

                            <td class="px-6 py-6">
                                <div class="text-sm text-gray-400 line-clamp-2 max-w-xs">
                                    {{ $category->description ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-300">{{ $category->articles_count }}</span>
                                    <span class="text-xs text-gray-500">articles</span>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-right">
                                <div class="inline-flex items-center gap-1 opacity-60 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-0 translate-x-4">
                                    <a href="{{ route('admin.article-categories.edit', $category) }}" 
                                       class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-blue-400 hover:bg-blue-500/10 transition-all"
                                       title="Edit Category">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.article-categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will remove the category from all articles.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all"
                                                title="Delete Category">
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
                            <td colspan="5" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-6">
                                        <svg class="w-10 h-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-white mb-2">No Categories Found</h3>
                                    <p class="text-gray-500 mb-8 max-w-sm mx-auto font-light">Create categories to structure your content effectively.</p>
                                    <a href="{{ route('admin.article-categories.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold uppercase tracking-wider text-xs shadow-lg shadow-blue-900/30 transition-all">
                                        Add First Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-8 py-6 border-t border-white/10 bg-white/5">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
