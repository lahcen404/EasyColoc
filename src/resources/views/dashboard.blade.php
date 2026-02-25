@extends('layouts.app')

@section('content')
    <div class="py-12">

        @if(!$membership)

            <!-- ONBOARDING STATE: User has no House -->
            <div class="max-w-4xl mx-auto text-center py-20">
                <div class="inline-flex p-6 bg-white rounded-[2.5rem] shadow-xl mb-8 border-b-4 border-brand-medium">
                    <svg class="w-12 h-12 text-brand-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-brand-dark tracking-tighter uppercase mb-4">
                    Ready to start<br/><span class="text-brand-medium">Your Journey?</span>
                </h2>
                <p class="text-sm font-bold text-brand-medium/60 uppercase tracking-widest max-w-md mx-auto leading-relaxed mb-10">
                    You are currently not associated with a house registry. Initialize a new cluster or wait for an invitation to join one.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('colocations.create') }}" class="w-full sm:w-auto px-10 py-5 bg-brand-dark text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl hover:bg-brand-medium hover:-translate-y-1 transition-all">
                        Initialize New House
                    </a>
                </div>
            </div>

        @else

            <!-- ACTIVE STATE: User is in a House -->

            <!-- 1. Header & Identity -->
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 bg-brand-medium text-white text-[9px] font-black uppercase rounded-full tracking-widest shadow-sm">
                            {{ $membership->is_owner ? 'Primary Owner' : 'House Member' }}
                        </span>
                        <span class="text-[10px] font-bold text-brand-medium/50 uppercase tracking-widest">
                            Registry Active since {{ $membership->joined_at->format('M Y') }}
                        </span>
                    </div>
                    <h2 class="text-6xl font-black text-brand-dark tracking-tighter uppercase leading-none">
                        {{ $membership->colocation->name }}
                    </h2>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('expenses.create') }}" class="px-8 py-4 bg-brand-dark text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl hover:bg-brand-medium transition-all hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Log Expense
                    </a>

                    @if($membership->is_owner)
                        <button class="px-8 py-4 bg-white text-brand-dark text-xs font-black uppercase tracking-widest rounded-2xl border border-brand-light/30 shadow-sm hover:bg-brand-soft transition-all">
                            Invite Roommate
                        </button>
                    @endif
                </div>
            </div>

            <!-- 2. Financial & Reputation Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">

                <!-- Personal Balance Card (Requirement 5.4) -->
                <div class="p-8 bg-brand-dark rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-brand-light/60">Your Current Balance</p>
                        <p class="text-5xl font-black mt-4 tracking-tighter">0.00 <span class="text-xl opacity-40 tabular-nums">€</span></p>
                    </div>
                    <div class="relative z-10 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-emerald-400">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                        All Accounts Settled
                    </div>
                    <!-- Decorative Radial Blur -->
                    <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-brand-medium/30 rounded-full blur-3xl"></div>
                </div>

                <!-- Global Reputation Score (Requirement 5.5) -->
                <div class="p-8 bg-white rounded-[2.5rem] shadow-sm border border-brand-light/10 flex flex-col justify-between group hover:border-brand-medium/30 transition-colors">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-brand-medium/50">System Reputation</p>
                        <div class="flex items-center gap-4 mt-4">
                            <span class="text-5xl font-black text-emerald-500 tracking-tighter">+{{ auth()->user()->reputation_score }}</span>
                            <div class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-black rounded-lg uppercase tracking-wider">Trusted Unit</div>
                        </div>
                    </div>
                    <p class="text-[10px] font-medium text-brand-medium/60 italic leading-tight uppercase tracking-wide">
                        Permanent score tied to your global Identity.
                    </p>
                </div>

                <!-- Active Registry Members -->
                <div class="p-8 bg-white rounded-[2.5rem] shadow-sm border border-brand-light/10 flex flex-col justify-between group hover:border-brand-medium/30 transition-colors">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-brand-medium/50">House Population</p>
                        <p class="text-5xl font-black mt-4 text-brand-dark tracking-tighter">
                            {{ $membership->colocation->memberships->count() }} <span class="text-xl text-brand-medium">Members</span>
                        </p>
                    </div>
                    <p class="text-[10px] font-black text-brand-dark uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-medium"></span>
                        Operational Status
                    </p>
                </div>
            </div>

            <!-- 3. Roommates Registry (Requirement 5.5) -->
            <div class="space-y-8">
                <div class="flex justify-between items-center px-2">
                    <h3 class="text-xs font-black text-brand-dark uppercase tracking-[0.3em]">Active Roommates</h3>
                    <div class="h-[1px] flex-1 bg-brand-light/20 mx-6"></div>
                    <span class="text-[10px] font-bold text-brand-medium uppercase tracking-widest">Telemetry Active</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($membership->colocation->memberships as $member)
                        <div class="p-6 bg-white rounded-[2rem] border border-brand-light/10 flex items-center justify-between shadow-sm group hover:border-brand-medium/30 transition-all hover:shadow-md">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-brand-soft flex items-center justify-center font-black text-brand-dark text-lg border border-brand-light/20 shadow-inner group-hover:bg-brand-dark group-hover:text-white transition-all duration-300">
                                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-brand-dark leading-none">{{ $member->user->name }}</p>
                                    <p class="text-[10px] font-bold text-brand-medium uppercase mt-2 tracking-widest">
                                        {{ $member->is_owner ? 'Primary Owner' : 'House Resident' }}
                                    </p>
                                </div>
                            </div>
                            <!-- Status indicator -->
                            <div class="w-2 h-2 rounded-full {{ $member->user->id === auth()->id() ? 'bg-emerald-400' : 'bg-brand-light/40' }}"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
