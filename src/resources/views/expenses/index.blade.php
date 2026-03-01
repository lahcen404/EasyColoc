@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header & Month Filter Section -->
        <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6 px-2">
            <div>
                <h2 class="text-4xl font-black text-brand-dark tracking-tighter uppercase">
                    House<span class="text-brand-medium">Registry</span>
                </h2>
                <p class="text-[10px] font-bold text-brand-medium/60 uppercase tracking-[0.3em] mt-2">
                    Historical telemetry for: {{ $membership->colocation->name }}
                </p>
            </div>

            <!-- Month/Year Filter: Requirement 5.3 -->
            <form action="{{ route('expenses.index') }}" method="GET" class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-brand-light/20">
                <div class="flex flex-col px-2">
                    <span class="text-[8px] font-black text-brand-medium uppercase tracking-widest mb-1">Month</span>
                    <select name="month" class="bg-transparent border-none p-0 text-xs font-black uppercase text-brand-dark focus:ring-0 cursor-pointer">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="h-8 w-[1px] bg-brand-light/20"></div>

                <div class="flex flex-col px-2">
                    <span class="text-[8px] font-black text-brand-medium uppercase tracking-widest mb-1">Year</span>
                    <select name="year" class="bg-transparent border-none p-0 text-xs font-black uppercase text-brand-dark focus:ring-0 cursor-pointer">
                        @foreach(range(date('Y')-2, date('Y')) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="ml-2 p-3 bg-brand-dark text-white rounded-xl hover:bg-brand-medium transition shadow-lg group">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Main Expense Ledger -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-brand-light/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-brand-medium uppercase tracking-[0.2em] border-b border-brand-soft bg-brand-soft/20">
                            <th class="px-8 py-6">Date</th>
                            <th class="px-8 py-6">Identity & Description</th>
                            <th class="px-8 py-6">Classification</th>
                            <th class="px-8 py-6 text-right">Debit Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-soft">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-brand-soft/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-brand-dark uppercase tracking-tighter">{{ $expense->date->format('d M') }}</span>
                                        <span class="text-[9px] font-bold text-brand-medium/50 uppercase">{{ $expense->date->format('Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-brand-soft flex items-center justify-center text-xs font-black text-brand-dark border border-brand-light/20 shadow-inner group-hover:bg-brand-light/20 transition-colors">
                                            {{ strtoupper(substr($expense->payer->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-brand-dark leading-none">{{ $expense->title }}</p>
                                            <p class="text-[10px] font-bold text-brand-medium mt-1 uppercase tracking-widest">Paid by {{ $expense->payer->user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-[9px] font-black px-3 py-1.5 bg-brand-soft text-brand-dark rounded-lg border border-brand-light/10 uppercase tracking-widest">
                                        {{ $expense->category->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-lg font-black text-brand-dark tabular-nums">
                                        {{ number_format($expense->amount, 2) }}€
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-24 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="text-[10px] font-black uppercase tracking-[0.4em]">No Registry Data Found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Controls -->
            @if($expenses->hasPages())
                <div class="px-8 py-6 bg-brand-soft/10 border-t border-brand-soft">
                    {{ $expenses->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
