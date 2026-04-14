<x-guest-layout>
    <!-- Gradient Background Overlay -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-black"></div>
        <div class="absolute top-0 right-1/3 w-96 h-96 bg-yellow-400/5 rounded-full mix-blend-screen filter blur-3xl opacity-40"></div>
        <div class="absolute bottom-0 left-1/3 w-96 h-96 bg-yellow-500/5 rounded-full mix-blend-screen filter blur-3xl opacity-40"></div>
        <div class="absolute top-1/2 right-0 w-full h-1 bg-gradient-to-l from-yellow-500/20 to-transparent"></div>
    </div>

    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="space-y-1 mb-6">
            <h2 class="text-3xl font-bold text-white text-center">Welcome Back</h2>
            <p class="text-center text-gray-400 text-sm">Sign in to your NetManager account</p>
        </div>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/30 font-medium text-sm text-green-400 animate-fade-in">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <x-label for="email" value="{{ __('Email Address') }}" class="text-gray-200 font-medium text-sm" />
                <x-input 
                    id="email" 
                    class="block w-full px-4 py-3 rounded-lg bg-gray-900/50 border border-yellow-500/20 text-white placeholder-gray-500 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/30 focus:bg-gray-900/80 transition duration-300 shadow-lg shadow-yellow-500/5" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="your@email.com"
                    required 
                    autofocus 
                    autocomplete="username" 
                />
            </div>

            <div class="space-y-2">
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-200 font-medium text-sm" />
                <x-input 
                    id="password" 
                    class="block w-full px-4 py-3 rounded-lg bg-gray-900/50 border border-yellow-500/20 text-white placeholder-gray-500 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/30 focus:bg-gray-900/80 transition duration-300 shadow-lg shadow-yellow-500/5" 
                    type="password" 
                    name="password" 
                    placeholder="••••••••"
                    required 
                    autocomplete="current-password" 
                />
            </div>

            <div class="flex items-center justify-between pt-2">
                <label for="remember_me" class="flex items-center cursor-pointer group">
                    <x-checkbox id="remember_me" name="remember" class="accent-yellow-400" />
                    <span class="ms-2 text-sm text-gray-400 group-hover:text-yellow-400 transition">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-yellow-400 hover:text-yellow-300 font-medium transition duration-200" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-button class="w-full mt-6 py-3 px-4 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-black font-bold rounded-lg shadow-lg hover:shadow-2xl hover:shadow-yellow-400/50 transform hover:scale-105 transition-all duration-200 active:scale-95">
                {{ __('Sign In') }}
            </x-button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center border-t border-gray-800 pt-6">
            <p class="text-gray-400 text-sm">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition duration-200">
                    Create one
                </a>
            </p>
        </div>
    </x-authentication-card>
</x-guest-layout>
