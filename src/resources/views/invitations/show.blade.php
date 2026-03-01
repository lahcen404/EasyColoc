@extends('layouts.app')

@section('content')
<div class="py-20 min-h-[80vh] flex items-center justify-center">
    <div class="max-w-3xl w-full px-6">

        <!-- Architectural Invitation Card -->
        <div class="bg-white rounded-[4rem] shadow-[0_50px_100px_rgba(10,96,113,0.15)] border border-brand-light/10 overflow-hidden relative group">

            <!-- Dynamic Background Element -->
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-brand-soft rounded-full blur-[100px] opacity-60 group-hover:scale-110 transition-transform duration-1000"></div>

            <div class="p-12 sm:p-20 text-center relative z-10">
                <!-- Icon Branding -->
                <div class="w-28 h-28 bg-brand-dark rounded-[2.5rem] flex items-center justify-center mx-auto mb-12 shadow-2xl transform -rotate-3 group-hover:rotate-0 transition-transform duration-500">
                    <svg class="w-14 h-14 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>

                <span class="text-[10px] font-black text-brand-medium uppercase tracking-[0.6em] mb-6 block opacity-50 text-center">Incoming Connection Protocol</span>

                <h2 class="text-6xl font-black text-brand-dark tracking-tighter uppercase leading-[0.85] mb-10 text-center">
                    Join The <br> <span class="text-brand-medium">{{ $invitation->colocation->name }}</span> Registry?
                </h2>

                <p class="text-brand-medium/60 font-bold max-w-sm mx-auto mb-16 uppercase text-[11px] tracking-[0.3em] leading-relaxed">
                    You have been invited to synchronize your financial telemetry within this domestic cluster.
                </p>

                <!-- Decision Logic Stack -->
                <div class="flex flex-col gap-5 max-w-md mx-auto">
                    <!-- Form 1: Accept -->
                    <form action="{{ route('invitations.accept', $invitation->token) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-7 bg-brand-dark text-white text-[11px] font-black uppercase tracking-[0.4em] rounded-[2rem] shadow-2xl hover:bg-brand-medium hover:-translate-y-1 transition-all active:scale-95">
                            Authorize Access
                        </button>
                    </form>

                    <!-- Form 2: Refuse -->
                    <form action="{{ route('invitations.refuse', $invitation->token) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-5 bg-red-50 text-red-500 text-[10px] font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-red-500 hover:text-white transition-all">
                            Decline Invitation
                        </button>
                    </form>
                </div>

                <!-- Registry Meta -->
                <div class="mt-16 pt-10 border-t border-brand-soft">
                    <div class="flex items-center justify-center gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-brand-medium animate-pulse"></div>
                        <p class="text-[9px] font-bold text-brand-medium/30 uppercase tracking-widest">
                            Token expires: {{ $invitation->expires_at->format('M d, Y \a\t H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Footer Label -->
        <div class="text-center mt-12 opacity-20">
            <p class="text-[10px] font-black text-brand-dark uppercase tracking-[0.8em]">EasyColoc Security Cluster</p>
        </div>
    </div>
</div>
@endsection
