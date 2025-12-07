@extends('layouts.app')

@section('title', $category->name . ' Articles')

@section('content')
<div class="min-h-screen bg-dermond-dark pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-400">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('articles.index') }}" class="hover:text-blue-400">Articles</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $category->name }}</span>
        </nav>

        <!-- Category Header -->
        <div class="text-center mb-12">
            @if($category->icon)
                <div class="text-6xl mb-4">{{ $category->icon }}</div>
            @endif
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                    {{ $category->description }}
                </p>
            @endif
        </div>

        <!-- Categories Filter -->
        @if($categories->isNotEmpty())
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 mb-8">
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="{{ route('articles.index') }}"
                       class="px-4 py-2 rounded-xl bg-dermond-dark border border-white/10 hover:border-blue-500/50 text-gray-400 transition-all">
                        All Articles
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('articles.category', $cat->slug) }}"
                           class="px-4 py-2 rounded-xl transition-all {{ $cat->id === $category->id ? 'bg-blue-600 text-white' : 'bg-dermond-dark border border-white/10 hover:border-blue-500/50 text-gray-400' }}">
                            {{ $cat->name }}
                            <span class="text-xs opacity-75">({{ $cat->articles_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            @forelse($articles as $index => $article)
                <x-article-card :article="$article" :index="$index" />
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No articles found in this category.</p>
                    <a href="{{ route('articles.index') }}" class="text-blue-400 hover:text-blue-300 mt-4 inline-block">
                        View all articles
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="flex justify-center">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
