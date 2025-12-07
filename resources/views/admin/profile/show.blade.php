@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold uppercase text-white mb-2">
                My Profile
            </h1>
            <p class="text-gray-400">
                View and manage your account details.
            </p>
        </div>
        
        <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-2 text-gray-400 hover:text-blue-400 transition-colors">
            <div class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center group-hover:border-blue-500/30 group-hover:bg-blue-500/10 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-widest">Dashboard</span>
        </a>
    </div>

    <!-- Alert -->
    @if (session('success'))
        <div class="bg-emerald-900/30 border border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Profile Card -->
    <div class="bg-dermond-card border border-white/10 rounded-2xl overflow-hidden">
        <!-- Cover Background -->
        <div class="h-48 bg-gradient-to-br from-blue-900/50 via-dermond-nav to-indigo-900/30 relative">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
        </div>

        <div class="px-8 pb-8 relative">
            <!-- Avatar -->
            <div class="relative -mt-16 mb-6 flex justify-center md:justify-start">
                <div class="h-32 w-32 rounded-2xl bg-dermond-nav p-2 shadow-xl border border-white/10">
                    <div class="h-full w-full rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-4xl font-bold">
                        {{ substr($user->username, 0, 1) }}
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-1">{{ $user->username }}</h2>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs font-bold uppercase tracking-wider border border-blue-500/20">
                            Administrator
                        </span>
                        <span class="text-gray-600 text-xs">•</span>
                        <span class="text-gray-500 text-xs">Member since {{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>

                <a href="{{ route('admin.profile.edit') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all shadow-lg shadow-blue-900/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Profile</span>
                </a>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-white/10 pt-8">
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Username</p>
                    <p class="text-lg font-medium text-white">{{ $user->username }}</p>
                </div>

                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Account Created</p>
                    <p class="text-lg font-medium text-white">{{ $user->created_at->format('F j, Y') }}</p>
                </div>
                
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Role</p>
                    <p class="text-lg font-medium text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Super Admin
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Status</p>
                    <p class="text-lg font-medium text-emerald-400">Active</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
