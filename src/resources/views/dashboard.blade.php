@extends('layouts.app')

@section('content')
    <div class="py-12">

        @if (!$membership)
            <!-- ONBOARDING STATE: User has no House (Requirement 3.1) -->
            <div class="max-w-4xl mx-auto text-center py-20">
                <div class="inline-flex p-6 bg-white rounded-[2.5rem] shadow-xl mb-8 border-b-4 border-brand-medium">
                    <svg class="w-12 h-12 text-brand-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-brand-dark tracking-tighter uppercase mb-4">
                    Ready to start<br /><span class="text-brand-medium">Your Journey?</span>
                </h2>
                <p class="text-sm font-bold text-brand-medium/60 uppercase tracking-widest max-w-md mx-auto leading-relaxed mb-10">
                    You are currently not associated with a house registry. Initialize a new cluster or wait for an invitation to join one.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('colocations.create') }}"
                        class="w-full sm:w-auto px-10 py-5 bg-brand-dark text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl hover:bg-brand-medium hover:-translate-y-1 transition-all">
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
                            Registry Active since {{ $membership->joined_at?->format('M Y') ?? 'N/A' }}
                        </span>
                    </div>
                    <h2 class="text-6xl font-black text-brand-dark tracking-tighter uppercase leading-none">
                        {{ $membership->colocation->name }}
                    </h2>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('expenses.create') }}"
                        class="px-8 py-4 bg-brand-dark text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl hover:bg-brand-medium transition-all hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Log Expense
                    </a>

                    @if ($membership->is_owner)
                        <a href="{{ route('invitations.create') }}"
                            class="px-8 py-4 bg-white text-brand-dark text-xs font-black uppercase tracking-widest rounded-2xl border border-brand-light/30 shadow-sm hover:bg-brand-soft transition-all">
                            Invite Roommate
                        </a>
                    @endif
                </div>
            </div>

            <!-- 2. Financial & Reputation Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- Personal Balance Card -->
                <div class="p-8 bg-brand-dark rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-brand-light/60">Your Current Balance</p>
                        <p class="text-5xl font-black mt-4 tracking-tighter tabular-nums">
                            {{ number_format($balance, 2) }} <span class="text-xl opacity-40">€</span>
                        </p>
                    </div>
                    <div class="relative z-10 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest {{ $balance >= 0 ? 'text-emerald-400' : 'text-orange-300' }}">
                        @if ($balance >= 0)
                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                            Credit Balance
                        @else
                            <div class="w-1.5 h-1.5 rounded-full bg-orange-300 animate-pulse"></div>
                            Settlement Required
                        @endif
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-brand-medium/30 rounded-full blur-3xl"></div>
                </div>

                <!-- Global Reputation Score (Rule 5.5) -->
                <div class="p-8 bg-white rounded-[2.5rem] shadow-sm border border-brand-light/10 flex flex-col justify-between group hover:border-brand-medium/30 transition-colors">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-brand-medium/50">System Reputation</p>
                        <div class="flex items-center gap-4 mt-4">
                            <span class="text-5xl font-black {{ auth()->user()->reputation_score >= 0 ? 'text-emerald-500' : 'text-red-500' }} tracking-tighter">
                                {{ auth()->user()->reputation_score >= 0 ? '+' : '' }}{{ auth()->user()->reputation_score }}
                            </span>
                            <div class="px-3 py-1 {{ auth()->user()->reputation_score >= 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} text-[9px] font-black rounded-lg uppercase tracking-wider">
                                {{ auth()->user()->reputation_score >= 0 ? 'Trusted Unit' : 'Risk Profile' }}
                            </div>
                        </div>
                    </div>
                    <p class="text-[10px] font-medium text-brand-medium/60 italic leading-tight uppercase tracking-wide">Permanent score tied to your identity.</p>
                </div>

                <!-- Monthly House Spend -->
                <div class="p-8 bg-white rounded-[2.5rem] shadow-sm border border-brand-light/10 flex flex-col justify-between group hover:border-brand-medium/30 transition-colors">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-brand-medium/50">Monthly House Spend</p>
                        <p class="text-5xl font-black mt-4 text-brand-dark tracking-tighter">
                            {{ number_format($totalHouseExpenses, 2) }} <span class="text-xl text-brand-medium">€</span>
                        </p>
                    </div>
                    <p class="text-[10px] font-black text-brand-dark uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-medium"></span>
                        {{ $memberCount }} Active Members
                    </p>
                </div>
            </div>

            <!-- 3. Settlement Matrix (Requirement 5.4: Who Owes Who) -->
            <div class="mb-16">
                <div class="flex justify-between items-center px-2 mb-8">
                    <h3 class="text-xs font-black text-brand-dark uppercase tracking-[0.3em]">Settlement Matrix</h3>
                    <div class="h-[1px] flex-1 bg-brand-light/20 mx-6"></div>
                    <span class="text-[9px] font-bold text-brand-medium uppercase">Reimbursement Logic Active</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($settlements as $settlement)
                        <div class="p-6 bg-white rounded-[2rem] border border-brand-light/10 shadow-sm flex items-center justify-between group hover:border-brand-medium/30 transition-all hover:shadow-md">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-black text-brand-dark">{{ $settlement['from'] }}</span>
                                    <svg class="w-3 h-3 text-brand-medium/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    <span class="text-xs font-black text-brand-medium">{{ $settlement['to'] }}</span>
                                </div>
                                <span class="text-[8px] font-bold text-brand-medium/50 uppercase tracking-widest mt-2">Required Payment</span>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-brand-dark tabular-nums">{{ number_format($settlement['amount'], 2) }}€</p>

                                {{-- Requirement 5.6: Mark as Paid --}}
                                @if($settlement['from'] === auth()->user()->name)
                                    <form action="" method="POST">
                                        @csrf
                                        <input type="hidden" name="receiver_id" value="{{ $settlement['id'] ?? '' }}">
                                        <input type="hidden" name="amount" value="{{ $settlement['amount'] }}">
                                        <button type="submit" class="text-[8px] font-black text-brand-medium hover:text-brand-dark uppercase tracking-widest mt-1 underline decoration-brand-light/30 transition-all">
                                            Mark as Sent
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[8px] font-bold text-brand-medium/30 uppercase tracking-widest mt-1">Pending</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full p-12 bg-brand-soft/20 rounded-[2.5rem] border border-dashed border-brand-light/30 text-center">
                            <p class="text-[10px] font-black text-brand-medium/40 uppercase tracking-[0.3em]">All balances are settled.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 4. Activity & Roommates Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-12">
                <!-- Recent Expenses -->
                <div class="space-y-8">
                    <div class="flex justify-between items-center px-2">
                        <h3 class="text-xs font-black text-brand-dark uppercase tracking-[0.3em]">Recent Activity</h3>
                        <div class="h-[1px] flex-1 bg-brand-light/20 mx-6"></div>
                    </div>

                    <div class="bg-white rounded-[2rem] border border-brand-light/10 overflow-hidden shadow-sm">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[10px] font-black text-brand-medium uppercase tracking-widest border-b border-brand-soft bg-brand-soft/10">
                                    <th class="px-6 py-4">Transaction</th>
                                    <th class="px-6 py-4 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-soft">
                                @forelse($membership->colocation->expenses->sortByDesc('date')->take(5) as $expense)
                                    <tr class="hover:bg-brand-soft/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-black text-brand-dark leading-none">{{ $expense->title }}</p>
                                            <p class="text-[9px] font-bold text-brand-medium uppercase mt-2 tracking-tighter">
                                                By {{ $expense->payer?->user?->name ?? 'System' }} • {{ $expense->date?->format('d M') ?? 'N/A' }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 text-right font-black text-brand-dark tabular-nums">
                                            {{ number_format($expense->amount, 2) }} €
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="px-6 py-16 text-center text-[10px] font-black text-brand-medium/30 uppercase tracking-[0.2em]">No transactions recorded</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Roommates & Invites -->
                <div class="space-y-12">
                    <div class="space-y-8">
                        <div class="flex justify-between items-center px-2">
                            <h3 class="text-xs font-black text-brand-dark uppercase tracking-[0.3em]">Active Roommates</h3>
                            <div class="h-[1px] flex-1 bg-brand-light/20 mx-6"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($membership->colocation->memberships()->whereNull('left_at')->get() as $member)
                                <div class="p-6 bg-white rounded-[2rem] border border-brand-light/10 flex items-center justify-between shadow-sm group hover:border-brand-medium/30 transition-all">
                                    <div class="flex items-center gap-5">
                                        <div class="w-14 h-14 rounded-2xl bg-brand-soft flex items-center justify-center font-black text-brand-dark text-lg border border-brand-light/20 shadow-inner group-hover:bg-brand-dark group-hover:text-white transition-all">
                                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-brand-dark leading-none">{{ $member->user->name }}</p>
                                            <p class="text-[10px] font-bold text-brand-medium uppercase mt-2 tracking-widest">{{ $member->is_owner ? 'Owner' : 'Member' }}</p>
                                        </div>
                                    </div>
                                    <div class="w-2 h-2 rounded-full {{ $member->user->id === auth()->id() ? 'bg-emerald-400' : 'bg-brand-light/40' }}"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- OWNER ONLY: Pending Invitations (Rule 5.2) -->
                    @if($membership->is_owner)
                        <div class="space-y-6">
                            <div class="flex justify-between items-center px-2">
                                <h3 class="text-xs font-black text-brand-dark uppercase tracking-[0.3em]">Outbound Tokens</h3>
                                <div class="h-[1px] flex-1 bg-brand-light/20 mx-6"></div>
                            </div>
                            @php
                                $pendingInvites = \App\Models\Invitation::where('colocation_id', $membership->colocation_id)
                                    ->where('status', \App\Enums\InvitationStatus::PENDING)
                                    ->where('expires_at', '>', now())
                                    ->get();
                            @endphp
                            <div class="space-y-3">
                                @forelse($pendingInvites as $invite)
                                    <div class="flex items-center justify-between p-4 bg-brand-soft/20 rounded-2xl border border-brand-light/10">
                                        <span class="text-xs font-black text-brand-dark">{{ $invite->email }}</span>
                                        <span class="text-[8px] font-black text-brand-medium uppercase tracking-widest">Expires {{ $invite->expires_at->diffForHumans() }}</span>
                                    </div>
                                @empty
                                    <p class="text-[10px] font-bold text-brand-medium/40 uppercase px-2 italic">No pending invitations.</p>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- MANAGEMENT SECTION (CDC Rule 6.1 & 6.2) -->
            <div class="mt-24 pt-10 border-t border-brand-light/20 text-center">
                @if ($membership->is_owner)
                    <!-- OWNER: CANCEL (Rule 6.2) -->
                    <form action="{{ route('colocations.cancel') }}" method="POST" onsubmit="return confirm('CDC RULE 5.2 & 5.5 WARNING:\n\nThis will permanently close the house registry. Reputation scores will be updated for ALL members.\n\nPROCEED?')">
                        @csrf
                        <button type="submit" class="group inline-flex flex-col items-center gap-3">
                            <span class="text-[10px] font-black text-orange-500/40 group-hover:text-orange-600 uppercase tracking-[0.4em] transition-all">Cancel House Registry</span>
                            <div class="w-1 h-1 rounded-full bg-orange-500/20 group-hover:w-12 group-hover:bg-orange-600 transition-all duration-500"></div>
                        </button>
                    </form>
                @else
                    <!-- MEMBER: LEAVE (Rule 6.1) -->
                    <form action="{{ route('colocations.leave') }}" method="POST" onsubmit="return confirm('CDC RULE 5.5 WARNING:\n\nLeaving with a negative balance will reduce your reputation. Confirm departure?')">
                        @csrf
                        <button type="submit" class="group inline-flex flex-col items-center gap-3">
                            <span class="text-[10px] font-black text-red-500/40 group-hover:text-red-600 uppercase tracking-[0.4em] transition-all">Terminate Membership</span>
                            <div class="w-1 h-1 rounded-full bg-red-500/20 group-hover:w-8 group-hover:bg-red-600 transition-all duration-500"></div>
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>
@endsection
