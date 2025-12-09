{{-- Dermond Footer --}}
@php
    $siteName = \App\Models\SiteSetting::getValue('general.site_name', 'Dermond');
    $instagramUrl = \App\Models\SiteSetting::getValue('social_media.instagram_url', '');
    $facebookUrl = \App\Models\SiteSetting::getValue('social_media.facebook_url', '');
    $youtubeUrl = \App\Models\SiteSetting::getValue('social_media.youtube_url', '');
@endphp

<footer id="contact" class="bg-[#020611] pt-24 pb-12 border-t border-white/5 scroll-mt-24">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Community Banner --}}
        <div class="bg-[#0f172a] rounded-2xl p-10 flex flex-col md:flex-row items-center justify-between gap-8 border border-white/5 mb-20 relative overflow-hidden group hover:border-blue-500/30 transition-colors">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            <div class="relative z-10 text-center md:text-left">
                <p class="text-blue-500 text-xs font-bold tracking-[0.2em] uppercase mb-2">Community</p>
                <h3 class="text-2xl font-bold text-white">Join our elite members</h3>
            </div>
            <div class="flex gap-4 grayscale opacity-50 relative z-10">
                <div class="w-12 h-12 bg-white/10 rounded-full animate-pulse-slow"></div>
                <div class="w-12 h-12 bg-white/10 rounded-full animate-pulse-slow" style="animation-delay: 75ms"></div>
                <div class="w-12 h-12 bg-white/10 rounded-full animate-pulse-slow" style="animation-delay: 150ms"></div>
                <div class="w-12 h-12 bg-white/10 rounded-full animate-pulse-slow" style="animation-delay: 300ms"></div>
            </div>
        </div>

        <div class="grid md:grid-cols-4 gap-12 mb-16">
            {{-- Brand --}}
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="text-white w-10 h-10">
                        <svg viewBox="0 0 100 100" fill="currentColor" class="w-full h-full">
                            <path d="M20 15 H 55 A 35 35 0 0 1 55 85 H 20 V 15 Z M 45 40 A 10 10 0 0 0 45 60 H 55 A 10 10 0 0 0 55 40 H 45 Z" fill-rule="evenodd"/>
                            <circle cx="45" cy="50" r="7"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-black tracking-[0.25em] text-white">DERMOND</span>
                </div>
                <p class="text-gray-500 max-w-sm text-sm leading-relaxed">
                    Redefining men's intimate care with science-backed formulas and premium ingredients. Elevate your daily routine with confidence.
                </p>
            </div>

            {{-- Explore Links --}}
            <div>
                <h4 class="text-white font-bold mb-6 tracking-wide uppercase text-sm">Explore</h4>
                <ul class="space-y-4 text-gray-500 text-sm font-medium">
                    <li><a href="{{ route('articles.index') }}" class="hover:text-blue-500 transition-colors">Blog</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-blue-500 transition-colors">Products</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-blue-500 transition-colors">Contact</a></li>
                </ul>
            </div>

            {{-- Connect --}}
            <div>
                <h4 class="text-white font-bold mb-6 tracking-wide uppercase text-sm">Connect</h4>
                <div class="flex gap-4 mb-8">
                    @if(! empty($facebookUrl))
                    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all hover:-translate-y-1">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif

                    @if(! empty($instagramUrl))
                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all hover:-translate-y-1">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif

                    @if(! empty($youtubeUrl))
                    <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all hover:-translate-y-1">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                <p class="text-gray-600 text-xs">
                    © {{ date('Y') }} {{ $siteName }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>
