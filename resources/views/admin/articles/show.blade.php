@extends('admin.layouts.app')

@section('title', $article->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-white">{{ $article->title }}</h1>
            <p class="text-gray-400 mt-1">Published {{ $article->published_at?->diffForHumans() ?? 'Not published' }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.articles.edit', $article) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-sm font-bold transition-colors">
                Edit
            </a>
            <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 bg-white/5 border border-white/10 hover:bg-white/10 text-gray-300 rounded-xl text-sm font-bold transition-colors">
                Back
            </a>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <div class="text-xs text-gray-500 uppercase">Status</div>
                <div class="mt-1">
                    @if($article->status === 'published')
                        <span class="px-2 py-1 text-xs font-bold rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Published</span>
                    @elseif($article->status === 'scheduled')
                        <span class="px-2 py-1 text-xs font-bold rounded-lg bg-amber-500/10 text-amber-400 border border-amber-500/20">Scheduled</span>
                    @else
                        <span class="px-2 py-1 text-xs font-bold rounded-lg bg-gray-500/10 text-gray-400 border border-gray-500/20">Draft</span>
                    @endif
                </div>
            </div>
            <div>
                <div class="text-xs text-gray-500 uppercase">Author</div>
                <div class="mt-1 text-sm text-white">{{ $article->display_author }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-500 uppercase">Views</div>
                <div class="mt-1 text-sm text-white">{{ number_format($article->views_count) }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-500 uppercase">Created</div>
                <div class="mt-1 text-sm text-white">{{ $article->created_at->format('M d, Y') }}</div>
            </div>
        </div>

        @if($article->hasImage())
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-3">Thumbnail</h2>
                <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}" class="w-full h-64 object-cover rounded-xl">
            </div>
        @endif

        @if($article->excerpt)
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-3">Excerpt</h2>
                <p class="text-gray-400">{{ $article->excerpt }}</p>
            </div>
        @endif

        <div class="bg-dermond-card border border-white/10 rounded-2xl p-6">
            <h2 class="text-lg font-bold text-white mb-3">Content</h2>
            <div class="prose prose-lg prose-invert max-w-none">
                <x-rich-text::styles />
                @include('rich-text-laravel::content', ['content' => $article->body])
            </div>
        </div>

        <div class="bg-dermond-card border border-white/10 rounded-2xl p-6">
            <h2 class="text-lg font-bold text-white mb-3">Categories</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($article->categories as $category)
                    <span class="px-3 py-1 text-sm rounded-lg bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">{{ $category->name }}</span>
                @endforeach
            </div>
        </div>

        @if($article->tags->isNotEmpty())
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-3">Tags</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                        <span class="px-3 py-1 text-sm rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/20">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
