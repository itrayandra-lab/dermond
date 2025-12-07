@extends('admin.layouts.app')

@section('title', 'Articles')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold uppercase text-white mb-2 tracking-wide">
                    Articles
                </h1>
                <p class="text-gray-400 text-lg">
                    Kelola konten, berita, dan tips produk Anda.
                </p>
            </div>
            <a href="{{ route('admin.articles.create') }}"
                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-blue-900/30 inline-flex items-center gap-2 group">
                <span>Create New</span>
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
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

        <div class="bg-dermond-card border border-white/10 rounded-2xl p-3 mb-8">
            <form method="GET" action="{{ route('admin.articles.index') }}" class="flex flex-col md:flex-row gap-3">

                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500 group-focus-within:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari judul atau slug..."
                        class="block w-full pl-11 pr-4 py-3 bg-dermond-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <div class="relative min-w-[180px]">
                    <select name="status" class="block w-full pl-4 pr-10 py-3 bg-dermond-dark border border-white/10 rounded-xl text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="draft" @selected(($filters['status'] ?? '') === 'draft')>Draft</option>
                        <option value="scheduled" @selected(($filters['status'] ?? '') === 'scheduled')>Scheduled</option>
                        <option value="published" @selected(($filters['status'] ?? '') === 'published')>Published</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <label class="flex items-center gap-3 px-5 py-3 bg-white/5 rounded-xl cursor-pointer hover:bg-white/10 transition-all select-none border border-white/10">
                    <input type="checkbox" name="mine" value="1" @checked(!empty($filters['mine']))
                        class="w-5 h-5 rounded border-white/20 bg-dermond-dark text-blue-500 focus:ring-blue-500 transition-colors">
                    <span class="text-gray-300 font-medium">Artikel Saya</span>
                </label>

                <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all shadow-lg shadow-blue-900/30">
                    Filter
                </button>

                @if (!empty($filters['search']) || !empty($filters['status']) || !empty($filters['mine']))
                    <a href="{{ route('admin.articles.index') }}" class="px-4 py-3 flex items-center justify-center text-gray-400 hover:text-red-400 transition-colors" title="Reset Filters">
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
                            <th class="px-8 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Article Details</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Author</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-6 text-center text-xs font-bold text-gray-500 uppercase tracking-widest">Views</th>
                            <th class="px-8 py-6 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($articles as $article)
                            <tr class="group hover:bg-white/5 transition-colors duration-300">
                                <td class="px-8 py-6">
                                    <div class="flex items-start gap-5">
                                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-dermond-dark flex-shrink-0 relative border border-white/10 group-hover:border-blue-500/30 transition-all">
                                            @if ($article->hasImage())
                                                <img src="{{ $article->getImageUrl() }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-600">
                                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0 pt-1">
                                            <a href="{{ route('articles.show', $article->slug) }}" target="_blank" rel="noopener noreferrer"
                                                class="block text-lg font-bold text-white hover:text-blue-400 transition-colors mb-1 truncate">
                                                {{ $article->title }}
                                            </a>
                                            <div class="text-xs text-gray-500 font-mono mb-2 truncate max-w-xs">/{{ $article->slug }}</div>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($article->categories as $category)
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-white/5 border border-white/10 text-gray-400">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-6 align-top pt-8">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center text-blue-400 font-bold text-xs border border-blue-500/20">
                                            {{ substr($article->display_author, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-300">{{ $article->display_author }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-6 align-top pt-8">
                                    @if ($article->status === 'published')
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                                            </span>
                                            Published
                                        </span>
                                    @elseif($article->status === 'scheduled')
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                            Scheduled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                            <span class="h-2 w-2 rounded-full bg-gray-500"></span>
                                            Draft
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-6 align-top pt-8">
                                    <div class="flex flex-col">
                                        @if ($article->published_at)
                                            <span class="text-sm font-bold text-white">{{ $article->published_at->format('d M Y') }}</span>
                                            <span class="text-xs text-gray-500 mt-0.5">{{ $article->published_at->format('H:i') }} WIB</span>
                                        @elseif($article->scheduled_at)
                                            <span class="text-sm font-bold text-amber-400">{{ $article->scheduled_at->format('d M Y') }}</span>
                                            <span class="text-xs text-amber-400/70 mt-0.5">Will publish at {{ $article->scheduled_at->format('H:i') }}</span>
                                        @else
                                            <span class="text-gray-500 text-sm">—</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-6 align-top pt-8 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-bold text-white">{{ number_format($article->views_count) }}</span>
                                        <span class="text-[10px] text-gray-500 uppercase tracking-wider">views</span>
                                    </div>
                                </td>

                                <td class="px-8 py-6 align-middle text-right">
                                    <div class="inline-flex items-center gap-1 opacity-60 group-hover:opacity-100 transition-all">
                                        <a href="{{ route('admin.articles.edit', $article) }}"
                                            class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-blue-400 hover:bg-blue-500/10 transition-all" title="Edit Article">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all" title="Delete Article">
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
                                <td colspan="6" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6 border border-white/10">
                                            <svg class="w-10 h-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-white mb-2">Belum ada artikel</h3>
                                        <p class="text-gray-500 mb-8 max-w-sm mx-auto">Mulai bagikan konten dengan membuat artikel pertama Anda.</p>
                                        <a href="{{ route('admin.articles.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all shadow-lg shadow-blue-900/30">
                                            Create First Article
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($articles->hasPages())
                <div class="px-8 py-6 border-t border-white/10">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
