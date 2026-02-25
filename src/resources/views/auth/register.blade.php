<x-guest-layout>
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-brand-dark tracking-tighter uppercase">
            Account<span class="text-brand-medium">Registry</span>
        </h2>
        <p class="text-xs font-bold text-brand-medium/60 uppercase tracking-[0.2em] mt-2">
            EasyColoc Management Engine v1.0
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-[10px] font-black text-brand-dark uppercase tracking-widest mb-2 px-1">
                Full Legal Name
            </label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus
                   placeholder="John Doe"
                   class="w-full px-4 py-3 rounded-xl border-brand-light/30 bg-brand-soft/30 text-brand-dark font-medium focus:border-brand-medium focus:ring-brand-medium transition-all shadow-sm placeholder:text-brand-medium/30"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-black text-brand-dark uppercase tracking-widest mb-2 px-1">
                System Email Address
            </label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   placeholder="name@example.com"
                   class="w-full px-4 py-3 rounded-xl border-brand-light/30 bg-brand-soft/30 text-brand-dark font-medium focus:border-brand-medium focus:ring-brand-medium transition-all shadow-sm placeholder:text-brand-medium/30"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-black text-brand-dark uppercase tracking-widest mb-2 px-1">
                Secure Password
            </label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   placeholder="••••••••"
                   class="w-full px-4 py-3 rounded-xl border-brand-light/30 bg-brand-soft/30 text-brand-dark font-medium focus:border-brand-medium focus:ring-brand-medium transition-all shadow-sm placeholder:text-brand-medium/30"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[10px] font-black text-brand-dark uppercase tracking-widest mb-2 px-1">
                Confirm Secret
            </label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required
                   placeholder="••••••••"
                   class="w-full px-4 py-3 rounded-xl border-brand-light/30 bg-brand-soft/30 text-brand-dark font-medium focus:border-brand-medium focus:ring-brand-medium transition-all shadow-sm placeholder:text-brand-medium/30"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Action Button -->
        <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-brand-dark text-white text-xs font-black uppercase tracking-[0.2em] rounded-xl shadow-lg hover:bg-brand-medium hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                Register Account
            </button>
        </div>
    </form>

    <!-- Footer Links -->
    <div class="mt-8 pt-6 border-t border-brand-soft text-center">
        <p class="text-xs font-bold text-brand-medium/60 uppercase tracking-widest">
            Already in the system?
            <a href="{{ route('login') }}" class="text-brand-dark hover:text-brand-medium transition underline decoration-brand-light/30 underline-offset-4">
                Sign in instead
            </a>
        </p>
    </div>
</x-guest-layout>
