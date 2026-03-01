@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(!$membership)
            <!-- No House State -->
            <div class="text-center py-24 bg-white rounded-[3rem] shadow-xl border-2 border-dashed border-brand-light/30">
                <div class="w-24 h-24 bg-brand-soft rounded-3xl flex items-center justify-center mx-auto mb-8">
                    <svg class="w-12 h-12 text-brand-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-brand-dark uppercase tracking-tighter">No Active House</h2>
                <p class="text-brand-medium/60 font-bold mt-3 mb-10 uppercase text-[10px] tracking-[0.4em]">Start your journey by joining or creating a house</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('colocations.create') }}" class="px-10 py-5 bg-brand-dark text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-2xl hover:bg-brand-medium transition-all transform hover:-translate-y-1">Create New House</a>
                </div>
            </div>
        @else
            <!-- Active House Header -->
            <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 px-4">
                <div>
                    <h2 class="text-6xl font-black text-brand-dark tracking-tighter uppercase leading-none">
                        {{ $membership->colocation->name }}
                    </h2>
                    <div class="flex items-center gap-5 mt-5">
                        <div class="flex items-center gap-2 px-4 py-1.5 bg-brand-dark rounded-xl">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[9px] font-black text-white uppercase tracking-widest">
                                {{ $membership->is_owner ? 'House Owner' : 'Member' }}
                            </span>
                        </div>
                        <span class="text-[10px] font-bold text-brand-medium uppercase tracking-[0.2em]">
                            {{ $memberCount }} Roommates Online
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('expenses.create') }}" class="px-8 py-5 bg-brand-dark text-white text-xs font-black uppercase tracking-widest rounded-[1.5rem] shadow-2xl hover:bg-brand-medium transition-all flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        Log Expense
                    </a>
                    @if($membership->is_owner)
                        <!-- ADD CATEGORY BUTTON (HEADER) -->
                        <a href="{{ route('categories.index') }}" class="px-8 py-5 bg-white border-2 border-brand-light text-brand-medium text-xs font-black uppercase tracking-widest rounded-[1.5rem] hover:bg-brand-soft transition-all shadow-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            Categories
                        </a>
                        <a href="{{ route('invitations.create') }}" class="px-8 py-5 bg-white border-2 border-brand-dark text-brand-dark text-xs font-black uppercase tracking-widest rounded-[1.5rem] hover:bg-brand-soft transition-all shadow-sm">
                            Invite
                        </a>
                    @endif
                </div>
            </div>

            <!-- Confirmation Handshake Section -->
            @if($pendingIncoming->count() > 0)
                <div class="mb-12 animate-in fade-in slide-in-from-top-4 duration-700">
                    <div class="flex items-center gap-3 mb-6 px-4">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></div>
                        <h3 class="text-[10px] font-black text-brand-dark uppercase tracking-[0.4em]">Action Required: Verify Received Funds</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach($pendingIncoming as $payment)
                            <div class="bg-white border-2 border-brand-light/20 p-8 rounded-[3rem] flex items-center justify-between shadow-sm hover:shadow-xl transition-all group">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-brand-soft rounded-[1.5rem] flex items-center justify-center border border-brand-light/10 shadow-inner group-hover:bg-brand-light/20 transition-colors">
                                        <svg class="w-7 h-7 text-brand-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-brand-medium uppercase tracking-widest mb-1">Incoming Verification</p>
                                        <p class="text-base font-black text-brand-dark tracking-tight">
                                            {{ $payment->sender->user->name }} sent <span class="text-brand-medium">{{ number_format($payment->amount, 2) }}€</span>
                                        </p>
                                    </div>
                                </div>

                                <form action="{{ route('payments.confirm', $payment) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-8 py-4 bg-brand-dark text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-brand-medium transition-all shadow-lg active:scale-95">
                                        Confirm
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Global Balance Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- My Current Standing -->
                <div class="lg:col-span-1 bg-brand-dark rounded-[3.5rem] p-12 text-white shadow-2xl relative overflow-hidden group">

                    <div class="absolute top-6 right-6 flex flex-col items-end">
                        <span class="text-xs font-semibold text-brand-light opacity-70 mb-1">Global standing</span>
                        <div class="px-3 py-1 bg-white/10 rounded-xl border border-white/10 backdrop-blur-sm flex items-center gap-2">
                            <svg class="w-3 h-3 {{ auth()->user()->reputation_score >= 0 ? 'text-emerald-400' : 'text-red-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="text-sm font-semibold {{ auth()->user()->reputation_score >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ auth()->user()->reputation_score > 0 ? '+' : '' }}{{ auth()->user()->reputation_score }}
                            </span>
                        </div>
                    </div>

                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.4em] text-brand-light opacity-60 mb-3">Individual Balance</p>
                        <h3 class="text-7xl font-black tracking-tighter leading-none mb-8 tabular-nums">
                            {{ number_format($balance, 2) }}<span class="text-3xl ml-1">€</span>
                        </h3>
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full {{ $balance >= 0 ? 'bg-emerald-400' : 'bg-red-400' }} shadow-[0_0_15px_rgba(52,211,153,0.5)]"></div>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-light">
                                {{ $balance >= 0 ? 'Account Settled' : 'Debt in Registry' }}
                            </span>
                        </div>
                    </div>
                    <div class="absolute -right-16 -bottom-16 w-56 h-56 bg-brand-medium rounded-full blur-[80px] opacity-30 group-hover:opacity-50 transition-opacity"></div>
                </div>

                <!-- House Metrics Grid -->
                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-[3rem] p-10 border border-brand-light/10 shadow-sm flex flex-col justify-center">
                        <p class="text-[10px] font-black text-brand-medium uppercase tracking-widest mb-6">Aggregate House Spend</p>
                        <p class="text-5xl font-black text-brand-dark tabular-nums tracking-tighter">{{ number_format($totalHouseExpenses, 2) }}€</p>
                        <p class="text-[9px] font-bold text-brand-medium/40 mt-3 uppercase tracking-[0.3em]">Historical ledger total</p>
                    </div>

                    <div class="bg-white rounded-[3rem] p-10 border border-brand-light/10 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-[10px] font-black text-brand-medium uppercase tracking-widest mb-6">Operational Tools</p>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('expenses.index') }}" class="px-6 py-3 bg-brand-soft text-brand-dark text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-brand-soft transition-all shadow-sm">History</a>

                                @if($membership->is_owner)
                                    <!-- ADD CATEGORY BUTTON (TOOLS) -->
                                    <a href="{{ route('categories.index') }}" class="px-6 py-3 bg-brand-soft text-brand-medium text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-brand-light/20 transition-all">Manage Categories</a>
                                @endif

                                <!-- leave colocation -->
                                <form action="{{ route('colocations.leave') }}" method="POST" onsubmit="return confirm('Are you sure you want to leave this colocation?');">
                                    @csrf
                                    <button type="submit" class="px-6 py-3 bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-red-100 transition-all">Exit House</button>
                                </form>
                            </div>
                        </div>
                        @if($membership->is_owner)
                            <div class="mt-6 pt-6 border-t border-brand-soft/50">
                                <form action="{{ route('colocations.cancel') }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this colocation? This will audit final reputations.');">
                                    @csrf
                                    <button type="submit" class="text-[9px] font-black text-red-400 uppercase tracking-widest hover:text-red-600 transition-colors">Cancel Colocation</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Settlement Logic Matrix -->
            <div class="bg-white rounded-[3.5rem] shadow-sm border border-brand-light/10 overflow-hidden mb-12">
                <div class="px-12 py-10 border-b border-brand-soft bg-brand-soft/10 flex justify-between items-center">
                    <div>
                        <h3 class="text-xs font-black text-brand-dark uppercase tracking-[0.4em]">Settlement Matrix</h3>
                        <p class="text-[8px] font-bold text-brand-medium/50 uppercase mt-1 tracking-widest">Active P2P Resolution Engine</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-[9px] font-black text-brand-medium uppercase tracking-widest italic">Live Logic</span>
                    </div>
                </div>

                <div class="p-12">
                    <div class="space-y-8">
                        @forelse($settlements as $settlement)
                            <div class="flex items-center justify-between p-8 bg-brand-soft/15 rounded-[2.5rem] border border-brand-light/5 hover:border-brand-medium/30 transition-all group">
                                <div class="flex items-center gap-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-brand-dark flex items-center justify-center text-[11px] font-black text-white shadow-lg">
                                            {{ strtoupper(substr($settlement['from'], 0, 1)) }}
                                        </div>
                                        <span class="text-xs font-black text-brand-dark uppercase tracking-tighter">{{ $settlement['from'] }}</span>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-[2px] bg-brand-medium/20 rounded-full"></div>
                                        <div class="p-2 bg-brand-soft rounded-lg text-brand-medium/40">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </div>
                                        <div class="w-12 h-[2px] bg-brand-medium/20 rounded-full"></div>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-brand-medium flex items-center justify-center text-[11px] font-black text-white shadow-lg">
                                            {{ strtoupper(substr($settlement['to'], 0, 1)) }}
                                        </div>
                                        <span class="text-xs font-black text-brand-dark uppercase tracking-tighter">{{ $settlement['to'] }}</span>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-3xl font-black text-brand-dark tabular-nums tracking-tighter">{{ number_format($settlement['amount'], 2) }}€</p>

                                    @if($settlement['from'] === auth()->user()->name)
                                        <form action="{{ route('payments.store') }}" method="POST" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="receiver_id" value="{{ $settlement['to_id'] }}">
                                            <input type="hidden" name="amount" value="{{ $settlement['amount'] }}">
                                            <button type="submit" class="text-[9px] font-black text-brand-medium hover:text-brand-dark uppercase tracking-widest underline decoration-brand-light/40 hover:decoration-brand-medium transition-all">
                                                Mark as Sent
                                            </button>
                                        </form>
                                    @else
                                        <div class="mt-2 flex items-center justify-end gap-1.5 opacity-40">
                                            <span class="text-[8px] font-black text-brand-medium uppercase tracking-[0.2em]">Settlement Pending</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20 flex flex-col items-center">
                                <div class="w-20 h-20 bg-brand-soft/50 rounded-full flex items-center justify-center mb-6 text-brand-medium/20">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-[10px] font-black text-brand-medium/30 uppercase tracking-[0.5em]">Financial Balance Reached</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- ROOMMATE REGISTRY -->
            <div class="bg-white rounded-[3.5rem] shadow-sm border border-brand-light/10 overflow-hidden">
                <div class="px-12 py-8 border-b border-brand-soft bg-brand-soft/10 flex justify-between items-center">
                    <h3 class="text-xs font-black text-brand-dark uppercase tracking-[0.3em]">Roommate Registry</h3>
                    @if($membership->is_owner)
                        <span class="text-[9px] font-black text-brand-medium uppercase tracking-widest px-3 py-1 bg-brand-soft rounded-lg">Administrative Control Active</span>
                    @endif
                </div>
                <div class="p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($membership->colocation->memberships as $member)
                            @if(!$member->left_at)
                                <div class="p-6 bg-brand-soft/10 rounded-[2rem] border border-brand-light/5 hover:bg-white hover:shadow-md transition-all group">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-brand-dark rounded-2xl flex items-center justify-center text-sm font-black text-white shadow-inner">
                                                {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-brand-dark leading-none">{{ $member->user->name }}</p>
                                                <p class="text-[9px] font-bold text-brand-medium uppercase tracking-widest mt-1">
                                                    {{ $member->is_owner ? 'House Owner' : 'Roommate' }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- UPDATE: Owner Actions Container -->
                                        @if($membership->is_owner && $member->id !== $membership->id)
                                            <div class="flex items-center gap-2">
                                                <!-- NEW: Transfer Ownership Button (Requirement 6.2) -->
                                                <form action="{{ route('members.transfer', $member) }}" method="POST" onsubmit="return confirm('WARNING: You will lose owner privileges. Transfer house control to {{ $member->user->name }}?');">
                                                    @csrf
                                                    <button type="submit" class="p-2 text-brand-medium/30 hover:text-brand-dark transition-colors" title="Make Owner">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 010.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <!-- Kick Button  -->
                                                <form action="{{ route('members.remove', $member) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove {{ $member->user->name }} from the house?');">
                                                    @csrf
                                                    <button type="submit" class="p-2 text-brand-medium/30 hover:text-red-600 transition-colors" title="Kick member">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="pt-4 border-t border-brand-soft flex items-center justify-between">
                                        <span class="text-[9px] font-black text-brand-medium/50 uppercase tracking-widest">Reputation</span>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-xs font-black {{ $member->user->reputation_score >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                                                {{ $member->user->reputation_score > 0 ? '+' : '' }}{{ $member->user->reputation_score }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
