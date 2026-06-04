@extends('admin.layouts.app')

@section('title', 'Bundles')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold uppercase text-white mb-2">Bundles</h1>
            <p class="text-gray-400">Manage exclusive product bundles displayed on the homepage.</p>
        </div>
        <a href="{{ route('admin.bundles.create') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all shadow-lg shadow-blue-900/30">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Bundle
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-900/30 border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-dermond-card border border-white/10 rounded-2xl overflow-hidden">
        @if($bundles->isEmpty())
            <div class="text-center py-20 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p class="text-sm">No bundles yet. <a href="{{ route('admin.bundles.create') }}" class="text-blue-400 hover:underline">Create the first one.</a></p>
            </div>
        @else
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Bundle</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest hidden md:table-cell">Price</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest hidden md:table-cell">Images</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($bundles as $bundle)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if($bundle->hasImages())
                                    <img src="{{ $bundle->getFirstImageUrl() }}" class="w-12 h-12 object-cover rounded-xl bg-dermond-dark" alt="{{ $bundle->name }}">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-dermond-dark flex items-center justify-center text-gray-600">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-white text-sm">{{ $bundle->name }}</p>
                                    @if($bundle->subtitle)
                                        <p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($bundle->subtitle, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            <p class="text-white font-mono font-medium text-sm">Rp {{ number_format($bundle->price, 0, ',', '.') }}</p>
                            @if($bundle->hasSavings())
                                <p class="text-xs text-green-400 mt-0.5">Hemat Rp {{ number_format($bundle->getSavingsAmount(), 0, ',', '.') }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            <span class="text-sm text-gray-400">{{ $bundle->getMedia('bundle_images')->count() }} foto</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                {{ $bundle->status === 'published' ? 'bg-green-500/10 text-green-400' : ($bundle->status === 'draft' ? 'bg-yellow-500/10 text-yellow-400' : 'bg-gray-500/10 text-gray-400') }}">
                                {{ ucfirst($bundle->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.bundles.edit', $bundle) }}"
                                   class="text-gray-400 hover:text-blue-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.bundles.destroy', $bundle) }}" method="POST"
                                      onsubmit="return confirm('Delete this bundle?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($bundles->hasPages())
                <div class="px-6 py-4 border-t border-white/5">
                    {{ $bundles->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
