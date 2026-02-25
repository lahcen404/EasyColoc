@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-16 px-4">
        <!-- Brand Header -->
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-brand-dark rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl transform -rotate-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <h2 class="text-4xl font-black text-brand-dark tracking-tighter uppercase">Start your<span class="text-brand-medium">Coloc</span></h2>
            <p class="text-xs font-bold text-brand-medium/60 uppercase tracking-[0.3em] mt-3">Establish your house rules and registry</p>
        </div>

        <!-- The Form Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border-t-8 border-brand-dark p-8 sm:p-12">
            <form action="{{ route('colocations.store') }}" method="POST" class="space-y-8">
                @csrf

                <div>
                    <label for="name" class="block text-[10px] font-black text-brand-dark uppercase tracking-widest mb-3 px-1">
                        House Name
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           required
                           placeholder="e.g., The Green House, Sunset Loft"
                           class="w-full px-6 py-4 rounded-2xl border-brand-light/30 bg-brand-soft/30 text-brand-dark font-bold focus:border-brand-medium focus:ring-brand-medium transition-all shadow-sm placeholder:text-brand-medium/20"
                    >
                    @error('name')
                        <p class="mt-2 text-xs font-bold text-red-500 uppercase px-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="p-6 bg-brand-soft/50 rounded-2xl border border-brand-light/20 flex gap-4">
                    <div class="shrink-0 w-6 h-6 rounded-full bg-brand-medium flex items-center justify-center text-[10px] font-black text-white">!</div>
                    <p class="text-[11px] font-bold text-brand-medium leading-relaxed uppercase">
                        By creating this house, you become the <span class="text-brand-dark font-black">Owner</span>. You will be responsible for inviting members and managing the monthly budget.
                    </p>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-5 bg-brand-dark text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl hover:bg-brand-medium hover:-translate-y-1 active:translate-y-0 transition-all duration-200">
                        Create Colocation
                    </button>
                    <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-[10px] font-black text-brand-medium/40 hover:text-brand-dark uppercase tracking-widest transition">
                        Cancel 
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
