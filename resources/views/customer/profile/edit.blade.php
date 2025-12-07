@extends('layouts.app')

@section('title', 'Edit Profil - Dermond')

@section('content')
<div class="bg-dermond-dark min-h-screen pt-24 pb-16">
    <div class="container mx-auto px-6 md:px-8 max-w-2xl">
        <div class="mb-8">
            <a href="{{ route('customer.profile.show') }}" class="text-xs font-bold tracking-widest text-blue-400 uppercase hover:text-blue-300 mb-2 inline-block">&larr; Kembali ke Profil</a>
            <p class="text-xs font-bold tracking-[0.2em] text-blue-400 uppercase">Profil</p>
            <h1 class="text-4xl font-bold text-white mt-2">Edit Profil</h1>
        </div>

        @if($errors->any())
            <div class="bg-red-900/30 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.profile.update') }}" method="POST" class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Full Name</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div>
                <label for="username" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Username</label>
                <input type="text"
                       name="username"
                       id="username"
                       value="{{ old('username', $user->username) }}"
                       class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
                @error('username')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            
            <div>
                <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Email</label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-white/10 pt-6">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Ubah Password</h3>
                <p class="text-xs text-gray-500 mb-4">Kosongkan jika tidak ingin mengubah password.</p>
                
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Password Baru</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="••••••••">
                        @error('password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Konfirmasi Password</label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-xl text-xs font-bold tracking-widest uppercase hover:bg-blue-500 transition-all">
                    Simpan Perubahan
                </button>
                <a href="{{ route('customer.profile.show') }}" class="flex-1 text-center bg-dermond-dark border border-white/10 text-white px-6 py-3 rounded-xl text-xs font-bold tracking-widest uppercase hover:border-blue-500/50 hover:bg-blue-900/20 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
