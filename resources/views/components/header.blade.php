{{-- Dermond Header with Alpine.js --}}
@php $forceScrolled = $forceScrolled ?? false; @endphp
<div
    x-data="{
        forceScrolled: {{ $forceScrolled ? 'true' : 'false' }},
        isScrolled: {{ $forceScrolled ? 'true' : 'false' }},
        isMobileMenuOpen: false,
        cartCount: 0,
        init() {
            let scrollHandler = () => { this.isScrolled = this.forceScrolled || window.scrollY > 20 };
            scrollHandler();
            window.addEventListener('scroll', scrollHandler);
            this.$el.addEventListener('destroy', () => window.removeEventListener('scroll', scrollHandler));
            this.fetchCartCount();
            window.addEventListener('cart-updated', () => this.fetchCartCount());
        },
        async fetchCartCount() {
            try {
                const response = await axios.get('{{ route('cart.count') }}');
                this.cartCount = response.data.count ?? 0;
            } catch (error) {
                console.error('Failed to fetch cart count', error);
            }
        }
    }"
    x-init="init()"
>
    <nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-md bg-[#0a1226]/80 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="text-white w-10 h-10 hover:opacity-80 transition-opacity">
                    <svg viewBox="0 0 100 100" fill="currentColor" class="w-full h-full">
                        <path d="M20 15 H 55 A 35 35 0 0 1 55 85 H 20 V 15 Z M 45 40 A 10 10 0 0 0 45 60 H 55 A 10 10 0 0 0 55 40 H 45 Z" fill-rule="evenodd"/>
                        <circle cx="45" cy="50" r="7"/>
                    </svg>
                </a>
                <a href="{{ url('/') }}" class="text-3xl font-black italic tracking-[0.25em] text-white hover:text-gray-300 transition-colors">
                    DERMOND
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-400">
                <a href="{{ url('/') }}" class="hover:text-blue-500 transition-colors">HOME</a>
                <a href="{{ route('articles.index') }}" class="hover:text-blue-500 transition-colors">BLOG</a>
                <a href="{{ route('products.index') }}" class="hover:text-blue-500 transition-colors">PRODUCTS</a>
                <a href="#features" class="hover:text-blue-500 transition-colors">WHY US</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-500 transition-colors">CONTACT</a>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-6">
                {{-- Auth Buttons --}}
                @guest
                <a href="{{ route('login') }}" class="hidden md:flex items-center gap-2 px-4 py-2 border border-blue-600/30 rounded text-blue-500 hover:bg-blue-600/10 transition-all text-sm uppercase tracking-widest font-bold">
                    Sign In
                </a>
                @endguest

                @auth('web')
                <a href="{{ route('customer.dashboard') }}" class="hidden md:flex items-center gap-2 px-4 py-2 border border-blue-600/30 rounded text-blue-500 hover:bg-blue-600/10 transition-all text-sm uppercase tracking-widest font-bold">
                    Account
                </a>
                @endauth

                @auth('admin')
                <a href="{{ route('admin.dashboard') }}" class="hidden md:flex items-center gap-2 px-4 py-2 border border-blue-600/30 rounded text-blue-500 hover:bg-blue-600/10 transition-all text-sm uppercase tracking-widest font-bold">
                    Admin
                </a>
                @endauth

                {{-- Cart Icon --}}
                <a href="{{ route('cart.index') }}" class="text-white hover:text-blue-500 transition-colors relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <template x-if="cartCount > 0">
                        <span class="absolute -top-2 -right-2 min-w-[18px] h-[18px] bg-blue-600 text-white text-[10px] font-bold flex items-center justify-center rounded-full px-1">
                            <span x-text="cartCount"></span>
                        </span>
                    </template>
                </a>

                {{-- Mobile Menu Toggle --}}
                <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden text-white">
                    <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="isMobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu Overlay --}}
    <div
        x-show="isMobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        @keydown.escape.window="isMobileMenuOpen = false"
        class="fixed inset-0 bg-[#050a14] z-40 md:hidden pt-24"
        x-cloak
    >
        <div class="flex flex-col items-center gap-8 p-8 text-lg font-bold tracking-wider text-gray-300">
            <a href="{{ url('/') }}" @click="isMobileMenuOpen = false" class="hover:text-blue-500 transition-colors w-full text-center py-4 border-b border-white/5">HOME</a>
            <a href="{{ route('articles.index') }}" @click="isMobileMenuOpen = false" class="hover:text-blue-500 transition-colors w-full text-center py-4 border-b border-white/5">BLOG</a>
            <a href="{{ route('products.index') }}" @click="isMobileMenuOpen = false" class="hover:text-blue-500 transition-colors w-full text-center py-4 border-b border-white/5">PRODUCTS</a>
            <a href="#features" @click="isMobileMenuOpen = false" class="hover:text-blue-500 transition-colors w-full text-center py-4 border-b border-white/5">WHY US</a>
            <a href="{{ route('contact') }}" @click="isMobileMenuOpen = false" class="hover:text-blue-500 transition-colors w-full text-center py-4 border-b border-white/5">CONTACT</a>

            @guest
            <a href="{{ route('login') }}" class="mt-4 px-8 py-3 bg-blue-600 text-white rounded font-bold uppercase tracking-widest hover:bg-blue-700 w-full text-center">
                Sign In
            </a>
            @endguest

            @auth('web')
            <a href="{{ route('customer.dashboard') }}" class="mt-4 px-8 py-3 bg-blue-600 text-white rounded font-bold uppercase tracking-widest hover:bg-blue-700 w-full text-center">
                My Account
            </a>
            @endauth
        </div>
    </div>
</div>
