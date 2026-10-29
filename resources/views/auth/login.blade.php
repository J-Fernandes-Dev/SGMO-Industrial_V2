<x-guest-layout>
    <!-- Contentor principal centrado e adaptado a ecrãs grandes -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-100">

        <!-- Cartão de Login Lado a Lado / Alargado -->
        <div class="w-full sm:max-w-xl mt-6 px-8 py-10 bg-white shadow-xl border border-slate-200 overflow-hidden sm:rounded-2xl">

            <!-- Logótipo e Título -->
            <div class="flex flex-col items-center mb-8">
                <img src="{{ asset('magesor.png') }}" alt="Magesor" class="h-20 w-auto object-contain mb-3">
            </div>

            <!-- Sessão de Erros / Estado -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block font-bold text-base text-slate-700 mb-2">Email</label>
                    <input id="email" class="block w-full text-base px-4 py-3 rounded-lg border-slate-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block font-bold text-base text-slate-700 mb-2">Password</label>
                    <input id="password" class="block w-full text-base px-4 py-3 rounded-lg border-slate-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-8">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-orange-600 shadow-sm focus:ring-orange-500 w-5 h-5" name="remember">
                        <span class="ml-3 text-base text-slate-600">Lembrar-me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-base text-orange-600 hover:text-orange-700 font-semibold underline" href="{{ route('password.request') }}">
                            Esqueceu-se da password?
                        </a>
                    @endif
                </div>

                <!-- Botão de Login -->
                <div>
                    <button type="submit" class="w-full justify-center bg-orange-500 hover:bg-orange-600 text-white text-lg font-bold py-3.5 px-6 rounded-xl transition-all hover:scale-[1.02] shadow-lg">
                        Entrar no Sistema
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
