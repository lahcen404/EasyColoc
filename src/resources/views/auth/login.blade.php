<x-guest-layout>
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-brand-dark tracking-tighter uppercase">
            System<span class="text-brand-medium">Entry</span>
        </h2>
        <p class="text-xs font-bold text-brand-medium/60 uppercase tracking-[0.2em] mt-2">
            EasyColoc Management Engine v1.0
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
 @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <p class="text-[10px] font-black text-red-600 uppercase tracking-widest leading-none mb-1">Security Alert</p>
                <p class="text-xs font-bold text-red-800 leading-tight">{{ session('error') }}</p>
            </div>
        </div>
    @endif
    
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-black text-brand-dark uppercase tracking-widest mb-2 px-1">
                Authorized Email
            </label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   placeholder="name@company.com"
                   class="w-full px-4 py-3 rounded-xl border-brand-light/30 bg-brand-soft/30 text-brand-dark font-medium focus:border-brand-medium focus:ring-brand-medium transition-all shadow-sm placeholder:text-brand-medium/30"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2 px-1">
                <label for="password" class="block text-[10px] font-black text-brand-dark uppercase tracking-widest">
                    Secure Password
                </label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-brand-medium hover:text-brand-dark transition uppercase tracking-tighter" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   placeholder="••••••••"
                   class="w-full px-4 py-3 rounded-xl border-brand-light/30 bg-brand-soft/30 text-brand-dark font-medium focus:border-brand-medium focus:ring-brand-medium transition-all shadow-sm placeholder:text-brand-medium/30"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded-md border-brand-light/50 text-brand-medium shadow-sm focus:ring-brand-medium transition-colors cursor-pointer" name="remember">
                <span class="ms-3 text-xs font-bold text-brand-medium/70 group-hover:text-brand-dark transition uppercase tracking-wide">
                    Keep session active
                </span>
            </label>
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-4 bg-brand-dark text-white text-xs font-black uppercase tracking-[0.2em] rounded-xl shadow-lg hover:bg-brand-medium hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                Login
            </button>
        </div>
    </form>

    <!-- Footer Links -->
    <div class="mt-8 pt-6 border-t border-brand-soft text-center">
        <p class="text-xs font-bold text-brand-medium/60 uppercase tracking-widest">
            New to the system?
            <a href="{{ route('register') }}" class="text-brand-dark hover:text-brand-medium transition underline decoration-brand-light/30 underline-offset-4">
                Register account
            </a>
        </p>
    </div>
</x-guest-layout>
