@extends('admin.layouts.app')

@section('title', isset($category) ? 'Edit Article Category' : 'Add New Article Category')

@section('content')
    <div class="section-container section-padding max-w-3xl mx-auto">

        <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <h1 class="text-4xl md:text-5xl font-display font-medium uppercase text-white mb-2">
                    {{ isset($category) ? 'Edit Category' : 'New Category' }}
                </h1>
                <p class="text-gray-400 font-light">
                    {{ isset($category) ? 'Update category details.' : 'Create a new classification for your articles.' }}
                </p>
            </div>

            <a href="{{ route('admin.article-categories.index') }}"
                class="group flex items-center gap-2 text-gray-400 hover:text-blue-400 transition-colors">
                <div
                    class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center group-hover:border-blue-500/30 group-hover:bg-blue-500/10 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-widest">Back to List</span>
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-900/30 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl mb-8 animate-fade-in-up">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="font-bold uppercase tracking-wider text-sm">Please check the form</h3>
                </div>
                <ul class="list-disc list-inside text-sm opacity-80 pl-8">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $isEdit = $isEdit ?? false;
        @endphp

        <form
            action="{{ $isEdit ? route('admin.article-categories.update', $category) : route('admin.article-categories.store') }}"
            method="POST" class="space-y-6">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8 space-y-8">

                <div>
                    <label for="name"
                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Category Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}"
                        class="w-full px-0 py-2 text-2xl md:text-3xl font-medium text-white bg-transparent border-0 border-b-2 border-white/10 focus:border-blue-500 focus:ring-0 placeholder-gray-600 transition-colors"
                        placeholder="e.g. Beauty Tips" required>
                    <p class="text-xs text-gray-500 mt-2">This name will be displayed in the blog navigation.</p>
                </div>

                <div>
                    <label for="slug" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Slug
                        (Optional)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug ?? '') }}"
                        class="w-full px-4 py-3 rounded-xl bg-dermond-dark border border-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-mono text-gray-300 placeholder-gray-600"
                        placeholder="beauty-tips">
                    <p class="text-xs text-gray-500 mt-2">Leave blank to auto-generate from name.</p>
                </div>

                <div>
                    <label for="description"
                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 rounded-xl bg-dermond-dark border border-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm text-gray-300 placeholder-gray-600"
                        placeholder="Brief description of this category...">{{ old('description', $category->description ?? '') }}</textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.article-categories.index') }}"
                        class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-xl font-bold uppercase tracking-wider text-xs shadow-lg shadow-blue-900/30 transition-all flex items-center gap-2">
                        <span>{{ isset($category) ? 'Save Changes' : 'Create Category' }}</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
