@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-10">
        <!-- Page Header -->
        <div class="mb-10 text-center sm:text-left">
            <h2 class="text-3xl font-black text-brand-dark tracking-tighter uppercase">
                Expense<span class="text-brand-medium">Registry</span>
            </h2>
            <p class="text-[10px] font-bold text-brand-medium/60 uppercase tracking-[0.3em] mt-2">
                Deployment for: {{ $membership->colocation->name }}
            </p>
        </div>

        <!-- Main Input Card -->
        <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border-t-8 border-brand-dark">
            <form action="{{ route('expenses.store') }}" method="POST" class="p-8 sm:p-12 space-y-10">
                @csrf

                <!-- 1. The Big Amount Input -->
                <div class="bg-brand-soft/30 p-10 rounded-[2rem] border border-brand-light/20 text-center">
                    <label class="block text-[10px] font-black text-brand-medium uppercase tracking-[0.2em] mb-4">Amount Charged (€)</label>
                    <div class="flex items-center justify-center">
                        <span class="text-4xl font-black text-brand-dark mr-3">€</span>
                        <input type="number"
                               step="0.01"
                               name="amount"
                               placeholder="0.00"
                               value="{{ old('amount') }}"
                               class="bg-transparent border-none text-6xl font-black text-brand-dark focus:ring-0 w-64 text-center placeholder:text-brand-light/20"
                               required
                               autofocus
                        >
                    </div>
                    @error('amount') <p class="text-red-500 text-[10px] font-black uppercase mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- 2. Description -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-brand-dark uppercase tracking-widest px-1">Description</label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="e.g., Weekly Groceries"
                               class="w-full px-6 py-4 rounded-2xl border-brand-light/30 bg-brand-soft/10 text-brand-dark font-bold focus:border-brand-medium focus:ring-brand-medium transition-all shadow-inner placeholder:text-brand-medium/20"
                               required
                        >
                        @error('title') <p class="text-red-500 text-[10px] font-black uppercase">{{ $message }}</p> @enderror
                    </div>

                    <!-- 3. Category Select -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-brand-dark uppercase tracking-widest px-1">Category</label>
                        <select name="category_id" class="w-full px-6 py-4 rounded-2xl border-brand-light/30 bg-brand-soft/10 text-brand-dark font-black focus:border-brand-medium focus:ring-brand-medium transition-all shadow-inner">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 4. Date Selection -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-brand-dark uppercase tracking-widest px-1">Payment Date</label>
                        <input type="date"
                               name="date"
                               value="{{ date('Y-m-d') }}"
                               class="w-full px-6 py-4 rounded-2xl border-brand-light/30 bg-brand-soft/10 text-brand-dark font-bold focus:border-brand-medium focus:ring-brand-medium transition-all shadow-inner"
                        >
                    </div>

                    <!-- 5. Static Split Logic (Informational) -->
                    <div class="space-y-3 opacity-60">
                        <label class="block text-[10px] font-black text-brand-dark uppercase tracking-widest px-1">Calculation Method</label>
                        <div class="px-6 py-4 rounded-2xl bg-brand-medium/5 border border-brand-medium/20 flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-brand-medium"></div>
                            <span class="text-[10px] font-black text-brand-medium uppercase tracking-tighter">Automatic Equal Split</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="pt-6">
                    <button type="submit" class="w-full py-6 bg-brand-dark text-white text-xs font-black uppercase tracking-[0.3em] rounded-[1.5rem] shadow-xl hover:bg-brand-medium hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        Log Transaction
                    </button>
                    <a href="{{ route('dashboard') }}" class="block text-center mt-8 text-[10px] font-black text-brand-medium/40 hover:text-brand-dark uppercase tracking-widest transition">
                        Discard & Return to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
