<header class="bg-white border-b-2 border-brand-light shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- Logo & Main Nav -->
            <div class="flex items-center gap-10">
                @php
                    $isAdmin = auth()->check() && auth()->user()->role->value === 'admin';
                    $homeRoute = $isAdmin ? route('admin.dashboard') : route('dashboard');
                @endphp

                <a href="{{ $homeRoute }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-brand-dark rounded-xl flex items-center justify-center shadow-lg group-hover:bg-brand-medium transition-all transform -rotate-2">
                        <svg class="w-6 h-6 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="text-2xl font-black text-brand-dark tracking-tighter uppercase">
                        Easy<span class="text-brand-medium">Coloc</span>
                    </span>
                </a>

                @auth
                    <nav class="hidden md:flex items-center gap-1">
                        @php
                            $user = auth()->user();
                            $activeMembership = $user->memberships()->whereNull('left_at')->first();
                        @endphp

                        <!-- Unified Dashboard Link -->
                        <a href="{{ $homeRoute }}"
                           class="px-4 py-2 text-xs font-black uppercase tracking-widest rounded-lg transition {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'bg-brand-soft text-brand-dark' : 'text-brand-medium hover:bg-brand-soft/50' }}">
                            Dashboard
                        </a>

                        @if($isAdmin)
                            <div class="h-4 w-[1px] bg-brand-light/30 mx-2"></div>
                            <!-- Admin specific nav -->
                            <a href="{{ route('admin.users.index') }}"
                               class="px-4 py-2 text-xs font-black uppercase tracking-widest rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-brand-dark text-white shadow-md' : 'text-brand-medium hover:bg-brand-soft/50' }}">
                                User Registry
                            </a>
                        @else
                            <!-- Member specific nav: Only show if they have a house -->
                            @if($activeMembership)
                                <div class="h-4 w-[1px] bg-brand-light/30 mx-2"></div>
                                <span class="px-4 py-2 text-[10px] font-black text-brand-medium/40 uppercase tracking-[0.2em]">
                                    {{ $activeMembership->colocation->name }}
                                </span>
                            @endif
                        @endif
                    </nav>
                @endauth
            </div>

            <!-- User Actions -->
            <div class="flex items-center gap-4">
                @auth
                    <div class="hidden sm:flex flex-col text-right mr-2">
                        <span class="text-xs font-black text-brand-dark leading-none">{{ Auth::user()->name }}</span>
                        <span class="text-[9px] uppercase font-bold text-brand-medium tracking-[0.2em] mt-1">
                            {{ Auth::user()->role->value }} Account
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Profile Settings -->
                        <a href="{{ route('profile.edit') }}"
                           class="p-2.5 bg-brand-soft text-brand-dark rounded-xl hover:bg-brand-light/20 transition border border-brand-light/20 shadow-sm"
                           title="Account Settings">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </a>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2.5 bg-brand-dark text-white rounded-xl hover:bg-red-600 transition shadow-md group" title="Sign Out">
                                <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endauth

                @guest
                    <div class="flex items-center gap-6">
                        <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-widest text-brand-dark hover:text-brand-medium transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-brand-dark text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl shadow-lg hover:bg-brand-medium transition transform hover:-translate-y-0.5">
                            Initialize
                        </a>
                    </div>
                @endguest
            </div>

        </div>
    </div>
</header>
