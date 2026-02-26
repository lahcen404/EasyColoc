@extends('layouts.app')

@section('content')
    <div class="py-8 px-4 sm:px-0">
        <!-- 1. System Alert Banner -->
        <div class="mb-10 p-8 bg-brand-dark rounded-[2rem] shadow-2xl text-white relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-2xl font-black uppercase tracking-tighter">System Console: Active</h3>
                    <p class="text-brand-light text-xs font-bold opacity-70 mt-1 uppercase tracking-widest">Global Monitoring Mode</p>
                </div>
                <div class="flex gap-4">
                    <div class="px-5 py-3 bg-white/10 rounded-2xl border border-white/10 backdrop-blur-sm">
                        <p class="text-[9px] font-black uppercase tracking-widest text-brand-light">Status</p>
                        <p class="text-xs font-bold uppercase tracking-tight">Operational</p>
                    </div>
                    <div class="px-5 py-3 bg-red-500/20 rounded-2xl border border-red-500/20 backdrop-blur-sm">
                        <p class="text-[9px] font-black uppercase tracking-widest text-red-300">Banned</p>
                        <p class="text-xs font-bold uppercase tracking-tight">{{ $stats['banned_users'] ?? 0 }} Units</p>
                    </div>
                </div>
            </div>
            <!-- Decorative blur effect -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-brand-medium rounded-full blur-[100px] opacity-30"></div>
        </div>

        <!-- 2. Statistical Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Metric 1: Users -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-brand-light/10 hover:border-brand-medium/30 transition-all group">
                <p class="text-[10px] font-black text-brand-medium uppercase tracking-[0.2em] mb-4">Total Population</p>
                <div class="flex items-end gap-3">
                    <span class="text-5xl font-black text-brand-dark tracking-tighter leading-none group-hover:scale-105 transition-transform">{{ $stats['total_users'] }}</span>
                    <span class="text-xs font-bold text-brand-medium mb-1 uppercase">Units</span>
                </div>
            </div>

            <!-- Metric 2: Houses -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-brand-light/10 hover:border-brand-medium/30 transition-all group">
                <p class="text-[10px] font-black text-brand-medium uppercase tracking-[0.2em] mb-4">Active Colocations</p>
                <div class="flex items-end gap-3">
                    <span class="text-5xl font-black text-brand-dark tracking-tighter leading-none group-hover:scale-105 transition-transform">{{ $stats['active_colocations'] }}</span>
                    <span class="text-xs font-bold text-brand-medium mb-1 uppercase">Clusters</span>
                </div>
            </div>

            <!-- Metric 3: Money Flow -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-brand-light/10 hover:border-brand-medium/30 transition-all group">
                <p class="text-[10px] font-black text-brand-medium uppercase tracking-[0.2em] mb-4">Registry Flow</p>
                <div class="flex items-end gap-3">
                    <span class="text-5xl font-black text-brand-dark tracking-tighter leading-none group-hover:scale-105 transition-transform">{{ number_format($stats['total_flow'], 2) }}</span>
                    <span class="text-xs font-bold text-brand-medium mb-1 uppercase">Euro</span>
                </div>
            </div>
        </div>

        <!-- 3. Recent Users Table -->
        <div class="mt-12 bg-white rounded-[2.5rem] shadow-sm border border-brand-light/10 overflow-hidden">
            <div class="px-8 py-6 border-b border-brand-soft bg-brand-soft/10 flex justify-between items-center">
                <h4 class="text-xs font-black text-brand-dark uppercase tracking-widest">Recent Account Registry</h4>
                <div class="flex items-center gap-2">
                    <span class="text-[9px] font-bold text-brand-medium uppercase">Live Sync</span>
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-brand-medium uppercase tracking-[0.2em] border-b border-brand-soft">
                            <th class="px-8 py-5">Full Name</th>
                            <th class="px-8 py-5">System Email</th>
                            <th class="px-8 py-5">Access Role</th>
                            <th class="px-8 py-5 text-right">Reputation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-soft">
                        @forelse($recentUsers as $user)
                            <tr class="hover:bg-brand-soft/20 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="text-sm font-black text-brand-dark">{{ $user->name }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-xs font-bold text-brand-medium">{{ $user->email }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-[9px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider {{ $user->role->value === 'admin' ? 'bg-brand-dark text-white' : 'bg-brand-soft text-brand-dark border border-brand-light/20' }}">
                                        {{ $user->role->value }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right font-black">
                                    <span class="{{ $user->reputation_score >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                                        {{ $user->reputation_score > 0 ? '+' : '' }}{{ $user->reputation_score }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-20 text-center text-xs font-bold text-brand-medium/40 uppercase tracking-widest">
                                    No telemetry data available for this cycle.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
