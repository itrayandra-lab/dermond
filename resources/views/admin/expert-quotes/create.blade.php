@extends('admin.layouts.app')

@section('title', 'Create Expert Quote')

@section('content')
<div class="section-container section-padding max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-display font-medium text-white">Add Expert Quote</h1>
            <p class="mt-2 text-gray-400 font-light">Introduce your featured expert voice for the homepage.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.expert-quotes.index') }}" class="bg-white/5 border border-white/10 hover:bg-white/10 text-gray-300 hover:text-white px-4 py-2 rounded-xl font-bold uppercase tracking-wider text-xs inline-flex items-center justify-center transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </div>

    <div class="bg-dermond-card border border-white/10 p-8 rounded-2xl">
        @include('admin.expert-quotes._form')
    </div>
</div>
@endsection
