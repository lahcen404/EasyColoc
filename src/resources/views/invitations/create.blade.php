@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-16 px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-brand-dark rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                <svg class="w-8 h-8 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </div>
            <h2 class="text-4xl font-black text-brand-dark tracking-tighter uppercase">Invite<span class="text-brand-medium">Roommate</span></h2>
            <p class="text-xs font-bold text-brand-medium/60 uppercase tracking-[0.3em] mt-3">Deploy a secure access token via email</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border-t-8 border-brand-dark p-8 sm:p-12">
            <form action="{{ route('invitations.store') }}" method="POST" class="space-y-8">
                @csrf

                <div>
                    <label for="email" class="block text-[10px] font-black text-brand-dark uppercase tracking-widest mb-3 px-1">
                        Guest Email Address
                    </label>
                    <input type="email"
                           name="email"
                           id="email"
                           required
                           placeholder="roommate@example.com"
                           class="w-full px-6 py-4 rounded-2xl border-brand-light/30 bg-brand-soft/30 text-brand-dark font-bold focus:border-brand-medium focus:ring-brand-medium transition-all shadow-sm placeholder:text-brand-medium/20"
                    >
                    @error('email')
                        <p class="mt-2 text-xs font-bold text-red-500 uppercase px-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="p-6 bg-brand-soft/50 rounded-2xl border border-brand-light/20 flex gap-4">
                    <div class="shrink-0 w-6 h-6 rounded-full bg-brand-medium flex items-center justify-center text-[10px] font-black text-white">i</div>
                    <p class="text-[11px] font-bold text-brand-medium leading-relaxed uppercase">
                        The recipient will receive a <span class="text-brand-dark font-black">unique link</span> valid for 7 days. They must register or log in to accept the invitation.
                    </p>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-5 bg-brand-dark text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl hover:bg-brand-medium hover:-translate-y-1 transition-all duration-200">
                        Dispatch Invitation
                    </button>
                    <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-[10px] font-black text-brand-medium/40 hover:text-brand-dark uppercase tracking-widest transition">
                        Return to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
