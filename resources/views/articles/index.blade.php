@extends('layouts.app')

@section('title', 'Blog - Dermond Insights')

@section('content')
    <div class="pt-32 pb-20 px-6 max-w-7xl mx-auto min-h-screen">
        {{-- Page Header --}}
        <div class="text-center mb-20">
            <div class="inline-block mb-4 px-4 py-1 rounded-full bg-blue-900/30 border border-blue-500/30 text-blue-400 text-sm font-bold tracking-widest uppercase">
                HIGHLIGHT ARTICLES
            </div>
            <h1 class="text-5xl md:text-7xl font-black italic tracking-tighter text-white mb-8">
                DERMOND <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-blue-600 pr-3">INSIGHTS</span>
            </h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto leading-relaxed">
            Deep dive into <span class="text-white font-semibold">Intimate Care</span>, men's health, and modern lifestyle.
            </p>
        </div>

        {{-- Search Bar --}}
        <div class="max-w-2xl mx-auto mb-12">
            <form method="GET" action="{{ route('articles.index') }}" class="relative">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500 group-focus-within:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text"
                           name="search"
                           value="{{ $searchQuery ?? '' }}"
                           placeholder="Search articles, tips, or topics..."
                           class="block w-full pl-14 pr-32 py-4 bg-white/5 border border-white/10 rounded-full text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300">
                    <div class="absolute inset-y-0 right-2 flex items-center">
                        @if(request('search'))
                            <a href="{{ route('articles.index', request('category') ? ['category' => request('category')] : []) }}"
                               class="mr-2 p-2 text-gray-500 hover:text-white transition-colors"
                               title="Clear search">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full text-xs font-bold tracking-widest uppercase transition-all duration-300">
                            Search
                        </button>
                    </div>
                </div>
            </form>
            @if(request('search'))
                <p class="text-center text-sm text-gray-500 mt-4">
                    Showing results for "<span class="font-medium text-white">{{ request('search') }}</span>"
                    <span class="text-gray-600">({{ $articles->total() }} {{ Str::plural('article', $articles->total()) }} found)</span>
                </p>
            @endif
        </div>

        {{-- Category Filter --}}
        @if($categories->isNotEmpty())
            <div class="mb-16" x-data="{ scrollContainer: null }" x-init="scrollContainer = $refs.categoryScroll">
                <div class="relative max-w-5xl mx-auto px-4 md:px-12">
                    {{-- Left Arrow --}}
                    <button @click="scrollContainer?.scrollBy({ left: -300, behavior: 'smooth' })"
                            class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:bg-white/10 text-gray-400 hover:text-white transition-all duration-300 hidden md:flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    {{-- Category Buttons Container --}}
                    <div x-ref="categoryScroll" class="flex gap-4 overflow-x-auto hide-scrollbar scroll-smooth">
                        <a href="{{ route('articles.index') }}"
                           class="flex-shrink-0 px-8 py-3 rounded-full text-xs font-bold tracking-widest uppercase transition-all duration-300 border whitespace-nowrap
                                  {{ !request('category')
                                      ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-600/30'
                                      : 'bg-white/5 border-white/10 text-gray-400 hover:border-blue-500/50 hover:text-blue-400' }}">
                            All Articles
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('articles.index', ['category' => $category->slug]) }}"
                               class="flex-shrink-0 px-8 py-3 rounded-full text-xs font-bold tracking-widest uppercase transition-all duration-300 border whitespace-nowrap
                                      {{ request('category') === $category->slug
                                          ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-600/30'
                                          : 'bg-white/5 border-white/10 text-gray-400 hover:border-blue-500/50 hover:text-blue-400' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Right Arrow --}}
                    <button @click="scrollContainer?.scrollBy({ left: 300, behavior: 'smooth' })"
                            class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:bg-white/10 text-gray-400 hover:text-white transition-all duration-300 hidden md:flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Featured Article --}}
        @if($featuredArticle)
            <div class="mb-16">
                <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="block group">
                    <div class="relative bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-blue-500/50 transition-all duration-300">
                        <div class="grid md:grid-cols-2 gap-0">
                            {{-- Image --}}
                            <div class="aspect-[16/9] md:aspect-auto overflow-hidden">
                                @if($featuredArticle->hasImage())
                                    <img src="{{ $featuredArticle->getImageUrl() }}"
                                         alt="{{ $featuredArticle->title }}"
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full min-h-[300px] bg-gradient-to-br from-blue-900/50 to-blue-600/30 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-blue-500/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            {{-- Content --}}
                            <div class="p-8 md:p-12 flex flex-col justify-center">
                                <div class="inline-block mb-4 px-3 py-1 rounded-full bg-blue-900/30 border border-blue-500/30 text-blue-400 text-xs font-bold tracking-widest uppercase w-fit">
                                    FEATURED
                                </div>
                                <div class="flex items-center gap-4 mb-4 text-xs font-bold tracking-wider text-blue-400 uppercase">
                                    @if($featuredArticle->categories->isNotEmpty())
                                        <span>{{ $featuredArticle->categories->first()->name }}</span>
                                        <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                                    @endif
                                    <span class="text-gray-500">{{ $featuredArticle->published_at->format('M d, Y') }}</span>
                                </div>
                                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4 group-hover:text-blue-400 transition-colors">
                                    {{ $featuredArticle->title }}
                                </h2>
                                @if($featuredArticle->excerpt)
                                    <p class="text-gray-400 mb-6 line-clamp-3">
                                        {{ $featuredArticle->excerpt }}
                                    </p>
                                @endif
                                <div class="inline-flex items-center gap-2 text-sm font-bold text-white group-hover:text-blue-400 transition-colors">
                                    READ ARTICLE
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        {{-- Articles Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16"
             x-data="articleLoader()"
             x-init="init()">
            @forelse($articles as $article)
                <x-article-card :article="$article" :index="$loop->index" />
            @empty
                <div class="col-span-full text-center py-24">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/5 border border-white/10 mb-6">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white uppercase mb-2">NO ARTICLES FOUND</h3>
                    <p class="text-gray-500 mb-8">We couldn't find any articles matching your selection.</p>
                    <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-blue-400 font-bold tracking-widest uppercase text-xs hover:text-blue-300 transition-colors">
                        View All Articles
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            @endforelse

            {{-- AJAX-loaded Articles Container --}}
            <template x-for="(article, index) in ajaxArticles" :key="article.id">
                <div x-html="renderArticleCard(article, index)" class="animate-fade-in-up"></div>
            </template>
        </div>

        {{-- Load More Button --}}
        <template x-if="hasMorePages && initialArticleCount > 0">
            <div class="text-center pb-12">
                <button @click="loadMore()"
                        :disabled="loading"
                        class="group relative inline-flex items-center justify-center px-12 py-4 overflow-hidden font-bold text-white transition-all duration-300 bg-blue-600 rounded-full hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/30 focus:outline-none disabled:opacity-60 disabled:cursor-not-allowed gap-2">
                    <span class="relative flex items-center gap-2 text-xs tracking-widest uppercase">
                        <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span x-text="loading ? 'Loading...' : 'Load More Articles'"></span>
                    </span>
                </button>
            </div>
        </template>

        {{-- End of Articles Message --}}
        <template x-if="!hasMorePages && ajaxArticles.length > 0">
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-xs font-bold tracking-widest uppercase">You've reached the end</p>
            </div>
        </template>
    </div>

    <script>
        function articleLoader() {
            return {
                ajaxArticles: [],
                currentPage: {{ $articles->currentPage() }},
                initialArticleCount: {{ $articles->count() }},
                categoryFilter: '{{ request('category', '') }}',
                searchQuery: '{{ request('search', '') }}',
                featuredArticleId: {{ $featuredArticle ? $featuredArticle->id : 'null' }},
                loading: false,
                hasMorePages: {{ $articles->hasMorePages() ? 'true' : 'false' }},

                init() {
                    // Initialize component
                },

                async loadMore() {
                    if (this.loading || !this.hasMorePages) return;

                    this.loading = true;

                    try {
                        const response = await axios.post('/articles/load-more', {
                            page: this.currentPage + 1,
                            category: this.categoryFilter,
                            search: this.searchQuery,
                            exclude_id: this.featuredArticleId
                        });

                        if (response.data.html) {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(response.data.html, 'text/html');
                            const articles = doc.querySelectorAll('[data-article]');

                            articles.forEach(articleEl => {
                                this.ajaxArticles.push({
                                    id: articleEl.dataset.id,
                                    html: articleEl.outerHTML
                                });
                            });
                        }

                        this.hasMorePages = response.data.has_more;
                        this.currentPage++;
                    } catch (error) {
                        console.error('Error loading articles:', error);
                        alert('Failed to load more articles. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                },

                renderArticleCard(article, index) {
                    return article.html;
                }
            };
        }
    </script>
@endsection
