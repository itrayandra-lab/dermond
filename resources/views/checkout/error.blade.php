@extends('layouts.app')

@section('title', 'Pembayaran Gagal - Dermond')

@section('content')
    <div class="pt-32 pb-20 px-6 min-h-screen bg-dermond-dark">
        <div class="max-w-3xl mx-auto text-center">
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-8">
                <div class="w-16 h-16 bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4 text-red-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-white mb-3">Pembayaran Gagal</h1>
                <p class="text-gray-400 mb-6">Terjadi kendala pada pembayaran. Silakan coba lagi atau pilih metode lain.</p>
                <a href="{{ route('customer.dashboard') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded font-bold transition-all hover:-translate-y-1 shadow-lg shadow-blue-900/20">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
