@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 px-4">

        <!-- Header -->
        <div class="mb-10">
            <h2 class="text-4xl font-black text-brand-dark uppercase tracking-tighter">Modify <span class="text-brand-medium">Category</span></h2>
            <p class="text-[10px] font-bold text-brand-medium/60 uppercase tracking-[0.4em] mt-2">Update registry classification name</p>
        </div>

        <!-- The Edit Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border-t-8 border-brand-medium p-8 sm:p-12">
            <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-brand-soft/20 p-8 rounded-[2rem] border border-brand-light/20">
                    <label for="name" class="block text-[10px] font-black text-brand-dark uppercase tracking-widest mb-4 px-1">
                        Revised Category Name
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           required
                           value="{{ old('name', $category->name) }}"
                           placeholder="e.g., Household Bills"
                           class="w-full px-6 py-5 rounded-2xl border-brand-light/30 bg-white text-brand-dark font-bold text-lg focus:border-brand-medium focus:ring-brand-medium transition-all shadow-inner placeholder:text-brand-medium/20 h-16"
                           autofocus
                    >
                    @error('name')
                        <p class="mt-3 text-[10px] font-black text-red-500 uppercase px-1 tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full py-6 bg-brand-dark text-white text-xs font-black uppercase tracking-[0.3em] rounded-2xl shadow-xl hover:bg-brand-medium hover:-translate-y-1 transition-all active:translate-y-0">
                        Confirm Update
                    </button>

                    <a href="{{ route('categories.index') }}" class="block text-center py-4 text-[10px] font-black text-brand-medium/40 hover:text-brand-dark uppercase tracking-widest transition-colors">
                        Discard & Return to List
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Notice -->
        <div class="mt-8 p-6 bg-brand-dark/5 rounded-2xl border border-brand-dark/5 flex items-start gap-4">
            <div class="w-5 h-5 rounded-full bg-brand-medium flex items-center justify-center text-[10px] font-bold text-white shrink-0 mt-0.5">!</div>
            <p class="text-[10px] font-bold text-brand-medium uppercase leading-relaxed tracking-wider">
                Renaming this category will automatically update all existing expenses linked to this classification in the registry history.
            </p>
        </div>
    </div>
</div>
@endsection
