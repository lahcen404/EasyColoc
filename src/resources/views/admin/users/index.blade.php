@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-4xl font-black text-brand-dark tracking-tighter uppercase">
                    Account<span class="text-brand-medium">Registry</span>
                </h2>
                <p class="text-[10px] font-bold text-brand-medium/60 uppercase tracking-[0.3em] mt-2">
                    Access Level: System Administrator
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-brand-light/20">
                    <span class="text-[9px] font-black text-brand-medium uppercase tracking-widest">Total Units:</span>
                    <span class="ml-2 text-sm font-black text-brand-dark">{{ $users->total() }}</span>
                </div>
            </div>
        </div>

        <!-- Main User Table -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-brand-light/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-brand-medium uppercase tracking-[0.2em] border-b border-brand-soft bg-brand-soft/20">
                            <th class="px-8 py-6">User Identity</th>
                            <th class="px-8 py-6">System Role</th>
                            <th class="px-8 py-6">Reputation</th>
                            <th class="px-8 py-6">Account Status</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-soft">
                        @foreach($users as $user)
                            <tr class="hover:bg-brand-soft/30 transition-colors {{ $user->is_banned ? 'opacity-60 bg-red-50/10' : '' }}">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-brand-dark flex items-center justify-center font-black text-white text-xs shadow-md">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-brand-dark leading-none">{{ $user->name }}</p>
                                            <p class="text-[10px] font-medium text-brand-medium mt-1">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-[9px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider {{ $user->role->value === 'admin' ? 'bg-brand-dark text-white' : 'bg-brand-soft text-brand-dark border border-brand-light/20' }}">
                                        {{ $user->role->value }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-full bg-brand-soft rounded-full h-1.5 max-w-[60px]">
                                            <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ min($user->reputation_score, 100) }}%"></div>
                                        </div>
                                        <span class="text-xs font-black text-brand-dark">{{ $user->reputation_score }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($user->is_banned)
                                        <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-red-600 bg-red-100 px-3 py-1 rounded-full uppercase">
                                            <div class="w-1 h-1 rounded-full bg-red-600"></div>
                                            Banned
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full uppercase">
                                            <div class="w-1 h-1 rounded-full bg-emerald-600"></div>
                                            Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <form action="{{ route('admin.users.toggle-ban', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to {{ $user->is_banned ? 'restore' : 'ban' }} this user?');">
                                        @csrf
                                        @if($user->is_banned)
                                            <button type="submit" class="px-4 py-2 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm hover:bg-emerald-600 transition">
                                                Restore User Access
                                            </button>
                                        @else
                                            <button type="submit" class="px-4 py-2 bg-red-500 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm hover:bg-red-600 transition">
                                                Ban User Access
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-8 py-6 bg-brand-soft/10 border-t border-brand-soft">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
