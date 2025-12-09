@php
    $siteName = \App\Models\SiteSetting::getValue('general.site_name', 'Dermond');
    $supportEmail = \App\Models\SiteSetting::getValue('contact.support_email', 'support@dermond.com');
    $contactPhone = \App\Models\SiteSetting::getValue('contact.phone', '');
    $businessAddress = \App\Models\SiteSetting::getValue('contact.address', '');
    $businessHours = \App\Models\SiteSetting::getValue('contact.business_hours', 'Senin - Jumat: 09:00 - 17:00 WIB');
    $googleMapsEmbed = \App\Models\SiteSetting::getValue('contact.google_maps_embed', '');
    $instagramUrl = \App\Models\SiteSetting::getValue('social_media.instagram_url', '');
    $facebookUrl = \App\Models\SiteSetting::getValue('social_media.facebook_url', '');
    $youtubeUrl = \App\Models\SiteSetting::getValue('social_media.youtube_url', '');
@endphp

@extends('layouts.app')

@section('title', 'Contact - ' . $siteName)

@section('content')
    <div class="pt-28 pb-20 bg-dermond-dark min-h-screen">
        <div class="container mx-auto px-6 md:px-8">
            {{-- Hero Section --}}
            <div class="text-center mb-12">
                <p class="text-xs font-bold tracking-widest text-blue-400 uppercase mb-2">Get In Touch</p>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Contact</h1>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Have questions or need assistance? Our team is here to help you.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                {{-- Contact Form --}}
                <div class="bg-dermond-card border border-white/10 p-6 md:p-8 rounded-2xl">
                    <h2 class="text-xl font-bold text-white mb-6">Send Message</h2>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-900/30 border border-green-500/30 rounded-xl text-green-400 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form
                        action="{{ route('contact.store') }}"
                        method="POST"
                        x-data="{ loading: false }"
                        @submit="loading = true"
                    >
                        @csrf

                        <div class="space-y-5">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">
                                    Name <span class="text-red-400">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="w-full px-4 py-3 bg-dermond-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('name') border-red-500/50 @enderror"
                                    placeholder="Your full name"
                                    required
                                >
                                @error('name')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">
                                    Email <span class="text-red-400">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="w-full px-4 py-3 bg-dermond-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('email') border-red-500/50 @enderror"
                                    placeholder="email@example.com"
                                    required
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Subject --}}
                            <div>
                                <label for="subject" class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">
                                    Subject <span class="text-red-400">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    value="{{ old('subject') }}"
                                    class="w-full px-4 py-3 bg-dermond-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('subject') border-red-500/50 @enderror"
                                    placeholder="Message subject"
                                    required
                                >
                                @error('subject')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Message --}}
                            <div>
                                <label for="message" class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">
                                    Message <span class="text-red-400">*</span>
                                </label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="5"
                                    class="w-full px-4 py-3 bg-dermond-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none @error('message') border-red-500/50 @enderror"
                                    placeholder="Write your message here..."
                                    required
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <button
                                type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-500 text-white font-medium py-3 px-6 rounded-xl transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="loading"
                            >
                                <template x-if="loading">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <span x-text="loading ? 'Sending...' : 'Send Message'"></span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Contact Info --}}
                <div class="space-y-6">
                    {{-- Contact Details Card --}}
                    <div class="bg-dermond-card border border-white/10 p-6 md:p-8 rounded-2xl">
                        <h2 class="text-xl font-bold text-white mb-6">Contact Information</h2>

                        <div class="space-y-5">
                            {{-- Email --}}
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-blue-900/30 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</p>
                                    <a href="mailto:{{ $supportEmail }}" class="text-white hover:text-blue-400 transition-colors">
                                        {{ $supportEmail }}
                                    </a>
                                </div>
                            </div>

                            {{-- WhatsApp --}}
                            @if($contactPhone)
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-green-900/30 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">WhatsApp</p>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactPhone) }}" target="_blank" class="text-white hover:text-blue-400 transition-colors">
                                        {{ $contactPhone }}
                                    </a>
                                </div>
                            </div>
                            @endif

                            {{-- Address --}}
                            @if($businessAddress)
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-blue-900/30 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Address</p>
                                    <p class="text-white">{{ $businessAddress }}</p>
                                </div>
                            </div>
                            @endif

                            {{-- Business Hours --}}
                            @if($businessHours)
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-blue-900/30 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Business Hours</p>
                                    <p class="text-white">{{ $businessHours }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Social Links Card --}}
                    @if($instagramUrl || $facebookUrl || $youtubeUrl)
                    <div class="bg-dermond-card border border-white/10 p-6 md:p-8 rounded-2xl">
                        <h2 class="text-xl font-bold text-white mb-6">Follow Us</h2>
                        <div class="flex gap-3">
                            @if($instagramUrl)
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-400 rounded-xl flex items-center justify-center hover:opacity-90 transition-opacity">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            @endif
                            @if($facebookUrl)
                            <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center hover:opacity-90 transition-opacity">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            @endif
                            @if($youtubeUrl)
                            <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center hover:opacity-90 transition-opacity">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Google Maps Embed --}}
            @if($googleMapsEmbed)
            <div class="mt-12 max-w-6xl mx-auto">
                <div class="bg-dermond-card border border-white/10 p-2 rounded-2xl">
                    <div class="aspect-video rounded-xl overflow-hidden">
                        <iframe
                            src="{{ $googleMapsEmbed }}"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-full"
                        ></iframe>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
