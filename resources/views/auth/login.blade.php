<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dermond</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-white antialiased bg-dermond-dark">
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md animate-fade-in-up">
            <img class="mx-auto h-12 w-auto" src="{{ asset('images/asset-logo.png') }}" alt="Dermond">
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-white">Welcome Back</h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Please sign in to continue
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md animate-fade-in-up delay-100">
            <div class="bg-dermond-card border border-white/10 py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10">
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-900/30 border border-red-500/30">
                        <div class="flex items-center gap-3 text-red-400 mb-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-bold">Login Failed</span>
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-400 ml-8">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-900/30 border border-green-500/30 flex items-center gap-3 text-green-400">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email_or_username" class="block text-sm font-medium text-gray-300">Email or Username</label>
                        <div class="mt-2">
                            <input id="email_or_username" name="email_or_username" type="text" autocomplete="username" required 
                                class="block w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('email_or_username') }}">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                class="block w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all hover:-translate-y-0.5">
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/10"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-dermond-card px-2 text-gray-400">New to Dermond?</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('register') }}" class="flex w-full justify-center rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-sm font-semibold text-white hover:border-blue-500/50 hover:bg-blue-900/20 transition-colors">
                            Create an account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
