@props(['article', 'index' => 0])

<article class="animate-fade-in-up"
         style="animation-delay: {{ $index * 100 }}ms"
         data-article
         data-id="{{ $article->id }}">
    <div class="group relative bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-blue-500/50 transition-all duration-300 h-full flex flex-col">
        {{-- Image --}}
        <a href="{{ route('articles.show', $article->slug) }}" class="block">
            <div class="aspect-[16/9] overflow-hidden">
                @if($article->hasImage())
                    <img src="{{ $article->getImageUrl() }}"
                         alt="{{ $article->title }}"
                         loading="lazy"
                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-blue-900/50 to-blue-600/30 flex items-center justify-center">
                        <svg class="w-16 h-16 text-blue-500/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                @endif
            </div>
        </a>

        {{-- Content --}}
        <div class="p-6 flex flex-col flex-grow">
            {{-- Meta Info --}}
            <div class="flex items-center gap-4 mb-4 text-xs font-bold tracking-wider text-blue-400 uppercase">
                @if($article->categories->isNotEmpty())
                    <span>{{ $article->categories->first()->name }}</span>
                    <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                @endif
                <span class="text-gray-500">{{ $article->published_at->format('M d, Y') }}</span>
            </div>

            {{-- Title --}}
            <a href="{{ route('articles.show', $article->slug) }}">
                <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors line-clamp-2">
                    {{ $article->title }}
                </h3>
            </a>

            {{-- Excerpt --}}
            @if($article->excerpt)
                <p class="text-gray-400 mb-6 line-clamp-2 flex-grow">
                    {{ $article->excerpt }}
                </p>
            @else
                <div class="flex-grow"></div>
            @endif

            {{-- Read Article Link --}}
            <a href="{{ route('articles.show', $article->slug) }}" class="inline-flex items-center gap-2 text-sm font-bold text-white hover:text-blue-400 transition-colors mt-auto">
                READ ARTICLE
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</article>
