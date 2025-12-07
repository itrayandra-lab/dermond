@extends('layouts.app')

@section('title', 'Profil Saya - Dermond')

@section('content')
<div class="bg-dermond-dark min-h-screen pt-24 pb-16">
    <div class="container mx-auto px-6 md:px-8 max-w-2xl">
        <div class="mb-8">
            <a href="{{ route('customer.dashboard') }}" class="text-xs font-bold tracking-widest text-blue-400 uppercase hover:text-blue-300 mb-2 inline-block">&larr; Kembali ke Dashboard</a>
            <p class="text-xs font-bold tracking-[0.2em] text-blue-400 uppercase">Profil</p>
            <h1 class="text-4xl font-bold text-white mt-2">Informasi Akun</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-900/30 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-dermond-dark border border-white/10 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Nama Lengkap</p>
                    <p class="text-white font-semibold text-lg">{{ $user->name }}</p>
                </div>
                <div class="bg-dermond-dark border border-white/10 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Username</p>
                    <p class="text-white font-semibold text-lg">{{ $user->username }}</p>
                </div>
            </div>

            <div class="bg-dermond-dark border border-white/10 rounded-xl p-4">
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Email</p>
                <p class="text-white font-semibold text-lg">{{ $user->email }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-dermond-dark border border-white/10 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Role</p>
                    <p class="text-white font-semibold text-lg capitalize">{{ $user->role }}</p>
                </div>
                <div class="bg-dermond-dark border border-white/10 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Member Sejak</p>
                    <p class="text-white font-semibold text-lg">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <a href="{{ route('customer.profile.edit') }}" class="flex-1 text-center bg-blue-600 text-white px-6 py-3 rounded-xl text-xs font-bold tracking-widest uppercase hover:bg-blue-500 transition-all">
                    Edit Profil
                </a>
                <a href="{{ route('addresses.index') }}" class="flex-1 text-center bg-dermond-dark border border-white/10 text-white px-6 py-3 rounded-xl text-xs font-bold tracking-widest uppercase hover:border-blue-500/50 hover:bg-blue-900/20 transition-colors">
                    Kelola Alamat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
