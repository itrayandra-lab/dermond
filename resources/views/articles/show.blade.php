@extends('layouts.app')

@section('title', $article->title . ' - Dermond')

@section('content')
    @php
        $readingTime = max(1, (int) ceil(str_word_count(strip_tags($article->body ?? '')) / 200));
        $firstCategory = $article->categories->first();
        $publishedDate = $article->published_at
            ? $article->published_at->format('F j, Y')
            : $article->created_at->format('F j, Y');
    @endphp

    <article class="pt-32 pb-20 px-6 min-h-screen bg-dermond-dark">
        <div class="max-w-4xl mx-auto">
            {{-- Back Link --}}
            <a href="{{ route('articles.index') }}" 
               class="inline-flex items-center gap-2 text-gray-400 hover:text-blue-400 transition-colors mb-8 group">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="font-medium">Back to Articles</span>
            </a>

            {{-- Header --}}
            <header class="mb-12 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-900/30 border border-blue-500/30 text-blue-400 text-xs font-bold tracking-widest uppercase mb-6">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    {{ $firstCategory?->name ?? 'Journal' }}
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight">
                    {{ $article->title }}
                </h1>
                @if ($article->excerpt)
                    <p class="text-xl text-gray-400 max-w-3xl mx-auto leading-relaxed mb-6">
                        {{ $article->excerpt }}
                    </p>
                @endif
                <div class="flex items-center justify-center gap-6 text-gray-400 text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $publishedDate }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $readingTime }} min read</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span>{{ number_format($article->views_count) }} views</span>
                    </div>
                </div>
            </header>

            {{-- Featured Image --}}
            <div class="aspect-[21/9] w-full overflow-hidden rounded-2xl border border-white/10 mb-12">
                @if ($article->hasImage())
                    <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-blue-900/30 to-blue-600/10 flex items-center justify-center">
                        <span class="text-gray-600">No Image</span>
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="article-content-dark prose prose-lg prose-invert mx-auto">
                <x-rich-text::styles />
                @include('rich-text-laravel::content', ['content' => $article->body])
            </div>

            {{-- Tags & Share Section --}}
            <div class="mt-16 pt-8 border-t border-white/10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-widest mr-2">Tags:</span>
                    @forelse($article->tags as $tag)
                        <span class="px-4 py-2 rounded-full bg-blue-900/30 border border-blue-500/30 text-blue-400 text-xs font-bold uppercase tracking-wide hover:bg-blue-900/50 transition-all cursor-pointer">
                            #{{ $tag->name }}
                        </span>
                    @empty
                        <span class="text-sm text-gray-600">No tags</span>
                    @endforelse
                </div>
                <button type="button"
                    class="flex items-center gap-2 px-6 py-3 rounded-full border border-white/10 text-xs font-bold tracking-widest text-white hover:bg-white/5 transition-all uppercase"
                    onclick="navigator.clipboard?.writeText('{{ url()->current() }}'); alert('Link copied to clipboard!')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                        </path>
                    </svg>
                    Share Article
                </button>
            </div>
        </div>

        {{-- Related Articles --}}
        @if ($relatedArticles->isNotEmpty())
            <div class="max-w-7xl mx-auto mt-24">
                <div class="text-center mb-12">
                    <span class="text-blue-500 font-bold italic tracking-widest text-sm uppercase mb-2 block">Continue Reading</span>
                    <h2 class="text-4xl md:text-5xl font-black text-white">RELATED ARTICLES</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($relatedArticles as $index => $relatedArticle)
                        <x-article-card :article="$relatedArticle" :index="$index" />
                    @endforeach
                </div>
            </div>
        @endif
    </article>

    <style>
        /* Dark Theme Article Content Typography */
        .article-content-dark {
            --tw-prose-body: theme('colors.gray.300');
            --tw-prose-headings: theme('colors.white');
            --tw-prose-links: theme('colors.blue.400');
            --tw-prose-bold: theme('colors.white');
            --tw-prose-counters: theme('colors.gray.400');
            --tw-prose-bullets: theme('colors.blue.500');
            --tw-prose-hr: theme('colors.white / 10%');
            --tw-prose-quotes: theme('colors.gray.300');
            --tw-prose-quote-borders: theme('colors.blue.500');
            --tw-prose-captions: theme('colors.gray.400');
            --tw-prose-code: theme('colors.blue.400');
            --tw-prose-pre-code: theme('colors.gray.200');
            --tw-prose-pre-bg: theme('colors.gray.900');
            --tw-prose-th-borders: theme('colors.white / 10%');
            --tw-prose-td-borders: theme('colors.white / 10%');
        }

        .article-content-dark p {
            @apply text-lg md:text-xl text-gray-300 leading-[1.8] mb-8;
        }

        .article-content-dark h2 {
            @apply text-3xl md:text-4xl font-bold text-white mt-16 mb-8;
        }

        .article-content-dark h3 {
            @apply text-2xl md:text-3xl font-bold text-white mt-12 mb-6;
        }

        .article-content-dark h4 {
            @apply text-xl md:text-2xl font-bold text-white mt-10 mb-4;
        }

        .article-content-dark a {
            @apply text-blue-400 hover:text-blue-300 transition-colors;
        }

        .article-content-dark strong,
        .article-content-dark b {
            @apply font-bold text-white;
        }

        .article-content-dark blockquote {
            @apply border-l-4 border-blue-500 bg-blue-900/20 py-6 px-8 my-10 rounded-r-xl;
        }

        .article-content-dark blockquote p {
            @apply text-gray-300 text-xl mb-0;
        }

        .article-content-dark ul,
        .article-content-dark ol {
            @apply my-8 pl-6 space-y-3;
        }

        .article-content-dark li {
            @apply text-lg text-gray-300;
        }

        .article-content-dark img {
            @apply rounded-2xl border border-white/10 my-10;
        }

        .article-content-dark pre {
            @apply bg-dermond-nav rounded-xl p-6 my-8 overflow-x-auto border border-white/10;
        }

        .article-content-dark :not(pre) > code {
            @apply bg-blue-900/30 text-blue-400 px-2 py-1 rounded text-base;
        }

        .article-content-dark hr {
            @apply my-16 border-0 h-px bg-white/10;
        }

        .article-content-dark table {
            @apply w-full my-10 border-collapse;
        }

        .article-content-dark th {
            @apply px-4 py-3 text-left font-bold text-white uppercase tracking-wider text-sm border-b border-white/10 bg-white/5;
        }

        .article-content-dark td {
            @apply px-4 py-3 text-gray-300 border-b border-white/10;
        }

        .article-content-dark tbody tr:hover {
            @apply bg-white/5;
        }
    </style>
@endsection
