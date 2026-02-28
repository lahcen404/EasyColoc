@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-10 px-4">
            <h2 class="text-4xl font-black text-brand-dark uppercase tracking-tighter">House <span class="text-brand-medium">Categories</span></h2>
            <p class="text-[10px] font-bold text-brand-medium/60 uppercase tracking-[0.4em] mt-2">Manage how expenses are classified in the registry</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Add Category Form (Left Sidebar) -->
            <div class="md:col-span-1 px-4">
                <div class="bg-brand-dark p-8 rounded-[2.5rem] shadow-2xl text-white border-t-8 border-brand-medium">
                    <h3 class="text-xs font-black uppercase tracking-widest mb-6 text-brand-light">New Category</h3>
                    <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-[9px] font-black uppercase tracking-widest mb-2 opacity-60 px-1">Classification Name</label>
                            <input type="text" name="name" required placeholder="e.g. Internet, Rent"
                                   class="w-full bg-white/10 border-white/10 rounded-2xl text-sm font-bold text-white focus:ring-brand-light focus:border-brand-light h-14 px-5 transition-all">
                        </div>
                        <button type="submit" class="w-full py-5 bg-brand-medium text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-white hover:text-brand-dark transition-all shadow-xl active:scale-95">
                            Add to Registry
                        </button>
                    </form>
                </div>
            </div>

            <!-- Categories List (Main Content) -->
            <div class="md:col-span-2 px-4">
                <div class="bg-white rounded-[3rem] shadow-sm border border-brand-light/10 overflow-hidden">
                    <div class="bg-brand-soft/10 px-8 py-5 border-b border-brand-soft flex justify-between items-center">
                        <span class="text-[9px] font-black text-brand-medium uppercase tracking-widest">Active Classifications</span>
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    </div>

                    <div class="divide-y divide-brand-soft">
                        @forelse($categories as $category)
                            <div class="flex items-center justify-between px-8 py-6 hover:bg-brand-soft/5 transition-colors group">
                                <div class="flex items-center gap-5">
                                    <div class="w-10 h-10 rounded-xl bg-brand-soft flex items-center justify-center text-xs font-black text-brand-dark border border-brand-light/20 shadow-inner group-hover:bg-brand-light/20 transition-colors">
                                        {{ strtoupper(substr($category->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-black text-brand-dark uppercase tracking-tighter">{{ $category->name }}</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <!-- Edit Link -->
                                    <a href="{{ route('categories.edit', $category) }}" class="p-2.5 bg-brand-soft/50 text-brand-medium rounded-xl hover:bg-brand-medium hover:text-white transition-all shadow-sm" title="Edit Name">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Security Check: Deletion is only possible if no expenses are linked. Proceed?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-red-50 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm" title="Delete Category">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-20 text-center">
                                <p class="text-[10px] font-black text-brand-medium/30 uppercase tracking-[0.4em]">No classifications established</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
