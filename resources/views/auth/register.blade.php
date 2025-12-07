<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dermond</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-white antialiased bg-dermond-dark">
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md animate-fade-in-up">
            <img class="mx-auto h-12 w-auto" src="{{ asset('images/asset-logo.png') }}" alt="Dermond">
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-white">Create Account</h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Join Dermond today
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
                            <span class="font-bold">Registration Failed</span>
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-400 ml-8">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Full Name</label>
                        <div class="mt-2">
                            <input id="name" name="name" type="text" autocomplete="name" required 
                                class="block w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('name') }}">
                        </div>
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                        <div class="mt-2">
                            <input id="username" name="username" type="text" autocomplete="username" required 
                                class="block w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('username') }}">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email Address</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="block w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('email') }}">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="new-password" required 
                                class="block w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                        <div class="mt-2">
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                                class="block w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all hover:-translate-y-0.5">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/10"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-dermond-card px-2 text-gray-400">Already have an account?</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('login') }}" class="flex w-full justify-center rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-sm font-semibold text-white hover:border-blue-500/50 hover:bg-blue-900/20 transition-colors">
                            Sign in
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
