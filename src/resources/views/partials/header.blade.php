<header class="bg-white border-b-2 border-brand-light shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- 1. Left: Logo -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex items-center group">
                    <span class="text-2xl font-black text-brand-dark tracking-tighter uppercase">
                        Easy<span class="text-brand-medium">Coloc</span>
                    </span>
                </a>

                <!-- Simple Navigation Links -->
                <nav class="hidden md:ml-10 md:flex space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-brand-dark hover:text-brand-medium transition">
                        Dashboard
                    </a>
                    <!-- Active Link for Profile -->
                    <a href="{{ route('profile.edit') }}" class="text-sm font-bold {{ request()->routeIs('profile.edit') ? 'text-brand-medium' : 'text-brand-dark' }} hover:text-brand-medium transition">
                        Profile
                    </a>
                </nav>
            </div>

            <!-- 2. Right: Auth / Guest Controls -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Logged In: Show User Name and Logout -->
                    <div class="hidden sm:flex flex-col text-right mr-4 border-r border-gray-100 pr-4">
                        <span class="text-xs font-black text-brand-dark">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] uppercase font-bold text-brand-medium">{{ Auth::user()->role->value }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-5 py-2 bg-brand-dark text-white text-xs font-bold uppercase rounded-lg hover:bg-brand-medium transition shadow-md">
                            Log Out
                        </button>
                    </form>
                @endauth

                @guest
                    <!-- Not Logged In: Show Login and Register -->
                    <a href="{{ route('login') }}" class="text-sm font-bold text-brand-dark hover:text-brand-medium transition">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-brand-medium text-white text-xs font-bold uppercase rounded-lg hover:bg-brand-dark transition shadow-md">
                        Get Started
                    </a>
                @endguest
            </div>

        </div>
    </div>
</header>
